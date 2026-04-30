@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
    <div style="width:100%;max-width:380px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:2rem;">
            <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:28px;color:#0e0f1a;letter-spacing:-.03em;">
                Kanban<span style="color:#4f6ef7;">Flow</span>
            </h1>
            <p style="color:#6b6d8a;font-size:14px;margin-top:6px;">Créez votre compte gratuitement</p>
        </div>

        {{-- Carte --}}
        <div style="background:#fff;border:1px solid #e8e9f2;border-radius:20px;padding:32px;">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nom --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Nom complet
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Jean Dupont"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }};border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                           onblur="this.style.borderColor='{{ $errors->has('name') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                    @error('name')
                    <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Adresse e-mail
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="vous@exemple.com"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('email') ? '#fca5a5' : '#e8e9f2' }};border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                           onblur="this.style.borderColor='{{ $errors->has('email') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                    @error('email')
                    <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Mot de passe
                    </label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('password') ? '#fca5a5' : '#e8e9f2' }};border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                           onblur="this.style.borderColor='{{ $errors->has('password') ? '#fca5a5' : '#e8e9f2' }}';this.style.background='#f9f9fc'">
                    @error('password')
                    <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div style="margin-bottom:24px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#252640;margin-bottom:6px;">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" name="password_confirmation" required
                           placeholder="••••••••"
                           style="width:100%;padding:10px 14px;border:1px solid #e8e9f2;border-radius:10px;font-size:13.5px;font-family:inherit;background:#f9f9fc;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#4f6ef7';this.style.background='#fff'"
                           onblur="this.style.borderColor='#e8e9f2';this.style.background='#f9f9fc'">
                </div>

                {{-- Bouton --}}
                <button type="submit"
                        style="width:100%;padding:11px;border-radius:10px;font-size:14px;font-weight:700;background:#4f6ef7;color:#fff;border:none;cursor:pointer;transition:.15s;"
                        onmouseover="this.style.background='#3b55e0'"
                        onmouseout="this.style.background='#4f6ef7'">
                    Créer mon compte
                </button>

            </form>
        </div>

        {{-- Lien connexion --}}
        <p style="text-align:center;margin-top:20px;font-size:13px;color:#6b6d8a;">
            Déjà un compte ?
            <a href="{{ route('login') }}" style="color:#4f6ef7;font-weight:600;text-decoration:none;">
                Se connecter
            </a>
        </p>

    </div>
</div>
@endsection
