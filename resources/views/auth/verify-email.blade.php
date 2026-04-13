@extends('layouts.auth')

@section('content')
    <h2>Vérifier votre e-mail</h2>
    <p>Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'e-mail, nous serons heureux de vous en envoyer un autre.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4">
            <i class="fas fa-check-circle"></i> {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail que vous avez fournie lors de votre inscription.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-primary-ondigoci w-100">
            <i class="fas fa-envelope" style="margin-right: 8px;"></i>{{ __('Renvoyer l\'e-mail de vérification') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">
            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>{{ __('Se déconnecter') }}
        </button>
    </form>

    <style>
        .btn-outline-secondary {
            background: white;
            border: 2px solid #1e5a9e;
            color: #1e5a9e;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            width: 100%;
            cursor: pointer;
        }
        .btn-outline-secondary:hover {
            background: #1e5a9e;
            color: white;
        }
    </style>
@endsection
