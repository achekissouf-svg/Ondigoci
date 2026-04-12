@extends('layouts.app')

@section('title', 'Boutique en attente')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-5">
                <div class="card-body p-5">
                    <i class="fas fa-hourglass-half text-warning text-6xl mb-4" style="font-size: 60px;"></i>
                    <h2 class="font-bold text-2xl text-gray-800 mb-3">Votre boutique est en cours de validation</h2>
                    <p class="text-gray-600 mb-4">
                        Merci de votre inscription. Un administrateur doit examiner et approuver votre boutique avant que vous ne puissiez accéder au tableau de bord pour commencer à vendre.
                    </p>
                    <p class="text-gray-500 text-sm">
                        Si ce processus prend trop de temps, n'hésitez pas à nous contacter.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
