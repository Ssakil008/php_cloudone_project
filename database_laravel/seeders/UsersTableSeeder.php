<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the super admin user
        User::create([
            'username' => 'moniruddin',
            'email' => 'monir.uddincloudone@gmail.com',
            'mobile' => '01622457458',
            'password' => Hash::make('monir121#'),
        ]);

        Role::create([
            'role' => 'Admin',
            'description' => 'He / she can see every panel',
        ]);

        Role::create([
            'role' => 'User',
            'description' => 'Only see permitted panel',
        ]);

        Menu::create([
            'name' => 'Credential For Server',
            'link' => 'credential_for_server',
        ]);

        Menu::create([
            'name' => 'User Setup',
            'link' => 'user_setup',
        ]);

        Menu::create([
            'name' => 'Role',
            'link' => 'role',
        ]);

        Menu::create([
            'name' => 'Credential For User',
            'link' => 'credential_for_user',
        ]);

        Menu::create([
            'name' => 'Menu Setup',
            'link' => 'menu_setup',
        ]);

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        Permission::create([
            'role_id' => 1,
            'menu_id' => 1,
            'read' => 'yes',
            'create' => 'yes',
            'edit' => 'yes',
            'delete' => 'yes',
        ]);

        Permission::create([
            'role_id' => 1,
            'menu_id' => 2,
            'read' => 'yes',
            'create' => 'yes',
            'edit' => 'yes',
            'delete' => 'yes',
        ]);

        Permission::create([
            'role_id' => 1,
            'menu_id' => 3,
            'read' => 'yes',
            'create' => 'yes',
            'edit' => 'yes',
            'delete' => 'yes',
        ]);

        Permission::create([
            'role_id' => 1,
            'menu_id' => 4,
            'read' => 'yes',
            'create' => 'yes',
            'edit' => 'yes',
            'delete' => 'yes',
        ]);

        Permission::create([
            'role_id' => 1,
            'menu_id' => 5,
            'read' => 'yes',
            'create' => 'yes',
            'edit' => 'yes',
            'delete' => 'yes',
        ]);

        // You can add more seed data here if needed
    }
}
