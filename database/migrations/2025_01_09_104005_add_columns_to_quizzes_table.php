<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('passing_score')->default(60);
            $table->integer('time_limit')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('attempts_allowed')->default(0);
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('passing_score');
            $table->dropColumn('time_limit');
            $table->dropColumn('is_published');
            $table->dropColumn('attempts_allowed');
        });
    }
};