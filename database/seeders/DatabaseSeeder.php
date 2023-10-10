<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Habit;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'kgsint',
            'email' => 'kgsint@co.uk',

        ]);

        User::factory()->create([
            'name' => 'someone',
            'email' => 'someone@gmail.com',
        ]);

        User::factory()->create();


        Habit::factory(10)->create();
        Task::factory()->create();
    }
}
