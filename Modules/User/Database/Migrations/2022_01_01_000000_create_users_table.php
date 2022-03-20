<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Modules\User\Entities\User;

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

        // $userCount = 200;
        // for ($i=0; $i < $userCount; $i++) {
        //     User::create([
        //         'name' => 'User'.$i,
        //         'email' => 'user@gmail.com'.$i,
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]);
        // }
        // Artisan::call("db:seed --class='Modules\User\Database\Seeders\UserDatabaseSeeder'");
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
