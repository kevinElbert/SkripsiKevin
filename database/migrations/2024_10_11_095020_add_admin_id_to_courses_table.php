<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('courses', function (Blueprint $table) {
        //     // Menambahkan kolom admin_id dengan foreign key yang terhubung ke tabel users
        //     $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('courses', function (Blueprint $table) {
        //     // Menghapus kolom admin_id saat rollback migration
        //     $table->dropForeign(['admin_id']);
        //     $table->dropColumn('admin_id');
        // });
    }
};
