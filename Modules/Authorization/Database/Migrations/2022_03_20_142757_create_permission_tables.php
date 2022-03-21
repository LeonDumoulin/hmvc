<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->string('routes')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([PermissionRegistrar::$pivotPermission, PermissionRegistrar::$pivotRole], 'role_has_permissions_permission_id_role_id_primary');
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
        Permission::create([
            'name' => 'الصفحة الرئيسية',
            'guard_name' => 'web',
            'routes' => 'home',
            'group' => 'الصفحة الرئيسية'
        ]);

        // government
        Permission::create([
            'name' => 'عرض المحافظات',
            'guard_name' => 'web',
            'routes' => 'government.index',
            'group' => 'المحافظات'
        ]);
        Permission::create([
            'name' => 'اضافة المحافظات',
            'guard_name' => 'web',
            'routes' => 'government.store,government.create',
            'group' => 'المحافظات'
        ]);
        Permission::create([
            'name' => 'تعديل المحافظات',
            'guard_name' => 'web',
            'routes' => 'government.edit,government.update',
            'group' => 'المحافظات'
        ]);
        Permission::create([
            'name' => 'حذف المحافظات',
            'guard_name' => 'web',
            'routes' => 'government.destroy',
            'group' => 'المحافظات'
        ]);

        // category
        Permission::create([
            'name' => 'عرض الاقسام',
            'guard_name' => 'web',
            'routes' => 'category.index',
            'group' => 'الاقسام'
        ]);
        Permission::create([
            'name' => 'اضافة الاقسام',
            'guard_name' => 'web',
            'routes' => 'category.store,category.create',
            'group' => 'الاقسام'
        ]);
        Permission::create([
            'name' => 'تعديل الاقسام',
            'guard_name' => 'web',
            'routes' => 'category.edit,category.update',
            'group' => 'الاقسام'
        ]);
        Permission::create([
            'name' => 'حذف الاقسام',
            'guard_name' => 'web',
            'routes' => 'category.destroy',
            'group' => 'الاقسام'
        ]);

        // product
        Permission::create([
            'name' => 'عرض المنتجات',
            'guard_name' => 'web',
            'routes' => 'product.index',
            'group' => 'المنتجات'
        ]);
        Permission::create([
            'name' => 'اضافة المنتجات',
            'guard_name' => 'web',
            'routes' => 'product.store,product.create',
            'group' => 'المنتجات'
        ]);
        Permission::create([
            'name' => 'تعديل المنتجات',
            'guard_name' => 'web',
            'routes' => 'product.edit,product.update',
            'group' => 'المنتجات'
        ]);
        Permission::create([
            'name' => 'حذف المنتجات',
            'guard_name' => 'web',
            'routes' => 'product.destroy',
            'group' => 'المنتجات'
        ]);
        Permission::create([
            'name' => 'تفعيل المنتجات',
            'guard_name' => 'web',
            'routes' => 'product.toggleBoolean',
            'group' => 'المنتجات'
        ]);
        Permission::create([
            'name' => 'المنتجات منتهية الكمية',
            'guard_name' => 'web',
            'routes' => 'product.outOFStock',
            'group' => 'المنتجات'
        ]);

        // supllier_product
        Permission::create([
            'name' => 'عرض منتجات التجار',
            'guard_name' => 'web',
            'routes' => 'supplier-product.index',
            'group' => 'منتجات التجار'
        ]);
        Permission::create([
            'name' => 'اضافة منتجات التجار',
            'guard_name' => 'web',
            'routes' => 'supplier-product.store,supplier-product.create',
            'group' => 'منتجات التجار'
        ]);
        Permission::create([
            'name' => 'تعديل منتجات التجار',
            'guard_name' => 'web',
            'routes' => 'supplier-product.edit,supplier-product.update',
            'group' => 'منتجات التجار'
        ]);
        Permission::create([
            'name' => 'حذف منتجات التجار',
            'guard_name' => 'web',
            'routes' => 'supplier-product.destroy',
            'group' => 'منتجات التجار'
        ]);

        // supplier_requests
        Permission::create([
            'name' => 'عرض طلبات تعديل الكمية',
            'guard_name' => 'web',
            'routes' => 'supplier-request.index',
            'group' => 'طلبات تعديل الكمية'
        ]);
        Permission::create([
            'name' => 'اضافة طلبات تعديل الكمية',
            'guard_name' => 'web',
            'routes' => 'supplier-request.store,supplier-request.create',
            'group' => 'طلبات تعديل الكمية'
        ]);
        Permission::create([
            'name' => 'تعديل طلبات تعديل الكمية',
            'guard_name' => 'web',
            'routes' => 'supplier-request.edit,supplier-request.update',
            'group' => 'طلبات تعديل الكمية'
        ]);
        Permission::create([
            'name' => 'حذف طلبات تعديل الكمية',
            'guard_name' => 'web',
            'routes' => 'supplier-request.destroy',
            'group' => 'طلبات تعديل الكمية'
        ]);

        // orders
        Permission::create([
            'name' => 'عرض الطلبات',
            'guard_name' => 'web',
            'routes' => 'order.index',
            'group' => 'الطلبات'
        ]);
        Permission::create([
            'name' => 'اضافة الطلبات',
            'guard_name' => 'web',
            'routes' => 'order.store,order.create',
            'group' => 'الطلبات'
        ]);
        Permission::create([
            'name' => 'تعديل الطلبات',
            'guard_name' => 'web',
            'routes' => 'order.edit,order.update',
            'group' => 'الطلبات'
        ]);
        Permission::create([
            'name' => 'حذف الطلبات',
            'guard_name' => 'web',
            'routes' => 'order.destroy',
            'group' => 'الطلبات'
        ]);

        // markters
        Permission::create([
            'name' => 'عرض المسوقين',
            'guard_name' => 'web',
            'routes' => 'markter.index',
            'group' => 'المسوقين'
        ]);
        Permission::create([
            'name' => 'اضافة المسوقين',
            'guard_name' => 'web',
            'routes' => 'markter.store,markter.create',
            'group' => 'المسوقين'
        ]);
        Permission::create([
            'name' => 'تعديل المسوقين',
            'guard_name' => 'web',
            'routes' => 'markter.edit,markter.update',
            'group' => 'المسوقين'
        ]);
        Permission::create([
            'name' => 'حذف المسوقين',
            'guard_name' => 'web',
            'routes' => 'markter.destroy',
            'group' => 'المسوقين'
        ]);

        // suppliers
        Permission::create([
            'name' => 'عرض التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.index',
            'group' => 'التجار'
        ]);
        Permission::create([
            'name' => 'اضافة التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.store,supplier.create',
            'group' => 'التجار'
        ]);
        Permission::create([
            'name' => 'تعديل التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.edit,supplier.update',
            'group' => 'التجار'
        ]);
        Permission::create([
            'name' => 'حذف التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.destroy',
            'group' => 'التجار'
        ]);

        // markter payments
        Permission::create([
            'name' => 'عرض طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.index',
            'group' => 'طلبات سحب المسوقين'
        ]);
        Permission::create([
            'name' => 'اضافة طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.store,payment.create',
            'group' => 'طلبات سحب المسوقين'
        ]);
        Permission::create([
            'name' => 'تعديل طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.edit,payment.update',
            'group' => 'طلبات سحب المسوقين'
        ]);
        Permission::create([
            'name' => 'حذف طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.destroy',
            'group' => 'طلبات سحب المسوقين'
        ]);
        Permission::create([
            'name' => 'قبول طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.accept',
            'group' => 'طلبات سحب المسوقين'
        ]);
        Permission::create([
            'name' => 'رفض طلبات سحب المسوقين',
            'guard_name' => 'web',
            'routes' => 'payment.reject',
            'group' => 'طلبات سحب المسوقين'
        ]);

        // supplier payments
        Permission::create([
            'name' => 'عرض طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier_payment.index',
            'group' => 'طلبات سحب التجار'
        ]);
        Permission::create([
            'name' => 'اضافة طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier_payment.store,supplier_payment.create',
            'group' => 'طلبات سحب التجار'
        ]);
        Permission::create([
            'name' => 'تعديل طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier_payment.edit,supplier_payment.update',
            'group' => 'طلبات سحب التجار'
        ]);
        Permission::create([
            'name' => 'حذف طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier_payment.destroy',
            'group' => 'طلبات سحب التجار'
        ]);
        Permission::create([
            'name' => 'قبول طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.payment.accept',
            'group' => 'طلبات سحب التجار'
        ]);
        Permission::create([
            'name' => 'رفض طلبات سحب التجار',
            'guard_name' => 'web',
            'routes' => 'supplier.payment.reject',
            'group' => 'طلبات سحب التجار'
        ]);

        // users
        Permission::create([
            'name' => 'عرض المستخدمين',
            'guard_name' => 'web',
            'routes' => 'user.index',
            'group' => 'المستخدمين'
        ]);
        Permission::create([
            'name' => 'اضافة المستخدمين',
            'guard_name' => 'web',
            'routes' => 'user.store,user.create',
            'group' => 'المستخدمين'
        ]);
        Permission::create([
            'name' => 'تعديل المستخدمين',
            'guard_name' => 'web',
            'routes' => 'user.edit,user.update',
            'group' => 'المستخدمين'
        ]);
        Permission::create([
            'name' => 'حذف المستخدمين',
            'guard_name' => 'web',
            'routes' => 'user.destroy',
            'group' => 'المستخدمين'
        ]);

        // roles
        Permission::create([
            'name' => 'عرض رتب المستخدمين',
            'guard_name' => 'web',
            'routes' => 'role.index',
            'group' => 'الرتب'
        ]);
        Permission::create([
            'name' => 'اضافة الرتب',
            'guard_name' => 'web',
            'routes' => 'role.store,role.create',
            'group' => 'الرتب'
        ]);
        Permission::create([
            'name' => 'تعديل الرتب',
            'guard_name' => 'web',
            'routes' => 'role.edit,role.update',
            'group' => 'الرتب'
        ]);
        Permission::create([
            'name' => 'حذف الرتب',
            'guard_name' => 'web',
            'routes' => 'role.destroy',
            'group' => 'الرتب'
        ]);

        // settings
        Permission::create([
            'name' => 'عرض اعدادات الموقع',
            'guard_name' => 'web',
            'routes' => 'settings.index',
            'group' => 'اعدادات الموقع'
        ]);
        Permission::create([
            'name' => 'اضافة اعدادات الموقع',
            'guard_name' => 'web',
            'routes' => 'settings.store,settings.create',
            'group' => 'اعدادات الموقع'
        ]);
        Permission::create([
            'name' => 'تعديل اعدادات الموقع',
            'guard_name' => 'web',
            'routes' => 'settings.edit,settings.update',
            'group' => 'اعدادات الموقع'
        ]);
        Permission::create([
            'name' => 'حذف اعدادات الموقع',
            'guard_name' => 'web',
            'routes' => 'settings.destroy',
            'group' => 'اعدادات الموقع'
        ]);

        // logs
        Permission::create([
            'name' => 'عرض السجلات',
            'guard_name' => 'web',
            'routes' => 'logs.index',
            'group' => 'السجلات'
        ]);
        Permission::create([
            'name' => 'اضافة السجلات',
            'guard_name' => 'web',
            'routes' => 'logs.store,logs.create',
            'group' => 'السجلات'
        ]);
        Permission::create([
            'name' => 'تعديل السجلات',
            'guard_name' => 'web',
            'routes' => 'logs.edit,logs.update',
            'group' => 'السجلات'
        ]);
        Permission::create([
            'name' => 'حذف السجلات',
            'guard_name' => 'web',
            'routes' => 'logs.destroy',
            'group' => 'السجلات'
        ]);

        // policy
        Permission::create([
            'name' => 'عرض سياسات الموقع',
            'guard_name' => 'web',
            'routes' => 'policy.index',
            'group' => 'سياسات الموقع'
        ]);
        Permission::create([
            'name' => 'اضافة سياسات الموقع',
            'guard_name' => 'web',
            'routes' => 'policy.store,policy.create',
            'group' => 'سياسات الموقع'
        ]);
        Permission::create([
            'name' => 'تعديل سياسات الموقع',
            'guard_name' => 'web',
            'routes' => 'policy.edit,policy.update',
            'group' => 'سياسات الموقع'
        ]);
        Permission::create([
            'name' => 'حذف سياسات الموقع',
            'guard_name' => 'web',
            'routes' => 'policy.destroy',
            'group' => 'سياسات الموقع'
        ]);

        $role = Role::create(['name' => 'super_admin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        $user = User::get()->first();
        $user->assignRole('super_admin');
    }
}
