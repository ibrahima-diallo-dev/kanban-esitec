@extends('layouts.app')

@section('title', $project->name . ' — Board')

@push('styles')
<style>
.board { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; align-items:start; }
@media(max-width:768px){ .board { grid-template-columns:1fr; } }

.column { border-radius:16px; padding:14px; }
.col-todo  { background:#f0f4ff; border:1px solid #c7d2fe; }
.col-doing { background:#fffbeb; border:1px solid #fcd34d; }
.col-done  { background:#f0fdf4; border:1px solid #86efac; }

.col-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.col-label  { display:flex; align-items:center; gap:7px; font-size:12.5px; font-weight:700; }
.dot { width:8px; height:8px; border-radius:50%; }
.col-count  { font-size:11px; font-weight:700; padding:2px 8px; border-radius:7px; }

.col-todo  .col-label { color:#3730a3; } .col-todo  .dot { background:#6366f1; } .col-todo  .col-count { background:#c7d2fe; color:#3730a3; }
.col-doing .col-label { color:#92400e; } .col-doing .dot { background:#f59e0b; } .col-doing .col-count { background:#fcd34d; color:#92400e; }
.col-done  .col-label { color:#166534; } .col-done  .dot { background:#10b981; } .col-done  .col-count { background:#86efac; color:#166534; }

.task-card {
    background:#fff; border-radius:12px; padding:13px; margin-bottom:9px;
    border:1px solid transparent; transition:.15s; display:block; text-decoration:none; color:inherit;
}
.task-card:hover { border-color:#4f6ef7; transform:translateY(-2px); box-shadow:0 4px 12px rgba(79,110,247,.1); }

.priority-badge { font-size:10px; font-weight:700; text-transform:uppercase; padding:2px 7px; border-radius:5px; letter-spacing:.04em; }
.p-haute   { background:#fef2f2; color:#dc2626; }
.p-moyenne { background:#fffbeb; color:#d97706; }
.p-basse   { background:#f0fdf4; color:#16a34a; }

.task-av {
    width:22px; height:22px; border-radius:6px;
    background:linear-gradient(135deg,#4f6ef7,#7c3aed);
    display:flex; align-items:center; justify-content:center;
    font-size:9px; font-weight:700; color:#fff; flex-shrink:0;
}

.add-btn {
    width:100%; padding:9px; border:1.5px dashed; border-radius:10px;
    background:none; font-size:12px; font-weight:600; cursor:pointer;
    transition:.15s; display:flex; align-items:center; justify-content:center; gap:5px; text-decoration:none;
}
.col-todo  .add-btn { border-color:#a5b4fc; color:#6366f1; }
.col-todo  .add-btn:hover { background:#e0e7ff; }
.col-doing .add-btn { border-color:#fcd34d; color:#d97706; }
.col-doing .add-btn:hover { background:#fef3c7; }
.col-done  .add-btn { border-color:#86efac; color:#16a34a; }
.col-done  .add-btn:hover { background:#dcfce7; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    {{-- En-tête --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <nav class="flex items-center gap-2 text-sm text-ink-400 mb-2">
                <a href="{{ route('projects.index') }}" class="hover:text-brand-500 transition-colors">Projets</a>
                <span>›</span>
                <span class="text-ink-900 font-medium">{{ $project->name }}</span>
            </nav>
            <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0e0f1a;letter-spacing:-.02em;">
                {{ $project->name }}
            </h1>
            @if($project->description)
            <p class="text-sm text-ink-400 mt-1">{{ $project->description }}</p>
            @endif
        </div>

        <div class="flex items-center gap-2">
            {{-- Membres du projet --}}
            <div style="display:flex;align-items:center;margin-right:8px;">
                @foreach($project->members->take(5) as $member)
                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;border:2px solid #fff;margin-left:-8px;" title="{{ $member->name }}">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                </div>
                @endforeach
            </div>

            @if(auth()->user()->isAdmin())
            <a href="{{ route('projects.edit', $project) }}"
               style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;color:#6b6d8a;border:1px solid #e8e9f2;background:#fff;text-decoration:none;">
                Modifier
            </a>
            @endif

            <a href="{{ route('tasks.create', $project) }}"
               style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;background:#4f6ef7;color:#fff;text-decoration:none;display:flex;align-items:center;gap:5px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter une tâche
            </a>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:20px;">
        @php $total = $todo->count() + $doing->count() + $done->count(); @endphp
        <div style="background:#fff;border:1px solid #e8e9f2;border-radius:12px;padding:12px 16px;">
            <p style="font-size:11px;font-weight:600;color:#6b6d8a;text-transform:uppercase;letter-spacing:.04em;">Total</p>
            <p style="font-size:22px;font-weight:700;color:#0e0f1a;">{{ $total }}</p>
        </div>
        <div style="background:#f0f4ff;border:1px solid #c7d2fe;border-radius:12px;padding:12px 16px;">
            <p style="font-size:11px;font-weight:600;color:#3730a3;text-transform:uppercase;letter-spacing:.04em;">À faire</p>
            <p style="font-size:22px;font-weight:700;color:#3730a3;">{{ $todo->count() }}</p>
        </div>
        <div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:12px;padding:12px 16px;">
            <p style="font-size:11px;font-weight:600;color:#92400e;text-transform:uppercase;letter-spacing:.04em;">En cours</p>
            <p style="font-size:22px;font-weight:700;color:#92400e;">{{ $doing->count() }}</p>
        </div>
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px 16px;">
            <p style="font-size:11px;font-weight:600;color:#166534;text-transform:uppercase;letter-spacing:.04em;">Terminées</p>
            <p style="font-size:22px;font-weight:700;color:#166534;">{{ $done->count() }}</p>
        </div>
    </div>

    {{-- BOARD KANBAN --}}
    <div class="board">

        {{-- COLONNE : À FAIRE --}}
        <div class="column col-todo">
            <div class="col-header">
                <div class="col-label"><div class="dot"></div>À faire</div>
                <span class="col-count">{{ $todo->count() }}</span>
            </div>

            @forelse($todo as $task)
            <a href="{{ route('tasks.show', [$project, $task]) }}" class="task-card">
                <p style="font-size:13px;font-weight:600;color:#0e0f1a;margin-bottom:8px;line-height:1.4;">
                    {{ $task->title }}
                </p>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span class="priority-badge p-{{ strtolower($task->priority) }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                    @if($task->assignedUser)
                    <div class="task-av" title="{{ $task->assignedUser->name }}">
                        {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <p style="font-size:12.5px;color:#6b6d8a;text-align:center;padding:16px 0;">Aucune tâche</p>
            @endforelse

            <a href="{{ route('tasks.create', ['project' => $project, 'status' => 'todo']) }}" class="add-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter
            </a>
        </div>

        {{-- COLONNE : EN COURS --}}
        <div class="column col-doing">
            <div class="col-header">
                <div class="col-label"><div class="dot"></div>En cours</div>
                <span class="col-count">{{ $doing->count() }}</span>
            </div>

            @forelse($doing as $task)
            <a href="{{ route('tasks.show', [$project, $task]) }}" class="task-card">
                <p style="font-size:13px;font-weight:600;color:#0e0f1a;margin-bottom:8px;line-height:1.4;">
                    {{ $task->title }}
                </p>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span class="priority-badge p-{{ strtolower($task->priority) }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                    @if($task->assignedUser)
                    <div class="task-av" title="{{ $task->assignedUser->name }}">
                        {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <p style="font-size:12.5px;color:#6b6d8a;text-align:center;padding:16px 0;">Aucune tâche</p>
            @endforelse

            <a href="{{ route('tasks.create', ['project' => $project, 'status' => 'doing']) }}" class="add-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter
            </a>
        </div>

        {{-- COLONNE : TERMINÉ --}}
        <div class="column col-done">
            <div class="col-header">
                <div class="col-label"><div class="dot"></div>Terminé</div>
                <span class="col-count">{{ $done->count() }}</span>
            </div>

            @forelse($done as $task)
            <a href="{{ route('tasks.show', [$project, $task]) }}" class="task-card">
                <p style="font-size:13px;font-weight:600;color:#0e0f1a;margin-bottom:8px;line-height:1.4;text-decoration:line-through;opacity:.6;">
                    {{ $task->title }}
                </p>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span class="priority-badge p-{{ strtolower($task->priority) }}" style="opacity:.6;">
                        {{ ucfirst($task->priority) }}
                    </span>
                    @if($task->assignedUser)
                    <div class="task-av" style="opacity:.6;" title="{{ $task->assignedUser->name }}">
                        {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <p style="font-size:12.5px;color:#6b6d8a;text-align:center;padding:16px 0;">Aucune tâche</p>
            @endforelse

            <a href="{{ route('tasks.create', ['project' => $project, 'status' => 'done']) }}" class="add-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter
            </a>
        </div>

    </div>{{-- fin .board --}}
</div>
@endsection
