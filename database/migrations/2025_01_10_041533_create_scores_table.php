<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Relasi ke tabel courses
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->integer('score'); // Kolom skor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scores');
    }

};
