@extends('layouts.app')

@section('title', 'Espace Boutique')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="font-bold text-3xl text-gray-800">Tableau de bord Boutique</h1>
            <p class="text-gray-600">Bienvenue dans votre espace vendeur, {{ Auth::user()->name }}.</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-box"></i> Articles publiés</h5>
                    <p class="card-text text-muted">Ajoutez, modifiez ou retirez vos produits visibles par les clients.</p>
                    <a href="{{ route('boutique.produits.index') }}" class="btn btn-outline-primary">Gérer mes produits</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-shopping-cart"></i> Mes Commandes</h5>
                    <p class="card-text text-muted">Suivez et traitez les commandes de vos clients.</p>
                    <a href="#" class="btn btn-outline-success">Voir les commandes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="fas fa-chart-line"></i> Mes Statistiques</h5>
                    <p class="card-text text-muted">Analysez vos ventes et performances.</p>
                    <a href="#" class="btn btn-outline-warning">Voir les stats</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title" style="color: #9b59b6;"><i class="fas fa-receipt"></i> Mes Commandes Reçues</h5>
                    <p class="card-text text-muted">Consultez les commandes passées sur vos produits.</p>
                    <a href="{{ route('boutique.commandes.index') }}" class="btn" style="border: 1px solid #9b59b6; color: #9b59b6;">Voir les commandes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
