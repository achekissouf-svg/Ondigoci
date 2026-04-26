@extends('layouts.app')

@section('title', 'Modifier la Catégorie')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-4">
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4">Modifier la Catégorie</h2>
                    
                    <form action="{{ route('admin.categories.update', $categorie->id_categorie) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="libel_categorie" class="form-label fw-bold">Nom de la catégorie</label>
                            <input type="text" name="libel_categorie" id="libel_categorie" class="form-control @error('libel_categorie') is-invalid @enderror" value="{{ old('libel_categorie', $categorie->libel_categorie) }}" required>
                            @error('libel_categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug actuel: {{ $categorie->slug_categorie }}</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning py-3 fw-bold shadow-sm">
                                <i class="fas fa-sync-alt me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
