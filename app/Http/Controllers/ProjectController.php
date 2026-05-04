<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Liste tous les projets.
     * Admin : voit tous les projets.
     * Member : voit seulement ses projets.
     */
    public function index()
    {
        $user = Auth::user();

        $projects = $user->isAdmin()
            ? Project::with(['creator', 'members'])->latest()->paginate(10)
            : Project::forUser($user)->with(['creator', 'members'])->latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Formulaire de création (admin seulement).
     */
    public function create()
    {
        $users = User::where('role', 'member')->get();
        return view('projects.create', compact('users'));
    }

    /**
     * Enregistrer un nouveau projet.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => Auth::id(),
        ]);

        // Attacher les membres sélectionnés
        if ($request->has('members')) {
            $project->members()->syncWithPivotValues($request->members, ['role' => 'member']);
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Afficher un projet avec son board Kanban.
     */
    public function show(Project $project)
    {
        $this->authorizeProjectAccess($project);

        $project->load('members');
        $todo = $project->tasks()->toDo()->with('assignedUser')->get();
        $doing = $project->tasks()->doing()->with('assignedUser')->get();
        $done = $project->tasks()->done()->with('assignedUser')->get();
        $members    = $project->members;

        return view('projects.show', compact('project', 'todo', 'doing', 'done', 'members'));
    }

    /**
     * Formulaire d'édition (admin seulement).
     */
    public function edit(Project $project)
    {
        $users = User::where('role', 'member')->get();
        $selectedMembers = $project->members->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'users', 'selectedMembers'));
    }

    /**
     * Mettre à jour un projet.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->only('name', 'description'));

        if ($request->has('members')) {
            $project->members()->syncWithPivotValues($request->members, ['role' => 'member']);
        } else {
            $project->members()->sync([]);
        }

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Projet mis à jour.');
    }

    /**
     * Supprimer un projet (admin seulement).
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Projet supprimé.');
    }

    /**
     * Vérifie que l'utilisateur a accès au projet.
     */
    private function authorizeProjectAccess(Project $project): void
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        $isMember = $project->members()->where('user_id', $user->id)->exists();
        $isCreator = $project->created_by === $user->id;

        if (! $isMember && ! $isCreator) {
            abort(403, 'Vous n\'avez pas accès à ce projet.');
        }
    }
}
