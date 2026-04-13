@extends('layouts.auth')

@section('content')
    <h2>Mot de passe oublié</h2>
    <p>Pas de problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Adresse e-mail') }}
            </label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="votre@email.com" />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-ondigoci">
            <i class="fas fa-envelope" style="margin-right: 8px;"></i>{{ __('Envoyer le lien de réinitialisation') }}
        </button>

        <div class="sign-up-section">
            <p>
                <a href="{{ route('login') }}" class="sign-up-link">Retour à la connexion</a>
            </p>
        </div>
    </form>
@endsection
