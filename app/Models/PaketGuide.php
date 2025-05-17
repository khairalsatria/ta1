<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PaketGuide extends Model
{
    use HasFactory;

    protected $table = 'paket_guides';
protected $primaryKey = 'id_paket_guide';

public $incrementing = true;
protected $keyType = 'int';

protected $fillable = ['paket_guide'];
// app/Models/PendaftaranGuides.php
public function paketGuide()
{
    return $this->belongsTo(\App\Models\PaketGuide::class, 'paket_guide', 'id_paket_guide');
}


}


