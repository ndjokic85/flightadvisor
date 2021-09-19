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
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'password' => bcrypt('admin'),
            'salt' => '123acdporimks09sff',
            'email' => 'admin@test.com',
        ]);

        $user = User::create([
            'username' => 'nikola',
            'first_name' => 'Nikola',
            'last_name' => 'Test',
            'password' => bcrypt('nikola'),
            'salt' => '823acgporimjs09skf',
            'email' => 'nikola@test.com',
        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
