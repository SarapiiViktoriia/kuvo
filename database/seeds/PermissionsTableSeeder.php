<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $date_now = \Carbon\Carbon::now();
    	$data_permissions = [
            ['name' => 'View User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Add User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Edit User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Role User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Permission User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Set Status User', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View All User Log', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Customer', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Add Customer', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Edit Customer', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Supplier', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Add Supplier', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    		['name' => 'Edit Supplier', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Status Supplier', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Category Of Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Add Category Of Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Edit Category Of Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Add Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Edit Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Generate Report Goods', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Generate Report Stock Flow', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Purchase', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Return Purchase', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Add Purchase', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Edit Purchase List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Delete Purchase List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Submit Purchase List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Purchase Price', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Print Purchase Invoice', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Purchase Price List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Print Purchase Price List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Generate Report Purchase', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Sale', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Return Sale', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Add Sale', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Delete Sale List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Submit Sale List', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Print Sale Invoice', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Free Sale', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Generate Report Sale', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'View Role', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Add Role', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Edit Role', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Set Permission Role', 'guard_name' => 'web', 'created_at' => $date_now, 'updated_at' => $date_now],
    	];
    	Permission::insert($data_permissions);
        $data_roles = [
            ['name' => 'System Administrator', 'guard_name' => 'web','created_at' => $date_now, 'updated_at' => $date_now],
        ];
        Role::insert($data_roles);
        Role::find(1)->givePermissionTo(Permission::all());
        \App\Models\Profile::find(1)->assignRole('System Administrator');
    }
}
