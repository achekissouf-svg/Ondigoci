@extends('layouts.app')

@section('title', 'Administration')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="font-bold text-3xl text-gray-800">Tableau de bord Administrateur</h1>
            <p class="text-gray-600">Bienvenue, {{ Auth::user()->name }}. Voici vos statistiques générales.</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 242, 254, 0.3); transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body position-relative overflow-hidden">
                    <i class="fas fa-users position-absolute" style="font-size: 5rem; opacity: 0.2; right: -10px; bottom: -10px;"></i>
                    <h5 class="card-title fw-semibold mb-3"><i class="fas fa-user-friends me-2"></i>Total Clients</h5>
                    <p class="card-text text-white" style="font-size: 2.5rem; font-weight: 700;">{{ $stats['total_clients'] }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light mt-2 fw-bold" style="color: #0082c8; border-radius: 8px;">Gérer les clients</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; border-radius: 15px; box-shadow: 0 10px 20px rgba(253, 160, 133, 0.3); transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body position-relative overflow-hidden">
                    <i class="fas fa-store position-absolute" style="font-size: 5rem; opacity: 0.2; right: -10px; bottom: -10px;"></i>
                    <h5 class="card-title fw-semibold mb-3"><i class="fas fa-store-alt me-2"></i>Boutiques en attente</h5>
                    <p class="card-text text-white" style="font-size: 2.5rem; font-weight: 700;">{{ $stats['boutiques_attente'] }}</p>
                    <a href="{{ route('admin.boutiques.index') }}" class="btn btn-light mt-2 fw-bold" style="color: #df5832; border-radius: 8px;">Voir les demandes</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px; box-shadow: 0 10px 20px rgba(56, 249, 215, 0.3); transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body position-relative overflow-hidden">
                    <i class="fas fa-box position-absolute" style="font-size: 5rem; opacity: 0.2; right: -10px; bottom: -10px;"></i>
                    <h5 class="card-title fw-semibold mb-3"><i class="fas fa-boxes me-2"></i>Produits en Stock</h5>
                    <p class="card-text text-white" style="font-size: 2.5rem; font-weight: 700;">{{ $stats['total_produits'] }}</p>
                    <a href="{{ route('admin.produits.index') }}" class="btn btn-light mt-2 fw-bold" style="color: #2ebf68; border-radius: 8px;">Gérer les produits</a>
                </div>
            </div>
        </div>
        <!-- Card 5: Catégories -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3); transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body position-relative overflow-hidden">
                    <i class="fas fa-list position-absolute" style="font-size: 5rem; opacity: 0.2; right: -10px; bottom: -10px;"></i>
                    <h5 class="card-title fw-semibold mb-3"><i class="fas fa-list-alt me-2"></i>Gestion des Catégories</h5>
                    <p class="card-text text-white" style="font-size: 1rem;">Évitez le désordre sur le site</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light mt-2 fw-bold" style="color: #667eea; border-radius: 8px;">Gérer les catégories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
