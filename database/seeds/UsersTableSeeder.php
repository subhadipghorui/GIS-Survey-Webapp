<?php

use App\User;
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
        $superAdmin = User::create([
            'userid' => 'super_admin101',
            'role_id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' =>  bcrypt('superadmin'),
        ]);
        $admin = User::create([
            'userid' => 'admin101',
            'role_id' => 2,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' =>  bcrypt('admin'),
        ]);
        $user = User::create([
            'userid' => 'user101',
            'role_id' => 3,
            'name' => 'User',
            'email' => 'user@example.com',
            'password' =>  bcrypt('user'),
        ]);

        $users = factory(App\User::class, 5)->create();

    }
}
