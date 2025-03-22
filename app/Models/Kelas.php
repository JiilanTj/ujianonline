<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    
    protected $fillable = [
        'tingkat',
        'nama_kelas',
        'jurusan'
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'kelas', 'nama_kelas');
    }
} 