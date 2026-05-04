@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;background:#f6fafc;">
    <div style="width:100%;max-width:380px;">
        <div style="text-align:center;margin-bottom:2rem;">
            <img src="{{ asset('logo.png') }}" alt="KanbanEsitec" class="brand-logo brand-logo-auth">
            <p style="color:#64748b;font-size:14px;margin-top:6px;">Connecte-toi pour retrouver tes projets.</p>
        </div>

        <div style="background:#fff;border:1px solid #dce8ef;border-radius:14px;padding:28px;box-shadow:0 12px 30px rgba(9,33,74,.06);">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#203a63;margin-bottom:6px;">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('email') ? '#fca5a5' : '#dce8ef' }};border-radius:9px;font-size:13.5px;font-family:inherit;background:#f8fbfd;outline:none;transition:.15s;">
                    @error('email')
                        <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#203a63;margin-bottom:6px;">Mot de passe</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('password') ? '#fca5a5' : '#dce8ef' }};border-radius:9px;font-size:13.5px;font-family:inherit;background:#f8fbfd;outline:none;transition:.15s;">
                    @error('password')
                        <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                    <input type="checkbox" name="remember" id="remember" style="width:15px;height:15px;accent-color:#009e92;border-radius:4px;">
                    <label for="remember" style="font-size:13px;color:#64748b;cursor:pointer;">Garder ma session ouverte</label>
                </div>

                <button type="submit" style="width:100%;padding:11px;border-radius:9px;font-size:14px;font-weight:700;background:#0b5f9f;color:#fff;border:none;cursor:pointer;transition:.15s;">
                    Se connecter
                </button>
            </form>
        </div>

        <p style="text-align:center;margin-top:20px;font-size:13px;color:#64748b;">
            Nouveau sur la plateforme ?
            <a href="{{ route('register') }}" style="color:#00786f;font-weight:600;text-decoration:none;">Créer un compte</a>
        </p>
    </div>
</div>
@endsection
