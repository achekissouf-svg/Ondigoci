@extends('layouts.app')

@section('title', 'Modifier une Promotion - Dashboard Boutique')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Modifier la Promotion</h1>
                <a href="{{ route('boutique.promotions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body p-4">
                    <form action="{{ route('boutique.promotions.update', $promotion->id_promo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom de la promotion</label>
                            <input type="text" name="nom_promo" class="form-control @error('nom_promo') is-invalid @enderror" value="{{ old('nom_promo', $promotion->nom_promo) }}" required>
                            @error('nom_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pourcentage de réduction (%)</label>
                            <input type="number" step="0.01" name="pourcentage_reduction" class="form-control @error('pourcentage_reduction') is-invalid @enderror" value="{{ old('pourcentage_reduction', $promotion->pourcentage_reduction) }}" required>
                            @error('pourcentage_reduction')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date de début</label>
                                <input type="date" name="date_debut_promo" class="form-control @error('date_debut_promo') is-invalid @enderror" value="{{ old('date_debut_promo', $promotion->date_debut_promo->format('Y-m-d')) }}" required>
                                @error('date_debut_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date de fin</label>
                                <input type="date" name="date_fin_promo" class="form-control @error('date_fin_promo') is-invalid @enderror" value="{{ old('date_fin_promo', $promotion->date_fin_promo->format('Y-m-d')) }}" required>
                                @error('date_fin_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Mettre à jour la promotion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
