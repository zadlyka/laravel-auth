<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\RoleId;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => RoleId::SuperAdmin,
            'name' => 'Super Admin',
            'permission' => [
                Permission::ManageAll
            ]
        ]);

        Role::create([
            'id' => RoleId::Admin,
            'name' => 'Admin',
            'permission' => [
                Permission::ManageRole,
                Permission::ManageUser
            ]
        ]);

        Role::create([
            'id' => RoleId::Employee,
            'name' => 'Employee',
            'permission' => []
        ]);
    }
}
