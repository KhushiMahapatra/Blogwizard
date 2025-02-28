<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'vaishvi',
            'email' => 'vaishvi@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 1
        ]);
    }
}
