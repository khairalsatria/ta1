<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PendaftaranProgram;
use App\Models\JenisKelas;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\JadwalKelas;
use App\Models\KelasGenze;
use App\Models\User;

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
        'jadwalkelas_konfirmasi',
        'jadwalkelas_alternatif',
        'status_alternatif',
        'kelas_id',
        'status', // Added status field
    ];

    protected $casts = [
        'jadwalkelas_pilihan' => 'array'
    ];
     public function getUserAttribute()
{
    return $this->pendaftaran ? $this->pendaftaran->user : null;
}


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

    public function jadwalAlternatif()
{
    return $this->belongsTo(JadwalKelas::class, 'jadwalkelas_alternatif', 'id_jadwalkelas');
}

    public function getJadwalPilihanObjectsAttribute()
{
    return JadwalKelas::whereIn('id_jadwalkelas', $this->jadwalkelas_pilihan ?? [])->get();
}

public function kelasGenze()
{
    return $this->belongsTo(KelasGenze::class, 'kelas_id');
}

}
