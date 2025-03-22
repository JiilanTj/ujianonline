<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    protected $table = 'jadwal_ujian';
    
    protected $fillable = [
        'nama_ujian',
        'bank_soal_id',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'is_active',
        'instruksi',
        'created_by'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'jadwal_ujian_kelas');
    }

    public function hasUserCompleted($userId)
    {
        // Implementasi sesuai dengan struktur tabel jawaban
        // Contoh jika ada tabel jawaban:
        // return $this->jawaban()->where('user_id', $userId)->exists();
        return false; // Sementara return false
    }
}