<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Ajouter un commentaire sur une tâche.
     */
    public function store(StoreCommentRequest $request, Project $project, Task $task)
    {
        $task->comments()->create([
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('projects.tasks.show', [$project, $task])
                         ->with('success', 'Commentaire ajouté.');
    }

    /**
     * Supprimer un commentaire (auteur ou admin seulement).
     */
    public function destroy(Project $project, Task $task, Comment $comment)
    {
        $user = Auth::user();

        if (! $user->isAdmin() && $comment->user_id !== $user->id) {
            abort(403, 'Vous ne pouvez pas supprimer ce commentaire.');
        }

        $comment->delete();

        return redirect()->route('projects.tasks.show', [$project, $task])
                         ->with('success', 'Commentaire supprimé.');
    }
}
