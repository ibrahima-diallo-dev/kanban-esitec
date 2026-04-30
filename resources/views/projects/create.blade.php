@extends('layouts.app')

@section('title', 'Nouveau projet')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Fil d'ariane --}}
    <nav class="flex items-center gap-2 text-sm text-ink-400 mb-6">
        <a href="{{ route('projects.index') }}" class="hover:text-brand-500 transition-colors">Projets</a>
        <span>›</span>
        <span class="text-ink-900 font-medium">Nouveau projet</span>
    </nav>

    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0e0f1a;margin-bottom:24px;">
        Créer un projet
    </h1>

    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:28px;">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            {{-- Nom --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ink-700 mb-1.5">
                    Nom du projet <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Ex : Refonte du site vitrine"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border transition-colors"
                       style="border-color:{{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }};outline:none;background:#f9f9fc;"
                       onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                       onblur="this.style.borderColor='{{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ink-700 mb-1.5">Description</label>
                <textarea name="description" rows="4"
                          placeholder="Décrivez l'objectif du projet, les livrables attendus…"
                          class="w-full px-4 py-2.5 rounded-xl text-sm border transition-colors resize-none"
                          style="border-color:#e8e9f2;outline:none;background:#f9f9fc;font-family:inherit;"
                          onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                          onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Membres --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-ink-700 mb-1.5">Ajouter des membres</label>
                <div style="border:1px solid #e8e9f2;border-radius:12px;overflow:hidden;background:#f9f9fc;">
                    @foreach($users as $user)
                    <label style="display:flex;align-items:center;gap:12px;padding:10px 14px;cursor:pointer;transition:.1s;border-bottom:1px solid #f0f0f8;"
                           onmouseover="this.style.background='#f0f4ff'"
                           onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="members[]" value="{{ $user->id }}"
                               {{ in_array($user->id, old('members', [])) ? 'checked' : '' }}
                               style="width:15px;height:15px;accent-color:#4f6ef7;border-radius:4px;">
                        <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:600;color:#0e0f1a;">{{ $user->name }}</p>
                            <p style="font-size:11.5px;color:#6b6d8a;">{{ $user->email }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('members')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('projects.index') }}"
                   style="padding:9px 18px;border-radius:10px;font-size:13.5px;font-weight:600;color:#6b6d8a;border:1px solid #e8e9f2;text-decoration:none;background:#fff;">
                    Annuler
                </a>
                <button type="submit"
                        style="padding:9px 20px;border-radius:10px;font-size:13.5px;font-weight:600;background:#4f6ef7;color:#fff;border:none;cursor:pointer;transition:.15s;"
                        onmouseover="this.style.background='#3b55e0'"
                        onmouseout="this.style.background='#4f6ef7'">
                    Créer le projet
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
