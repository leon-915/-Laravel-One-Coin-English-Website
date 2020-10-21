<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeacherDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_detail', function($table) {
			$table->smallInteger('japanese_resident')->default(0);
			$table->smallInteger('own_realstate_in_japan')->default(0);
			$table->string('occupation')->nullable();
			$table->string('conversation_topic')->nullable();
			$table->string('english_language_specialization')->nullable();
			$table->string('teaching_english_in')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_detail', function($table) {
			$table->dropColumn('japanese_resident');
			$table->dropColumn('own_realstate_in_japan');
			$table->dropColumn('occupation');
			$table->dropColumn('conversation_topic');
			$table->dropColumn('english_language_specialization');
			$table->dropColumn('teaching_english_in');
		});
    }
}
