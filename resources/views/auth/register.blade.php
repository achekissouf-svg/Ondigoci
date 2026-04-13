@extends('layouts.auth')

@section('content')
    <h2>Inscription sur Ondigoci</h2>
    <p>Créez votre compte pour commencer vos achats</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="fas fa-user" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Nom complet') }}
            </label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Votre nom complet" />
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Email') }}
            </label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com" />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
 
        <!-- Telephone -->
        <div class="mb-3">
            <label for="telephone" class="form-label">
                <i class="fas fa-phone" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Numéro de téléphone') }}
            </label>
            <input id="telephone" class="form-control" type="text" name="telephone" value="{{ old('telephone') }}" required placeholder="ex: +225 0505..." />
            @error('telephone')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Mot de passe') }}
            </label>
            <input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimum 8 caractères" />
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Confirmer le mot de passe') }}
            </label>
            <input id="password_confirmation" class="form-control"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre mot de passe" />
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-ondigoci">
            <i class="fas fa-user-plus" style="margin-right: 8px;"></i>{{ __('S\'inscrire') }}
        </button>

        <div class="sign-up-section">
            <p>Déjà inscrit ? 
                <a href="{{ route('login') }}" class="sign-up-link">Connectez-vous</a>
            </p>
        </div>
    </form>
@endsection