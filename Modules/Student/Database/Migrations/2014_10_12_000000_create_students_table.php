<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration {

	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
			$table->string('phone')->unique();
            $table->string('password');
            // $table->enum('theme',['dark','light'])->default('dark');
            $table->rememberToken();
			$table->boolean('status')->default(0);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('students');
	}
}
