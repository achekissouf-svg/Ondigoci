@extends('layouts.app')

@section('title', 'Ouvrir ma boutique - Ondigoci')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1e5a9e, #2d6db5) !important;">
                    <i class="fas fa-store text-white fs-1"></i>
                </div>
                <h1 class="fw-bold">Vendez sur Ondigoci</h1>
                <p class="text-muted">Créez votre boutique en quelques secondes et commencez à vendre vos produits à des milliers de clients.</p>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <form action="{{ route('boutique.register.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Nom de la boutique <span class="text-danger">*</span></label>
                                <input type="text" name="nom_boutique" class="form-control @error('nom_boutique') is-invalid @enderror" 
                                       placeholder="Ex: Ma Boutique Fashion" value="{{ old('nom_boutique') }}" required>
                                @error('nom_boutique')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Nom du responsable <span class="text-danger">*</span></label>
                                <input type="text" name="nom_responsable" class="form-control @error('nom_responsable') is-invalid @enderror" 
                                       placeholder="Ex: Jean Dupont" value="{{ old('nom_responsable') }}" required>
                                @error('nom_responsable')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description de l'activité <span class="text-danger">*</span></label>
                            <textarea name="description" rows="2" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Que vendez-vous ?">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Lieu (Ville/Quartier) <span class="text-danger">*</span></label>
                                <input type="text" name="lieu" class="form-control @error('lieu') is-invalid @enderror" 
                                       placeholder="Ex: Douala, Akwa" value="{{ old('lieu') }}" required>
                                @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Adresse précise / Siège <span class="text-danger">*</span></label>
                                <input type="text" name="adresse_siege" class="form-control @error('adresse_siege') is-invalid @enderror" 
                                       placeholder="Ex: Rue 1.234 face Boulangerie" value="{{ old('adresse_siege') }}" required>
                                @error('adresse_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Numéro WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" 
                                   placeholder="Ex: 237612345678" value="{{ old('whatsapp') }}" required>
                            @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-file-alt me-2"></i> Documents & Vérification</h5>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Pièce d'identité (Recto) <span class="text-danger">*</span></label>
                                <input type="file" name="piece_identite_recto" class="form-control @error('piece_identite_recto') is-invalid @enderror" required>
                                @error('piece_identite_recto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Pièce d'identité (Verso) <span class="text-danger">*</span></label>
                                <input type="file" name="piece_identite_verso" class="form-control @error('piece_identite_verso') is-invalid @enderror" required>
                                @error('piece_identite_verso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">RCCM (Registre de commerce) <small class="text-muted">(Optionnel)</small></label>
                            <input type="file" name="rccm" class="form-control @error('rccm') is-invalid @enderror">
                            @error('rccm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Photo du magasin / devanture <span class="text-danger">*</span></label>
                            <input type="file" name="photo_magasin" class="form-control @error('photo_magasin') is-invalid @enderror" required>
                            @error('photo_magasin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm" style="border-radius: 12px; background: #1e5a9e;">
                                Soumettre ma demande d'ouverture
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">
                En soumettant ce formulaire, vous acceptez nos conditions générales de vente en tant que partenaire marchand. 
                Votre boutique sera examinée par notre équipe sous 24h à 48h.
            </p>
        </div>
    </div>
</div>
@endsection
