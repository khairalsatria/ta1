<?php

// app/Models/PendaftaranClass.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranClass extends Model
{
    protected $table = 'pendaftaran_class';

    protected $fillable = [
    'nama', 'email', 'nohp', 'id_jeniskelas', 'kelas',
    'id_jenjang_pendidikan', 'id_mata_pelajaran', // <- ganti di sini
    'jadwal_konfirmasi', 'jadwal_pilihan', 'harga',
    'bukti_pembayaran', 'status_pembayaran'
];



    protected $casts = [
        'jadwal_pilihan' => 'array',
    ];

    public function jenisKelas()
    {
        return $this->belongsTo(JenisKelas::class, 'id_jeniskelas');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran', 'id_mata_pelajaran');
    }

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_pendidikan', 'id_jenjang_pendidikan');
    }



    public function jadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'jadwal_konfirmasi');
    }

}
