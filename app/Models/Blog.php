<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriBlog;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id_blog';

    protected $fillable = [
        'judul',
        'tanggal_posting',
        'isi',
        'penulis',
        'kategori', // Foreign key ke id_kategori_blog
        'gambar'
    ];

    public function kategoriBlog()
{
    return $this->belongsTo(KategoriBlog::class, 'kategori', 'id_kategori_blog');
}

public function penulisUser()
{
    return $this->belongsTo(User::class, 'penulis', 'id');
}

// Blog.php
public function user()
{
    return $this->belongsTo(User::class, 'penulis');
}


}
