<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('site_name')->nullable();
			$table->string('site_name_en')->nullable();
			$table->string('region_name')->nullable();
			$table->string('contract_num')->nullable();
			$table->string('contractor_name')->nullable();
			$table->string('contractor_name_en')->nullable();
			$table->string('contractor_supervisor')->nullable();
			$table->string('site_manager')->nullable();
			$table->date('project_start_date')->nullable();
			$table->decimal('total_budget')->default('0')->nullable();
			$table->date('hijri_project_start_date')->nullable();
			$table->date('project_end_date')->nullable();
			$table->date('hijri_project_end_date')->nullable();
			$table->decimal('daily_cut_class_a')->nullable();
			$table->decimal('daily_cut_class_b')->nullable();
			$table->decimal('cut_operator_class_a')->nullable();
			$table->decimal('cut_operator_class_b')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
