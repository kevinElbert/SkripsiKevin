<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToQuizResultsTable extends Migration
{
    public function up()
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->integer('time_taken')->nullable()->after('total_questions');
            $table->decimal('percentage_score', 5, 2)->after('time_taken');
            $table->boolean('passed')->default(false)->after('percentage_score');
        });
    }

    public function down()
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->dropColumn(['time_taken', 'percentage_score', 'passed']);
        });
    }
}