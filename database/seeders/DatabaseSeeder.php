<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(3)->create();
        
        // Ensure we have a specific user for testing
        $testUser = User::factory()->create([
            'name' => 'Test Candidate',
            'email' => 'candidate@example.com',
            'password' => bcrypt('password'),
        ]);

        $allUsers = $users->push($testUser);

        foreach ($allUsers as $user) {
            Task::factory()->count(10)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
