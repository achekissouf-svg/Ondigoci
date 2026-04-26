@extends('layouts.app')
@section('title', 'Ajouter un produit')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('boutique.produits.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h1 class="fw-bold mb-0" style="color: #1e5a9e;">Ajouter un produit</h1>
            </div>
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-5">
                    <form action="{{ route('boutique.produits.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Nom du produit</label>
                                <input type="text" name="nom_produit" class="form-control @error('nom_produit') is-invalid @enderror"
                                       placeholder="Ex: iPhone 15 Pro Max" value="{{ old('nom_produit') }}">
                                @error('nom_produit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description_produit" rows="3" class="form-control @error('description_produit') is-invalid @enderror"
                                          placeholder="Décrivez votre produit...">{{ old('description_produit') }}</textarea>
                                @error('description_produit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prix (FCFA)</label>
                                <input type="number" name="prix_unitaire_produit" class="form-control @error('prix_unitaire_produit') is-invalid @enderror"
                                       placeholder="Ex: 150000" value="{{ old('prix_unitaire_produit') }}" min="0">
                                @error('prix_unitaire_produit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Stock disponible</label>
                                <input type="number" name="stock_disponible_produit" class="form-control @error('stock_disponible_produit') is-invalid @enderror"
                                       placeholder="Ex: 10" value="{{ old('stock_disponible_produit') }}" min="0">
                                @error('stock_disponible_produit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Catégorie</label>
                                <select name="id_categorie" class="form-select @error('id_categorie') is-invalid @enderror">
                                    <option value="">-- Choisir une catégorie --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id_categorie }}" {{ old('id_categorie') == $cat->id_categorie ? 'selected' : '' }}>
                                            {{ $cat->libel_categorie }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_categorie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Promotion</label>
                                <select name="id_promo" class="form-select @error('id_promo') is-invalid @enderror">
                                    <option value="">-- Aucune promotion --</option>
                                    @foreach($promotions as $promo)
                                        <option value="{{ $promo->id_promo }}" {{ old('id_promo') == $promo->id_promo ? 'selected' : '' }}>
                                            {{ $promo->nom_promo }} (-{{ $promo->pourcentage_reduction }}%)
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Image du produit</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-5">
                            @if($boutique->aAtteintLimiteProduits())
                                <button type="button" class="btn fw-bold text-white px-5 opacity-50" style="background: #ff6b35; border-radius: 8px;" disabled>
                                    <i class="fas fa-exclamation-circle me-2"></i> Limite atteinte
                                </button>
                                <p class="text-danger small mb-0 align-self-center">Veuillez vous réabonner pour publier.</p>
                            @else
                                <button type="submit" class="btn fw-bold text-white px-5" style="background: #1e5a9e; border-radius: 8px;">
                                    <i class="fas fa-save me-2"></i> Publier le produit
                                </button>
                            @endif
                            <a href="{{ route('boutique.produits.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
