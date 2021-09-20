<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        $adminRole =  Role::where('name', Role::ADMIN_ROLE)->first();
        $admin = User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'password' => Hash::make('admin123'),
            'email' => 'admin@test.com',
        ]);
        $admin->roles()->attach($adminRole);
    }
}
