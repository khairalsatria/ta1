<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenzeLearnEvent extends Model
{
    use HasFactory;

    protected $fillable = [
    'program_id',
    'link_zoom',
    'tanggal_event',
    'jam_event',
    'template_sertifikat'
];


    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
