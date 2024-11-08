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
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Kolom admin_id sebagai foreign key
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }

};
