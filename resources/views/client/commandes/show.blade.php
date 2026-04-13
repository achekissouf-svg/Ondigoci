@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <a href="{{ route('client.commandes') }}" class="text-decoration-none mb-3 d-inline-block">
                <i class="fas fa-arrow-left"></i> Retour aux commandes
            </a>
        </div>
    </div>

    @if($commande->statut_commande === 'livré')
        <!-- Message de remerciement pour livraison -->
        <div class="row mt-3 mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                    <div class="card-body text-center py-4">
                        <div style="font-size: 3rem; color: white; margin-bottom: 15px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h4 class="text-white mb-2">Merci pour votre achat!</h4>
                        <p class="text-white mb-0" style="opacity: 0.9;">
                            Votre commande a été livrée avec succès. Nous espérons que vous êtes satisfait!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($commande->statut_commande === 'rejeté' || $commande->statut_commande === 'annulé')
        <!-- Message pour commande rejetée/annulée -->
        <div class="row mt-3 mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); border-radius: 15px;">
                    <div class="card-body text-center py-4">
                        <div style="font-size: 3rem; color: white; margin-bottom: 15px;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h4 class="text-white mb-2">Commande {{ $commande->statut_commande }}</h4>
                        <p class="text-white mb-0" style="opacity: 0.9;">
                            Votre commande a été {{ $commande->statut_commande }}. Veuillez nous contacter pour plus d'informations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-md-8">
            <!-- Détails de la commande -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #1e5a9e 0%, #ff6b35 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Détails de la commande #{{ $commande->num_commande }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date de commande:</strong>
                            <p>{{ $commande->date_commande->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Mode de paiement:</strong>
                            <p>{{ $commande->modePaiement->libel_mode_paiement ?? 'Non spécifié' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Téléphone:</strong>
                            <p>{{ $commande->telephone_commande }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Statut:</strong>
                            <p>
                                @php
                                    $statusColor = match($commande->statut_commande) {
                                        'en_attente' => 'warning',
                                        'encours' => 'info',
                                        'livré' => 'success',
                                        'rejeté' => 'danger',
                                        'annulé' => 'dark',
                                        default => 'secondary'
                                    };
                                    $statusLabel = match($commande->statut_commande) {
                                        'en_attente' => 'En attente',
                                        'encours' => 'En cours',
                                        'livré' => 'Livré',
                                        'rejeté' => 'Rejeté',
                                        'annulé' => 'Annulé',
                                        default => ucfirst($commande->statut_commande)
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">{{ $statusLabel }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produits commandés -->
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #1e5a9e;">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Produits commandés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="border-bottom: 2px solid #1e5a9e;">
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lignees as $ligne)
                                    <tr>
                                        <td>
                                            <strong>{{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}</strong>
                                        </td>
                                        <td>{{ $ligne->quantite_ligne }}</td>
                                        <td>{{ number_format($ligne->prix_unitaire_ligne, 0, ',', ' ') }} FCFA</td>
                                        <td class="fw-bold">
                                            {{ number_format($ligne->quantite_ligne * $ligne->prix_unitaire_ligne, 0, ',', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucun produit trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Résumé -->
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #ff6b35;">
                    <h5 class="mb-0">Résumé</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total:</span>
                        <span>{{ number_format($commande->montant_total_commande, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Frais de livraison:</span>
                        <span>0 FCFA</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong style="color: #ff6b35; font-size: 1.2rem;">
                            {{ number_format($commande->montant_total_commande, 0, ',', ' ') }} FCFA
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Suivi -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body text-center">
                    <a href="{{ route('client.commandes.tracking', $commande) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #1e5a9e 0%, #ff6b35 100%); color: white;">
                        <i class="fas fa-tracking"></i> Suivre ma commande
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 5px;
    }
</style>
@endsection
