<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriPertemuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id', 'pertemuan_ke', 'judul',
        'file_pdf', 'link_zoom', 'link_rekaman'
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasGenze::class, 'kelas_id');
    }
}
