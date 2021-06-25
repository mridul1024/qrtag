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
        Permission::create(['name' => 'view users']);
        //create category permissions
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'add category']);
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'approve category']);
        //create subcategory permissions
        Permission::create(['name' => 'edit subcategory']);
        Permission::create(['name' => 'delete subcategory']);
        Permission::create(['name' => 'add subcategory']);
        Permission::create(['name' => 'view subcategory']);
        Permission::create(['name' => 'view subcategories']);
        Permission::create(['name' => 'approve subcategory']);
        //create subcategorytype permissions
        Permission::create(['name' => 'edit subcategorytype']);
        Permission::create(['name' => 'delete subcategorytype']);
        Permission::create(['name' => 'add subcategorytype']);
        Permission::create(['name' => 'view subcategorytype']);
        Permission::create(['name' => 'view subcategorytypes']);
        Permission::create(['name' => 'approve subcategorytype']);
        //create attributes permissions
        Permission::create(['name' => 'edit attributes']);
        Permission::create(['name' => 'delete attributes']);
        Permission::create(['name' => 'add attributes']);
        Permission::create(['name' => 'view attributes']);
        Permission::create(['name' => 'approve attributes']);
        //create attributesmaster permissions
        Permission::create(['name' => 'delete attributemaster']);
        Permission::create(['name' => 'add attributemaster']);
        Permission::create(['name' => 'view attributemasters']);
        //create unit master permissions
        Permission::create(['name' => 'delete unitmaster']);
        Permission::create(['name' => 'add unitmaster']);
        Permission::create(['name' => 'view unitmasters']);
        //jobs
        Permission::create(['name' => 'create job']);
        Permission::create(['name' => 'delete job']);
        Permission::create(['name' => 'view job']);
        Permission::create(['name' => 'view jobs']);
        //products
        Permission::create(['name' => 'add product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'approve product']);
        Permission::create(['name' => 'reject product']);
        // create roles and assign existing permissions
        //viewer
        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('view category');
        $role1->givePermissionTo('view categories');
        $role1->givePermissionTo('view attributes');
        $role1->givePermissionTo('view subcategory');
        $role1->givePermissionTo('view subcategories');
        $role1->givePermissionTo('view subcategorytype');
        $role1->givePermissionTo('view subcategorytypes');
        $role1->givePermissionTo('view job');
        $role1->givePermissionTo('view jobs');
        $role1->givePermissionTo('view product');
        //editor
        $role2 = Role::create(['name' => 'editor']);
        $role2->givePermissionTo('view category');
        $role2->givePermissionTo('view categories');
        $role2->givePermissionTo('view subcategory');
        $role2->givePermissionTo('view subcategories');
        $role2->givePermissionTo('view subcategorytype');
        $role2->givePermissionTo('view subcategorytypes');
        $role2->givePermissionTo('create job');
        $role2->givePermissionTo('delete job');
        $role2->givePermissionTo('view job');
        $role2->givePermissionTo('view jobs');
        $role2->givePermissionTo('add product');
        $role2->givePermissionTo('view product');
        $role2->givePermissionTo('delete product');
        //approver
        $role3 = Role::create(['name' => 'approver']);
        $role3->givePermissionTo('view category');
        $role3->givePermissionTo('view categories');
        $role3->givePermissionTo('view subcategory');
        $role3->givePermissionTo('view subcategories');
        $role3->givePermissionTo('view subcategorytype');
        $role3->givePermissionTo('view subcategorytypes');
        $role3->givePermissionTo('create job');
        $role3->givePermissionTo('delete job');
        $role3->givePermissionTo('view job');
        $role3->givePermissionTo('view jobs');
        $role3->givePermissionTo('add product');
        $role3->givePermissionTo('view product');
        $role3->givePermissionTo('delete product');
        $role3->givePermissionTo('approve product');
        $role3->givePermissionTo('reject product');
        //admin
        $role4 = Role::create(['name' => 'admin']);
        $role4->givePermissionTo('add user');
        $role4->givePermissionTo('view user');
        $role4->givePermissionTo('view users');
        $role4->givePermissionTo('delete user');
        $role4->givePermissionTo('edit user');
        $role4->givePermissionTo('add category');
        $role4->givePermissionTo('delete category');
        $role4->givePermissionTo('view category');
        $role4->givePermissionTo('view categories');
        $role4->givePermissionTo('edit category');
        $role4->givePermissionTo('add subcategory');
        $role4->givePermissionTo('delete subcategory');
        $role4->givePermissionTo('view subcategory');
        $role4->givePermissionTo('view subcategories');
        $role4->givePermissionTo('edit subcategory');
        $role4->givePermissionTo('add subcategorytype');
        $role4->givePermissionTo('delete subcategorytype');
        $role4->givePermissionTo('view subcategorytype');
        $role4->givePermissionTo('view subcategorytypes');
        $role4->givePermissionTo('edit subcategorytype');
        $role4->givePermissionTo('create job');
        $role4->givePermissionTo('delete job');
        $role4->givePermissionTo('view job');
        $role4->givePermissionTo('view jobs');
        $role4->givePermissionTo('add product');
        $role4->givePermissionTo('view product');
        $role4->givePermissionTo('delete product');
        $role4->givePermissionTo('approve product');
        $role4->givePermissionTo('reject product');
        //superadmin
        $role5 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users

        $user = factory(App\User::class)->create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'phone' => '1234567890',
            'password' =>  Hash::make('demo'),

        ]);
        $user->assignRole($role5);

        $user2 = factory(App\User::class)->create([
            'name' => 'edtior',
            'email' => 'edtior@example.com',
            'phone' => '1234567892',
            'password' =>  Hash::make('demo'),

        ]);
        $user2->assignRole($role2);




    }
}
