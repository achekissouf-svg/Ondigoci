@extends('layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="fw-bold">Catégories <i class="fas fa-list ms-2"></i></h1>
            <p class="text-muted">Gérez les catégories de produits pour maintenir l'ordre.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Nouvelle Catégorie
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Libellé</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3 text-center">Produits</th>
                            <th class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="px-4 py-3 text-muted small">{{ $cat->id_categorie }}</td>
                            <td class="px-4 py-3 fw-bold">{{ $cat->libel_categorie }}</td>
                            <td class="px-4 py-3 text-muted">{{ $cat->slug_categorie }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge rounded-pill bg-info text-dark">
                                    {{ $cat->produits_count }} produits
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('admin.categories.edit', $cat->id_categorie) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat->id_categorie) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette catégorie ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p>Aucune catégorie trouvée.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
