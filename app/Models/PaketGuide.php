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

}
