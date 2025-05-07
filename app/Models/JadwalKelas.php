<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id_jadwalkelas';

    protected $fillable = ['jadwalkelas'];

//     public function jadwal_kelas()
// {
//     return $this->belongsToMany(JadwalKelas::class, 'jadwal_pendaftaran', 'pendaftaran_id', 'jadwal_id');
// }

public function pendaftaranClass()
    {
        return $this->hasMany(PendaftaranClasses::class, 'jadwalkelas_konfirmasi', 'id_jadwalkelas');
    }

}
