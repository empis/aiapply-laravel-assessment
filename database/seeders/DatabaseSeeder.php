<?php

namespace Database\Seeders;

use App\Models\Comment;
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
        // Test candidate account
        $candidate = User::factory()->create([
            'name' => 'Test Candidate',
            'email' => 'candidate@example.com',
            'password' => bcrypt('password'),
        ]);

        // Additional team members
        $alice = User::factory()->create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);

        $bob = User::factory()->create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create tasks for each user
        $candidateTasks = Task::factory()->count(12)->create(['user_id' => $candidate->id]);
        Task::factory()->count(8)->create(['user_id' => $alice->id]);
        Task::factory()->count(5)->create(['user_id' => $bob->id]);

        // Seed some comments on candidate's tasks
        $sampleBodies = [
            'Looks good to me, let\'s proceed.',
            'I have a few questions about this one.',
            'This is blocked by the API changes.',
            'Almost done, just needs a final review.',
            'Can we reprioritize this?',
        ];

        foreach ($candidateTasks->take(5) as $task) {
            Comment::create([
                'task_id' => $task->id,
                'user_id' => $candidate->id,
                'body' => $sampleBodies[array_rand($sampleBodies)],
            ]);
        }
    }
}
