<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class KategoriBlog extends Model
{
    protected $table = 'kategori_blogs';
    protected $primaryKey = 'id_kategori_blog';

    protected $fillable = ['kategori_blog'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'kategori', 'id_kategori_blog');
    }
}
