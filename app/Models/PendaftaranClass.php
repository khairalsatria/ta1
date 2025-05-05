<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranClass extends Model
{
    protected $table = 'pendaftaran_class';

    // Menyesuaikan kolom yang bisa diisi dengan yang sesuai di database
    protected $fillable = [
        'nama',
        'email',
        'nohp',
        'id_jeniskelas',
        'kelas',
        'jenjang_pendidikan',
        'mata_pelajaran',
        'jadwal_pilihan',
        'jadwal_konfirmasi',
        'harga',
        'status_pembayaran',
        'bukti_pembayaran',
    ];


    // Mengatur casting untuk kolom jadwal_pilihan agar menjadi array
    protected $casts = [
        'jadwal_pilihan' => 'array',
    ];

    // Relasi ke JenisKelas
    public function jenisKelas()
    {
        return $this->belongsTo(JenisKelas::class, 'id_jeniskelas');
    }

    // Relasi ke MataPelajaran
    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_pendidikan', 'id_jenjang_pendidikan');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran', 'id_mata_pelajaran');
    }


    // Relasi ke JadwalKelas
    public function jadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'jadwal_konfirmasi');
    }
}
