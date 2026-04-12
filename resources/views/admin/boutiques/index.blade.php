@extends('layouts.app')
@section('title', 'Gestion des Boutiques')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #1e5a9e;">Demandes d'ouverture de boutique <i class="fas fa-store-alt ms-2"></i></h1>
            <p class="text-muted">Approuvez ou gérez les boutiques partenaires sur votre plateforme.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: linear-gradient(135deg, #1e5a9e, #2d6db5); color: white;">
                    <tr>
                        <th class="py-3 px-4">Boutique</th>
                        <th class="py-3 px-4">Propriétaire</th>
                        <th class="py-3 px-4">Adresse</th>
                        <th class="py-3 px-4 text-center">Statut</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boutiques as $boutique)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-bold">{{ $boutique->nom_boutique }}</div>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;">{{ $boutique->description }}</small>
                        </td>
                        <td class="px-4">
                            <div>{{ $boutique->user->name }}</div>
                            <small class="text-muted">{{ $boutique->user->email }}</small>
                        </td>
                        <td class="px-4 text-muted small">{{ $boutique->adresse_siege }}</td>
                        <td class="px-4 text-center">
                            @if($boutique->statut === 'approuve')
                                <span class="badge bg-success">Actif</span>
                            @elseif($boutique->statut === 'en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                            @elseif($boutique->statut === 'rejete')
                                <span class="badge bg-danger">Rejeté</span>
                            @else
                                <span class="badge bg-secondary">Bloqué</span>
                            @endif
                        </td>
                        <td class="px-4 text-center">
                            @if($boutique->statut === 'en_attente')
                                <form action="{{ route('admin.boutiques.approve', $boutique->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i> Approuver</button>
                                </form>
                                <form action="{{ route('admin.boutiques.reject', $boutique->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Rejeter</button>
                                </form>
                            @else
                                <span class="text-muted small">Aucune action requise</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">Aucune boutique enregistrée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
