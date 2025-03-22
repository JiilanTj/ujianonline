<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Manajemen Siswa') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data siswa dalam sistem</p>
            </div>
            <a href="{{ route('students.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Siswa
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

            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter Section -->
                    <div class="mb-6 flex justify-between items-center">
                        <div class="relative w-64">
                            <input type="text" placeholder="Cari siswa..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button id="kelasManagerBtn" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 flex items-center">
                                <i class="fas fa-school mr-2 text-gray-600"></i>
                                Kelola Kelas
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-900 to-indigo-900">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">NISN</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Jurusan</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Lahir</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($students as $student)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random" alt="{{ $student->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $student->nisn ?? 'Belum diatur' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $student->kelas ? $student->kelas->nama_kelas : 'Belum diatur' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $student->kelas ? $student->kelas->jurusan : 'Belum diatur' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('students.edit', $student) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 p-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Anda yakin ingin menghapus data siswa ini?')" class="text-red-600 hover:text-red-900 bg-red-100 p-2 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center py-6">
                                                <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                                                <p class="text-lg font-medium">Belum ada data siswa</p>
                                                <p class="text-sm text-gray-500">Silakan tambahkan data siswa baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kelas -->
    <div id="kelasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Manajemen Kelas</h3>
                <button id="closeKelasModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Alert Messages -->
            <div id="kelasAlert" class="hidden mb-4"></div>

            <!-- Form Tambah Kelas -->
            <form id="kelasForm" class="mb-4">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                        <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="VII">VII (SMP)</option>
                            <option value="VIII">VIII (SMP)</option>
                            <option value="IX">IX (SMP)</option>
                            <option value="X">X (SMA)</option>
                            <option value="XI">XI (SMA)</option>
                            <option value="XII">XII (SMA)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Contoh: X IPA 1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jurusan (Opsional)</label>
                        <input type="text" id="jurusan" name="jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Contoh: IPA">
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tambah Kelas
                    </button>
                </div>
            </form>

            <!-- Daftar Kelas -->
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Daftar Kelas</h4>
                <div id="kelasList" class="space-y-2 max-h-60 overflow-y-auto">
                    <!-- Kelas akan di-render di sini -->
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('kelasModal');
        const openBtn = document.getElementById('kelasManagerBtn');
        const closeBtn = document.getElementById('closeKelasModal');
        const form = document.getElementById('kelasForm');
        const kelasList = document.getElementById('kelasList');
        const alertDiv = document.getElementById('kelasAlert');

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
            loadKelas();
        };
        
        closeBtn.onclick = () => modal.classList.add('hidden');
        modal.onclick = (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        };

        // Load Kelas
        function loadKelas() {
            kelasList.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>';
            fetch('/kelas')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        kelasList.innerHTML = '<div class="text-center py-4 text-gray-500">Belum ada kelas</div>';
                        return;
                    }
                    kelasList.innerHTML = data.map(kelas => `
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-700">${kelas.nama_kelas}</span>
                            <button onclick="deleteKelas(${kelas.id})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error('Error:', error);
                    kelasList.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat data</div>';
                });
        }

        // Add Kelas
        form.onsubmit = async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';

            const formData = new FormData(form);
            try {
                const response = await fetch('/kelas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Kelas berhasil ditambahkan!');
                    form.reset();
                    loadKelas();
                } else {
                    showAlert(data.message || 'Gagal menambahkan kelas', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan saat menambahkan kelas', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Tambah Kelas';
            }
        };

        // Delete Kelas
        window.deleteKelas = async (id) => {
            if (confirm('Yakin ingin menghapus kelas ini?')) {
                try {
                    const response = await fetch(`/kelas/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        showAlert('Kelas berhasil dihapus!');
                        loadKelas();
                    } else {
                        showAlert('Gagal menghapus kelas', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat menghapus kelas', 'error');
                }
            }
        };

        // Initial load
        loadKelas();
    });
    </script>
</x-app-layout> 