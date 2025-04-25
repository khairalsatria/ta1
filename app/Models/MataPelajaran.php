<?php

// app/Models/MataPelajaran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';
    protected $primaryKey = 'id_mata_pelajaran';

    protected $fillable = ['mata_pelajaran', 'jenjang_pendidikan'];

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_pendidikan', 'id_jenjang_pendidikan');
    }
    
}
