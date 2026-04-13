@extends('layouts.auth')

@section('content')
    <h2>Réinitialiser le mot de passe</h2>
    <p>Créez un nouveau mot de passe pour votre compte Ondigoci</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Adresse e-mail') }}
            </label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="votre@email.com" />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock" style="color: #ff6b35; margin-right: 5px;"></i>{{ __('Nouveau mot de passe') }}
            </label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Minimum 8 caractères" />
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
            <i class="fas fa-key" style="margin-right: 8px;"></i>{{ __('Réinitialiser le mot de passe') }}
        </button>

        <div class="sign-up-section">
            <p>
                <a href="{{ route('login') }}" class="sign-up-link">Retour à la connexion</a>
            </p>
        </div>
    </form>
@endsection
