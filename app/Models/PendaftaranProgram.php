<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranProgram extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_programs';

    protected $fillable = [
        'user_id',
        'tipe_program',
        'harga',
        'status',
        'bukti_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'tipe_program');
    }

    public function pendaftaranClass()
    {
        return $this->hasOne(PendaftaranClasses::class, 'pendaftaran_id');
    }

    public function pendaftaranGuide()
    {
        return $this->hasOne(PendaftaranGuides::class, 'pendaftaran_id');
    }

    public function pendaftaranLearn()
    {
        return $this->hasOne(PendaftaranLearns::class, 'pendaftaran_id');
    }
}
