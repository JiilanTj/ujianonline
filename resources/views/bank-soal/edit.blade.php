<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ $bankSoal->nama_bank_soal }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 flex items-center">
                    <i class="fas fa-book-open mr-2"></i>{{ $bankSoal->mataPelajaran->nama }} • 
                    <span class="capitalize ml-1 inline-flex items-center">
                        <i class="fas fa-layer-group mr-1"></i>
                        {{ str_replace('_', ' ', $bankSoal->tipe) }}
                    </span>
                </p>
            </div>
            <a href="{{ route('bank-soal.index') }}" 
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 
                      flex items-center shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex items-center transform animate-fade-in-down">
                    <i class="fas fa-check-circle mr-2 text-lg"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Daftar Soal -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list-alt mr-2 text-blue-600"></i>
                            Daftar Soal
                        </h3>
                        <span class="px-3 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded-full text-sm font-medium" id="soalCount">
                            0 Soal
                        </span>
                    </div>
                    
                    <div id="soalList" class="space-y-2">
                        <!-- Empty state -->
                        <div class="text-center text-gray-500 py-6" id="emptySoal">
                            <i class="fas fa-book text-4xl mb-2 text-gray-300"></i>
                            <p class="text-base">Belum ada soal. Silakan tambahkan soal baru.</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="flex justify-center items-center space-x-1.5 mt-4">
                        <!-- Pagination akan di-render di sini -->
                    </div>
                </div>
            </div>

            <!-- Form Tambah Soal -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-6">
                        <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                        Tambah Soal Baru
                    </h3>
                    
                    <form id="formSoal" class="space-y-6">
                        @csrf
                        <!-- Tipe Soal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipe Soal <span class="text-red-500">*</span>
                            </label>
                            <select id="tipe_soal" name="tipe" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="pilihan_ganda">Pilihan Ganda</option>
                                <option value="essay">Essay</option>
                            </select>
                        </div>

                        <!-- Pertanyaan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pertanyaan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="pertanyaan" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                        </div>

                        <!-- Pilihan (untuk Pilihan Ganda) -->
                        <div id="pilihanSection">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pilihan A <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="pilihan_a" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pilihan B <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="pilihan_b" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pilihan C
                                    </label>
                                    <input type="text" name="pilihan_c" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pilihan D
                                    </label>
                                    <input type="text" name="pilihan_d" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pilihan E
                                    </label>
                                    <input type="text" name="pilihan_e" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Jawaban -->
                        <div id="jawabanSection">
                            <div id="jawabanPG">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Jawaban Benar <span class="text-red-500">*</span>
                                </label>
                                <select name="jawaban_benar" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                    <option value="e">E</option>
                                </select>
                            </div>
                            <div id="jawabanEssay" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kunci Jawaban <span class="text-red-500">*</span>
                                </label>
                                <textarea name="kunci_jawaban" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <!-- Pembahasan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pembahasan
                            </label>
                            <textarea name="pembahasan" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tingkat Kesulitan <span class="text-red-500">*</span>
                            </label>
                            <select name="tingkat_kesulitan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="1">Mudah</option>
                                <option value="2">Sedang</option>
                                <option value="3">Sulit</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-8">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center w-auto min-w-[200px] h-12
                                           bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 
                                           hover:from-blue-700 hover:via-blue-800 hover:to-indigo-700
                                           text-white text-base font-semibold
                                           rounded-xl
                                           shadow-lg hover:shadow-xl
                                           transform hover:-translate-y-0.5 
                                           transition-all duration-200 ease-in-out
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus-circle text-lg mr-2"></i>
                                <span class="mr-1">Tambah Soal</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankSoalId = {{ $bankSoal->id }};
            const formSoal = document.getElementById('formSoal');
            const soalList = document.getElementById('soalList');
            const emptySoal = document.getElementById('emptySoal');
            const tipeSoal = document.getElementById('tipe_soal');
            const pilihanSection = document.getElementById('pilihanSection');
            const jawabanPG = document.getElementById('jawabanPG');
            const jawabanEssay = document.getElementById('jawabanEssay');
            
            // Toggle form berdasarkan tipe soal
            tipeSoal.addEventListener('change', function() {
                toggleFormFields(this.value);
            });

            function toggleFormFields(type) {
                if (type === 'pilihan_ganda') {
                    pilihanSection.style.display = 'block';
                    jawabanPG.style.display = 'block';
                    jawabanEssay.style.display = 'none';
                    // Set required attributes
                    document.querySelectorAll('[name="pilihan_a"], [name="pilihan_b"], [name="jawaban_benar"]')
                        .forEach(el => el.required = true);
                    document.querySelector('[name="kunci_jawaban"]').required = false;
                } else {
                    pilihanSection.style.display = 'none';
                    jawabanPG.style.display = 'none';
                    jawabanEssay.style.display = 'block';
                    // Set required attributes
                    document.querySelectorAll('[name="pilihan_a"], [name="pilihan_b"], [name="jawaban_benar"]')
                        .forEach(el => el.required = false);
                    document.querySelector('[name="kunci_jawaban"]').required = true;
                }
            }

            // Tambahkan state untuk pagination
            let currentPage = 1;
            const itemsPerPage = 5;

            // Update fungsi loadSoal dengan pagination
            async function loadSoal() {
                try {
                    const response = await fetch(`/bank-soal/${bankSoalId}/soal`);
                    if (!response.ok) throw new Error('Failed to load soal');
                    
                    const data = await response.json();
                    console.log('Loaded soal:', data);

                    if (data.length === 0) {
                        emptySoal.style.display = 'block';
                        document.getElementById('soalCount').textContent = '0 Soal';
                        return;
                    }

                    emptySoal.style.display = 'none';
                    document.getElementById('soalCount').textContent = `${data.length} Soal`;
                    
                    // Render pagination
                    const totalPages = Math.ceil(data.length / itemsPerPage);
                    renderPagination(totalPages);

                    // Get current page data
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    const currentData = data.slice(startIndex, endIndex);
                    
                    // Render soal list
                    renderSoalList(currentData);
                } catch (error) {
                    console.error('Error loading soal:', error);
                    soalList.innerHTML = `
                        <div class="text-center text-red-500 py-4">
                            <p>Gagal memuat data soal</p>
                            <p class="text-sm">${error.message}</p>
                        </div>
                    `;
                }
            }

            // Fungsi untuk render pagination
            function renderPagination(totalPages) {
                const pagination = document.getElementById('pagination');
                let paginationHTML = '';

                paginationHTML += `
                    <button onclick="changePage(${currentPage - 1})" 
                            class="p-2 rounded-md ${currentPage === 1 
                                ? 'bg-gray-50 text-gray-400 cursor-not-allowed' 
                                : 'bg-white text-gray-700 hover:bg-gray-50'} 
                            transition-all duration-200"
                            ${currentPage === 1 ? 'disabled' : ''}>
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                `;

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `
                        <button onclick="changePage(${i})" 
                                class="w-8 h-8 flex items-center justify-center rounded-md transition-all duration-200 text-sm
                                ${currentPage === i 
                                    ? 'bg-blue-600 text-white' 
                                    : 'bg-white text-gray-700 hover:bg-gray-50'}">
                            ${i}
                        </button>
                    `;
                }

                paginationHTML += `
                    <button onclick="changePage(${currentPage + 1})" 
                            class="p-2 rounded-md ${currentPage === totalPages 
                                ? 'bg-gray-50 text-gray-400 cursor-not-allowed' 
                                : 'bg-white text-gray-700 hover:bg-gray-50'} 
                            transition-all duration-200"
                            ${currentPage === totalPages ? 'disabled' : ''}>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                `;

                pagination.innerHTML = paginationHTML;
            }

            // Fungsi untuk render daftar soal
            function renderSoalList(soalData) {
                soalList.innerHTML = soalData.map((soal, index) => `
                    <div class="bg-gray-50 rounded-lg p-3 relative group hover:shadow-sm transition-all duration-200 border border-gray-100">
                        <div class="absolute right-2 top-2 opacity-0 group-hover:opacity-100 transition-all duration-200 flex space-x-1">
                            <button onclick="editSoal(${soal.id})" 
                                    class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded-md transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteSoal(${soal.id})" 
                                    class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded-md transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="pr-16"> <!-- Memberikan ruang untuk tombol aksi -->
                            <!-- Header & Badges -->
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 bg-gradient-to-r from-blue-50 to-blue-100 
                                             text-blue-700 text-xs font-medium rounded-full">
                                    #${((currentPage - 1) * itemsPerPage) + index + 1}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 
                                             ${soal.tipe === 'pilihan_ganda' 
                                               ? 'bg-gradient-to-r from-green-50 to-green-100 text-green-700' 
                                               : 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700'} 
                                             text-xs font-medium rounded-full">
                                    ${soal.tipe === 'pilihan_ganda' ? 'PG' : 'Essay'}
                                </span>
                            </div>

                            <!-- Pertanyaan & Jawaban dalam satu baris -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 line-clamp-2">${soal.pertanyaan}</p>
                                </div>
                                <div class="text-sm whitespace-nowrap">
                                    ${soal.tipe === 'pilihan_ganda' 
                                      ? `<span class="font-medium text-green-600">Jawaban: ${soal.jawaban_benar.toUpperCase()}</span>`
                                      : `<span class="font-medium text-purple-600">Essay</span>`
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Fungsi untuk ganti halaman
            window.changePage = function(page) {
                const totalPages = Math.ceil(data.length / itemsPerPage);
                if (page < 1 || page > totalPages) return;
                
                currentPage = page;
                loadSoal();
            }

            // Helper functions
            function getDifficultyColor(level) {
                return {
                    1: 'green',
                    2: 'yellow',
                    3: 'red'
                }[level] || 'gray';
            }

            function getDifficultyText(level) {
                return {
                    1: 'Mudah',
                    2: 'Sedang',
                    3: 'Sulit'
                }[level] || 'Unknown';
            }

            // Submit soal baru
            formSoal.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menambahkan...
                `;

                try {
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData);
                    
                    const response = await fetch(`/bank-soal/${bankSoalId}/soal`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Gagal menambahkan soal');
                    }

                    this.reset();
                    loadSoal();
                    
                    // Success Alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Soal berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                    
                    // Error Alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#3B82F6',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    });
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = `
                        <i class="fas fa-plus-circle text-xl mr-2"></i>
                        <span class="mr-1">Tambah Soal</span>
                    `;
                }
            });

            // Delete soal
            window.deleteSoal = async function(soalId) {
                // Konfirmasi delete dengan SweetAlert
                const result = await Swal.fire({
                    title: 'Hapus Soal?',
                    text: "Soal yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    }
                });

                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/bank-soal/${bankSoalId}/soal/${soalId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error('Gagal menghapus soal');

                        loadSoal();
                        
                        // Success delete alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Soal berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                popup: 'animated fadeInDown faster'
                            }
                        });
                    } catch (error) {
                        console.error('Error:', error);
                        
                        // Error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message,
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#3B82F6',
                            customClass: {
                                popup: 'animated fadeInDown faster'
                            }
                        });
                    }
                }
            };

            // Optional: Tambahkan CSS untuk animasi
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeInDown {
                    from {
                        opacity: 0;
                        transform: translate3d(0, -20px, 0);
                    }
                    to {
                        opacity: 1;
                        transform: translate3d(0, 0, 0);
                    }
                }
                .animated {
                    animation-duration: 0.3s;
                    animation-fill-mode: both;
                }
                .fadeInDown {
                    animation-name: fadeInDown;
                }
                .faster {
                    animation-duration: 0.2s;
                }
            `;
            document.head.appendChild(style);

            // Initial setup
            toggleFormFields(tipeSoal.value);
            loadSoal();
        });
    </script>
    @endpush
</x-app-layout> 