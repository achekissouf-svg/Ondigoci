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
                    <form action="{{ route('boutique.register.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nom de votre boutique</label>
                            <input type="text" name="nom_boutique" class="form-control form-control-lg @error('nom_boutique') is-invalid @enderror" 
                                   placeholder="Ex: Ma Boutique Fashion" value="{{ old('nom_boutique') }}">
                            @error('nom_boutique')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Ce nom sera visible par tous les clients sur vos produits.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description de l'activité</label>
                            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Ex: Nous vendons des vêtements haut de gamme depuis 2010.">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Adresse du siège / Lieu de vente</label>
                            <input type="text" name="adresse_siege" class="form-control @error('adresse_siege') is-invalid @enderror" 
                                   placeholder="Ex: Douala, Akwa face Douala Bercy" value="{{ old('adresse_siege') }}">
                            @error('adresse_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm" style="border-radius: 12px; background: #1e5a9e;">
                                Soumettre ma demande de création
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
