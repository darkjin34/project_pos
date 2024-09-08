<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $cashier = Role::create(['name' => 'cashier']);
        $supervisor = Role::create(['name' => 'supervisor']);
    
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
    
        $admin->givePermissionTo('edit users', 'delete users');

        // Creating permissions
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'process transactions']);

        // Assigning permissions to cashier role
        $cashier->givePermissionTo(['view products', 'process transactions']);

        //Add Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Properly hash the password
        ])->assignRole('admin');
    }
}
