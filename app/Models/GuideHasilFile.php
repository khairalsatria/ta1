<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideHasilFile extends Model
{
    use HasFactory;

    protected $table = 'guide_hasil_files';

    protected $fillable = [
        'pendaftaran_guide_id',
        'file_hasil',   // path storage (nullable utk Zoom-only row)
        'link_zoom',    // url zoom (nullable utk file-only row)
        'uploaded_by',
        'keterangan',
    ];

    public function pendaftaranGuide()
    {
        return $this->belongsTo(PendaftaranGuides::class, 'pendaftaran_guide_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
