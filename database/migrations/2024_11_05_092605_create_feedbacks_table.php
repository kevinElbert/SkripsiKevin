<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Relasi ke tabel courses
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Relasi ke tabel users, nullable untuk pengguna tidak terdaftar
            $table->string('user_name')->nullable(); // Nama pengguna jika tidak terdaftar
            $table->text('comment'); // Isi feedback
            $table->unsignedTinyInteger('rating')->nullable(); // Rating, nilai antara 1-5 biasanya diatur di sisi validasi
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}

