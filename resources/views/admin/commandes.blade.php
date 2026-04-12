@extends('layouts.app')

@section('title', 'Mes Commandes Reçues')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="fw-bold" style="color: #1e5a9e;">Commandes reçues <i class="fas fa-receipt ms-2"></i></h1>
            <p class="text-muted">
                @if($boutique)
                    Produits de <strong>{{ $boutique->nom_boutique }}</strong> — commandes passées par vos clients.
                @else
                    Vue globale de toutes les commandes (Administrateur).
                @endif
            </p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Tableau de bord
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($lignes->count() > 0)
        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #1e5a9e, #2d6db5); color: white;">
                            <tr>
                                <th class="py-3 px-4">Produit</th>
                                <th class="py-3 px-4">Client</th>
                                <th class="py-3 px-4 text-center">Quantité</th>
                                <th class="py-3 px-4 text-end">Prix unitaire</th>
                                <th class="py-3 px-4 text-end">Sous-total</th>
                                <th class="py-3 px-4 text-center">Statut commande</th>
                                <th class="py-3 px-4 text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lignes as $ligne)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($ligne->produit && $ligne->produit->image_principale_produit)
                                            <img src="{{ asset('images/' . $ligne->produit->image_principale_produit) }}"
                                                 alt="{{ $ligne->produit->nom_produit }}"
                                                 style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #f5f5f5; padding: 4px;">
                                        @endif
                                        <span class="fw-semibold">{{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}</span>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $ligne->commande->user->name ?? '—' }}</p>
                                        <small class="text-muted"><i class="fas fa-envelope me-1"></i> {{ $ligne->commande->user->email ?? '' }}</small><br>
                                        <small class="fw-bold text-success"><i class="fas fa-phone me-1"></i> {{ $ligne->commande->telephone_commande ?? ($ligne->commande->user->telephone ?? 'N/A') }}</small>
                                    </div>
                                </td>
                                <td class="px-4 text-center">
                                    <span class="badge bg-primary rounded-pill fs-6" style="background: #1e5a9e !important;">
                                        {{ $ligne->quantite_ligne_commande }}
                                    </span>
                                </td>
                                <td class="px-4 text-end fw-bold text-primary" style="color: #1e5a9e !important;">
                                    {{ number_format($ligne->prix_au_moment_achat, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-4 text-end fw-bold" style="color: #ff6b35;">
                                    {{ number_format($ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-4 text-center">
                                    <div class="dropdown">
                                        @php $statut = $ligne->commande->statut_commande ?? 'en_attente'; @endphp
                                        <button class="btn btn-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown" 
                                                style="border-radius: 20px; @if($statut === 'livre') background: #d1e7dd; color: #0f5132; @elseif($statut === 'en_cours') background: #cff4fc; color: #055160; @elseif($statut === 'annule') background: #f8d7da; color: #842029; @else background: #fff3cd; color: #664d03; @endif">
                                            @if($statut === 'livre') Livré @elseif($statut === 'en_cours') En cours @elseif($statut === 'annule') Annulé @else En attente @endif
                                        </button>
                                        <ul class="dropdown-menu shadow border-0">
                                            <li>
                                                <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="statut_commande" value="en_cours">
                                                    <button type="submit" class="dropdown-item text-info"><i class="fas fa-play-circle me-2"></i> Valider (En cours)</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="statut_commande" value="livre">
                                                    <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-double me-2"></i> Terminer (Livré)</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="statut_commande" value="annule">
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-times-circle me-2"></i> Rejeter (Annulé)</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="px-4 text-center text-muted small">
                                    {{ $ligne->commande->date_commande ? \Carbon\Carbon::parse($ligne->commande->date_commande)->format('d/m/Y') : '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Total Summary -->
        <div class="row justify-content-end mt-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-end">
                        <p class="text-muted mb-1">Total des ventes</p>
                        <h3 class="fw-bold" style="color: #ff6b35;">
                            {{ number_format($lignes->sum(fn($l) => $l->prix_au_moment_achat * $l->quantite_ligne_commande), 0, ',', ' ') }} FCFA
                        </h3>
                        <small class="text-muted">{{ $lignes->count() }} ligne(s) de commande</small>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 130px; height: 130px;">
                <i class="fas fa-inbox text-muted" style="font-size: 3.5rem; opacity: 0.4;"></i>
            </div>
            <h4 class="fw-bold">Aucune commande reçue pour le moment</h4>
            <p class="text-muted">Lorsque des clients commanderont vos produits, elles apparaîtront ici.</p>
        </div>
    @endif
</div>
@endsection
