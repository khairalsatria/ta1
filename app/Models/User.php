<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nohp',
        'gender',
        'role',
        'photo',
        'google_id',
        'must_set_password', // kolom baru
    ];

    /**
     * Relasi ke tabel pendaftaran_program
     */
    public function pendaftaranPrograms()
    {
        return $this->hasMany(PendaftaranProgram::class, 'user_id');
    }

    /**
     * Relasi ke kelas yang dikelola mentor
     */
    public function kelasYangDikelola()
    {
        return $this->hasMany(KelasGenze::class, 'mentor_id');
    }

    /**
     * Relasi ke pendaftaran kelas
     */
    public function pendaftaranKelas()
    {
        return $this->hasOne(PendaftaranClasses::class, 'pendaftaran_id', 'id');
    }

    /**
     * Relasi ke kelas_genze
     */
    public function kelas_genze()
    {
        return $this->hasMany(KelasGenze::class, 'mentor_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_set_password' => 'boolean', // supaya otomatis jadi true/false
    ];
}
