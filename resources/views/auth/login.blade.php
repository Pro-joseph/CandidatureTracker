@extends('layouts.guest')
@section('title', 'Connexion')

@section('content')
<div class="auth-card">
    <h2>Bon retour 👋</h2>
    <p class="auth-subtitle">Connectez-vous pour accéder à vos candidatures.</p>

    {{-- Session Errors --}}
    @if($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Session Status (e.g. email verified) --}}
    @if(session('status'))
        <div style="background:rgba(62,207,142,.1);border:1px solid rgba(62,207,142,.2);border-radius:6px;padding:11px 14px;font-size:13px;color:#3ecf8e;margin-bottom:20px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="vous@exemple.com"
                   autofocus autocomplete="email" required>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;">
                <label class="form-label" for="password" style="margin-bottom:0;">Mot de passe</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:12px;color:#4f7cff;text-decoration:none;">Mot de passe oublié ?</a>
                @endif
            </div>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="••••••••"
                   autocomplete="current-password" required>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <input type="checkbox" name="remember" id="remember"
                   style="width:15px;height:15px;accent-color:#4f7cff;cursor:pointer;"
                   {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" style="font-size:13px;color:#8b91ad;cursor:pointer;">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn-auth">Se connecter</button>
    </form>

    @if(Route::has('register'))
        <div class="auth-link">
            Pas encore de compte ?
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    @endif
</div>
@endsection