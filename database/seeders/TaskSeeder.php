<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            foreach (range(1, 5) as $i) {
                Task::create([
                    'titre' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'status' => fake()->randomElement(['todo', 'in_progress', 'done']),
                    'project_id' => $project->id,
                    'assigned_to' => $users->random()->id,
                ]);
            }
        }
    }
}