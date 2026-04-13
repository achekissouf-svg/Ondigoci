@extends('layouts.auth')

@section('content')
    <h2>Confirmer le mot de passe</h2>
    <p>Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <button type="submit" class="btn btn-primary-ondigoci">
            <i class="fas fa-check" style="margin-right: 8px;"></i>{{ __('Confirmer') }}
        </button>
    </form>
@endsection
