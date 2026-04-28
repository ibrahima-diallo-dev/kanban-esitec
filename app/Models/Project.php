<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'created_by',
    ];

    // le créateur du projet
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // les membres du projet
    public function members()
    {        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
}
    // les tâches du projet
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }   
}