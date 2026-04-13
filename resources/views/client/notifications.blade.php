@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 fw-bold">
                <i class="fas fa-bell" style="color: #ff6b35;"></i> Mes Notifications
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if($notifications->count() > 0)
                @foreach($notifications as $notif)
                    <div class="card border-0 shadow-sm mb-3 notification-card" data-notification="{{ $notif->id }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background-color: 
                                        @if($notif->statut_commande === 'en_attente') #ffc107
                                        @elseif($notif->statut_commande === 'encours') #17a2b8
                                        @elseif($notif->statut_commande === 'livré') #28a745
                                        @elseif($notif->statut_commande === 'rejeté') #dc3545
                                        @else #6c757d
                                        @endif
                                    ; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem;">
                                        <i class="fas 
                                            @if($notif->statut_commande === 'en_attente') fa-hourglass
                                            @elseif($notif->statut_commande === 'encours') fa-truck
                                            @elseif($notif->statut_commande === 'livré') fa-check-circle
                                            @elseif($notif->statut_commande === 'rejeté') fa-times-circle
                                            @else fa-question-circle
                                            @endif
                                        "></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">
                                        {{ $notif->titre }}
                                        @if(!$notif->lue)
                                            <small class="badge bg-danger ms-2">Nouvelle</small>
                                        @endif
                                    </h6>
                                    <p class="mb-1 text-muted">{{ $notif->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $notif->created_at->format('d/m/Y à H:i') }}
                                        | <a href="{{ route('client.commandes.tracking', $notif->commande) }}" class="text-primary text-decoration-none">
                                            Voir le suivi de #{{ $notif->commande->num_commande }}
                                        </a>
                                    </small>
                                </div>
                                @if(!$notif->lue)
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-outline-primary mark-as-read" onclick="markAsRead({{ $notif->id }})">
                                            <i class="fas fa-check"></i> Marquer comme lu
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <nav aria-label="pagination" class="d-flex justify-content-center mt-4">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info border-2" style="border-color: #1e5a9e !important; background-color: #f0f7ff;">
                    <i class="fas fa-info-circle" style="color: #1e5a9e;"></i>
                    <strong>Aucune notification</strong> - Vous serez notifié ici des mises à jour de vos commandes.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function markAsRead(notificationId) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch(`/notification/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.querySelector(`[data-notification="${notificationId}"]`);
                if (card) {
                    card.remove();
                }
                // Mettre à jour le badge
                updateNotificationBadge();
            }
        })
        .catch(error => console.error('Erreur:', error));
    }

    function updateNotificationBadge() {
        fetch('{{ route('client.notifications.data') }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
    }
</script>

<style>
    .notification-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    .notification-card:not(.read) {
        background-color: #f8f9fa;
        border-left-color: #ff6b35;
    }
</style>
@endsection
