<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    protected $table = 'bank_soal';
    
    protected $fillable = [
        'nama_bank_soal',
        'mata_pelajaran_id',
        'tipe',
        'deskripsi',
        'created_by'
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
} 