<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenjangPendidikan extends Model
{
    use HasFactory;

    protected $table = 'jenjang_pendidikans';
    protected $primaryKey = 'id_jenjang_pendidikan';

    protected $fillable = ['jenjang_pendidikan'];

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class, 'id_jenjang_pendidikan');
    }
}
