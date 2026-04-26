@extends('layouts.app')
@section('title', 'Mes Produits')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #1e5a9e;">Articles Publiés <i class="fas fa-box ms-2"></i></h1>
            <p class="text-muted">
                @if($boutique)
                    Produits de <strong>{{ $boutique->nom_boutique }}</strong>
                @else
                    <span class="text-danger">Aucune boutique associée à votre compte.</span>
                @endif
            </p>
        </div>
        @if($boutique)
            @if($boutique->aAtteintLimiteProduits())
                <button class="btn fw-bold text-white shadow-sm opacity-50" style="background: #ff6b35; border-radius: 8px;" title="Limite atteinte" disabled>
                    <i class="fas fa-plus me-2"></i> Ajouter un produit
                </button>
            @else
                <a href="{{ route('boutique.produits.create') }}" class="btn fw-bold text-white shadow-sm" style="background: #ff6b35; border-radius: 8px;">
                    <i class="fas fa-plus me-2"></i> Ajouter un produit
                </a>
            @endif
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" style="border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($boutique && $boutique->aAtteintLimiteProduits())
        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" style="border-left: 5px solid #ffc107; background-color: #fff8e1;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fa-2x text-warning"></i>
                <div>
                    <h5 class="fw-bold mb-1">Limite de produits atteinte !</h5>
                    <p class="mb-0">Vous avez publié <strong>{{ $boutique->produits()->count() }}</strong> produits sur <strong>{{ $boutique->getMaxProduits() }}</strong> autorisés. <br>
                    <span class="fw-bold" style="color: #d32f2f;">Veuillez vous réabonner pour continuer à ajouter de nouveaux articles et booster votre visibilité.</span></p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($produits->count() > 0)
    <div class="row g-4">
        @foreach($produits as $produit)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="height: 180px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 10px;">
                    <img src="{{ asset('images/' . $produit->image_principale_produit) }}"
                         alt="{{ $produit->nom_produit }}"
                         style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1" style="color: #333; font-size: 0.9rem;">{{ $produit->nom_produit }}</h6>
                    <p class="fw-bold mb-2" style="color: #1e5a9e; font-size: 1rem;">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</p>
                    <p class="text-muted small mb-3">Stock : {{ $produit->stock_disponible_produit }} unité(s)</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('boutique.produits.edit', $produit->id_produit) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('boutique.produits.destroy', $produit->id_produit) }}" method="POST" class="flex-fill">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Supprimer ce produit ?')">
                                <i class="fas fa-trash"></i> Retirer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 130px; height: 130px;">
            <i class="fas fa-box-open text-muted" style="font-size: 3.5rem; opacity: 0.4;"></i>
        </div>
        <h4 class="fw-bold">Aucun produit pour le moment</h4>
        <p class="text-muted">Ajoutez votre premier produit pour qu'il soit visible par les clients.</p>
        @if($boutique)
            @if($boutique->aAtteintLimiteProduits())
                <button class="btn text-white fw-bold px-4 opacity-50" style="background: #ff6b35; border-radius: 8px;" disabled>
                    <i class="fas fa-plus me-2"></i> Ajouter un produit (Limite atteinte)
                </button>
            @else
                <a href="{{ route('boutique.produits.create') }}" class="btn text-white fw-bold px-4" style="background: #ff6b35; border-radius: 8px;">
                    <i class="fas fa-plus me-2"></i> Ajouter un produit
                </a>
            @endif
        @endif
    </div>
    @endif
</div>
@endsection
