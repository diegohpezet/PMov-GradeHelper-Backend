<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(5)
            ->create();

        // Creates a new user and relates it to a student
        $studentUser = User::factory()->create([
            'email' => 'student@example.com',
        ]);
        Student::inRandomOrder()->first()->user()->associate($studentUser);

        // Creates a new admin user and assign role
        $adminUser = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $adminUser->assignRole('admin');
    }
}
