@extends('layouts.app')

@section('title', 'Modifier ' . $project->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Fil d'ariane --}}
    <nav style="display:flex;align-items:center;gap:8px;font-size:13px;color:#6b6d8a;margin-bottom:24px;">
        <a href="{{ route('projects.index') }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">Projets</a>
        <span>›</span>
        <a href="{{ route('projects.show', $project) }}" style="color:#6b6d8a;text-decoration:none;" onmouseover="this.style.color='#0b5f9f'" onmouseout="this.style.color='#6b6d8a'">{{ $project->name }}</a>
        <span>›</span>
        <span style="color:#0e0f1a;font-weight:500;">Modifier</span>
    </nav>

    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0e0f1a;margin-bottom:24px;">
        Modifier le projet
    </h1>

    <div style="background:#fff;border:1px solid #e8e9f2;border-radius:18px;padding:28px;">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Nom du projet <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" required
                       style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }};border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                       onfocus="this.style.borderColor='#0b5f9f';this.style.background='#fff'"
                       onblur="this.style.borderColor='{{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                @error('name')
                <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                    Description
                </label>
                <textarea name="description" rows="4"
                          style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;resize:none;transition:.15s;"
                          onfocus="this.style.borderColor='#0b5f9f';this.style.background='#fff'"
                          onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">{{ old('description', $project->description) }}</textarea>
                @error('description')
                <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Membres --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:8px;">
                    Membres du projet
                </label>
                <div style="border:1px solid #e8e9f2;border-radius:12px;overflow:hidden;">
                    @foreach($users as $user)
                    @php $isMember = $project->members->contains($user->id); @endphp
                    <label style="display:flex;align-items:center;gap:12px;padding:10px 14px;cursor:pointer;transition:.1s;border-bottom:1px solid #f5f5fb;"
                           onmouseover="this.style.background='#eaf4fb'"
                           onmouseout="this.style.background='transparent'">
                        <input type="checkbox" name="members[]" value="{{ $user->id }}"
                               {{ in_array($user->id, old('members', $project->members->pluck('id')->toArray())) ? 'checked' : '' }}
                               style="width:15px;height:15px;accent-color:#0b5f9f;flex-shrink:0;">
                        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#0b5f9f,#009e92);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:600;color:#0e0f1a;margin:0;">{{ $user->name }}</p>
                            <p style="font-size:12px;color:#6b6d8a;margin:0;">{{ $user->email }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:space-between;align-items:center;">
                {{-- Supprimer (admin seulement) --}}
                @if(auth()->user()->isAdmin())
                <form method="POST" action="{{ route('projects.destroy', $project) }}"
                      onsubmit="return confirm('Supprimer ce projet ? Toutes les tâches seront supprimées.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:9px 16px;border-radius:10px;font-size:13px;font-weight:600;background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;cursor:pointer;">
                        Supprimer le projet
                    </button>
                </form>
                @else
                <div></div>
                @endif

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('projects.show', $project) }}"
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
