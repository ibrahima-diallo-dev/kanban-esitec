<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'user_id',
        'task_id',
    ];

    //la tache du commentaire
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    // l'utilisateur qui a écrit le commentaire
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
