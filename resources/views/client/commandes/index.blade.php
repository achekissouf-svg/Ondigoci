@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Mon espace client</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('client.commandes') }}" class="text-decoration-none" style="color: #1e5a9e; font-weight: 600;">
                                <i class="fas fa-box"></i> Mes Commandes
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-shopping-cart"></i> Mon Panier
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="fas fa-user"></i> Mon Profil
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h3 class="mb-4 fw-bold">
                <i class="fas fa-box" style="color: #1e5a9e;"></i> Mes Commandes
            </h3>

            @if($commandes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #1e5a9e;">
                                <th class="fw-bold">N° Commande</th>
                                <th class="fw-bold">Date</th>
                                <th class="fw-bold">Montant</th>
                                <th class="fw-bold">Statut</th>
                                <th class="fw-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $commande->num_commande }}</span>
                                    </td>
                                    <td>{{ $commande->date_commande->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ number_format($commande->montant_total_commande, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('client.commandes.show', $commande) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        @if(!in_array($commande->statut_commande, ['livré', 'rejeté', 'annulé']))
                                            <a href="{{ route('client.commandes.tracking', $commande) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-truck"></i> Suivi
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="pagination" class="d-flex justify-content-center mt-4">
                    {{ $commandes->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info border-2" style="border-color: #1e5a9e !important; background-color: #f0f7ff;">
                    <i class="fas fa-info-circle" style="color: #1e5a9e;"></i>
                    <strong>Aucune commande</strong> - Vous n'avez pas encore passé de commande.
                    <a href="{{ route('shop') }}" class="alert-link">Commencez vos achats</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(30, 90, 158, 0.05);
    }

    .btn-outline-primary {
        color: #1e5a9e;
        border-color: #1e5a9e;
    }

    .btn-outline-primary:hover {
        background-color: #1e5a9e;
        color: white;
    }

    .btn-outline-info {
        color: #ff6b35;
        border-color: #ff6b35;
    }

    .btn-outline-info:hover {
        background-color: #ff6b35;
        color: white;
    }
</style>
@endsection
