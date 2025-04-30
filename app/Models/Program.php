<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'tipe_program', // tambahkan ini
        'deskripsi',
        'fitur',
        'rating',
        'instruktur',
        'durasi',
        'level',
        'harga',
        'gambar',
    ];
}
