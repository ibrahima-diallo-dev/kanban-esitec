@extends('layouts.app')

@section('title', 'Mes projets')

@push('styles')
<style>
.project-card {
    background:#fff; border:1px solid #e8e9f2; border-radius:16px;
    padding:20px; cursor:pointer; transition:.2s; position:relative; overflow:hidden;
    text-decoration:none; display:block; color:inherit;
}
.project-card:hover { border-color:#4f6ef7; transform:translateY(-3px); box-shadow:0 8px 24px rgba(79,110,247,.1); }
.project-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:4px; border-radius:16px 16px 0 0;
}
.color-blue::before   { background:#4f6ef7; }
.color-violet::before { background:#8b5cf6; }
.color-rose::before   { background:#f43f5e; }
.color-teal::before   { background:#14b8a6; }
.color-amber::before  { background:#f59e0b; }

.member-av {
    width:24px; height:24px; border-radius:7px;
    background:linear-gradient(135deg,#4f6ef7,#7c3aed);
    display:flex; align-items:center; justify-content:center;
    font-size:10px; font-weight:700; color:#fff;
    border:2px solid #fff; margin-left:-7px;
}
.member-av:first-child { margin-left:0; }

.btn-primary {
    background:#4f6ef7; color:#fff; border:none; border-radius:10px;
    padding:9px 16px; font-size:13.5px; font-weight:600; cursor:pointer; transition:.15s;
    display:inline-flex; align-items:center; gap:6px; text-decoration:none;
}
.btn-primary:hover { background:#3b55e0; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    {{-- En-tête --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:26px;color:#0e0f1a;letter-spacing:-.02em;">
                Mes projets
            </h1>
            <p class="text-sm text-ink-400 mt-1">{{ $projects->total() }} projet(s) au total</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('projects.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nouveau projet
        </a>
        @endif
    </div>

    {{-- Grille des projets --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">

    @forelse($projects as $project)
    @php
        $colors = ['color-blue','color-violet','color-rose','color-teal','color-amber'];
        $color  = $colors[$project->id % count($colors)];
        $total  = $project->tasks()->count();
        $done   = $project->tasks()->done()->count();
        $pct    = $total > 0 ? round(($done / $total) * 100) : 0;
    @endphp
    <a href="{{ route('projects.show', $project) }}" class="project-card {{ $color }}">

        {{-- Nom + description --}}
        <h2 style="font-size:15px;font-weight:700;color:#0e0f1a;margin-bottom:6px;">
            {{ $project->name }}
        </h2>
        <p style="font-size:12.5px;color:#6b6d8a;line-height:1.5;margin-bottom:14px;min-height:38px;">
            {{ Str::limit($project->description, 80) }}
        </p>

        {{-- Barre de progression --}}
        <div style="margin-bottom:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                <span style="font-size:11px;font-weight:600;color:#6b6d8a;text-transform:uppercase;letter-spacing:.04em;">Progression</span>
                <span style="font-size:11px;font-weight:700;color:#0e0f1a;">{{ $pct }}%</span>
            </div>
            <div style="height:5px;background:#f0f0f8;border-radius:99px;overflow:hidden;">
                <div style="height:100%;border-radius:99px;background:#4f6ef7;width:{{ $pct }}%;transition:.3s;"></div>
            </div>
        </div>

        {{-- Membres + compteur tâches --}}
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;">
                @foreach($project->members->take(4) as $member)
                <div class="member-av" title="{{ $member->name }}">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                </div>
                @endforeach
                @if($project->members->count() > 4)
                <div class="member-av" style="background:#e8e9f2;color:#6b6d8a;">
                    +{{ $project->members->count() - 4 }}
                </div>
                @endif
            </div>
            <span style="font-size:11.5px;color:#6b6d8a;background:#f5f5fb;padding:3px 9px;border-radius:7px;font-weight:500;">
                {{ $total }} tâche{{ $total > 1 ? 's' : '' }}
            </span>
        </div>

    </a>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px 20px;">
        <p style="font-size:15px;color:#6b6d8a;margin-bottom:12px;">Aucun projet pour le moment.</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('projects.create') }}" class="btn-primary">Créer le premier projet</a>
        @endif
    </div>
    @endforelse

    </div>{{-- fin grille --}}

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $projects->links('components.pagination') }}
    </div>

</div>
@endsection
