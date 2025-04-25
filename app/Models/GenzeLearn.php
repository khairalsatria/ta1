<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenzeLearn extends Model
{
    protected $table = 'genze_learns';
    protected $primaryKey = 'id_learn';

    protected $fillable = [
        'nama_learn',
        'pembicara',
        'jadwal',
        'harga',
        'keterangan',
        'link_zoom',
        'sertifikat',
    ];

}
