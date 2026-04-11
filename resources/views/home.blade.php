@extends('layouts.app')

@section('title', 'Votre Shopping Livré en un Clic')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background: linear-gradient(135deg, #1e5a9e, #2d6db5); padding: 60px 0; color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <h1 style="font-size: 3rem; font-weight: 700; line-height: 1.2; margin-bottom: 20px;">
                    VOTRE SHOPPING.<br>LIVRÉ EN UN CLIC.
                </h1>
                <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.95;">
                    Explorez des milliers de produits et faites-vous livrer rapidement !
                </p>
                <a href="{{ route('shop') }}" class="btn btn-lg px-5 py-3 fw-bold" 
                   style="background: #ff6b35; color: white; border: none; border-radius: 8px; font-size: 1rem; text-decoration: none; display: inline-block; transition: all 0.3s; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);"
                   onmouseover="this.style.background='#e55a28'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(255, 107, 53, 0.4)'"
                   onmouseout="this.style.background='#ff6b35'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(255, 107, 53, 0.3)'">
                    ACCÉDER AU MARKETPLACE
                </a>
            </div>
            
            <div class="col-lg-6 col-md-12">
                <div class="row g-3 align-items-center justify-content-center">
                    <div class="col-4">
                        <div class="bg-white p-3 rounded-3 shadow" style="animation: float 3s ease-in-out infinite;">
                            <img src="{{ asset('images/pc_ondigo.png') }}" alt="PC" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white p-3 rounded-3 shadow" style="animation: float 3s ease-in-out infinite 0.5s;">
                            <img src="{{ asset('images/montre_intelligente.png') }}" alt="Smartwatch" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white p-3 rounded-3 shadow" style="animation: float 3s ease-in-out infinite 1s;">
                            <img src="{{ asset('images/panier_ondigo.png') }}" alt="Panier" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <img src="{{ asset('images/livreur_ondigo.png') }}" alt="Livreur" class="img-fluid" style="max-height: 200px; animation: slide 2s ease-in-out infinite;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes slide {
    0%, 100% { transform: translateX(0px); }
    50% { transform: translateX(10px); }
}
</style>

<!-- Featured Products Section -->
<div class="container py-5">
    <h2 class="mb-4 fw-bold" style="font-size: 2rem; color: #1e5a9e;">Featured Products</h2>
    
    @if(isset($featuredProducts) && count($featuredProducts) > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/' . $product->image_principale_produit) }}" 
                             alt="{{ $product->nom_produit }}"
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            {{ $product->nom_produit }}
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            {{ number_format($product->prix_unitaire_produit, 0, ',', ' ') }} FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'"
                                onclick="addToCart('{{ $product->id_produit }}')">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Produits par défaut si la base de données est vide -->
        <div class="row g-4">
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/pc_ondigo.png') }}" alt="Smartphone" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Smartphone Pro Max
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            350 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/produits.png') }}" alt="Chaussures" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Chaussures de Course
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            330 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/panier_ondigo.png') }}" alt="Panier" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Panier Alimentaire
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            350 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/montre_intelligente.png') }}" alt="Smartwatch" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Smartwatch Pro Max
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            350 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/pc_ondigo.png') }}" alt="Smartphone" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Smartphone Pro Max
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            350 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card h-100 shadow-sm" style="border: none; border-radius: 12px; overflow: hidden; cursor: pointer;">
                    <div class="card-img-top" style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        <img src="{{ asset('images/carton_ondigo.png') }}" alt="Smartphone" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title fw-semibold mb-2" style="font-size: 0.95rem; min-height: 45px; color: #333;">
                            Smartphone Pro Max
                        </h6>
                        <p class="card-text fw-bold mb-3" style="font-size: 1.1rem; color: #1e5a9e;">
                            350 000 FCFA
                        </p>
                        <button class="btn btn-primary w-100 fw-semibold" 
                                style="background: #1e5a9e; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; transition: background 0.3s;"
                                onmouseover="this.style.background='#ff6b35'"
                                onmouseout="this.style.background='#1e5a9e'">
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>
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
<script>
function addToCart(productId) {
    // Vérifier si connecté
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    
    if (!isAuthenticated) {
        alert('Veuillez vous connecter pour ajouter des produits au panier');
        window.location.href = '{{ route("login") }}';
        return;
    }

    // Utilisateur connecté - envoyer la requête
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
            // Changer le bouton temporairement
            event.target.textContent = 'Ajouté ✓';
            event.target.style.background = '#4CAF50';
            setTimeout(() => {
                event.target.textContent = 'Ajouter au Panier';
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
@endsection