<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['nama'];

    public function bankSoal()
    {
        return $this->hasMany(BankSoal::class);
    }
} 