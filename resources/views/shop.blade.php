@extends('layouts.app')

@section('title', $query ? "Résultats pour: $query" : 'Notre Boutique')

@section('content')
<div class="container mt-5 mb-5">
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="fw-bold" style="color: #1e5a9e;">
                @if($query)
                    <i class="fas fa-search" style="color: #ff6b35;"></i> Résultats pour "<strong>{{ $query }}</strong>"
                @else
                    <i class="fas fa-store" style="color: #ff6b35;"></i> Notre Boutique
                @endif
            </h1>
            <p class="text-muted">
                @if($query)
                    {{ $produits->total() }} produit(s) trouvé(s)
                @else
                    Découvrez tous nos produits
                @endif
            </p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row mb-4">
        @if($produits->count() > 0)
            <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6">
                @foreach($produits as $produit)
                        <div class="col">
                            <x-product-card :product="$produit" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5" style="display: flex; justify-content: center;">
                    {{ $produits->links() }}
                </div>
            @else
                <!-- No Products Found -->
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fas fa-search-minus" style="font-size: 60px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #1e5a9e; margin-bottom: 10px;">Aucun produit trouvé</h3>
                    <p style="color: #999; margin-bottom: 20px;">
                        @if($query)
                            Désolé, aucun produit ne correspond à votre recherche: "<strong>{{ $query }}</strong>"
                        @else
                            Aucun produit disponible pour le moment
                        @endif
                    </p>
                    <a href="{{ route('shop') }}" class="btn" style="background: linear-gradient(135deg, #ff6b35, #ff8c42); color: white; border: none;">
                        <i class="fas fa-arrow-left"></i> Voir tous les produits
                    </a>
                </div>
            @endif
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }

    .list-group-item.active {
        background-color: #ff6b35 !important;
        border-color: #ff6b35 !important;
        color: white !important;
    }

    .btn-outline-primary {
        color: #1e5a9e !important;
        border-color: #1e5a9e !important;
    }

    .btn-outline-primary:hover {
        background-color: #1e5a9e !important;
        border-color: #1e5a9e !important;
        color: white !important;
    }

    /* Pagination styling */
    .pagination {
        gap: 5px;
    }

    .pagination a, .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border-radius: 5px;
        border: 1px solid #ddd;
        color: #1e5a9e;
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination a:hover {
        background-color: #1e5a9e;
        color: white;
        border-color: #1e5a9e;
    }

    .pagination .active span {
        background-color: #ff6b35;
        color: white;
        border-color: #ff6b35;
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column-reverse;
        }
    }
</style>

@endsection
