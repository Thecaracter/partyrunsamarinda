<?php

namespace App\Http\Controllers\User;

use App\Models\Size;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class RegistrasiController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('user.registrasi', compact('sizes'));
    }

    public function getProvinces()
    {
        try {
            $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data provinsi'], 500);
        }
    }

    public function getCities($provinceId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kota'], 500);
        }
    }

    public function getDistricts($cityId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kecamatan'], 500);
        }
    }

    public function getVillages($districtId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kelurahan'], 500);
        }
    }

    public function saveStep1(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_bib' => 'required|string|max:255',
            'email' => 'required|email|unique:peserta,email',
            'no_wa' => ['required', 'string', 'regex:/^(\+62|62|0)[0-9]{9,12}$/'],
            'usia' => 'required|numeric|min:1|max:150',
            'kategori' => 'required|in:Pelajar,Umum,Master',
            'size_id' => 'required|exists:sizes,id',
            'golongan_darah' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
        ]);

        $request->session()->put('registration_step1', $validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
        ]);
    }

    public function saveStep2(Request $request)
    {
        $validatedData = $request->validate([
            'provinsi_id' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kota_id' => 'required|string',
            'kota' => 'required|string|max:255',
            'kecamatan_id' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'kelurahan_id' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $request->session()->put('registration_step2', $validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
        ]);
    }

    public function saveStep3(Request $request)
    {
        \Log::info('Step 3 Data:', $request->all());

        try {
            $validatedData = $request->validate([
                'ada_alergi' => 'required|boolean',
                'riwayat_penyakit' => 'nullable|string',
                'emergency_nama' => 'required|string|max:255',
                'emergency_nomor' => 'required|string|max:20'
            ]);

            $step1Data = $request->session()->get('registration_step1');
            $step2Data = $request->session()->get('registration_step2');

            \Log::info('Step 1 Data:', $step1Data ?? []);
            \Log::info('Step 2 Data:', $step2Data ?? []);

            if (!$step1Data || !$step2Data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data step sebelumnya tidak ditemukan',
                    'errors' => [
                        'session' => ['Silakan isi form dari awal']
                    ]
                ], 422);
            }

            // Only store the names in database, not the IDs
            $locationData = [
                'provinsi' => $step2Data['provinsi'],
                'kota' => $step2Data['kota'],
                'kecamatan' => $step2Data['kecamatan'],
                'kelurahan' => $step2Data['kelurahan'],
                'alamat' => $step2Data['alamat']
            ];

            $allData = array_merge(
                $step1Data,
                $locationData,
                $validatedData,
                [
                    'status_pembayaran' => 'pending',
                    'amount' => config('registration.fee', 0)
                ]
            );

            \Log::info('Final Data:', $allData);

            $peserta = Peserta::create($allData);

            $request->session()->forget(['registration_step1', 'registration_step2']);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'redirect' => route('payment.show', $peserta->id)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', [
                'errors' => $e->errors(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}