@extends('layouts.app')

@section('title', 'Nouvelle Catégorie')

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
                    <h2 class="fw-bold mb-4">Créer une Catégorie</h2>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libel_categorie" class="form-label fw-bold">Nom de la catégorie</label>
                            <input type="text" name="libel_categorie" id="libel_categorie" class="form-control @error('libel_categorie') is-invalid @enderror" value="{{ old('libel_categorie') }}" placeholder="Ex: Informatique, Mode..." required>
                            @error('libel_categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
