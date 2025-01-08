<?php

namespace App\Http\Controllers\User;

use App\Models\Size;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RegistrasiController extends Controller
{
    public function index()
    {
        $sizes = Size::where('stock', '>', 0)->get();
        $registrationFee = number_format(config('registration.fee'), 0, ',', '.');
        // return view('user.registrasi', compact('sizes', 'registrationFee'));
        return view('maintenace', compact('sizes', 'registrationFee'));
    }

    public function getProvinces()
    {
        try {
            $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data provinsi. Silakan coba lagi.'
            ], 500);
        }
    }

    public function getCities($provinceId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kota. Silakan coba lagi.'
            ], 500);
        }
    }

    public function getDistricts($cityId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kecamatan. Silakan coba lagi.'
            ], 500);
        }
    }

    public function getVillages($districtId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kelurahan. Silakan coba lagi.'
            ], 500);
        }
    }

    public function saveStep1(Request $request)
    {
        try {
            // Cek no_wa yang sudah terdaftar
            $existingPhone = Peserta::where('no_wa', $request->no_wa)->first();

            if ($existingPhone) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Wa/telepon tidak boleh sama',
                    'errors' => [
                        'no_wa' => [
                            sprintf(
                                'Nomor WhatsApp %s sudah terdaftar atas nama %s pada tanggal %s. Silakan gunakan nomor lain atau hubungi panitia jika ini adalah nomor Anda.',
                                $request->no_wa,
                                $existingPhone->nama_lengkap,
                                $existingPhone->created_at->format('d-m-Y H:i')
                            )
                        ]
                    ],
                    'error_fields' => ['no_wa'],
                    'submitted_data' => $request->only(['no_wa'])
                ], 422);
            }

            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nama_bib' => 'required|string|max:255',
                'email' => 'required|email',
                'no_wa' => [
                    'required',
                    'string',
                    'regex:/^(\+62|62|0)[0-9]{9,12}$/',
                    'unique:peserta,no_wa'
                ],
                'usia' => 'required|numeric|min:1|max:150',
                'kategori' => 'required|in:Pelajar,Umum,Master',
                'size_id' => 'required|exists:sizes,id',
                'golongan_darah' => 'required|in:A,B,AB,O'
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
                'nama_bib.required' => 'Nama BIB wajib diisi',
                'nama_bib.max' => 'Nama BIB maksimal 255 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'no_wa.required' => 'Nomor WhatsApp wajib diisi',
                'no_wa.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789)',
                'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar',
                'usia.required' => 'Usia wajib diisi',
                'usia.numeric' => 'Usia harus berupa angka',
                'usia.min' => 'Usia minimal 1 tahun',
                'usia.max' => 'Usia maksimal 150 tahun',
                'kategori.required' => 'Kategori wajib dipilih',
                'kategori.in' => 'Kategori tidak valid',
                'size_id.required' => 'Ukuran jersey wajib dipilih',
                'size_id.exists' => 'Ukuran jersey tidak valid atau sudah habis',
                'golongan_darah.required' => 'Golongan darah wajib dipilih',
                'golongan_darah.in' => 'Golongan darah tidak valid'
            ]);

            $request->session()->put('registration_step1', $validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $failedFields = array_keys($errors);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal pada field: ' . implode(', ', $failedFields),
                'errors' => $errors,
                'error_fields' => $failedFields,
                'submitted_data' => $request->only([
                    'nama_lengkap',
                    'nama_bib',
                    'email',
                    'no_wa',
                    'usia',
                    'kategori',
                    'size_id',
                    'golongan_darah'
                ])
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Registration Step 1 Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan data. Detail: ' . $e->getMessage(),
                'error_detail' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    public function saveStep2(Request $request)
    {
        try {
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
            ], [
                'provinsi_id.required' => 'Provinsi wajib dipilih',
                'provinsi.required' => 'Provinsi wajib dipilih',
                'kota_id.required' => 'Kota/Kabupaten wajib dipilih',
                'kota.required' => 'Kota/Kabupaten wajib dipilih',
                'kecamatan_id.required' => 'Kecamatan wajib dipilih',
                'kecamatan.required' => 'Kecamatan wajib dipilih',
                'kelurahan_id.required' => 'Kelurahan/Desa wajib dipilih',
                'kelurahan.required' => 'Kelurahan/Desa wajib dipilih',
                'alamat.required' => 'Alamat lengkap wajib diisi'
            ]);

            $request->session()->put('registration_step2', $validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Data alamat berhasil disimpan'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $failedFields = array_keys($errors);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal pada field: ' . implode(', ', $failedFields),
                'errors' => $errors,
                'error_fields' => $failedFields,
                'submitted_data' => $request->only([
                    'provinsi_id',
                    'provinsi',
                    'kota_id',
                    'kota',
                    'kecamatan_id',
                    'kecamatan',
                    'kelurahan_id',
                    'kelurahan',
                    'alamat'
                ])
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Registration Step 2 Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan alamat. Detail: ' . $e->getMessage(),
                'error_detail' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    public function saveStep3(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'ada_alergi' => 'required|boolean',
                'riwayat_penyakit' => 'nullable|string',
                'emergency_nama' => 'required|string|max:255',
                'emergency_nomor' => ['required', 'string', 'regex:/^(\+62|62|0)[0-9]{9,12}$/']
            ], [
                'ada_alergi.required' => 'Status alergi wajib dipilih',
                'ada_alergi.boolean' => 'Status alergi tidak valid',
                'emergency_nama.required' => 'Nama kontak darurat wajib diisi',
                'emergency_nama.max' => 'Nama kontak darurat maksimal 255 karakter',
                'emergency_nomor.required' => 'Nomor kontak darurat wajib diisi',
                'emergency_nomor.regex' => 'Format nomor kontak darurat tidak valid (contoh: 08123456789)'
            ]);

            $step1Data = $request->session()->get('registration_step1');
            $step2Data = $request->session()->get('registration_step2');

            if (!$step1Data || !$step2Data) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data pendaftaran tidak lengkap',
                    'errors' => [
                        'session' => ['Session data tidak ditemukan. Mohon ulangi pendaftaran dari awal.']
                    ],
                    'error_fields' => ['session']
                ], 422);
            }

            // Cek size tersedia
            $size = Size::find($step1Data['size_id']);
            if (!$size) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran gagal',
                    'errors' => [
                        'size' => ['Ukuran jersey yang dipilih tidak valid.']
                    ],
                    'error_fields' => ['size']
                ], 422);
            }

            // Cek stock
            if ($size->stock <= 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran gagal',
                    'errors' => [
                        'size' => ['Maaf, stok jersey untuk ukuran yang dipilih sudah habis. Silakan pilih ukuran lain.']
                    ],
                    'error_fields' => ['size']
                ], 422);
            }

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
                    'amount' => config('registration.fee')
                ]
            );

            $peserta = Peserta::create($allData);

            // Hapus data session
            $request->session()->forget(['registration_step1', 'registration_step2']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan lanjutkan ke pembayaran.',
                'redirect' => route('payment.show', $peserta->id)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            $errors = $e->errors();
            $failedFields = array_keys($errors);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal pada field: ' . implode(', ', $failedFields),
                'errors' => $errors,
                'error_fields' => $failedFields,
                'submitted_data' => $request->only([
                    'ada_alergi',
                    'riwayat_penyakit',
                    'emergency_nama',
                    'emergency_nomor'
                ])
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration Step 3 Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'step1_data' => $request->session()->get('registration_step1'),
                'step2_data' => $request->session()->get('registration_step2')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyelesaikan pendaftaran. Silakan coba lagi.',
                'error_detail' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }
    }
}