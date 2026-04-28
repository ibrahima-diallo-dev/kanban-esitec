<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();
        $users = User::all();

        foreach ($tasks as $task) {
            foreach (range(1, 3) as $i) {
                Comment::create([
                    'body' => fake()->sentence(),
                    'task_id' => $task->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}