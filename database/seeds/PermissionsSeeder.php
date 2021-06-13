<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        // create user permissions
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'view user']);
        //create category permissions
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'add category']);
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'approve category']);
        //create subcategory permissions
        Permission::create(['name' => 'edit subcategory']);
        Permission::create(['name' => 'delete subcategory']);
        Permission::create(['name' => 'add subcategory']);
        Permission::create(['name' => 'view subcategory']);
        Permission::create(['name' => 'approve subcategory']);
        //create attributes permissions
        Permission::create(['name' => 'edit attributes']);
        Permission::create(['name' => 'delete attributes']);
        Permission::create(['name' => 'add attributes']);
        Permission::create(['name' => 'view attributes']);
        Permission::create(['name' => 'approve attributes']);
        // create roles and assign existing permissions
        //viewer
        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('view category');
        $role1->givePermissionTo('view attributes');
        $role1->givePermissionTo('view subcategory');
        //editor
        $role2 = Role::create(['name' => 'editor']);
        $role2->givePermissionTo('edit category');
        $role2->givePermissionTo('view category');
        $role2->givePermissionTo('view attributes');
        $role2->givePermissionTo('edit category');
        //approver
        $role3 = Role::create(['name' => 'approver']);
        $role3->givePermissionTo('approve category');
        $role3->givePermissionTo('approve subcategory');
        $role3->givePermissionTo('approve attributes');
        //admin
        $role4 = Role::create(['name' => 'admin']);
        $role4->givePermissionTo('add user');
        $role4->givePermissionTo('view user');
        $role4->givePermissionTo('delete user');
        $role4->givePermissionTo('edit user');
        $role4->givePermissionTo('add category');
        $role4->givePermissionTo('delete category');
        $role4->givePermissionTo('view category');
        //superadmin
        $role5 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users

        $user = factory(App\User::class)->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@example.com',
            'phone' => '1234567890',
            'password' =>  Hash::make('demo'),

        ]);
        $user->assignRole($role5);

        $user2 = factory(App\User::class)->create([
            'name' => 'edtior user',
            'email' => 'writer@example.com',
            'phone' => '1234567892',
            'password' =>  Hash::make('demo'),

        ]);
        $user2->assignRole($role2);




    }
}
