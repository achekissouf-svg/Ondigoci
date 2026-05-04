@extends('layouts.admin')

@section('header_title', 'Gestion des Boutiques')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800">Demandes d'ouverture de boutique</h2>
    <p class="text-sm text-slate-500">Approuvez ou gérez les boutiques partenaires.</p>
</div>

<div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-primary-500 text-white border-0">
                <tr>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Boutique</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Propriétaire</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Adresse</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Abonnement</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Statut</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Actions</th>
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
                        <div class="fw-medium">{{ $boutique->user->name }}</div>
                        <small class="text-muted">{{ $boutique->user->email }}</small>
                    </td>
                    <td class="px-4 text-muted small">{{ $boutique->adresse_siege }}</td>
                    <td class="px-4">
                        <form action="{{ route('admin.boutiques.plan', $boutique->id) }}" method="POST" class="row g-2">
                            @csrf @method('PATCH')
                            <div class="col-8">
                                <select name="type_abonnement" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="gratuit" {{ $boutique->type_abonnement == 'gratuit' ? 'selected' : '' }}>Gratuit</option>
                                    <option value="standard" {{ $boutique->type_abonnement == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="premium" {{ $boutique->type_abonnement == 'premium' ? 'selected' : '' }}>Premium</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <input type="number" name="priorite" class="form-control form-control-sm" value="{{ $boutique->priorite }}" title="Priorité" onchange="this.form.submit()">
                            </div>
                        </form>
                    </td>
                    <td class="px-4 text-center">
                        @if($boutique->statut === 'approuve')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Actif</span>
                        @elseif($boutique->statut === 'en_attente')
                            <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2 rounded-pill border border-warning-subtle">En attente</span>
                        @elseif($boutique->statut === 'rejete')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Rejeté</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Bloqué</span>
                        @endif
                    </td>
                    <td class="px-4 text-center">
                        @if($boutique->statut === 'en_attente')
                            <div class="d-flex justify-content-center gap-2">
                                <form action="{{ route('admin.boutiques.approve', $boutique->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success shadow-sm rounded-pill px-3"><i class="fas fa-check me-1"></i> Approuver</button>
                                </form>
                                <form action="{{ route('admin.boutiques.reject', $boutique->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fas fa-times me-1"></i> Rejeter</button>
                                </form>
                            </div>
                        @else
                            <span class="text-muted small italic">Déjà traité</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-slate-400 font-medium">Aucune boutique enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

