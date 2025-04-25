<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalGuide2 extends Model
{
    use HasFactory;

    protected $table = 'jadwal_guide2';
    protected $primaryKey = 'id_jadwalguide2';

    protected $fillable = ['jadwalguide2'];
}
