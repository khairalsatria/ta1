<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranLearns extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_learns';

    protected $fillable = [
        'pendaftaran_id',
        'asal_instansi',
        'sertifikat'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgram::class, 'pendaftaran_id');
    }
}
