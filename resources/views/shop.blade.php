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
            <div class="row g-4">
                @foreach($produits as $produit)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100" style="border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: all 0.3s;">
                                <!-- Product Image -->
                                <div style="background: #f5f5f5; height: 250px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                                    @if($produit->image_principale_produit)
                                        <img src="{{ asset('images/' . $produit->image_principale_produit) }}" alt="{{ $produit->nom_produit }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-image" style="font-size: 60px; color: #ddd;"></i>
                                    @endif
                                    
                                    <!-- Badge -->
                                    @if($produit->promotion && $produit->promotion->date_debut_promo <= now() && $produit->promotion->date_fin_promo >= now())
                                        <span style="position: absolute; top: 10px; right: 10px; background: #ff6b35; color: white; padding: 5px 10px; border-radius: 5px; font-weight: 600; font-size: 12px;">
                                            -{{ $produit->promotion->pourcentage_reduction }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="card-body" style="padding: 15px;">
                                    <!-- Category -->
                                    <small style="color: #ff6b35; font-weight: 600;">
                                        <i class="fas fa-tag"></i> {{ $produit->categorie->libel_categorie ?? 'Sans catégorie' }}
                                    </small>

                                    <!-- Product Name -->
                                    <h5 class="card-title mt-2 mb-2" style="color: #1e5a9e; font-size: 16px; font-weight: 600;">
                                        {{ Str::limit($produit->nom_produit, 50) }}
                                    </h5>

                                    <!-- Description -->
                                    <p class="card-text text-muted" style="font-size: 13px; margin-bottom: 10px;">
                                        {{ Str::limit($produit->description_produit, 80) }}
                                    </p>

                                    <!-- Rating -->
                                    <div class="mb-2">
                                        <small style="color: #ff6b35;">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            ({{ rand(10, 200) }} avis)
                                        </small>
                                    </div>

                                    <!-- Price -->
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            @if($produit->promotion && $produit->promotion->date_debut_promo <= now() && $produit->promotion->date_fin_promo >= now())
                                                <span style="font-size: 18px; font-weight: 700; color: #ff6b35;">
                                                    {{ number_format($produit->prix_unitaire_produit * (1 - $produit->promotion->pourcentage_reduction / 100), 0, '.', ' ') }} F
                                                </span>
                                                <span style="font-size: 13px; color: #999; text-decoration: line-through; margin-left: 5px;">
                                                    {{ number_format($produit->prix_unitaire_produit, 0, '.', ' ') }} F
                                                </span>
                                            @else
                                                <span style="font-size: 18px; font-weight: 700; color: #1e5a9e;">
                                                    {{ number_format($produit->prix_unitaire_produit, 0, '.', ' ') }} F
                                                </span>
                                            @endif
                                        </div>
                                        <span style="font-size: 12px; color: #999;">
                                            <i class="fas fa-box"></i> {{ $produit->stock_disponible_produit }}
                                        </span>
                                    </div>

                                    <!-- Store -->
                                    <small style="color: #666;">
                                        <i class="fas fa-store" style="color: #ff6b35;"></i> {{ $produit->boutique->nom_boutique ?? 'Ondigoci Store' }}
                                    </small>

                                    <!-- Actions -->
                                    <div class="mt-3 d-flex gap-2">
                                        <button type="button" class="btn btn-sm w-100" 
                                                onclick="addToCart('{{ $produit->id_produit }}')"
                                                style="background: linear-gradient(135deg, #ff6b35, #ff8c42); color: white; border: none; font-weight: 600;">
                                            <i class="fas fa-shopping-cart"></i> Ajouter
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" style="color: #1e5a9e; border-color: #1e5a9e;">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
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

<script>
    function addToCart(productId) {
        // Vérifier si l'utilisateur est connecté
        @if(!auth()->check())
            alert('Veuillez vous connecter pour ajouter des produits au panier');
            window.location.href = '{{ route("login") }}';
            return;
        @endif

        // CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Faire la requête AJAX
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_produit: productId,
                quantite: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour le badge du panier
                const cartBadge = document.getElementById('cart-badge');
                if (cartBadge) {
                    cartBadge.textContent = data.cartCount;
                }
                
                // Afficher une notification
                showNotification('Produit ajouté au panier avec succès!', 'success');
            } else {
                showNotification(data.message || 'Erreur lors de l\'ajout au panier', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'ajout au panier', 'error');
        });
    }

    function showNotification(message, type) {
        // Créer une notification temporaire
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        notification.setAttribute('role', 'alert');
        notification.id = 'temp-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Supprimer après 3 secondes
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
@endsection
