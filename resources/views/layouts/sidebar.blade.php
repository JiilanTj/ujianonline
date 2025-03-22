<div class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-900 to-indigo-900 text-white transition-all duration-300 z-30 shadow-lg">
    <div class="flex items-center justify-center h-16 bg-blue-800 shadow-md">
        <h2 class="text-xl font-bold tracking-wide">Admin Ujian Online</h2>
    </div>
    
    <nav class="mt-5">
        <div class="px-4 py-2 text-xs font-semibold text-gray-300 uppercase">Menu Utama</div>
        
        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
            <i class="fas fa-tachometer-alt w-5 text-lg"></i>
            <span class="mx-3">Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('students.*') ? 'bg-blue-800' : '' }}">
            <i class="fas fa-users w-5 text-lg"></i>
            <span class="mx-3">Manajemen Siswa</span>
        </a>

        <a href="{{ route('bank-soal.index') }}" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('bank-soal.*') ? 'bg-blue-800' : '' }}">
            <i class="fas fa-book w-5 text-lg"></i>
            <span class="mx-3">Bank Soal</span>
        </a>

        <a href="{{ route('jadwal-ujian.index') }}" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('jadwal-ujian.*') ? 'bg-blue-800' : '' }}">
            <i class="fas fa-clock w-5 text-lg"></i>
            <span class="mx-3">Jadwal Ujian</span>
        </a>

        <a href="#" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-chart-bar w-5 text-lg"></i>
            <span class="mx-3">Hasil Ujian</span>
        </a>

        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-300 uppercase">Pengaturan</div>
        
        <a href="#" class="flex items-center px-6 py-3 text-gray-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-cog w-5 text-lg"></i>
            <span class="mx-3">Konfigurasi</span>
        </a>
    </nav>
</div> 