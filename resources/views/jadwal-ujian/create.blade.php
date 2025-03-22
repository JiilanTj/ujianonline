<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Tambah Jadwal Ujian') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Buat jadwal ujian baru dan pilih kelas yang akan mengikuti
                </p>
            </div>
            <a href="{{ route('jadwal-ujian.index') }}" 
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 
                      flex items-center shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <form action="{{ route('jadwal-ujian.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ujian -->
                        <div class="col-span-2">
                            <label for="nama_ujian" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Ujian <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-pen text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_ujian" id="nama_ujian" 
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('nama_ujian') }}" required>
                            </div>
                            @error('nama_ujian')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bank Soal -->
                        <div class="col-span-2">
                            <label for="bank_soal_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Bank Soal <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <select name="bank_soal_id" id="bank_soal_id" 
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih Bank Soal</option>
                                    @foreach($bankSoal as $bs)
                                        <option value="{{ $bs->id }}" {{ old('bank_soal_id') == $bs->id ? 'selected' : '' }}>
                                            {{ $bs->nama_bank_soal }} ({{ $bs->mataPelajaran->nama }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('bank_soal_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Mulai -->
                        <div>
                            <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai"
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('waktu_mulai') }}" required>
                            </div>
                            @error('waktu_mulai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div>
                            <label for="durasi" class="block text-sm font-medium text-gray-700 mb-1">
                                Durasi (menit) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hourglass-half text-gray-400"></i>
                                </div>
                                <input type="number" name="durasi" id="durasi" min="1"
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('durasi') }}" required>
                            </div>
                            @error('durasi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Selesai (Auto-calculated) -->
                        <div>
                            <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-1">
                                Waktu Selesai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-flag-checkered text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    value="{{ old('waktu_selesai') }}" required readonly>
                            </div>
                            @error('waktu_selesai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Kelas <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($kelas as $k)
                                        <div class="flex items-center p-2 rounded-lg hover:bg-white transition-colors duration-200">
                                            <input type="checkbox" name="kelas_ids[]" id="kelas_{{ $k->id }}"
                                                value="{{ $k->id }}" 
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                {{ in_array($k->id, old('kelas_ids', [])) ? 'checked' : '' }}>
                                            <label for="kelas_{{ $k->id }}" class="ml-2 text-sm text-gray-700">
                                                {{ $k->tingkat }} {{ $k->jurusan }} - {{ $k->nama_kelas }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('kelas_ids')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instruksi -->
                        <div class="col-span-2">
                            <label for="instruksi" class="block text-sm font-medium text-gray-700 mb-1">
                                Instruksi Ujian
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                </div>
                                <textarea name="instruksi" id="instruksi" rows="4"
                                    class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >{{ old('instruksi') }}</textarea>
                            </div>
                            @error('instruksi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('jadwal-ujian.index') }}" 
                           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 
                                  transition-all duration-200 text-gray-700 text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 
                                       hover:from-blue-700 hover:via-blue-800 hover:to-indigo-700
                                       text-white text-sm font-medium rounded-lg
                                       shadow-lg hover:shadow-xl
                                       transform hover:-translate-y-0.5 
                                       transition-all duration-200 ease-in-out
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Buat Jadwal Ujian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const waktuMulai = document.getElementById('waktu_mulai');
            const waktuSelesai = document.getElementById('waktu_selesai');
            const durasi = document.getElementById('durasi');

            function updateWaktuSelesai() {
                if (waktuMulai.value && durasi.value) {
                    const startTime = new Date(waktuMulai.value);
                    const endTime = new Date(startTime);
                    endTime.setMinutes(startTime.getMinutes() + parseInt(durasi.value));
                    
                    const year = endTime.getFullYear();
                    const month = String(endTime.getMonth() + 1).padStart(2, '0');
                    const day = String(endTime.getDate()).padStart(2, '0');
                    const hours = String(endTime.getHours()).padStart(2, '0');
                    const minutes = String(endTime.getMinutes()).padStart(2, '0');
                    
                    waktuSelesai.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                }
            }

            waktuMulai.addEventListener('change', updateWaktuSelesai);
            durasi.addEventListener('input', updateWaktuSelesai);
        });
    </script>
    @endpush
</x-app-layout> 