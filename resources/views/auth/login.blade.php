<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-4">
        <h2 class="fw-bold">Connexion à Ondigoci</h2>
        <p class="text-muted">Connectez-vous pour accéder à votre compte</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="form-control mt-1"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">{{ __('Se souvenir de moi') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ __('Se connecter') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-decoration-none">Inscrivez-vous</a>
            </p>
        </div>
    </form>
</x-guest-layout>