@extends('layouts.app')
@section('title', 'Modifier l\'article')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h1 class="fw-bold mb-0" style="color: #1e5a9e;">Modifier l'article</h1>
            </div>
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-5">
                    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Titre</label>
                            <input type="text" name="titre" class="form-control form-control-lg @error('titre') is-invalid @enderror"
                                   value="{{ old('titre', $article->titre) }}">
                            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contenu</label>
                            <textarea name="contenu" rows="8" class="form-control @error('contenu') is-invalid @enderror">{{ old('contenu', $article->contenu) }}</textarea>
                            @error('contenu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-semibold">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="brouillon" {{ $article->statut === 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="publie" {{ $article->statut === 'publie' ? 'selected' : '' }}>Publié</option>
                            </select>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn fw-bold text-white px-5" style="background: #1e5a9e; border-radius: 8px;">
                                <i class="fas fa-save me-2"></i> Enregistrer
                            </button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
