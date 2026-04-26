@extends('layouts.app')

@section('title', 'Mes Promotions - Dashboard Boutique')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar could go here, for now we just show content -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Mes Promotions</h1>
                <a href="{{ route('boutique.promotions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Promotion
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Réduction (%)</th>
                                    <th>Date Début</th>
                                    <th>Date Fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promotions as $promo)
                                    <tr>
                                        <td>{{ $promo->nom_promo }}</td>
                                        <td>-{{ $promo->pourcentage_reduction }}%</td>
                                        <td>{{ $promo->date_debut_promo->format('d/m/Y') }}</td>
                                        <td>{{ $promo->date_fin_promo->format('d/m/Y') }}</td>
                                        <td>
                                            @if(now() < $promo->date_debut_promo)
                                                <span class="badge bg-warning text-dark">À venir</span>
                                            @elseif(now() > $promo->date_fin_promo)
                                                <span class="badge bg-secondary">Terminée</span>
                                            @else
                                                <span class="badge bg-success">En cours</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('boutique.promotions.edit', $promo->id_promo) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('boutique.promotions.destroy', $promo->id_promo) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            Aucune promotion trouvée. <a href="{{ route('boutique.promotions.create') }}">Créez votre première promotion</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
