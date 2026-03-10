<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Pán',
                'last_name' => 'Admin',
                'email' => 'admin@ukf.sk',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Dávid',
                'last_name' => 'Držík',
                'email' => 'ddrzik@ukf.sk',
                'password' => Hash::make('456'),
                'role' => 'user',
                'premium_until' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jozef',
                'last_name' => 'Kapusta',
                'email' => 'jkapusta@ukf.sk',
                'password' => Hash::make('789'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Nováková',
                'email' => 'anovakova@ukf.sk',
                'password' => Hash::make('111'),
                'role' => 'user',
                'premium_until' => now()->addDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Martin',
                'last_name' => 'Kováč',
                'email' => 'mkovac@ukf.sk',
                'password' => Hash::make('222'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Lucia',
                'last_name' => 'Bartošová',
                'email' => 'lbartosova@ukf.sk',
                'password' => Hash::make('333'),
                'role' => 'user',
                'premium_until' => now()->addDays(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Peter',
                'last_name' => 'Horváth',
                'email' => 'phorvath@ukf.sk',
                'password' => Hash::make('444'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Eva',
                'last_name' => 'Šimková',
                'email' => 'esimkova@ukf.sk',
                'password' => Hash::make('555'),
                'role' => 'user',
                'premium_until' => now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
