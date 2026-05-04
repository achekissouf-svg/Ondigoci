@extends('layouts.app')

@section('title', $boutique->nom_boutique . ' - Ondigoci')

@push('styles')
<style>
    .store-header {
        position: relative;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 20px;
        overflow: hidden;
        color: white;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .store-cover {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        opacity: 0.1;
        background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
    }

    .store-logo-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: white;
        padding: 5px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 2rem;
        overflow: hidden;
        flex-shrink: 0;
    }

    .store-logo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .store-logo-wrapper .fa-store {
        font-size: 3rem;
        color: #2a5298;
    }

    .store-info {
        position: relative;
        z-index: 1;
        padding: 3rem;
        display: flex;
        align-items: center;
    }

    .whatsapp-btn {
        background: #25D366;
        color: white;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    }

    .whatsapp-btn:hover {
        background: #1ebe57;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
    }

    .product-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .product-img-wrapper {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: contain;
        padding: 1rem;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-price {
        color: #1e3c72;
        font-size: 1.25rem;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .store-info {
            flex-direction: column;
            text-align: center;
            padding: 2rem;
        }
        .store-logo-wrapper {
            margin-right: 0;
            margin-bottom: 1.5rem;
        }
        .whatsapp-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Store Header -->
    <div class="store-header">
        <div class="store-cover"></div>
        <div class="store-info">
            <div class="store-logo-wrapper">
                @if($boutique->logo)
                    <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom_boutique }}">
                @else
                    <i class="fas fa-store"></i>
                @endif
            </div>
            
            <div class="flex-grow-1">
                <h1 class="fw-bold mb-2">
                    {{ $boutique->nom_boutique }}
                    @if($boutique->est_verifie)
                        <i class="fas fa-check-circle text-info ms-2" title="Magasin vérifié" style="font-size: 1.5rem; text-shadow: 0 0 10px rgba(0, 123, 255, 0.5);"></i>
                    @endif
                </h1>
                
                <div class="mb-2 d-flex align-items-center">
                    <div class="text-warning me-2">
                        @php $note = $boutique->note_moyenne; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $note)
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $note)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-white-50 fw-bold">{{ $note }} / 5</span>
                    <span class="text-white-50 ms-2">({{ $boutique->avis->count() }} avis)</span>
                </div>

                <p class="mb-2 text-white-50">
                    <i class="fas fa-map-marker-alt me-2"></i> {{ $boutique->adresse_siege }}
                </p>
                <p class="mb-3 lead" style="font-size: 1rem; max-width: 600px;">
                    {{ $boutique->description }}
                </p>
            </div>
            
            <div class="ms-md-4 mt-4 mt-md-0">
                @if($boutique->user_id !== auth()->id())
                    @if($boutique->whatsapp)
                        <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $boutique->whatsapp) }}&text=Bonjour {{ $boutique->nom_boutique }}, j'aimerais discuter avec vous." class="whatsapp-btn">
                            <i class="fab fa-whatsapp fs-5"></i>
                            Contacter sur WhatsApp
                        </a>
                    @elseif($boutique->user->telephone)
                        <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $boutique->user->telephone) }}&text=Bonjour {{ $boutique->nom_boutique }}, j'aimerais discuter avec vous." class="whatsapp-btn">
                            <i class="fab fa-whatsapp fs-5"></i>
                            Contacter sur WhatsApp
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Store Products -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold fs-3 mb-0">Produits de ce magasin</h2>
        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $produits->total() }} produit(s)</span>
    </div>

    <div class="row g-4 mb-5">
        @forelse($produits as $produit)
            <div class="col-6 col-md-4 col-lg-3">
                <x-product-card :product="$produit" />
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-box-open fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted">Aucun produit disponible pour le moment.</h4>
                <p>Ce magasin n'a pas encore ajouté de produits ou ils sont en rupture de stock.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4 mb-5">
        {{ $produits->links('pagination::bootstrap-5') }}
    </div>

    <!-- Section Avis Clients -->
    <hr class="my-5">
    
    <div class="row">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">Avis Clients ({{ $boutique->avis->count() }})</h3>
            
            @if($boutique->avis->count() > 0)
                <div class="d-flex flex-column gap-4">
                    @foreach($boutique->avis as $avis)
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0">{{ $avis->user->name }}</h6>
                                    <span class="text-muted small">{{ $avis->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-warning mb-3" style="font-size: 0.9rem;">
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
                <div class="alert alert-light text-center py-4">
                    Aucun avis pour le moment. Soyez le premier à donner votre avis !
                </div>
            @endif
        </div>
        
        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="card border-0 shadow" style="border-radius: 16px; background: #f8f9fa;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Laisser un avis</h5>
                    @auth
                        @if($boutique->user_id !== auth()->id())
                            @php
                                $hasPurchased = \App\Models\Commande::where('user_id', auth()->id())
                                    ->where('boutique_id', $boutique->id)
                                    ->where('statut_commande', 'livree')
                                    ->exists();
                            @endphp

                            @if($hasPurchased)
                                <form action="{{ route('magasin.avis.store', $boutique->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Votre Note</label>
                                        <select name="note" class="form-select border-0 shadow-sm" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5) - Très bon</option>
                                            <option value="3">⭐⭐⭐ (3/5) - Moyen</option>
                                            <option value="2">⭐⭐ (2/5) - Décevant</option>
                                            <option value="1">⭐ (1/5) - Mauvais</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Commentaire</label>
                                        <textarea name="commentaire" rows="4" class="form-control border-0 shadow-sm" placeholder="Partagez votre expérience..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 8px;">Envoyer mon avis</button>
                                </form>
                            @else
                                <div class="alert alert-light border-0 shadow-sm p-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Seuls les clients ayant déjà reçu une commande de cette boutique peuvent laisser un avis.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info border-0">Vous ne pouvez pas noter votre propre boutique.</div>
                        @endif
                    @else
                        <div class="alert alert-warning border-0">
                            Veuillez <a href="{{ route('login') }}" class="alert-link">vous connecter</a> pour laisser un avis.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
