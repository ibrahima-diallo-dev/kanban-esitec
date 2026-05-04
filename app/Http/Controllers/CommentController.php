<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tasks.show', [$project, $task])
            ->with('success', 'Commentaire ajouté.');
    }

    public function destroy(Project $project, Task $task, Comment $comment)
    {
        abort_unless($task->project_id === $project->id && $comment->task_id === $task->id, 404);

        $user = Auth::user();

        if (! $user->isAdmin() && $comment->user_id !== $user->id) {
            abort(403, 'Vous ne pouvez pas supprimer ce commentaire.');
        }

        $comment->delete();

        return redirect()->route('tasks.show', [$project, $task])
            ->with('success', 'Commentaire supprimé.');
    }
}
