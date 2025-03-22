<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Buat Bank Soal Baru') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Buat kumpulan soal baru untuk ujian</p>
            </div>
            <a href="{{ route('bank-soal.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 flex items-center shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <form action="{{ route('bank-soal.store') }}" method="POST" class="divide-y divide-gray-200">
                    @csrf
                    
                    <!-- Informasi Dasar -->
                    <div class="p-8 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Bank Soal</h3>
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Nama Bank Soal -->
                            <div class="col-span-2">
                                <label for="nama_bank_soal" class="block text-sm font-medium text-gray-700">
                                    Nama Bank Soal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_bank_soal" id="nama_bank_soal" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: UTS Matematika Kelas X Semester 1" required>
                            </div>

                            <!-- Mata Pelajaran -->
                            <div>
                                <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700">
                                    Mata Pelajaran <span class="text-red-500">*</span>
                                </label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mataPelajaran as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipe Bank Soal -->
                            <div>
                                <label for="tipe" class="block text-sm font-medium text-gray-700">
                                    Tipe Soal <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe" id="tipe" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih Tipe Soal</option>
                                    <option value="pilihan_ganda">Pilihan Ganda</option>
                                    <option value="essay">Essay</option>
                                    <option value="kombinasi">Kombinasi</option>
                                </select>
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                    Deskripsi
                                    <span class="text-xs text-gray-500">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tambahkan deskripsi atau petunjuk pengerjaan soal"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="px-8 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                        <button type="button" onclick="window.location.href='{{ route('bank-soal.index') }}'" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                            Buat Bank Soal dan Lanjut Tambah Soal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Setelah membuat bank soal, Anda akan diarahkan ke halaman untuk menambahkan soal-soal ke dalam bank soal ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validasi form
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi');
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 