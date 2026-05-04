@extends('layouts.app')

@section('title', 'Nouvelle tâche')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Fil d'ariane --}}
    <nav style="display:flex;align-items:center;gap:8px;font-size:13px;color:#6b6d8a;margin-bottom:24px;">
        <a href="{{ route('projects.index') }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">Projets</a>
        <span>›</span>
        <a href="{{ route('projects.show', $project) }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">{{ $project->name }}</a>
        <span>›</span>
        <span style="color:#0e0f1a;font-weight:500;">Nouvelle tâche</span>
    </nav>

    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0e0f1a;margin-bottom:24px;">
        Créer une tâche
    </h1>

    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:28px;">
        <form method="POST" action="{{ route('tasks.store', $project) }}">
            @csrf

            {{-- Titre --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Titre de la tâche <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required autofocus
                       placeholder="Titre de la tâche"
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
                          placeholder="Notes utiles, contraintes, lien, contexte..."
                          style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;resize:none;transition:.15s;"
                          onfocus="this.style.borderColor='#0b5f9f';this.style.background='#fff'"
                          onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">{{ old('description') }}</textarea>
            </div>

            {{-- Statut + Priorité --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Statut
                    </label>
                    <select name="status"
                            style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                        <option value="todo"  {{ old('status', request('status')) == 'todo'  ? 'selected' : '' }}>À faire</option>
                        <option value="doing" {{ old('status', request('status')) == 'doing' ? 'selected' : '' }}>En cours</option>
                        <option value="done"  {{ old('status', request('status')) == 'done'  ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Priorité
                    </label>
                    <select name="priority"
                            style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                        <option value="haute"   {{ old('priority') == 'haute'   ? 'selected' : '' }}>Haute</option>
                        <option value="moyenne" {{ old('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="basse"   {{ old('priority') == 'basse'   ? 'selected' : '' }}>Basse</option>
                    </select>
                </div>
            </div>

            {{-- Assigné à --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Assigner à
                </label>
                <select name="assigned_to"
                        style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;cursor:pointer;">
                    <option value="">— Non assigné —</option>
                    @foreach($project->members as $member)
                    <option value="{{ $member->id }}" {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
                @error('assigned_to')
                <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <a href="{{ route('projects.show', $project) }}"
                   style="padding:9px 18px;border-radius:10px;font-size:13.5px;font-weight:600;color:#6b6d8a;border:1px solid #e8e9f2;text-decoration:none;background:#fff;">
                    Annuler
                </a>
                <button type="submit"
                        style="padding:9px 22px;border-radius:10px;font-size:13.5px;font-weight:700;background:#0b5f9f;color:#fff;border:none;cursor:pointer;transition:.15s;"
                        onmouseover="this.style.background='#00786f'"
                        onmouseout="this.style.background='#0b5f9f'">
                    Créer la tâche
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
