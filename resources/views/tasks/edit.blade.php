@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Fil d'ariane --}}
    <nav style="display:flex;align-items:center;gap:8px;font-size:13px;color:#6b6d8a;margin-bottom:24px;">
        <a href="{{ route('projects.index') }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">Projets</a>
        <span>›</span>
        <a href="{{ route('projects.show', $project) }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">{{ $project->name }}</a>
        <span>›</span>
        <a href="{{ route('tasks.show', [$project, $task]) }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">{{ Str::limit($task->title, 30) }}</a>
        <span>›</span>
        <span style="color:#0e0f1a;font-weight:500;">Modifier</span>
    </nav>

    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0e0f1a;margin-bottom:24px;">
        Modifier la tâche
    </h1>

    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:28px;">
        <form method="POST" action="{{ route('tasks.update', [$project, $task]) }}">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Titre <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" required
                       style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('title') ? '#fca5a5' : '#e8e9f2' }};border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                       onfocus="this.style.borderColor='#0b5f9f';this.style.background='#fff'"
                       onblur="this.style.borderColor='{{ $errors->has('title') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                @error('title')
                <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Description
                </label>
                <textarea name="description" rows="3"
                          style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;resize:none;transition:.15s;"
                          onfocus="this.style.borderColor='#0b5f9f';this.style.background='#fff'"
                          onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">{{ old('description', $task->description) }}</textarea>
            </div>

            {{-- Statut + Priorité --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">Statut</label>
                    <select name="status"
                            style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                        <option value="todo"  {{ old('status', $task->status) == 'todo'  ? 'selected' : '' }}>À faire</option>
                        <option value="doing" {{ old('status', $task->status) == 'doing' ? 'selected' : '' }}>En cours</option>
                        <option value="done"  {{ old('status', $task->status) == 'done'  ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">Priorité</label>
                    <select name="priority"
                            style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                        <option value="haute"   {{ old('priority', $task->priority) == 'haute'   ? 'selected' : '' }}>Haute</option>
                        <option value="moyenne" {{ old('priority', $task->priority) == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="basse"   {{ old('priority', $task->priority) == 'basse'   ? 'selected' : '' }}>Basse</option>
                    </select>
                </div>
            </div>

            {{-- Assigné à --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">Assigner à</label>
                <select name="assigned_to"
                        style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                    <option value="">— Non assigné —</option>
                    @foreach($project->members as $member)
                    <option value="{{ $member->id }}"
                        {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <form method="POST" action="{{ route('tasks.destroy', [$project, $task]) }}"
                      onsubmit="return confirm('Supprimer cette tâche définitivement ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:9px 16px;border-radius:10px;font-size:13px;font-weight:600;background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;cursor:pointer;">
                        Supprimer
                    </button>
                </form>

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('tasks.show', [$project, $task]) }}"
                       style="padding:9px 18px;border-radius:10px;font-size:13.5px;font-weight:600;color:#6b6d8a;border:1px solid #e8e9f2;text-decoration:none;background:#fff;">
                        Annuler
                    </a>
                    <button type="submit"
                            style="padding:9px 22px;border-radius:10px;font-size:13.5px;font-weight:700;background:#0b5f9f;color:#fff;border:none;cursor:pointer;transition:.15s;"
                            onmouseover="this.style.background='#00786f'"
                            onmouseout="this.style.background='#0b5f9f'">
                        Enregistrer
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
