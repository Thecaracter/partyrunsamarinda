@extends('layouts.applanding')

@section('content')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    <!-- Fixed Position Flash Messages -->
    <div class="fixed left-4 bottom-4 z-50 space-y-4 w-80">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg flex items-center shadow-lg animate-fade-in">
                <i class="fas fa-check-circle text-xl mr-2"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg flex items-center shadow-lg animate-fade-in">
                <i class="fas fa-exclamation-circle text-xl mr-2"></i>
                <div>
                    <p class="font-bold">Perhatian!</p>
                    <p class="text-sm">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-lg flex items-center shadow-lg animate-fade-in">
                <i class="fas fa-times-circle text-xl mr-2"></i>
                <div>
                    <p class="font-bold">Error!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- JavaScript Alert Container -->
        <div id="alertContainer" style="display: none;">
            <div class="bg-red-100 text-red-800 p-4 rounded-lg flex items-center shadow-lg animate-fade-in">
                <i class="fas fa-exclamation-circle text-xl mr-2"></i>
                <div>
                    <p class="font-bold">Perhatian!</p>
                    <p class="text-sm" id="alertMessage"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-28 min-h-screen bg-gradient-to-br from-pink-500 to-pink-400 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Alert Container -->
        <div id="alertContainer" class="max-w-4xl mx-auto mb-4" style="display: none;">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <p class="font-bold">Peringatan!</p>
                <p id="alertMessage"></p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Registrasi Party Color Run</h2>
                    <p class="text-gray-600 text-lg">Ayo bergabung dalam keseruan lari berwarna!</p>
                </div>

                <!-- Progress Steps -->
                <div class="flex justify-between items-center mb-12 px-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center relative">
                        <div id="step1Circle"
                            class="w-14 h-14 rounded-full bg-pink-600 flex items-center justify-center text-white text-xl font-bold">
                            1
                        </div>
                        <div id="step1Text" class="text-pink-600 font-medium mt-2">Data Diri</div>
                    </div>

                    <!-- Line 1 -->
                    <div id="line1" class="flex-1 h-1 mx-4 bg-gray-200"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center relative">
                        <div id="step2Circle"
                            class="w-14 h-14 rounded-full bg-gray-200 border-2 border-gray-200 flex items-center justify-center text-gray-600 text-xl font-bold">
                            2
                        </div>
                        <div id="step2Text" class="text-gray-600 font-medium mt-2">Alamat</div>
                    </div>

                    <!-- Line 2 -->
                    <div id="line2" class="flex-1 h-1 mx-4 bg-gray-200"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center relative">
                        <div id="step3Circle"
                            class="w-14 h-14 rounded-full bg-gray-200 border-2 border-gray-200 flex items-center justify-center text-gray-600 text-xl font-bold">
                            3
                        </div>
                        <div id="step3Text" class="text-gray-600 font-medium mt-2">Emergency</div>
                    </div>
                </div>

                <!-- Forms Container -->
                <div class="forms-container">
                    <!-- Step 1 Form -->
                    <form id="step1Form" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Nama BIB -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Nama di BIB
                                </label>
                                <input type="text" name="nama_bib"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Nama yang akan ditampilkan di BIB">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Email
                                </label>
                                <input type="email" name="email"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="email@example.com">
                            </div>

                            <!-- No. WhatsApp -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    No. WhatsApp
                                </label>
                                <input type="tel" name="no_wa"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Contoh: 08123456789">
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Kategori
                                </label>
                                <select name="kategori"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih kategori</option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>

                            <!-- Size Jersey -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Ukuran Jersey
                                </label>
                                <select name="size_id"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih ukuran</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Usia -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Usia
                                </label>
                                <input type="number" name="usia"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Masukkan usia Anda">
                            </div>

                            <!-- Golongan Darah -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Golongan Darah
                                </label>
                                <select name="golongan_darah"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih golongan darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end mt-12">
                            <button type="button" onclick="submitStep1()"
                                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-pink-600 rounded-xl hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                                Lanjutkan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Step 2 Form -->
                    <form id="step2Form" class="space-y-8 hidden">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Provinsi -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Provinsi
                                </label>
                                <select name="provinsi" id="provinsi"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="provinsi_id" id="provinsi_id">
                            </div>

                            <!-- Kota -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Kota
                                </label>
                                <select name="kota" id="kota" disabled
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                </select>
                                <input type="hidden" name="kota_id" id="kota_id">
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Kecamatan
                                </label>
                                <select name="kecamatan" id="kecamatan" disabled
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                </select>
                                <input type="hidden" name="kecamatan_id" id="kecamatan_id">
                            </div>

                            <!-- Kelurahan -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Kelurahan/Desa
                                </label>
                                <select name="kelurahan" id="kelurahan" disabled
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200 bg-white">
                                    <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                </select>
                                <input type="hidden" name="kelurahan_id" id="kelurahan_id">
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Alamat Lengkap
                                </label>
                                <textarea name="alamat" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-between mt-12">
                            <button type="button" onclick="prevStep()"
                                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-pink-600 bg-white border-2 border-pink-600 rounded-xl hover:bg-pink-50 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kembali
                            </button>
                            <button type="button" onclick="submitStep2()"
                                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-pink-600 rounded-xl hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                                Lanjutkan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Step 3 Form -->
                    <form id="step3Form" class="space-y-8 hidden">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Ada Alergi -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Apakah Ada Alergi?
                                </label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="ada_alergi" value="1"
                                            class="form-radio h-5 w-5 text-pink-600">
                                        <span class="ml-2 text-gray-700">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="ada_alergi" value="0"
                                            class="form-radio h-5 w-5 text-pink-600">
                                        <span class="ml-2 text-gray-700">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Riwayat Penyakit -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Riwayat Penyakit
                                </label>
                                <textarea name="riwayat_penyakit" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Masukkan riwayat penyakit (opsional)"></textarea>
                            </div>

                            <!-- Emergency Nama -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Nama Kontak Darurat
                                </label>
                                <input type="text" name="emergency_nama"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Masukkan nama kontak darurat">
                            </div>

                            <!-- Emergency Nomor -->
                            <div>
                                <label class="block text-gray-700 text-lg font-semibold mb-2">
                                    Nomor Kontak Darurat
                                </label>
                                <input type="tel" name="emergency_nomor"
                                    class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                                    placeholder="Contoh: 08123456789">
                            </div>

                            <div class="md:col-span-2 mt-8">
                                <div class="bg-pink-50 p-6 rounded-xl border border-pink-200">
                                    <h4 class="font-semibold text-lg text-gray-900 mb-4">Syarat dan Ketentuan</h4>
                                    <label class="flex items-start">
                                        <input type="checkbox" name="agreement" id="agreement"
                                            class="mt-1 h-5 w-5 text-pink-600 rounded focus:ring-pink-500">
                                        <span class="ml-3 text-gray-700">
                                            Saya telah membaca dan menyetujui
                                            <a href="#" target="_blank"
                                                class="text-pink-600 font-semibold hover:text-pink-700 underline">
                                                syarat dan ketentuan
                                            </a>
                                            yang berlaku
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-12">
                            <button type="button" onclick="prevStep()"
                                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-pink-600 bg-white border-2 border-pink-600 rounded-xl hover:bg-pink-50 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kembali
                            </button>
                            <button type="button" onclick="submitStep3()"
                                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-pink-600 rounded-xl hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                                Selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function showAlert(message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertMessage = document.getElementById('alertMessage');
            alertMessage.textContent = message;
            alertContainer.style.display = 'block';

            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 3000);
        }

        function updateStepIndicator(step) {
            for (let i = 1; i <= totalSteps; i++) {
                const circle = document.getElementById(`step${i}Circle`);
                const text = document.getElementById(`step${i}Text`);
                const line = i < totalSteps ? document.getElementById(`line${i}`) : null;

                if (i < step) {
                    circle.classList.remove('bg-gray-200', 'border-gray-200', 'text-gray-600');
                    circle.classList.add('bg-pink-600', 'text-white');
                    text.classList.remove('text-gray-600');
                    text.classList.add('text-pink-600');
                    if (line) line.classList.add('bg-pink-600');
                } else if (i === step) {
                    circle.classList.remove('bg-gray-200', 'border-gray-200', 'text-gray-600');
                    circle.classList.add('bg-pink-600', 'text-white');
                    text.classList.remove('text-gray-600');
                    text.classList.add('text-pink-600');
                } else {
                    circle.classList.remove('bg-pink-600', 'text-white');
                    circle.classList.add('bg-gray-200', 'border-gray-200', 'text-gray-600');
                    text.classList.remove('text-pink-600');
                    text.classList.add('text-gray-600');
                    if (line) line.classList.remove('bg-pink-600');
                }
            }
        }

        function showStep(step) {
            document.getElementById(`step1Form`).classList.add('hidden');
            document.getElementById(`step2Form`).classList.add('hidden');
            document.getElementById(`step3Form`).classList.add('hidden');

            document.getElementById(`step${step}Form`).classList.remove('hidden');
            currentStep = step;
            updateStepIndicator(step);
        }

        function prevStep() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }

        function validateForm(formId) {
            const form = document.getElementById(formId);
            let isValid = true;
            const requiredFields = form.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select, textarea'
            );

            requiredFields.forEach(field => {
                if (!field.value && field.name !== 'riwayat_penyakit') {
                    isValid = false;
                    field.classList.add('border-red-500');

                    let errorMsg = field.parentElement.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                        errorMsg.textContent = 'Field ini wajib diisi';
                        field.parentElement.appendChild(errorMsg);
                    }
                } else {
                    field.classList.remove('border-red-500');
                    const errorMsg = field.parentElement.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });

            return isValid;
        }

        async function loadProvinces() {
            try {
                const response = await fetch('/registrasi/provinces');
                const provinces = await response.json();
                const provinsiSelect = document.getElementById('provinsi');

                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.dataset.id = province.id;
                    option.textContent = province.name;
                    provinsiSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading provinces:', error);
                showAlert('Gagal memuat data provinsi');
            }
        }

        async function loadCities(provinceId, provinceName) {
            try {
                const response = await fetch(`/registrasi/cities/${provinceId}`);
                const cities = await response.json();
                const kotaSelect = document.getElementById('kota');

                kotaSelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                kotaSelect.disabled = false;

                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.dataset.id = city.id;
                    option.textContent = city.name;
                    kotaSelect.appendChild(option);
                });

                document.getElementById('provinsi_id').value = provinceId;
            } catch (error) {
                console.error('Error loading cities:', error);
                showAlert('Gagal memuat data kota');
            }
        }

        async function loadDistricts(cityId, cityName) {
            try {
                const response = await fetch(`/registrasi/districts/${cityId}`);
                const districts = await response.json();
                const kecamatanSelect = document.getElementById('kecamatan');

                kecamatanSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                kecamatanSelect.disabled = false;

                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.dataset.id = district.id;
                    option.textContent = district.name;
                    kecamatanSelect.appendChild(option);
                });

                document.getElementById('kota_id').value = cityId;
            } catch (error) {
                console.error('Error loading districts:', error);
                showAlert('Gagal memuat data kecamatan');
            }
        }

        async function loadVillages(districtId, districtName) {
            try {
                const response = await fetch(`/registrasi/villages/${districtId}`);
                const villages = await response.json();
                const kelurahanSelect = document.getElementById('kelurahan');

                kelurahanSelect.innerHTML = '<option value="" disabled selected>Pilih Kelurahan/Desa</option>';
                kelurahanSelect.disabled = false;

                villages.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village.name;
                    option.dataset.id = village.id;
                    option.textContent = village.name;
                    kelurahanSelect.appendChild(option);
                });

                document.getElementById('kecamatan_id').value = districtId;
            } catch (error) {
                console.error('Error loading villages:', error);
                showAlert('Gagal memuat data kelurahan');
            }
        }

        function submitStep1() {
            if (!validateForm('step1Form')) {
                showAlert('Harap lengkapi semua field yang diperlukan.');
                return;
            }

            const emailField = document.querySelector('input[name="email"]');
            if (emailField.value && !emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                emailField.classList.add('border-red-500');
                showAlert('Format email tidak valid');
                return;
            }

            const waField = document.querySelector('input[name="no_wa"]');
            if (waField.value && !waField.value.match(/^(\+62|62|0)[0-9]{9,12}$/)) {
                waField.classList.add('border-red-500');
                showAlert('Format nomor WhatsApp tidak valid');
                return;
            }

            const formData = new FormData(document.getElementById('step1Form'));

            fetch('/registrasi/step1', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw {
                        response,
                        data
                    };

                    const formObject = {};
                    formData.forEach((value, key) => {
                        formObject[key] = value;
                    });
                    sessionStorage.setItem('step1Data', JSON.stringify(formObject));

                    showStep(2);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert(error.data?.message || 'Terjadi kesalahan saat menyimpan data.');
                });
        }

        function submitStep2() {
            if (!validateForm('step2Form')) {
                showAlert('Harap lengkapi semua field yang diperlukan.');
                return;
            }

            const formData = new FormData(document.getElementById('step2Form'));

            const provinsiSelect = document.getElementById('provinsi');
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');

            formData.append('provinsi_nama', provinsiSelect.options[provinsiSelect.selectedIndex].text);
            formData.append('kota_nama', kotaSelect.options[kotaSelect.selectedIndex].text);
            formData.append('kecamatan_nama', kecamatanSelect.options[kecamatanSelect.selectedIndex].text);
            formData.append('kelurahan_nama', kelurahanSelect.options[kelurahanSelect.selectedIndex].text);

            fetch('/registrasi/step2', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw {
                        response,
                        data
                    };

                    const formObject = {};
                    formData.forEach((value, key) => {
                        formObject[key] = value;
                    });
                    sessionStorage.setItem('step2Data', JSON.stringify(formObject));

                    showStep(3);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert(error.data?.message || 'Terjadi kesalahan saat menyimpan data.');
                });
        }

        function submitStep3() {
            if (!validateForm('step3Form')) {
                showAlert('Harap lengkapi semua field yang diperlukan.');
                return;
            }

            // Validasi checkbox persetujuan
            const agreementCheckbox = document.getElementById('agreement');
            if (!agreementCheckbox.checked) {
                showAlert('Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.');
                agreementCheckbox.parentElement.classList.add('text-red-500');
                return;
            }

            const formData = new FormData(document.getElementById('step3Form'));

            fetch('/registrasi/step3', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw {
                        response,
                        data
                    };

                    if (data.success) {
                        sessionStorage.removeItem('step1Data');
                        sessionStorage.removeItem('step2Data');
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.data?.errors) {
                        const firstError = Object.values(error.data.errors)[0][0];
                        showAlert(firstError);
                    } else {
                        showAlert(error.data?.message || 'Terjadi kesalahan saat mengirim data.');
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Load provinces on page load
            loadProvinces();

            // Event listeners for region selects
            document.getElementById('provinsi').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const provinceId = selectedOption.dataset.id;
                loadCities(provinceId, this.value);

                // Reset dependent fields
                document.getElementById('kecamatan').innerHTML =
                    '<option value="" disabled selected>Pilih Kecamatan</option>';
                document.getElementById('kecamatan').disabled = true;
                document.getElementById('kelurahan').innerHTML =
                    '<option value="" disabled selected>Pilih Kelurahan/Desa</option>';
                document.getElementById('kelurahan').disabled = true;
            });

            document.getElementById('kota').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const cityId = selectedOption.dataset.id;
                loadDistricts(cityId, this.value);

                document.getElementById('kelurahan').innerHTML =
                    '<option value="" disabled selected>Pilih Kelurahan/Desa</option>';
                document.getElementById('kelurahan').disabled = true;
            });

            document.getElementById('kecamatan').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const districtId = selectedOption.dataset.id;
                loadVillages(districtId, this.value);
            });

            document.getElementById('kelurahan').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('kelurahan_id').value = selectedOption.dataset.id;
            });

            // Clear error on input
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                    const errorMsg = this.parentElement.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                });
            });

            const step1Data = sessionStorage.getItem('step1Data');
            if (step1Data) {
                const data = JSON.parse(step1Data);
                for (const [key, value] of Object.entries(data)) {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field) field.value = value;
                }
            }
        });

        function showAlert(message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertMessage = document.getElementById('alertMessage');

            // Reset animation
            alertContainer.classList.remove('animate-fade-in');
            void alertContainer.offsetWidth; // Trigger reflow
            alertContainer.classList.add('animate-fade-in');

            alertMessage.textContent = message;
            alertContainer.style.display = 'block';

            // Auto hide setelah 5 detik
            setTimeout(() => {
                alertContainer.style.opacity = '0';
                setTimeout(() => {
                    alertContainer.style.display = 'none';
                    alertContainer.style.opacity = '1';
                }, 300);
            }, 5000);
        }
    </script>
@endpush
