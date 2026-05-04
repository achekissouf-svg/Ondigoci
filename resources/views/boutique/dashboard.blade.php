@extends('layouts.app')

@section('title', 'Tableau de bord Boutique')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="font-bold text-3xl text-gray-800">Tableau de bord Boutique</h1>
            <p class="text-gray-600">Bienvenue dans votre espace vendeur, {{ Auth::user()->name }}.</p>
        </div>
        @if($boutique)
            <div class="col-md-4 text-md-end">
                <a href="{{ route('magasin.show', $boutique->id) }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-eye me-2"></i> Voir ma boutique
                </a>
            </div>
        @endif
    </div>

    @if(!$boutique)
        <div class="alert alert-warning border-0 shadow-sm">
            Vous n'avez pas encore de boutique configurée ou approuvée.
        </div>
    @else
        <!-- KPIs Section -->
        <div class="row mb-5 g-4">
            <!-- Chiffre d'affaires -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #28a745 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Ventes Totales (Livrées)</p>
                                <h3 class="fw-bold text-success mb-0">{{ number_format($chiffreAffaires, 0, ',', ' ') }} <small class="fs-6">FCFA</small></h3>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-coins text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #1e5a9e !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Commandes Totales</p>
                                <h3 class="fw-bold mb-0" style="color: #1e5a9e;">{{ $totalCommandes }}</h3>
                                <small class="text-warning fw-semibold"><i class="fas fa-clock"></i> {{ $commandesEnAttente }} en attente</small>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-shopping-bag text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produits -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Produits Actifs</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $totalProduits }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-box text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note Globale -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-left: 5px solid #17a2b8 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Statistiques / Avis</p>
                                <h3 class="fw-bold text-info mb-0">
                                    {{ $boutique->note_moyenne }} <small class="fs-6 text-muted">/ 5</small>
                                </h3>
                                <small class="text-muted">{{ $boutique->avis->count() }} avis clients</small>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-star text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Raccourcis Rapides -->
        <h4 class="fw-bold mb-3">Accès Rapides</h4>
        <div class="row mb-5 g-3">
            <div class="col-md-3">
                <a href="{{ route('boutique.produits.index') }}" class="btn btn-outline-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="border-radius: 12px; background: white;">
                    <i class="fas fa-box"></i> Gérer mes produits
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('boutique.commandes.index') }}" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="border-radius: 12px; background: white; border-color: #9b59b6; color: #9b59b6;">
                    <i class="fas fa-receipt"></i> Voir toutes mes commandes
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('boutique.promotions.index') }}" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="border-radius: 12px; background: white; border-color: #e74c3c; color: #e74c3c;">
                    <i class="fas fa-tags"></i> Mes Promotions
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('boutique.avis.index') }}" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="border-radius: 12px; background: white; border-color: #f1c40f; color: #f39c12;">
                    <i class="fas fa-star"></i> Avis Clients
                </a>
            </div>
        </div>

        <!-- Commandes Récentes -->
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">Commandes Récentes</h4>
                <a href="{{ route('boutique.commandes.index') }}" class="btn btn-sm btn-link text-decoration-none">Voir tout</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Client</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentesCommandes as $ligne)
                                <tr>
                                    <td>
                                        <p class="mb-0 fw-semibold">{{ $ligne->commande->user->name ?? '—' }}</p>
                                        <small class="text-muted">{{ $ligne->commande->telephone_commande ?? '' }}</small>
                                    </td>
                                    <td>{{ $ligne->produit->nom_produit ?? '—' }}</td>
                                    <td class="text-center">{{ $ligne->quantite_ligne_commande }}</td>
                                    <td class="fw-bold">{{ number_format($ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-muted small">{{ $ligne->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @php $statut = $ligne->commande->statut_commande ?? 'en_attente'; @endphp
                                        @if($statut === 'livree')
                                            <span class="badge bg-success">Livrée</span>
                                        @elseif($statut === 'en_livraison')
                                            <span class="badge bg-info">En livraison</span>
                                        @elseif($statut === 'en_preparation')
                                            <span class="badge bg-primary">En préparation</span>
                                        @elseif(in_array($statut, ['annulee', 'rejetee']))
                                            <span class="badge bg-danger">Annulée</span>
                                        @else
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Aucune commande récente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
