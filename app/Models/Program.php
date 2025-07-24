<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'tipe_program', // tambahkan ini
        'deskripsi',
        'fitur',
        'rating',
        'instruktur',
        'durasi',
        'level',
        'harga',
        'gambar',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(PendaftaranProgram::class, 'tipe_program');
    }

   public function genzeLearnEvent()
{
    return $this->hasOne(GenzeLearnEvent::class, 'program_id');
}
public function testimonials()
{
    return $this->hasMany(Testimonial::class);
}

public function getRatingAttribute()
{
    // Jika ingin override kolom `rating`, kamu bisa return dari testimonial
    return $this->testimonials()->avg('rating') ? number_format($this->testimonials()->avg('rating'), 1) : 'Belum ada';
}


}
