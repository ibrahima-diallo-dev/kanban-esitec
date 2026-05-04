@extends('layouts.app')

@section('title', $task->title)

@push('styles')
<style>
.status-badge {
    display:inline-flex; align-items:center; gap:6px;
    font-size:12px; font-weight:700; padding:5px 13px;
    border-radius:8px; letter-spacing:.02em;
}
.status-todo  { background:#f0f4ff; color:#3730a3; border:1px solid #c7d2fe; }
.status-doing { background:#fffbeb; color:#92400e; border:1px solid #fcd34d; }
.status-done  { background:#f0fdf4; color:#166534; border:1px solid #86efac; }

.comment-av {
    width:30px; height:30px; border-radius:8px; flex-shrink:0;
    background:linear-gradient(135deg,#4f6ef7,#7c3aed);
    display:flex; align-items:center; justify-content:center;
    font-size:11px; font-weight:700; color:#fff;
}
.priority-badge { font-size:11px; font-weight:700; text-transform:uppercase; padding:3px 9px; border-radius:6px; letter-spacing:.04em; }
.p-haute   { background:#fef2f2; color:#dc2626; }
.p-moyenne { background:#fffbeb; color:#d97706; }
.p-basse   { background:#f0fdf4; color:#16a34a; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    {{-- Fil d'ariane --}}
    <nav class="flex items-center gap-2 text-sm text-ink-400 mb-6 flex-wrap">
        <a href="{{ route('projects.index') }}" class="hover:text-brand-500 transition-colors">Projets</a>
        <span>›</span>
        <a href="{{ route('projects.show', $project) }}" class="hover:text-brand-500 transition-colors">{{ $project->name }}</a>
        <span>›</span>
        <span class="text-ink-900 font-medium">{{ Str::limit($task->title, 40) }}</span>
    </nav>

    {{-- Carte principale --}}
    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:28px;margin-bottom:16px;">

        {{-- Statut --}}
        <div style="margin-bottom:14px;">
            @if($task->status === 'todo')
                <span class="status-badge status-todo">
                    <span style="width:7px;height:7px;border-radius:50%;background:#6366f1;display:inline-block;"></span>
                    À faire
                </span>
            @elseif($task->status === 'doing')
                <span class="status-badge status-doing">
                    <span style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                    En cours
                </span>
            @else
                <span class="status-badge status-done">
                    <span style="width:7px;height:7px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                    Terminé
                </span>
            @endif
        </div>

        {{-- Titre --}}
        <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:22px;color:#0e0f1a;line-height:1.3;margin-bottom:10px;">
            {{ $task->title }}
        </h1>

        {{-- Description --}}
        @if($task->description)
        <p style="font-size:14px;color:#3a3b52;line-height:1.7;margin-bottom:20px;">
            {{ $task->description }}
        </p>
        @endif

        {{-- Méta-données --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:20px;">
            <div style="background:#f5f5fb;border-radius:10px;padding:12px 14px;">
                <p style="font-size:10.5px;font-weight:700;color:#6b6d8a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Assigné à</p>
                @if($task->assignedUser)
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:26px;height:26px;border-radius:7px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;">
                        {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#0e0f1a;">{{ $task->assignedUser->name }}</span>
                </div>
                @else
                <span style="font-size:13px;color:#6b6d8a;">Non assigné</span>
                @endif
            </div>

            <div style="background:#f5f5fb;border-radius:10px;padding:12px 14px;">
                <p style="font-size:10.5px;font-weight:700;color:#6b6d8a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Priorité</p>
                <span class="priority-badge p-{{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
            </div>

            <div style="background:#f5f5fb;border-radius:10px;padding:12px 14px;">
                <p style="font-size:10.5px;font-weight:700;color:#6b6d8a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Créé le</p>
                <span style="font-size:13px;font-weight:500;color:#0e0f1a;">{{ $task->created_at->format('d M Y') }}</span>
            </div>

            <div style="background:#f5f5fb;border-radius:10px;padding:12px 14px;">
                <p style="font-size:10.5px;font-weight:700;color:#6b6d8a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Mis à jour</p>
                <span style="font-size:13px;font-weight:500;color:#0e0f1a;">{{ $task->updated_at->diffForHumans() }}</span>
            </div>
        </div>

        {{-- Changer le statut --}}
        <div style="border-top:1px solid #e8e9f2;padding-top:16px;margin-bottom:16px;">
            <p style="font-size:11px;font-weight:700;color:#6b6d8a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Changer le statut</p>
            <form method="POST" action="{{ route('tasks.updateStatus', [$project, $task]) }}" style="display:flex;gap:8px;flex-wrap:wrap;">
                @csrf
                @method('PATCH')
                <button type="submit" name="status" value="todo"
                        style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;border:1px solid #c7d2fe;background:{{ $task->status==='todo' ? '#c7d2fe' : '#f0f4ff' }};color:#3730a3;">
                    À faire
                </button>
                <button type="submit" name="status" value="doing"
                        style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;border:1px solid #fcd34d;background:{{ $task->status==='doing' ? '#fcd34d' : '#fffbeb' }};color:#92400e;">
                    En cours
                </button>
                <button type="submit" name="status" value="done"
                        style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;border:1px solid #86efac;background:{{ $task->status==='done' ? '#86efac' : '#f0fdf4' }};color:#166534;">
                    Terminé
                </button>
            </form>
        </div>

        {{-- Actions --}}
        <div style="display:flex;justify-content:flex-end;gap:8px;">
            @can('update', $task)
            <a href="{{ route('tasks.edit', [$project, $task]) }}"
               style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;color:#6b6d8a;border:1px solid #e8e9f2;background:#fff;text-decoration:none;">
                Modifier
            </a>
            @endcan

            @can('delete', $task)
            <form method="POST" action="{{ route('tasks.destroy', [$project, $task]) }}"
                  onsubmit="return confirm('Supprimer cette tâche ?')">
                @csrf @method('DELETE')
                <button type="submit"
                        style="padding:7px 14px;border-radius:9px;font-size:12.5px;font-weight:600;background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;cursor:pointer;">
                    Supprimer
                </button>
            </form>
            @endcan
        </div>

    </div>

    {{-- ======================================
         SECTION COMMENTAIRES
         ====================================== --}}
    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:24px;">

        <h2 style="font-size:16px;font-weight:700;color:#0e0f1a;margin-bottom:18px;">
            Commentaires
            <span style="font-weight:400;color:#6b6d8a;font-size:14px;">({{ $task->comments->count() }})</span>
        </h2>

        {{-- Liste des commentaires --}}
        @forelse($task->comments as $comment)
        <div style="display:flex;gap:12px;margin-bottom:18px;">
            <div class="comment-av">
                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
            </div>
            <div style="flex:1;">
                <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:4px;">
                    <span style="font-size:13px;font-weight:700;color:#0e0f1a;">{{ $comment->user->name }}</span>
                    <span style="font-size:11.5px;color:#6b6d8a;">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <div style="background:#f5f5fb;border-radius:0 12px 12px 12px;padding:10px 14px;">
                    <p style="font-size:13px;color:#3a3b52;line-height:1.6;">{{ $comment->body }}</p>
                </div>

                {{-- Supprimer son propre commentaire --}}
                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                <form method="POST" action="{{ route('comments.destroy', [$project, $task, $comment]) }}" style="margin-top:4px;">
                    @csrf @method('DELETE')
                    <button type="submit" style="font-size:11px;color:#6b6d8a;background:none;border:none;cursor:pointer;padding:0;"
                            onmouseover="this.style.color='#dc2626'"
                            onmouseout="this.style.color='#6b6d8a'">
                        Supprimer
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <p style="font-size:13px;color:#6b6d8a;margin-bottom:20px;">Aucun commentaire pour l'instant. Soyez le premier !</p>
        @endforelse

        {{-- Formulaire ajout commentaire --}}
        <div style="border-top:1px solid #e8e9f2;padding-top:18px;margin-top:8px;">
            <form method="POST" action="{{ route('comments.store', [$project, $task]) }}">
                @csrf
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div class="comment-av">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div style="flex:1;">
                        <textarea name="body" rows="3"
                                  placeholder="Écrire un commentaire…"
                                  class="w-full"
                                  style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:12px;font-size:13px;font-family:inherit;resize:none;background:#f9f9fc;outline:none;transition:.15s;"
                                  onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                                  onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">{{ old('body') }}</textarea>
                        @error('body')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <div style="display:flex;justify-content:flex-end;margin-top:8px;">
                            <button type="submit"
                                    style="padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;background:#4f6ef7;color:#fff;border:none;cursor:pointer;transition:.15s;"
                                    onmouseover="this.style.background='#3b55e0'"
                                    onmouseout="this.style.background='#4f6ef7'">
                                Envoyer
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
