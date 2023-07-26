<?php

namespace Database\Seeders;

use App\Enums\RoleId;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('not-set'),
        ]);

        UserRole::create([
            'user_id' => $super_admin->id,
            'role_id' => RoleId::SuperAdmin,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('not-set'),
        ]);

        UserRole::create([
            'user_id' => $admin->id,
            'role_id' => RoleId::Admin,
        ]);

        $employee = User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@mail.com',
            'password' => Hash::make('not-set'),
        ]);

        UserRole::create([
            'user_id' => $employee->id,
            'role_id' => RoleId::Employee,
        ]);
    }
}
