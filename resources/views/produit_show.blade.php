@extends('layouts.app')

@section('title', $produit->nom_produit)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none">Boutique</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produit->nom_produit }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                @if($produit->image_principale_produit)
                    <img src="{{ asset('images/' . $produit->image_principale_produit) }}" class="img-fluid w-100" alt="{{ $produit->nom_produit }}" style="max-height: 500px; object-fit: contain;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill me-2">
                        {{ $produit->categorie->libel_categorie }}
                    </span>
                    @if($produit->id_promo)
                        <span class="badge bg-danger px-3 py-2 rounded-pill">PROMO</span>
                    @endif
                </div>

                <h1 class="fw-bold mb-3" style="color: #1e5a9e;">{{ $produit->nom_produit }}</h1>
                
                <!-- Shop Link -->
                <p class="mb-4">
                    Vendu par : 
                    <a href="{{ route('magasin.show', $produit->boutique->id) }}" class="fw-bold text-decoration-none">
                        {{ $produit->boutique->nom_boutique }}
                        @if($produit->boutique->est_verifie)
                            <i class="fas fa-check-circle text-primary ms-1" title="Magasin Vérifié"></i>
                        @endif
                    </a>
                </p>

                <div class="mb-4">
                    @if($produit->prixAvecReduction() < $produit->prix_unitaire_produit)
                        <span class="fs-2 fw-bold text-danger">{{ number_format($produit->prixAvecReduction(), 0, ',', ' ') }} FCFA</span>
                        <del class="text-muted ms-2">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</del>
                    @else
                        <span class="fs-2 fw-bold" style="color: #ff6b35;">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</span>
                    @endif
                </div>

                <div class="card border-0 bg-light rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <p class="text-muted mb-0">{{ $produit->description_produit }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="fw-bold mb-2">Disponibilité : 
                        @if($produit->stock_disponible_produit > 0)
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> En stock ({{ $produit->stock_disponible_produit }})</span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Rupture de stock</span>
                        @endif
                    </p>
                </div>

                <div class="d-grid gap-3 d-md-flex">
                    @if($produit->stock_disponible_produit > 0)
                        <button onclick="addToCart('{{ $produit->id_produit }}')" class="btn btn-primary btn-lg px-5 py-3 fw-bold rounded-3 shadow-sm flex-grow-1">
                            <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                        </button>
                    @endif
                    
                    @if($produit->boutique->whatsapp)
                        <a href="https://wa.me/{{ $produit->boutique->whatsapp }}?text=Bonjour {{ $produit->boutique->nom_boutique }}, je suis intéressé par votre produit : {{ $produit->nom_produit }}" 
                           target="_blank" 
                           class="btn btn-outline-success btn-lg px-4 py-3 fw-bold rounded-3 shadow-sm">
                            <i class="fab fa-whatsapp me-2"></i> Contacter
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Suggestions -->
    @if(count($suggestions) > 0)
    <div class="mt-5 pt-5 border-top">
        <h3 class="fw-bold mb-4">Vous pourriez aussi aimer</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($suggestions as $suggest)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card" style="border-radius: 15px;">
                    <img src="{{ asset('images/' . ($suggest->image_principale_produit ?? 'default_product.png')) }}" class="card-img-top p-3" alt="{{ $suggest->nom_produit }}" style="height: 200px; object-fit: contain;">
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-truncate">{{ $suggest->nom_produit }}</h6>
                        <p class="text-primary fw-bold mb-0">{{ number_format($suggest->prix_unitaire_produit, 0, ',', ' ') }} FCFA</p>
                        <a href="{{ route('produit.show', $suggest->id_produit) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .product-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<script>
function addToCart(id) {
    @if(!auth()->check())
        window.location.href = "{{ route('login') }}";
        return;
    @endif

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id_produit: id,
            quantite: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message);
            // On pourrait mettre à jour le badge du panier ici
        } else {
            alert("Erreur lors de l'ajout.");
        }
    });
}
</script>
@endsection
