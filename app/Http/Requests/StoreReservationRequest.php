<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:60',
            'nohp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'layanan' => 'required',
            'alamat' => ['nullable', 'string', 'max:255', Rule::requiredIf($this->layanan === 'Homecare')],
            'tanggal' => 'required|date',
            'hari' => 'required',
            'jam' => 'required',
            'terapi' => 'required',
            'jumlah' => 'required|integer|min:1',
        ];
    }

    /*
    custom error messages
    */

    public function messages() : array
    {
        return [
            'nama_lengkap.required' => 'Tolong isi nama anda.',
            'nama_lengkap.string' => 'Nama harus berupa teks.',
            'nama_lengkap.max' => 'Nama tidak boleh lebih dari 60 karakter.',
            'nohp.required' => 'Tolong cantumkan nomor Whatsapp anda.',
            'nohp.numeric' => 'Nomor Whatsapp harus berupa angka.',
            'jenis_kelamin.required' => 'Tolong pilih jenis kelamin.',
            'layanan.required' => 'Tolong pilih jenis layanan yang anda inginkan.',
            'alamat.required' => 'Tolong isi alamat tempat homecare.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'tanggal.required' => 'Mohon pilih tanggal reservasi.',
            'tanggal.date' => 'Tanggal harus berupa format yang valid.',
            'hari.required' => 'Tolong pilih hari terapi.',
            'jam.required' => 'Tolong pilih jam terapi.',
            'terapi.required' => 'Tolong pilih jenis terapi yang anda inginkan.',
            'jumlah.required' => 'Tolong masukkan jumlah orang yang diterapi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1 orang.',
        ];
    }
}
