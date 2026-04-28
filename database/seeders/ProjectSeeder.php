<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach(range(1,5) as $i){
            $project =Project::create([
                'nom' => "Project". $i,
                'description' => fake()->paragraph(),
                'created_by' => $users->random()->id
            ]);

            //Assigner des membres aleatoires au projet
            $members =$users->random(3);

            foreach($members as $member){
                $project->members()->attach($member->id, [
                    'role' => fake()->randomElement(['member', 'admin']),
                ]);
            }
        }
    }
}
