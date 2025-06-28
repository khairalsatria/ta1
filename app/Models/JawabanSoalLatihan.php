<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SoalLatihan;
use App\Models\User;

class JawabanSoalLatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'soal_id', 'jawaban_dipilih', 'benar'
    ];

    public function soal()
    {
        return $this->belongsTo(SoalLatihan::class, 'soal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
