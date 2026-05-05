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

    @if(in_array($commande->statut_commande, ['rejetee', 'annulee']))
        <div class="row mb-8">
            <div class="col-12">
                <div class="bg-rose-50 border border-rose-100 p-6 rounded-[2rem] flex items-center gap-4 text-rose-800 shadow-sm">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-rose-500 shadow-sm">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-black uppercase tracking-widest text-xs mb-1">Commande {{ $commande->statut_commande === 'rejetee' ? 'rejetée' : 'annulée' }}</h4>
                        <p class="text-sm font-medium opacity-80">Désolé, cette commande ne pourra pas être honorée. Veuillez nous contacter pour plus de détails.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    
    <!-- Nouveau Stepper de Suivi -->
    <div class="row mb-10">
        <div class="col-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative">
                    <!-- Progress Line (Desktop) -->
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 hidden md:block z-0">
                        @php
                            $progress = match($commande->statut_commande) {
                                'en_attente' => '0%',
                                'en_preparation' => '33%',
                                'en_livraison' => '66%',
                                'livree' => '100%',
                                default => '0%'
                            };
                        @endphp
                        <div class="h-full bg-primary-500 transition-all duration-1000" style="width: {{ $progress }}"></div>
                    </div>

                    <!-- Steps -->
                    @php
                        $steps = [
                            ['id' => 'en_attente', 'icon' => 'fa-clock', 'label' => 'Validée'],
                            ['id' => 'en_preparation', 'icon' => 'fa-box-open', 'label' => 'Préparation'],
                            ['id' => 'en_livraison', 'icon' => 'fa-truck', 'label' => 'En route'],
                            ['id' => 'livree', 'icon' => 'fa-check-double', 'label' => 'Livrée']
                        ];
                        $currentPriority = [
                            'en_attente' => 1,
                            'en_preparation' => 2,
                            'en_livraison' => 3,
                            'livree' => 4,
                            'rejetee' => 0,
                            'annulee' => 0
                        ][$commande->statut_commande] ?? 1;
                    @endphp

                    @foreach($steps as $index => $step)
                        @php $isCompleted = ($index + 1) <= $currentPriority; @endphp
                        <div class="flex items-center gap-4 md:flex-col md:gap-3 relative z-10">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 {{ $isCompleted ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/20' : 'bg-slate-50 text-slate-300' }}">
                                <i class="fas {{ $step['icon'] }} text-lg"></i>
                            </div>
                            <div class="text-left md:text-center">
                                <p class="text-[10px] font-black uppercase tracking-widest {{ $isCompleted ? 'text-primary-500' : 'text-slate-300' }}">{{ $step['label'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


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
