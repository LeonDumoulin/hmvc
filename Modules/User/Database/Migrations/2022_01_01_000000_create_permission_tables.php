<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('routes')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->bigInteger('permission_id');
            $table->string('model_type');
            $table->bigInteger($columnNames['model_morph_key']);
            $table->primary(
                ['permission_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary'
            );
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->bigInteger('role_id');
            $table->string('model_type');
            $table->bigInteger($columnNames['model_morph_key']);
            $table->primary(
                ['role_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary'
            );
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->bigInteger('permission_id');
            $table->bigInteger('role_id');
            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
        $this->importPermissions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }

    private function importPermissions(): void
    {

        /*         DB::table('permissions')->delete();
        DB::unprepared(file_get_contents(storage_path('permissions.sql')));
        $director = \Spatie\Permission\Models\Role::create([
            'name' => 'مدير',
            'guard_name' => 'web',
            'description' => 'أعلى صلاحية بالنظام',
        ]);
        $superVisor = \Spatie\Permission\Models\Role::create([
            'name' => 'مشرف رئيسي',
            'guard_name' => 'web',
            'description' => '-',
        ]);
        $visor =  \Spatie\Permission\Models\Role::create([
            'name' => 'مشرف',
            'guard_name' => 'web',
            'description' => '-',
        ]);
        $teacher =  \Spatie\Permission\Models\Role::create([
            'name' => 'مدرس',
            'guard_name' => 'teacher',
            'description' => '-',
        ]); */

        /*         $director->permissions()->sync(DB::table('permissions')->whereNotIn('id', [22, 23, 24, 34])->pluck('id')->toArray());
        $superVisor->permissions()->sync(DB::table('permissions')->pluck('id')->toArray());
        $visor->permissions()->sync(DB::table('permissions')->pluck('id')->toArray());
        $teacher->permissions()->sync(DB::table('permissions')->pluck('id')->toArray());

        App\User::first()->roles()->sync(1);
        App\User::where('id', 2)->first()->roles()->sync(1);
        App\User::where('id', 3)->first()->roles()->sync(2);
        App\User::where('id', 4)->first()->roles()->sync(3);
        App\Models\Teacher::first()->roles()->sync(4); */
    }
}