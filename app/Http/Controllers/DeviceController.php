<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
        Device::create([
            'name' => $validated['name'],
            'device' => $validated['device'],
            'token' => $response['token'] ?? null, // Pastikan untuk mendapatkan token jika ada
        ]);

        return redirect()->route('devices.index')->with('success', 'Device added successfully!');
    }


    public function activateDevice(Request $request)
    {

        Device::query()->update(['is_activated' => 0]);

        $device = Device::where('device', $request->device)->first();
        

        if ($device && $device->is_activated) {
            return response()->json([
                'status' => true,
                'connected' => true,
                'message' => 'Device sudah terhubung'
            ]);
        }
    
        $expired = true;

        if ($device && $device->qr_requested_at) {
            $expired = now()->diffInSeconds($device->qr_requested_at) > 60;
        }
        
        // kalau QR masih fresh → pakai
        if ($device && !$expired && $device->qr_url) {
            return response()->json([
                'status' => true,
                'qr' => $device->qr_url
            ]);
        }
    
        // REQUEST QR BARU
        $response = $this->fonnteService->requestQRActivation(
            $request->device,
            $request->token
        );
    
        if (
            !$response['status'] ||
            empty($response['data']['url'])
        ) {
            return response()->json([
                'status' => false,
                'connected' => false,
                'message' => 'QR tidak tersedia, device mungkin sudah terhubung'
            ], 400);
        }
    
        $qr = 'data:image/png;base64,' . $response['data']['url'];
    
        Device::updateOrCreate(
            ['device' => $request->device],
            [
                'token' => $request->token,
                'qr_url' => $qr,
                'qr_requested_at' => now(),
                'is_activated' => true
            ]
        );
    
        // Log::info('QR DEBUG', [
        //     'device_exists' => (bool) $device,
        //     'qr_url' => $device->qr_url ?? null,
        //     'qr_requested_at' => $device->qr_requested_at ?? null,
        //     'expired' => $expired ?? null,
        // ]);

        return response()->json([
            'status' => true,
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
            Device::query()->update(['is_activated' => 0]);

            $deviceToken = $request->input('token');
            $response = $this->fonnteService->disconnectDevice($deviceToken);

            // Jika API mengembalikan status sukses
            if ($response['status'] === true) {
                return response()->json(['message' => 'Device disconnected successfully'], 200); // Status 200 untuk sukses
            }

            // Jika terjadi kesalahan pada respons dari API
            return response()->json(['error' => $response['error'] ?? 'Failed to disconnect device'], 500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Menghapus perangkat
    public function destroy($deviceToken)
{
    $delete = $this->fonnteService->deleteDevice($deviceToken);

    if (!$delete['status']) {
        return response()->json([
            'message' => 'Gagal menghapus device',
            'error'   => $delete['error'],
        ], 500);
    }

    return response()->json([
        'message' => 'Device berhasil dihapus',
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

    public function checkDeviceStatus()
    {
        $accountToken = config('services.fonnte.token'); // Assuming you have your token stored in config/services.php
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

        return response()->json(json_decode($response, true));
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
}
