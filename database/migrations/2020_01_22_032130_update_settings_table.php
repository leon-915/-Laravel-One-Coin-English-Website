<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_settings', function($table) {
			$table->integer('allowed_trial_lessons')->default(3);
			$table->integer('allowed_trial_lessons_period')->default(3);
			$table->string('reset_trial_lessons', 5)->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_settings', function($table) {
			$table->dropColumn('allowed_trial_lessons');
			$table->dropColumn('allowed_trial_lessons_period');
			$table->dropColumn('reset_trial_lessons');
		});
    }
}
