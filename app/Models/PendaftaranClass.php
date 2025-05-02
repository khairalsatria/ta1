<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranClass extends Model
{
    protected $table = 'pendaftaran_class';

    // Menyesuaikan kolom yang bisa diisi dengan yang sesuai di database
    protected $fillable = [
        'nama', 'email', 'nohp', 'id_jeniskelas', 'kelas',
        'id_jenjang_pendidikan', 'id_mata_pelajaran', // Ganti sesuai dengan kolom yang ada
        'jadwal_konfirmasi', 'jadwal_pilihan', 'harga',
        'bukti_pembayaran', 'status_pembayaran'
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
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran', 'id_mata_pelajaran');
    }

    // Relasi ke JenjangPendidikan
    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang_pendidikan', 'id_jenjang_pendidikan');
    }

    // Relasi ke JadwalKelas
    public function jadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'jadwal_konfirmasi');
    }
}
