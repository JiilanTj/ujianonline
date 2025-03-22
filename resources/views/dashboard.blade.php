<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-semibold">150</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Bank Soal</p>
                    <p class="text-2xl font-semibold">45</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Ujian Aktif</p>
                    <p class="text-2xl font-semibold">3</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Total Ujian</p>
                    <p class="text-2xl font-semibold">12</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Ujian Terjadwal</h3>
            <div class="space-y-4">
                <!-- Daftar ujian yang akan datang -->
                <div class="border-l-4 border-blue-500 pl-4">
                    <p class="font-medium">Matematika Kelas XII</p>
                    <p class="text-sm text-gray-500">Senin, 25 Maret 2025 - 08:00 WIB</p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4">
                    <p class="font-medium">Bahasa Indonesia Kelas X</p>
                    <p class="text-sm text-gray-500">Selasa, 26 Maret 2025 - 10:00 WIB</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <!-- Daftar aktivitas terbaru -->
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <p class="ml-3 text-sm">Ahmad baru saja menyelesaikan ujian Matematika</p>
                </div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <p class="ml-3 text-sm">20 soal baru ditambahkan ke Bank Soal</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
