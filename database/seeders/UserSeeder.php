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
     */
    public function run(): void
    {
        //Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kanban.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        //Membres avec faker
        User::factory(9)->create();
    }
}    
