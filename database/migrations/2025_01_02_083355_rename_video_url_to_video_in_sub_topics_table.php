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
        Schema::table('sub_topics', function (Blueprint $table) {
            $table->renameColumn('video_url', 'video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('sub_topics', function (Blueprint $table) {
            $table->renameColumn('video', 'video_url');
        });
    }
};
