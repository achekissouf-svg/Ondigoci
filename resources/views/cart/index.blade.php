@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold" style="color: #1e5a9e;">Mon Panier <i class="fas fa-shopping-cart ms-2"></i></h1>
            <p class="text-muted">Gérez les articles de votre panier avant de finaliser votre commande.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @if(count($paniers) > 0)
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($paniers as $item)
                            <li class="list-group-item p-4 transition-all" style="transition: background 0.3s;">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4 text-center">
                                        @if($item->produit && $item->produit->image_principale_produit)
                                            <img src="{{ asset('images/' . $item->produit->image_principale_produit) }}" alt="{{ $item->produit->nom_produit }}" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px; width: 100%;">
                                                <i class="fas fa-box text-muted fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-5 col-8 mb-2 mb-md-0">
                                        <h5 class="fw-bold mb-1" style="color: #333;">{{ $item->produit->nom_produit ?? 'Produit Introuvable' }}</h5>
                                        @if($item->produit && $item->produit->prixAvecReduction() < $item->produit->prix_unitaire_produit)
                                            <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                                <del>{{ number_format($item->produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</del><br>
                                                <span class="text-success fw-bold">{{ number_format($item->produit->prixAvecReduction(), 0, ',', ' ') }} FCFA</span>
                                            </p>
                                        @else
                                            <p class="mb-0 text-muted fw-bold">{{ number_format($item->produit->prix_unitaire_produit ?? 0, 0, ',', ' ') }} FCFA</p>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-6 text-center">
                                        <div class="d-inline-flex align-items-center bg-light border rounded px-3 py-1">
                                            <form action="{{ route('cart.update', $item->id_panier) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 me-2" title="Retirer une unité">
                                                    <i class="fas fa-minus-circle text-muted"></i>
                                                </button>
                                            </form>
                                            
                                            <span class="fw-bold fs-5">{{ $item->quantite }}</span>
                                            
                                            <form action="{{ route('cart.update', $item->id_panier) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 ms-2" title="Ajouter une unité">
                                                    <i class="fas fa-plus-circle text-muted"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6 text-end">
                                        <form action="{{ route('cart.destroy', $item->id_panier) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm border-0 shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center" title="Tout retirer" style="width: 40px; height: 40px;" onclick="return confirm('Retirer cet article du panier ?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="border-radius: 12px; top: 120px;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold border-bottom pb-3 mb-4">Résumé de la commande</h4>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Sous-total ({{ $paniers->sum('quantite') }} articles)</span>
                            <span class="fw-bold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Frais de livraison</span>
                            <span class="text-success fw-bold">Calculés à l'étape suivante</span>
                        </div>
                        
                        <div class="border-top pt-3 d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Total</h5>
                            <h4 class="fw-bold text-primary mb-0" style="color: #ff6b35 !important;">{{ number_format($total, 0, ',', ' ') }} FCFA</h4>
                        </div>
                        
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="adresse_livraison" class="form-label fw-bold text-muted small text-uppercase">Adresse de livraison à domicile</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                    <input type="text" name="adresse_livraison" id="adresse_livraison" class="form-control border-start-0 ps-0" placeholder="Ex: Douala, Akwa face immeuble X" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="telephone_commande" class="form-label fw-bold text-muted small text-uppercase">Numéro de contact pour livraison</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" name="telephone_commande" id="telephone_commande" class="form-control border-start-0 ps-0" value="{{ auth()->user()->telephone }}" placeholder="Numéro joignable pour la livraison" required>
                                </div>
                                <small class="text-muted">Par défaut, nous utiliserons le numéro de votre compte.</small>
                            </div>

                            <hr class="my-4">
                            <h5 class="fw-bold mb-3">Moyen de paiement</h5>
                            <div class="mb-4">
                                @foreach($modesPaiement as $mode)
                                    <div class="form-check custom-radio border rounded p-3 mb-2 d-flex align-items-center" style="cursor: pointer; transition: background 0.2s;" onclick="document.getElementById('mode_{{ $mode->id_mode_paiement }}').checked = true;">
                                        <input class="form-check-input mt-0 me-3" type="radio" name="id_mode_paiement" id="mode_{{ $mode->id_mode_paiement }}" value="{{ $mode->id_mode_paiement }}" required {{ $loop->first ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold flex-grow-1 mb-0" for="mode_{{ $mode->id_mode_paiement }}" style="cursor: pointer;">
                                            {{ $mode->libel_mode_paiement }}
                                        </label>
                                        @if($mode->id_mode_paiement === 'MP_MOBILE')
                                            <i class="fas fa-mobile-alt text-warning fs-4"></i>
                                        @elseif($mode->id_mode_paiement === 'MP_LIVRAISON')
                                            <i class="fas fa-truck text-info fs-4"></i>
                                        @elseif($mode->id_mode_paiement === 'MP_PLACE')
                                            <i class="fas fa-store text-success fs-4"></i>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-lg w-100 py-3 fw-bold shadow-sm mb-3 text-white" style="background: #ff6b35; border-radius: 8px; transition: background 0.3s;" onmouseover="this.style.background='#e55a28'" onmouseout="this.style.background='#ff6b35'">
                                VALIDER MA COMMANDE <i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </form>
                        
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 py-2 fw-medium" style="border-radius: 8px;">
                            <i class="fas fa-arrow-left me-2"></i> Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 150px; height: 150px;">
                        <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-3">Votre panier est vide !</h3>
                <p class="text-muted mb-4">Explorez nos catégories et découvrez nos meilleures offres.</p>
                <a href="{{ route('shop') }}" class="btn px-4 py-3 fw-bold text-white shadow-sm" style="background: #1e5a9e; border-radius: 8px;">
                    DÉMARRER MES ACHATS
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
