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
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#docsModal{{ $boutique->id }}">
                                <i class="fas fa-file-alt me-1"></i> Documents
                            </button>
                            
                            @if($boutique->statut === 'en_attente')
                                <form action="{{ route('admin.boutiques.approve', $boutique->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success shadow-sm rounded-pill px-3"><i class="fas fa-check me-1"></i></button>
                                </form>
                                <form action="{{ route('admin.boutiques.reject', $boutique->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fas fa-times me-1"></i></button>
                                </form>
                            @else
                                <span class="text-muted small italic">Traité</span>
                            @endif
                        </div>

                        <!-- Modal Documents -->
                        <div class="modal fade" id="docsModal{{ $boutique->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content text-start">
                                    <div class="modal-header bg-light border-0">
                                        <h5 class="modal-title fw-bold">Détails de {{ $boutique->nom_boutique }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted small uppercase fw-bold">Responsable</p>
                                                <p class="fw-bold">{{ $boutique->nom_responsable ?? 'Non renseigné' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted small uppercase fw-bold">Lieu / Ville</p>
                                                <p class="fw-bold">{{ $boutique->lieu ?? 'Non renseigné' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <p class="mb-2 text-muted small uppercase fw-bold">ID Recto</p>
                                                @if($boutique->piece_identite_recto)
                                                    <a href="{{ asset('images/' . $boutique->piece_identite_recto) }}" target="_blank">
                                                        <img src="{{ asset('images/' . $boutique->piece_identite_recto) }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px;">
                                                    </a>
                                                @else <span class="badge bg-light text-muted">Manquant</span> @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-2 text-muted small uppercase fw-bold">ID Verso</p>
                                                @if($boutique->piece_identite_verso)
                                                    <a href="{{ asset('images/' . $boutique->piece_identite_verso) }}" target="_blank">
                                                        <img src="{{ asset('images/' . $boutique->piece_identite_verso) }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px;">
                                                    </a>
                                                @else <span class="badge bg-light text-muted">Manquant</span> @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-2 text-muted small uppercase fw-bold">Photo Magasin</p>
                                                @if($boutique->photo_magasin)
                                                    <a href="{{ asset('images/' . $boutique->photo_magasin) }}" target="_blank">
                                                        <img src="{{ asset('images/' . $boutique->photo_magasin) }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px;">
                                                    </a>
                                                @else <span class="badge bg-light text-muted">Manquant</span> @endif
                                            </div>
                                        </div>

                                        @if($boutique->rccm)
                                        <div class="mt-4 p-3 bg-light rounded d-flex align-items-center">
                                            <i class="fas fa-file-pdf fs-3 text-danger me-3"></i>
                                            <div>
                                                <p class="mb-0 fw-bold">Registre de Commerce (RCCM)</p>
                                                <a href="{{ asset('images/' . $boutique->rccm) }}" target="_blank" class="small text-decoration-none">Télécharger / Voir le document</a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

