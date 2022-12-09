<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mr s',
            'email' => 'x@gmail.com',
            'email_verified' => true,
            'password' => Hash::make('12345678'),
            'role' => ROLE_USER,
        ]);
    }
}
