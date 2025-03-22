<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Bank Soal') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Kelola soal-soal dalam sistem</p>
            </div>
            <a href="{{ route('bank-soal.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Soal
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('bank-soal.index') }}" class="flex justify-between items-center">
                    <!-- Search Box -->
                    <div class="relative w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari soal..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center space-x-4">
                        <div class="w-48">
                            <select name="tipe" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                                <option value="">Semua Tipe</option>
                                <option value="pilihan_ganda" {{ request('tipe') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                <option value="essay" {{ request('tipe') == 'essay' ? 'selected' : '' }}>Essay</option>
                                <option value="kombinasi" {{ request('tipe') == 'kombinasi' ? 'selected' : '' }}>Kombinasi</option>
                            </select>
                        </div>
                        <button id="mapelManagerBtn" type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 flex items-center">
                            <i class="fas fa-book mr-2 text-gray-600"></i>
                            Kelola Mapel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Soal List -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-900 to-indigo-900">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Bank Soal</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Dibuat Oleh</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bankSoal as $soal)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $soal->nama_bank_soal }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $soal->mataPelajaran->nama }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $soal->tipe === 'pilihan_ganda' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ str_replace('_', ' ', ucfirst($soal->tipe)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ Str::limit($soal->deskripsi, 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $soal->creator->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('bank-soal.edit', $soal) }}" 
                                                   class="text-blue-600 hover:text-blue-900 bg-blue-100 p-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('bank-soal.destroy', $soal) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Yakin ingin menghapus bank soal ini?')" 
                                                            class="text-red-600 hover:text-red-900 bg-red-100 p-2 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center py-6">
                                                <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                                                <p class="text-lg font-medium">Belum ada bank soal</p>
                                                <p class="text-sm text-gray-500">Silakan tambahkan bank soal baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $bankSoal->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mata Pelajaran -->
    <div id="mapelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Manajemen Mata Pelajaran</h3>
                <button id="closeMapelModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Alert Messages -->
            <div id="mapelAlert" class="hidden mb-4"></div>

            <!-- Form Tambah Mapel -->
            <form id="mapelForm" class="mb-4">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran</label>
                        <input type="text" id="nama" name="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Contoh: Matematika" required>
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tambah Mata Pelajaran
                    </button>
                </div>
            </form>

            <!-- Daftar Mata Pelajaran -->
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Daftar Mata Pelajaran</h4>
                <div id="mapelList" class="space-y-2 max-h-60 overflow-y-auto">
                    <!-- Mapel akan di-render di sini -->
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('mapelModal');
        const openBtn = document.getElementById('mapelManagerBtn');
        const closeBtn = document.getElementById('closeMapelModal');
        const form = document.getElementById('mapelForm');
        const mapelList = document.getElementById('mapelList');
        const alertDiv = document.getElementById('mapelAlert');

        function showAlert(message, type = 'success') {
            alertDiv.className = type === 'success' 
                ? 'bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded'
                : 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded';
            alertDiv.innerHTML = `<p class="flex items-center"><i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>${message}</p>`;
            alertDiv.classList.remove('hidden');
            setTimeout(() => alertDiv.classList.add('hidden'), 3000);
        }

        // Toggle Modal
        openBtn.onclick = () => {
            modal.classList.remove('hidden');
            loadMapel();
        };
        
        closeBtn.onclick = () => modal.classList.add('hidden');
        modal.onclick = (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        };

        // Load Mata Pelajaran
        function loadMapel() {
            mapelList.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>';
            fetch('/mata-pelajaran')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        mapelList.innerHTML = '<div class="text-center py-4 text-gray-500">Belum ada mata pelajaran</div>';
                        return;
                    }
                    mapelList.innerHTML = data.map(mapel => `
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-700">${mapel.nama}</span>
                            <button onclick="deleteMapel(${mapel.id})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error('Error:', error);
                    mapelList.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat data</div>';
                });
        }

        // Add Mata Pelajaran
        form.onsubmit = async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';

            const formData = new FormData(form);
            try {
                const response = await fetch('/mata-pelajaran', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Mata pelajaran berhasil ditambahkan!');
                    form.reset();
                    loadMapel();
                } else {
                    showAlert(data.message || 'Gagal menambahkan mata pelajaran', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan saat menambahkan mata pelajaran', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Tambah Mata Pelajaran';
            }
        };

        // Delete Mata Pelajaran
        window.deleteMapel = async (id) => {
            if (confirm('Yakin ingin menghapus mata pelajaran ini?')) {
                try {
                    const response = await fetch(`/mata-pelajaran/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        showAlert('Mata pelajaran berhasil dihapus!');
                        loadMapel();
                    } else {
                        showAlert('Gagal menghapus mata pelajaran', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat menghapus mata pelajaran', 'error');
                }
            }
        };

        // Initial load
        loadMapel();
    });
    </script>
</x-app-layout> 