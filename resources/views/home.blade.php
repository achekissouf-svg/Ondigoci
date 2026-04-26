@extends('layouts.app')

@section('title', 'Votre Shopping Livré en un Clic')

@section('content')
@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold" style="color: #1e5a9e;">Bienvenue sur Ondigoci</h1>
            <p class="text-muted">Découvrez les derniers produits publiés par nos boutiques partenaires.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('shop') }}" class="btn fw-bold text-white px-4" style="background: #ff6b35; border-radius: 8px;">
                TOUT LE CATALOGUE <i class="fas fa-th ms-2"></i>
            </a>
        </div>
    </div>


<!-- Featured Products Section -->
<div class="container py-5">
    <h2 class="mb-4 fw-bold" style="font-size: 2rem; color: #1e5a9e;">Nos Produits en Vedette</h2>
    
    @if(isset($featuredProducts) && count($featuredProducts) > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <a href="{{ route('produit.show', $product->id_produit) }}" class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px; text-decoration: none;">
                        <img src="{{ asset('images/' . $product->image_principale_produit) }}" 
                             alt="{{ $product->nom_produit }}"
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </a>
                        <div class="card-body text-center">
                            <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                                <a href="{{ route('produit.show', $product->id_produit) }}" class="text-decoration-none text-dark">
                                    {{ $product->nom_produit }}
                                </a>
                            </h6>
                            <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                                {{ number_format($product->prix_unitaire_produit, 0, ',', ' ') }} FCFA
                            </p>
                            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'boutique'))
                                <a href="{{ auth()->user()->role === 'admin' ? route('admin.produits.index') : route('boutique.produits.index') }}"
                                   class="btn w-100 fw-semibold"
                                   style="background: #1e5a9e; color:white; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                   onmouseover="this.style.background='#ff6b35'" onmouseout="this.style.background='#1e5a9e'">
                                    <i class="fas fa-cog me-1"></i> Gérer mes produits
                                </a>
                            @else
                                <button class="btn btn-primary w-100 fw-semibold"
                                        style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                        onmouseover="this.style.background='#ff6b35'"
                                        onmouseout="this.style.background='#1e5a9e'"
                                        onclick="addToCart('{{ $product->id_produit }}')">
                                    Ajouter au Panier
                                </button>
                            @endif
                        </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 130px; height: 130px;">
                <i class="fas fa-store-slash text-muted" style="font-size: 3.5rem; opacity: 0.4;"></i>
            </div>
            <h4 class="fw-bold">Aucun produit disponible</h4>
            <p class="text-muted">Revenez plus tard pour découvrir les nouveautés de nos vendeurs.</p>
        </div>
    @endif
</div>

<!-- Section Avantages -->
<div class="bg-light py-5 mt-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="p-3">
                    <i class="fas fa-truck fa-3x mb-3" style="color: #1e5a9e;"></i>
                    <h5 class="fw-bold">Livraison Rapide</h5>
                    <p class="text-muted">Partout en Côte d'Ivoire</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="p-3">
                    <i class="fas fa-lock fa-3x mb-3" style="color: #1e5a9e;"></i>
                    <h5 class="fw-bold">Paiement Sécurisé</h5>
                    <p class="text-muted">Transactions 100% sécurisées</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="p-3">
                    <i class="fas fa-headset fa-3x mb-3" style="color: #1e5a9e;"></i>
                    <h5 class="fw-bold">Support 24/7</h5>
                    <p class="text-muted">Service client disponible</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="p-3">
                    <i class="fas fa-tag fa-3x mb-3" style="color: #1e5a9e;"></i>
                    <h5 class="fw-bold">Prix Compétitifs</h5>
                    <p class="text-muted">Meilleurs prix du marché</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('scripts')
<div id="cart-toast" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050; margin-top: 20px; display: none;">
    <div class="toast show align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 8px;">
        <div class="d-flex">
            <div class="toast-body fw-bold fs-6">
                <i class="fas fa-check-circle me-2"></i> Produit ajouté au panier avec succès !
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="document.getElementById('cart-toast').style.display='none'"></button>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    // Vérifier si connecté
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    
    if (!isAuthenticated) {
        alert('Veuillez vous connecter pour ajouter des produits au panier');
        window.location.href = '{{ route("login") }}';
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id_produit: productId,
            quantite: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the global cart badge if it exists
            const badge = document.getElementById('cart-badge');
            if (badge) {
                badge.textContent = data.cartCount;
                
                // Add a small bounce animation to the badge
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 500);
            }

            // Show Jumia-style Green Toast Notification
            const toastEl = document.getElementById('cart-toast');
            toastEl.style.display = 'block';
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                toastEl.style.display = 'none';
            }, 3000);

            // Changer le bouton temporairement
            event.target.innerHTML = '<i class="fas fa-check"></i> Ajouté';
            event.target.style.background = '#28a745';
            setTimeout(() => {
                event.target.innerHTML = 'Ajouter au Panier';
                event.target.style.background = '#1e5a9e';
            }, 2000);
        } else {
            alert('Erreur: ' + (data.message || 'Impossible d\'ajouter le produit'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'ajout au panier');
    });
}
</script>

<style>
@keyframes bounce-custom {
    0%, 100% { transform: translateY(0) translateX(-50%); }
    50% { transform: translateY(-5px) translateX(-50%); }
}
.animate-bounce {
    animation: bounce-custom 0.5s ease;
}
</style>
@endsection