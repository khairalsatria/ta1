<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\KelasGenze;
class SoalLatihan extends Model

{
    use HasFactory;

    protected $fillable = [
        'kelas_id', 'pertemuan_ke', 'pertanyaan',
        'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
        'jawaban_benar'
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasGenze::class, 'kelas_id');
    }
}
