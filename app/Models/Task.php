<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'assigned_to',
    ];
    // le projet auquel la tâche appartient
    public function project()
    {
        return $this->belongsTo(Project::class);
}
    // l'utilisateur à qui la tâche est assignée
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    // les commentaires de la tâche
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }   

    // Scopes par statut
    public function scopeToDo($query)
    {
        return $query->where('status', 'todo');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }
}
