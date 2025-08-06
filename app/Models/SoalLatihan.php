<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\KelasGenze;
use App\Models\JawabanSoalLatihan;
class SoalLatihan extends Model

{
    use HasFactory;

    protected $fillable = [
        'kelas_id', 'pertemuan_ke', 'pertanyaan',
        'gambar_soal',
        'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
        'jawaban_benar'
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasGenze::class, 'kelas_id');
    }

    public function jawaban()
{
    return $this->hasMany(JawabanSoalLatihan::class, 'soal_id');
}

public function getKunciJawabanTeksAttribute()
{
    switch ($this->jawaban_benar) {
        case 'A': return $this->pilihan_a;
        case 'B': return $this->pilihan_b;
        case 'C': return $this->pilihan_c;
        case 'D': return $this->pilihan_d;
        default: return null;
    }
}

}
