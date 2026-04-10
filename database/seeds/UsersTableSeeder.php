<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'created_at' => now()
        ]);

        // Admin2
        DB::table('users')->insert([
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'created_at' => now()
        ]);

        // Superadmin
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'SuperAdmin',
            'created_at' => now()
        ]);

        // Bendahara
        DB::table('users')->insert([
            'name' => 'bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Bendahara',
            'created_at' => now()
        ]);
    }
}
