@extends('layouts.app')

@section('title', 'Avis Clients')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold" style="color: #1e5a9e;">Avis Clients <i class="fas fa-star ms-2 text-warning"></i></h1>
            <p class="text-muted">Retrouvez ici tous les retours de vos clients sur votre boutique et vos produits.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="card shadow-sm border-0 d-inline-block p-3 bg-white" style="border-radius: 12px;">
                <h4 class="fw-bold mb-0 text-warning">{{ $boutique->note_moyenne }} <small class="text-muted fs-6">/ 5</small></h4>
                <small class="text-muted">Note globale boutique</small>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-pills mb-4 gap-2" id="avisTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold rounded-pill px-4 shadow-sm" id="boutique-tab" data-bs-toggle="pill" data-bs-target="#boutique-avis" type="button" role="tab">
                Avis sur la Boutique ({{ $avisBoutique->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold rounded-pill px-4 shadow-sm" id="produits-tab" data-bs-toggle="pill" data-bs-target="#produits-avis" type="button" role="tab">
                Avis sur vos Produits ({{ $avisProduits->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="avisTabsContent">
        <!-- Boutique Avis -->
        <div class="tab-pane fade show active" id="boutique-avis" role="tabpanel">
            <div class="row g-3">
                @forelse($avisBoutique as $avis)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0">{{ $avis->user->name }}</h6>
                                    <span class="text-muted small">{{ $avis->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="text-warning mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-secondary mb-0">"{{ $avis->commentaire }}"</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center py-5 border-0 shadow-sm rounded-4">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Aucun avis sur votre boutique pour le moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Produits Avis -->
        <div class="tab-pane fade" id="produits-avis" role="tabpanel">
            <div class="row g-3">
                @forelse($avisProduits as $avis)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded p-2 me-3" style="width: 50px; height: 50px;">
                                        <img src="{{ asset('images/' . $avis->produit->image_principale_produit) }}" alt="" class="img-fluid object-fit-contain">
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $avis->produit->nom_produit }}</h6>
                                        <small class="text-muted">Par {{ $avis->user->name }}</small>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <span class="text-muted small d-block">{{ $avis->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-secondary mb-0 italic">"{{ $avis->commentaire }}"</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center py-5 border-0 shadow-sm rounded-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Aucun avis sur vos produits pour le moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: #6c757d;
        background: white;
    }
    .nav-pills .nav-link.active {
        background: #1e5a9e;
        color: white;
    }
</style>
@endsection
