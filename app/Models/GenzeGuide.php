<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenzeGuide extends Model
{
    use HasFactory;

    protected $table = 'genze_guides';
    protected $primaryKey = 'id_guide';

    protected $fillable = [
        'paket_guide',
        'jadwal_guide2',
        'file',
        'harga',
        'keterangan',
        'link_zoom',
    ];

    public function paket()
    {
        return $this->belongsTo(PaketGuide::class, 'paket_guide');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalGuide2::class, 'jadwal_guide2');
    }
}



