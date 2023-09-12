<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Rahul',
                'email' => 'rahul@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Ranjan',
                'email' => 'ranjan@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Nitin',
                'email' => 'nitin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Ayush',
                'email' => 'ayush@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
            ]
        ]);
    }
}
