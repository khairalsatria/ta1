<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranClasses extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_classes';

    protected $fillable = [
        'pendaftaran_id',
        'jeniskelas',
        'kelas',
        'jenjang_pendidikan',
        'mata_pelajaran',
        'jadwalkelas_pilihan',
        'jadwalkelas_konfirmasi'
    ];

    protected $casts = [
        'jadwalkelas_pilihan' => 'array'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgram::class, 'pendaftaran_id');
    }

    public function jenisKelas()
    {
        return $this->belongsTo(JenisKelas::class, 'jeniskelas', 'id_jeniskelas');
    }

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_pendidikan', 'id_jenjang_pendidikan');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran', 'id_mata_pelajaran');
    }

    public function jadwalKonfirmasi()
    {
        return $this->belongsTo(JadwalKelas::class, 'jadwalkelas_konfirmasi', 'id_jadwalkelas');
    }

    public function getJadwalPilihanObjectsAttribute()
{
    return JadwalKelas::whereIn('id_jadwalkelas', $this->jadwalkelas_pilihan ?? [])->get();
}

}
