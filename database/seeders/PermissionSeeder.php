<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Categories
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'read categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        // Products
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'read products']);
        Permission::create(['name' => 'update all products']);
        Permission::create(['name' => 'update own products']);
        Permission::create(['name' => 'delete all products']);
        Permission::create(['name' => 'delete own products']);

        // Roles
        Permission::create(['name' => 'read roles']);
        Permission::create(['name' => 'assign roles']);
        Permission::create(['name' => 'revoke roles']);
        Permission::create(['name' => 'read permissions']);
        Permission::create(['name' => 'assign permissions']);
        Permission::create(['name' => 'revoke permissions']);
        
        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('seller')->givePermissionTo([
            'create products',
            'read products',
            'update own products',
            'delete own products',
        ]);
        Role::findByName('user')->givePermissionTo([
            'read products',
        ]);
        // give read categories permission to all roles
        Role::all()->each(function ($role) {
            $role->givePermissionTo('read categories');
        });
    }
}
