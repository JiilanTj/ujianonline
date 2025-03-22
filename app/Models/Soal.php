<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
    
    protected $fillable = [
        'bank_soal_id',
        'pertanyaan',
        'tipe',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'jawaban_benar',
        'kunci_jawaban',
        'pembahasan',
        'tingkat_kesulitan',
        'urutan'
    ];

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class);
    }
} 