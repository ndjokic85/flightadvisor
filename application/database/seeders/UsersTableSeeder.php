<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole =  Role::where('name', 'admin')->first();
        $admin = User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'password' => bcrypt('admin'),
            'salt' => '123acdporimks09sff',
            'email' => 'admin@test.com',
        ]);
        $admin->roles()->attach($adminRole);
    }
}
