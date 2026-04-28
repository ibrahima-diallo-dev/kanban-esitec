<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Formulaire de création d'une tâche dans un projet.
     */
    public function create(Project $project)
    {
        $members = $project->members;
        return view('tasks.create', compact('project', 'members'));
    }

    /**
     * Enregistrer une nouvelle tâche.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Afficher une tâche avec ses commentaires.
     */
    public function show(Project $project, Task $task)
    {
        $task->load('comments.author', 'assignee');
        return view('tasks.show', compact('project', 'task'));
    }

    /**
     * Formulaire d'édition d'une tâche.
     */
    public function edit(Project $project, Task $task)
    {
        $members = $project->members;
        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    /**
     * Mettre à jour une tâche.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->only('title', 'description', 'status', 'assigned_to'));

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche mise à jour.');
    }

    /**
     * Soft delete d'une tâche.
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete(); // soft delete grâce au trait SoftDeletes

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche supprimée.');
    }

    /**
     * Changer le statut d'une tâche (via drag & drop ou bouton).
     */
    public function updateStatus(Project $project, Task $task, string $status)
    {
        $allowed = ['todo', 'in_progress', 'done'];

        if (! in_array($status, $allowed)) {
            abort(422, 'Statut invalide.');
        }

        $task->update(['status' => $status]);

        return response()->json(['message' => 'Statut mis à jour.', 'status' => $status]);
    }
}
