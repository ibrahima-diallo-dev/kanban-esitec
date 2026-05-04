<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $members = $project->members;

        return view('tasks.create', compact('project', 'members'));
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->only(
            'title',
            'description',
            'status',
            'priority',
            'assigned_to'
        ));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tâche créée avec succès.');
    }

    public function show(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->load('comments.user', 'assignedUser');

        return view('tasks.show', compact('project', 'task'));
    }

    public function edit(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $members = $project->members;

        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->update($request->only(
            'title',
            'description',
            'status',
            'priority',
            'assigned_to'
        ));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tâche supprimée.');
    }

    public function updateStatus(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $validated = $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->update(['status' => $validated['status']]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Statut mis à jour.', 'status' => $validated['status']]);
        }

        return redirect()->route('tasks.show', [$project, $task])
            ->with('success', 'Statut mis à jour.');
    }
}
