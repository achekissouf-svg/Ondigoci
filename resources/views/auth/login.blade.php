@extends('layouts.auth')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2>Connexion à Ondigoci</h2>
    <p>Connectez-vous pour accéder à votre compte</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Email') }}
            </label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="votre@email.com" />
            @error('email')
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
                            required autocomplete="current-password" placeholder="Votre mot de passe" />
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">{{ __('Se souvenir de moi') }}</label>
        </div>

        <button type="submit" class="btn btn-primary-ondigoci">
            <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>{{ __('Se connecter') }}
        </button>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    <i class="fas fa-question-circle"></i> {{ __('Mot de passe oublié ?') }}
                </a>
            </div>
        @endif

        <div class="sign-up-section">
            <p>Pas encore de compte ? 
                <a href="{{ route('register') }}" class="sign-up-link">Inscrivez-vous</a>
            </p>
        </div>
    </form>
@endsection