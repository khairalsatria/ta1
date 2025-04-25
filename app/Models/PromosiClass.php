<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromosiClass extends Model
{
    use HasFactory;

    protected $table = 'promosi_class';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'benefit',
        'harga',
        'gambar',
    ];
}
