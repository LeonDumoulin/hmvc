<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('theme',['dark','light'])->default('dark');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password' => bcrypt(123),
            'email_verified_at' => Carbon\Carbon::now(),
        ]);
        User::create([
            'name'=>'hady',
            'email'=>'hady@admin.com',
            'password' => bcrypt(123),
            'email_verified_at' => Carbon\Carbon::now(),
        ]);
        User::create([
            'name'=>'kholuo',
            'email'=>'kholuo@admin.com',
            'password' => bcrypt(123),
            'email_verified_at' => Carbon\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
