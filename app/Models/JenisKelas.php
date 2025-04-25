<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelas extends Model
{
    use HasFactory;

    protected $table = 'jenis_kelas';
    protected $primaryKey = 'id_jeniskelas';

    protected $fillable = ['jeniskelas'];
}
