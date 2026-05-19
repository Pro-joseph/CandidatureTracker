@extends('layouts.guest')
@section('title', 'Inscription')

@section('content')
<div class="auth-card">
    <h2>Créer un compte</h2>
    <p class="auth-subtitle">Commencez à suivre vos candidatures dès aujourd'hui.</p>

    @if($errors->any())
        <div class="alert-error">
            <ul style="list-style:none;display:flex;flex-direction:column;gap:4px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nom complet</label>
            <input type="text" id="name" name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Jean Dupont"
                   autofocus autocomplete="name" required>
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="vous@exemple.com"
                   autocomplete="username" required>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                   class="form-control"
                   placeholder="Minimum 8 caractères"
                   autocomplete="new-password" required>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control"
                   placeholder="Répétez votre mot de passe"
                   autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn-auth">Créer mon compte</button>
    </form>

    <div class="auth-link">
        Déjà un compte ?
        <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>
@endsection