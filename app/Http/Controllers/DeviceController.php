<?php

namespace App\Http\Controllers;

use App\Events\DeviceRealtimeEvent;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    // Menampilkan semua perangkat yang terkait dengan api_key tertentu
    public function index()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/get-devices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . config('services.fonnte.account_token'), // Get the token from the services config
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if the response is successful
        if ($data['status']) {
            $devices = $data['data']; // Use the 'data' array from the response
        } else {
            $devices = []; // Handle error case
        }

        $page_title = 'All Devices';

        return view('devices.index', compact('devices', 'page_title'));
    }

    public function create()
    {
        return view('devices.create'); // Menampilkan halaman form penambahan device
    }

    // Menyimpan perangkat baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'device' => 'required|string|max:255',
        ]);

        $existingDevice = Device::where('device', $validated['device'])->first();

        if ($existingDevice) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor/device sudah terdaftar di sistem.');
        }

        // Ambil token dari .env
        $accountToken = config('services.fonnte.account_token');

        // Mengirim request ke Fonnte API untuk menambahkan perangkat
        $response = Http::withHeaders([
            'Authorization' => $accountToken,
        ])->post('https://api.fonnte.com/add-device', [
            'name' => $validated['name'],
            'device' => $validated['device'],
            'autoread' => false,
            'personal' => true,
            'group' => false,
        ]);

        // Periksa jika permintaan gagal
        if ($response->failed()) {
            return redirect()->back()->withInput()->with('error', $response->json()['reason'] ?? 'Unknown error occurred');
        }

        $response = $response->json();
        // Periksa jika Fonnte API mengembalikan status false
        if (!$response['status']) {
            return redirect()->back()->withInput()->with('error', $response['reason'] ?? 'Failed to add device.');
        }

        // Jika berhasil, simpan ke database lokal (jika perlu)
        $device = Device::create([
            'name' => $validated['name'],
            'device' => $validated['device'],
            'token' => $response['token'] ?? null, // Pastikan untuk mendapatkan token jika ada
        ]);

        event(new DeviceRealtimeEvent('created', $this->deviceRealtimePayload($device, 'disconnect')));

        return redirect()->route('devices.index')->with('success', 'Device added successfully!');
    }


    public function activateDevice(Request $request)
    {
        $device = Device::where('device', $request->device)->first();

        // ✅ cek apakah QR lama masih bisa dipakai
        $expired = true;

        if ($device && $device->qr_requested_at) {
            $expired = now()->diffInSeconds($device->qr_requested_at) > 60;
        }

        // ✅ kalau QR masih fresh → kirim ulang QR lama
        if ($device && !$expired && $device->qr_url) {
            return response()->json([
                'status' => true,
                'connected' => false,
                'qr' => $device->qr_url
            ]);
        }

        // ✅ request QR baru dari service
        $response = $this->fonnteService->requestQRActivation(
            $request->device,
            $request->token
        );

        // ✅ kalau gagal → reset QR lama biar bisa retry
        if (
            !$response ||
            empty($response['status']) ||
            empty($response['data']['url'])
        ) {
            Device::where('device', $request->device)->update([
                'qr_url' => null,
                'qr_requested_at' => null,
                'is_activated' => false
            ]);

            return response()->json([
                'status' => false,
                'connected' => false,
                'message' => 'QR gagal dibuat, coba lagi nanti'
            ], 400);
        }

        $qr = 'data:image/png;base64,' . $response['data']['url'];

        $device = Device::updateOrCreate(
            ['device' => $request->device],
            [
                'token' => $request->token,
                'qr_url' => $qr,
                'qr_requested_at' => now(),
                'is_activated' => false
            ]
        );

        event(new DeviceRealtimeEvent('qr_requested', $this->deviceRealtimePayload($device, 'disconnect')));

        return response()->json([
            'status' => true,
            'connected' => false,
            'qr' => $qr
        ]);
    }

    // Mengecek profil perangkat melalui Fonnte API berdasarkan token
    public function show($id)
    {
        $device = Device::findOrFail($id);
        $response = $this->fonnteService->getDeviceProfile($device->token);

        if ($response['status']) {
            return response()->json([
                'html' => view('devices.partials.show', compact('device', 'response'))->render(),
            ]);
        }

        return response()->json([
            'status' => false,
            'error' => 'Gagal mendapatkan profil perangkat: ' . $response['error']
        ], 500);
    }

    public function disconnect(Request $request)
    {
        try {
            $deviceToken = $request->input('token');

            if (!$deviceToken) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak ditemukan'
                ], 400);
            }

            $device = Device::where('token', $deviceToken)->first();

            if (!$device) {
                return response()->json([
                    'status' => false,
                    'message' => 'Device tidak ditemukan'
                ], 404);
            }

            // logout dari WhatsApp gateway DULU
            $response = $this->fonnteService->disconnectDevice($deviceToken);

            if (
                !$response ||
                empty($response['status']) ||
                $response['status'] !== true
            ) {
                return response()->json([
                    'status' => false,
                    'message' => $response['error'] ?? 'Gagal disconnect dari server WhatsApp'
                ], 500);
            }

            // reset total device di database
            $device->update([
                'is_activated' => false,
                'qr_url' => null,
                'qr_requested_at' => null
            ]);

            event(new DeviceRealtimeEvent('disconnect', $this->deviceRealtimePayload($device->fresh(), 'disconnect')));

            return response()->json([
                'status' => true,
                'message' => 'Device berhasil disconnect'
            ], 200);

        } catch (\Throwable $e) {
            Log::error('DISCONNECT ERROR: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

        // Menghapus perangkat
        public function destroy($deviceToken)
    {
        // Cari device di database berdasarkan token
        $device = Device::where('token', $deviceToken)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device tidak ditemukan di database',
            ], 404);
        }

        // Hapus device di Fonnte
        $delete = $this->fonnteService->deleteDevice($deviceToken);

        if (!$delete['status']) {
            return response()->json([
                'message' => 'Gagal menghapus device di Fonnte',
                'error'   => $delete['error'] ?? null,
            ], 500);
        }

        $payload = $this->deviceRealtimePayload($device, 'disconnect');

        // Hapus dari database lokal
        $device->delete();

        event(new DeviceRealtimeEvent('deleted', $payload));

        return response()->json([
            'message' => 'Device berhasil dihapus dari Fonnte dan database',
        ]);
    }

    // Mengirim request OTP untuk penghapusan perangkat
    protected function requestOTPForDeleteDevice($notificationId, $deviceId)
    {
        $device = Device::findOrFail($deviceId);
        $response = $this->fonnteService->requestOTPForDeleteDevice($device->token);

        if ($response['status']) {
            return response()->json(['message' => 'OTP berhasil dikirim!']);
        } else {
            return response()->json(['message' => 'Gagal mengirim OTP.', 'error' => $response['error']], 500);
        }
    }

    // Mengirim OTP untuk menghapus perangkat setelah OTP diisi
    protected function submitOTPForDeleteDevice(Request $request, $deviceId)
    {
        $device = Device::findOrFail($deviceId);
        $otp = $request->input('otp');

        Log::info('Mengirim OTP untuk menghapus perangkat', ['device_id' => $deviceId, 'otp' => $otp]);

        // Mengirim OTP untuk menghapus perangkat di Fonnte
        $response = $this->fonnteService->submitOTPForDeleteDevice($otp, $device->token);

        if ($response['status']) {
            // Menghapus perangkat dari sistem jika berhasil dihapus dari Fonnte
            $device->delete();
            Log::info('Perangkat berhasil dihapus dari sistem dan Fonnte', ['device_id' => $deviceId]);
            return response()->json(['message' => 'Perangkat berhasil dihapus!']);
        } else {
            Log::error('Gagal menghapus perangkat', ['error' => $response['error']]);
            // Kembalikan pesan error dengan response dari Fonnte
            return response()->json(['message' => 'Gagal menghapus perangkat.', 'error' => $response['error']], 500);
        }
    }

    public function checkDeviceStatus(Request $request)
    {
        $accountToken = config('services.fonnte.account_token');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/get-devices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $accountToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        $deviceToken = $request->input('token');
        $phoneNumber = $request->input('device');

        if (!$deviceToken && !$phoneNumber) {
            return response()->json($data);
        }

        $device = Device::query()
            ->when($deviceToken, fn ($query) => $query->where('token', $deviceToken))
            ->when(!$deviceToken && $phoneNumber, fn ($query) => $query->where('device', $phoneNumber))
            ->first();

        $targetToken = $device?->token ?? $deviceToken;
        $targetPhone = $device?->device ?? $phoneNumber;

        $fonnteDevice = collect($data['data'] ?? [])->first(function ($item) use ($targetToken, $targetPhone) {
            $itemToken = trim((string) ($item['token'] ?? ''));
            $itemPhone = $this->normalizePhoneNumber($item['device'] ?? $item['whatsapp'] ?? $item['number'] ?? '');

            return ($targetToken && $itemToken === trim((string) $targetToken))
                || ($targetPhone && $itemPhone === $this->normalizePhoneNumber($targetPhone));
        });

        $fonnteStatus = strtolower(trim((string) ($fonnteDevice['status'] ?? '')));
        $connected = in_array($fonnteStatus, ['connect', 'connected', 'online'], true);

        $deviceProfile = null;

        if ($targetToken) {
            $profileResponse = $this->fonnteService->getDeviceProfile($targetToken);
            $deviceProfile = $profileResponse['data'] ?? null;
            $profileStatus = strtolower(trim((string) ($deviceProfile['device_status'] ?? '')));

            if ($profileStatus) {
                $fonnteStatus = $profileStatus;
                $connected = in_array($profileStatus, ['connect', 'connected', 'online'], true);
            }

            if (!$fonnteDevice && !empty($deviceProfile['status'])) {
                $fonnteDevice = [
                    'device' => $deviceProfile['device'] ?? $targetPhone,
                    'name' => $deviceProfile['name'] ?? $device?->name,
                    'quota' => $deviceProfile['quota'] ?? null,
                    'status' => $deviceProfile['device_status'] ?? null,
                    'token' => $targetToken,
                ];
            }
        }

        if ($device && $connected) {
            if (!$device->is_activated || $device->qr_url || $device->qr_requested_at) {
                $device->update([
                    'is_activated' => true,
                    'qr_url' => null,
                    'qr_requested_at' => null,
                ]);
            }

            event(new DeviceRealtimeEvent('connect', $this->deviceRealtimePayload($device->fresh(), 'connect')));
        }

        return response()->json([
            'status' => (bool) ($data['status'] ?? false),
            'connected' => $connected,
            'device' => $fonnteDevice,
            'device_profile' => $deviceProfile,
            'fonnte_status' => $fonnteStatus,
            'local_device_updated' => (bool) ($device && $connected),
        ]);
    }

    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'target' => 'required|string',
            'message' => 'required|string',
        ]);

        $deviceToken = $request->header('Authorization'); // Ambil token dari header

        // Hilangkan prefix 'Bearer ' jika ada
        if (str_starts_with($deviceToken, 'Bearer ')) {
            $deviceToken = substr($deviceToken, 7);
        }

        $response = $this->fonnteService->sendWhatsAppMessage(
            $request->input('target'),
            $request->input('message'),
            $deviceToken
        );

        if (!$response['status'] || (isset($response['data']['status']) && !$response['data']['status'])) {
            $errorReason = $response['data']['reason'] ?? 'Unknown error occurred';
            return response()->json(['message' => 'Error', 'error' => $errorReason], 500);
        }

        return response()->json(['message' => 'Pesan berhasil dikirim!', 'data' => $response['data']]);
    }

    protected function deviceRealtimePayload(Device $device, ?string $status = null): array
    {
        return [
            'id' => $device->id,
            'name' => $device->name,
            'device' => $device->device,
            'token' => $device->token,
            'quota' => '-',
            'status' => $status ?? ($device->is_activated ? 'connect' : 'disconnect'),
            'is_activated' => (bool) $device->is_activated,
        ];
    }

    protected function normalizePhoneNumber($phoneNumber): string
    {
        return preg_replace('/\D+/', '', (string) $phoneNumber);
    }
}
