<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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

        // Users
        
    }
}
