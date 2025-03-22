<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalUjianController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            // Ambil jadwal ujian yang sesuai dengan kelas siswa
            // menggunakan relasi many-to-many
            $jadwalUjian = JadwalUjian::with(['bankSoal.mataPelajaran'])
                ->whereHas('kelas', function($query) use ($user) {
                    $query->where('kelas.id', $user->kelas_id);
                })
                ->where('waktu_selesai', '>', Carbon::now())
                ->where('is_active', true)
                ->orderBy('waktu_mulai', 'asc')
                ->get()
                ->map(function ($jadwal) use ($user) {
                    return [
                        'id' => $jadwal->id,
                        'nama_ujian' => $jadwal->nama_ujian,
                        'mata_pelajaran' => $jadwal->bankSoal->mataPelajaran->nama,
                        'waktu_mulai' => Carbon::parse($jadwal->waktu_mulai)->format('Y-m-d H:i:s'),
                        'waktu_selesai' => Carbon::parse($jadwal->waktu_selesai)->format('Y-m-d H:i:s'),
                        'durasi' => $jadwal->durasi,
                        'instruksi' => $jadwal->instruksi,
                        'status' => $this->getStatus($jadwal),
                        'sudah_selesai' => $jadwal->hasUserCompleted($user->id)
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'jadwal_ujian' => $jadwalUjian
                ]
            ]);

        } catch (\Exception $e) {
            // Tampilkan error detail saat development
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    private function getStatus($jadwal)
    {
        $now = Carbon::now();
        $mulai = Carbon::parse($jadwal->waktu_mulai);
        $selesai = Carbon::parse($jadwal->waktu_selesai);

        if ($now < $mulai) {
            return 'akan_mulai';
        } elseif ($now >= $mulai && $now <= $selesai) {
            return 'sedang_berlangsung';
        } else {
            return 'selesai';
        }
    }
}
