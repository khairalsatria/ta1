<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBlog extends Model
{

    protected $table = 'kategori_blogs';
    protected $primaryKey = 'id_kategori_blog';

    protected $fillable = ['kategori_blog'];
}
