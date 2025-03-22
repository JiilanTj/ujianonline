<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Jadwal Ujian') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Kelola jadwal ujian dalam sistem</p>
            </div>
            <a href="{{ route('jadwal-ujian.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Jadwal
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

            <!-- Jadwal List -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-900 to-indigo-900">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Ujian</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Bank Soal</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jadwalUjian as $jadwal)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $jadwal->nama_ujian }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Durasi: {{ $jadwal->durasi }} menit
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $jadwal->bankSoal->nama_bank_soal }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                @foreach($jadwal->kelas as $kelas)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-1 mb-1">
                                                        {{ $kelas->tingkat }} {{ $kelas->jurusan }} - {{ $kelas->nama_kelas }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $jadwal->waktu_mulai->format('d M Y, H:i') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                s/d {{ $jadwal->waktu_selesai->format('d M Y, H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $now = now();
                                                $status = $now < $jadwal->waktu_mulai ? 'upcoming' : 
                                                         ($now > $jadwal->waktu_selesai ? 'completed' : 'ongoing');
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $status === 'upcoming' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($status === 'ongoing' ? 'bg-green-100 text-green-800' : 
                                                    'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('jadwal-ujian.edit', $jadwal) }}" 
                                                   class="text-blue-600 hover:text-blue-900 bg-blue-100 p-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('jadwal-ujian.destroy', $jadwal) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Yakin ingin menghapus jadwal ujian ini?')" 
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
                                                <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                                                <p class="text-lg font-medium">Belum ada jadwal ujian</p>
                                                <p class="text-sm text-gray-500">Silakan tambahkan jadwal ujian baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $jadwalUjian->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
