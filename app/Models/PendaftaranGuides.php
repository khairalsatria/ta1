<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranGuides extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_guide';

    protected $fillable = [
        'pendaftaran_id',
        'paketguides',
        'file_upload',
        'jadwalguide2_pilihan',
        'jadwalguide2_konfirmasi'
    ];

    protected $casts = [
        'jadwalguide2_pilihan' => 'array'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgram::class, 'pendaftaran_id');
    }

    public function paketGuide()
    {
        return $this->belongsTo(PaketGuide::class, 'paketguides', 'id_paket_guide');
    }

    public function jadwalKonfirmasi()
    {
        return $this->belongsTo(JadwalGuide2::class, 'jadwalguide2_konfirmasi', 'id_jadwalguide2');
    }
}
