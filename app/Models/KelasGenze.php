<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Program;
use App\Models\User;
use App\Models\PendaftaranGenzeClass;
use App\Models\MateriPertemuan;

use Illuminate\Database\Eloquent\Model;

class KelasGenze extends Model
{
    use HasFactory;

    protected $table = 'kelas_genze';

    protected $fillable = [
        'nama_kelas', 'program_id', 'mentor_id', 'kuota', 'deskripsi', 'link_zoom_default'
    ];

     public function program()
    {
        return $this->belongsTo(Program::class, 'program_id'); // sesuaikan dengan foreign key-nya
    }

    public function mentor() {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function siswa() {
        return $this->hasMany(PendaftaranClasses::class, 'kelas_id');
    }

    public function materi()
{
    return $this->hasMany(MateriPertemuan::class, 'kelas_id');
}
}
