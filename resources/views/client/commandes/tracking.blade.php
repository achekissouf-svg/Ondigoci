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

    <div class="row mt-4">
        <div class="col-md-3">
            <!-- Sidebar with status -->
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #1e5a9e 0%, #ff6b35 100%); color: white;">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Statut actuel</h5>
                </div>
                <div class="card-body text-center">
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
                        $statusIcon = match($commande->statut_commande) {
                            'en_attente' => 'fa-hourglass',
                            'encours' => 'fa-truck',
                            'livré' => 'fa-check-circle',
                            'rejeté' => 'fa-times-circle',
                            'annulé' => 'fa-ban',
                            default => 'fa-question-circle'
                        };
                    @endphp
                    <div style="font-size: 3rem; color: #1e5a9e; margin: 15px 0;">
                        <i class="fas {{ $statusIcon }}"></i>
                    </div>
                    <span class="badge bg-{{ $statusColor }} p-2" style="font-size: 1rem;">{{ $statusLabel }}</span>
                    <p class="mt-3 text-muted small">
                        <strong>N° Commande:</strong><br>
                        #{{ $commande->num_commande }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if($commande->statut_commande === 'livré')
                <!-- Message de remerciement pour livraison -->
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 4rem; color: white; margin-bottom: 20px; animation: bounceIn 0.6s ease;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="text-white mb-3">Commande livrée avec succès!</h3>
                        <p class="text-white mb-2" style="font-size: 1.1rem;">
                            Merci pour votre achat! Votre commande <strong>#{{ $commande->num_commande }}</strong> a été livrée.
                        </p>
                        <p class="text-white mb-4" style="opacity: 0.9; font-size: 0.95rem;">
                            Nous espérons que vous êtes satisfait de votre achat. N'hésitez pas à nous contacter si vous avez des questions.
                        </p>
                        <a href="{{ route('shop') }}" class="btn btn-light mt-3" style="color: #28a745; font-weight: 600;">
                            <i class="fas fa-shopping-bag"></i> Continuer vos achats
                        </a>
                    </div>
                </div>
            @elseif($commande->statut_commande === 'rejeté' || $commande->statut_commande === 'annulé')
                <!-- Message pour commande rejetée/annulée -->
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 4rem; color: white; margin-bottom: 20px;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h3 class="text-white mb-3">Commande {{ $commande->statut_commande }}</h3>
                        <p class="text-white mb-4" style="font-size: 1.1rem;">
                            Votre commande <strong>#{{ $commande->num_commande }}</strong> a été {{ $commande->statut_commande }}.
                        </p>
                        <a href="{{ route('client.commandes.show', $commande) }}" class="btn btn-light mt-3" style="color: #dc3545; font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Retour aux détails
                        </a>
                    </div>
                </div>
            @else
                <!-- Timeline pour statuts en cours -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #1e5a9e;">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Historique du suivi</h5>
                    </div>
                    <div class="card-body">
                        @if($notifications->count() > 0)
                        <!-- Timeline -->
                        <div class="timeline">
                            @foreach($notifications as $index => $notif)
                                <div class="timeline-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="timeline-marker" style="background-color: 
                                        @if($notif->statut_commande === 'en_attente') #ffc107
                                        @elseif($notif->statut_commande === 'encours') #17a2b8
                                        @elseif($notif->statut_commande === 'livré') #28a745
                                        @elseif($notif->statut_commande === 'rejeté') #dc3545
                                        @else #6c757d
                                        @endif
                                    ">
                                        <i class="fas 
                                            @if($notif->statut_commande === 'en_attente') fa-hourglass
                                            @elseif($notif->statut_commande === 'encours') fa-truck
                                            @elseif($notif->statut_commande === 'livré') fa-check-circle
                                            @elseif($notif->statut_commande === 'rejeté') fa-times-circle
                                            @else fa-question-circle
                                            @endif
                                        "></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1">{{ $notif->titre }}</h6>
                                        <p class="mb-1">{{ $notif->message }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> {{ $notif->created_at->format('d/m/Y à H:i') }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning border-2" style="border-color: #ffc107 !important;">
                            <i class="fas fa-info-circle"></i> Aucune mise à jour pour le moment. Le vendeur doit confirmer votre commande.
                        </div>
                    @endif
                    </div>
                </div>
            @endif

            <!-- Détails de livraison -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #ff6b35;">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Détails de livraison</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Téléphone de livraison:</strong>
                            <p>{{ $commande->telephone_commande }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Mode de paiement:</strong>
                            <p>{{ $commande->modePaiement->libel_mode_paiement ?? 'Non spécifié' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 60px;
        width: 2px;
        height: 30px;
        background-color: #e9ecef;
    }

    .timeline-marker {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 20px;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .timeline-item.active .timeline-marker {
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2), 0 2px 5px rgba(0,0,0,0.1);
        transform: scale(1.1);
    }

    .timeline-content {
        flex: 1;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border-left: 3px solid #1e5a9e;
    }

    .timeline-item.active .timeline-content {
        background-color: #e7f4ff;
        border-left-color: #ff6b35;
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {
        .timeline-marker {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .timeline-item:not(:last-child)::before {
            left: 15px;
        }
    }
</style>
@endsection
