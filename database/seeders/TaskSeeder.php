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
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'status' => fake()->randomElement(['todo', 'doing', 'done']),
                    'priority' => fake()->randomElement(['haute', 'moyenne', 'basse']),
                    'project_id' => $project->id,
                    'assigned_to' => $users->random()->id,
                ]);
            }
        }
    }
}
