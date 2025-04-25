<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('id_blog');
            $table->string('judul');
            $table->date('tanggal_posting');
            $table->text('isi');
            $table->string('penulis');
            $table->unsignedBigInteger('kategori'); // foreign key
            $table->string('gambar')->nullable();
            $table->timestamps();

            // Foreign key ke tabel kategori_blogs
            $table->foreign('kategori')
                  ->references('id_kategori_blog')
                  ->on('kategori_blogs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
}
