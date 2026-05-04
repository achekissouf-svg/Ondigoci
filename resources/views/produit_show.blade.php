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

                <div class="card border-0 bg-white shadow-sm rounded-4 mb-4">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @if($produit->boutique->logo)
                                    <img src="{{ asset('images/' . $produit->boutique->logo) }}" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; font-weight: bold;">
                                        {{ substr($produit->boutique->nom_boutique, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">{{ $produit->boutique->nom_boutique }}</h6>
                                <div class="text-warning small">
                                    @php $noteBoutique = $produit->boutique->avis->avg('note') ?: 5; @endphp
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= round($noteBoutique) ? '' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-1">({{ count($produit->boutique->avis) }} avis)</span>
                                </div>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('magasin.show', $produit->boutique->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Voir Boutique</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3 d-md-flex">
                    @if($produit->stock_disponible_produit > 0)
                        <button onclick="addToCart('{{ $produit->id_produit }}')" class="btn btn-primary btn-lg px-5 py-3 fw-bold rounded-3 shadow-sm flex-grow-1">
                            <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                        </button>
                    @endif
                    
                    @if($produit->boutique->user_id !== auth()->id())
                        @if($produit->boutique->whatsapp)
                            <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $produit->boutique->whatsapp) }}&text=Bonjour {{ $produit->boutique->nom_boutique }}, je suis intéressé par votre produit : {{ $produit->nom_produit }}" 
                               class="btn btn-outline-success btn-lg px-4 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fab fa-whatsapp me-2"></i> Contacter
                            </a>
                        @elseif($produit->boutique->user->telephone)
                            <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $produit->boutique->user->telephone) }}&text=Bonjour {{ $produit->boutique->nom_boutique }}, je suis intéressé par votre produit : {{ $produit->nom_produit }}" 
                               class="btn btn-outline-success btn-lg px-4 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fab fa-whatsapp me-2"></i> Contacter
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5 pt-5 border-top">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">Avis sur ce produit <span class="badge bg-light text-muted ms-2">{{ $produit->avis->count() }}</span></h3>
            
            @if($produit->avis->count() > 0)
                <div class="reviews-container">
                    @foreach($produit->avis as $avis)
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">{{ $avis->user->name }}</h6>
                                    <span class="text-muted small">{{ $avis->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-0 text-secondary">{{ $avis->commentaire }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light text-center py-4 rounded-4">
                    Aucun avis pour le moment. Soyez le premier à partager votre expérience !
                </div>
            @endif
        </div>
    </div>

    <!-- Rating Forms Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-edit text-primary me-2"></i> Partagez votre expérience</h5>
                </div>
                <div class="card-body p-4 bg-light bg-opacity-50">
                    <div class="row g-4">
                        <!-- Product Rating -->
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold mb-3">Évaluer le produit</h6>
                            @auth
                                @if($produit->boutique->user_id !== auth()->id())
                                    @php
                                        $hasBought = \App\Models\LigneCommande::whereHas('commande', function($q) {
                                                $q->where('user_id', auth()->id())
                                                  ->where('statut_commande', 'livree');
                                            })
                                            ->where('id_produit', $produit->id_produit)
                                            ->exists();
                                    @endphp
                                    @if($hasBought)
                                        <form action="{{ route('produit.avis.store', $produit->id_produit) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <select name="note" class="form-select border-0 shadow-sm" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                                                    <option value="4">⭐⭐⭐⭐ (4/5) - Très bon</option>
                                                    <option value="3">⭐⭐⭐ (3/5) - Moyen</option>
                                                    <option value="2">⭐⭐ (2/5) - Décevant</option>
                                                    <option value="1">⭐ (1/5) - Mauvais</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <textarea name="commentaire" rows="3" class="form-control border-0 shadow-sm" placeholder="Qu'avez-vous pensé de cet article ?"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 8px;">Envoyer mon avis sur le produit</button>
                                        </form>
                                    @else
                                        <div class="alert alert-light border-0 shadow-sm p-3 small">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            Vous devez avoir acheté et reçu ce produit pour le noter.
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info border-0 small">Vous êtes le vendeur de ce produit.</div>
                                @endif
                            @else
                                <div class="alert alert-warning border-0 small">Connectez-vous pour laisser une note.</div>
                            @endauth
                        </div>

                        <!-- Boutique Rating -->
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Évaluer la boutique ({{ $produit->boutique->nom_boutique }})</h6>
                            @auth
                                @if($produit->boutique->user_id !== auth()->id())
                                    @php
                                        $hasPurchasedBoutique = \App\Models\Commande::where('user_id', auth()->id())
                                            ->where('boutique_id', $produit->boutique->id)
                                            ->where('statut_commande', 'livree')
                                            ->exists();
                                    @endphp
                                    @if($hasPurchasedBoutique)
                                        <form action="{{ route('magasin.avis.store', $produit->boutique->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <select name="note" class="form-select border-0 shadow-sm" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                                                    <option value="4">⭐⭐⭐⭐ (4/5) - Très bon</option>
                                                    <option value="3">⭐⭐⭐ (3/5) - Moyen</option>
                                                    <option value="2">⭐⭐ (2/5) - Décevant</option>
                                                    <option value="1">⭐ (1/5) - Mauvais</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <textarea name="commentaire" rows="3" class="form-control border-0 shadow-sm" placeholder="Service, livraison, accueil de la boutique..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold" style="border-radius: 8px;">Évaluer la boutique</button>
                                        </form>
                                    @else
                                        <div class="alert alert-light border-0 shadow-sm p-3 small">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            Vous devez avoir reçu une commande de cette boutique pour la noter.
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info border-0 small">C'est votre propre boutique.</div>
                                @endif
                            @else
                                <div class="alert alert-warning border-0 small">Connectez-vous pour laisser une note.</div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Suggestions -->
    @if(count($suggestions) > 0)
    <div class="mt-5 pt-5 border-top">
        <h3 class="fw-bold mb-4">Vous pourriez aussi aimer</h3>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
            @foreach($suggestions as $suggest)
            <div class="col">
                <x-product-card :product="$suggest" />
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

@endsection
