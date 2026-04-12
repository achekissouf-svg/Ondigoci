@extends('layouts.app')
@section('title', 'Mes Articles Publiés')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #1e5a9e;">Articles Publiés <i class="fas fa-newspaper ms-2"></i></h1>
            <p class="text-muted">Rédigez et gérez vos articles visibles par les clients.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn fw-bold text-white shadow-sm" style="background: #ff6b35; border-radius: 8px;">
            <i class="fas fa-plus me-2"></i> Nouvel Article
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" style="border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($articles->count() > 0)
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: linear-gradient(135deg, #1e5a9e, #2d6db5); color: white;">
                    <tr>
                        <th class="py-3 px-4">Titre</th>
                        <th class="py-3 px-4 text-center">Statut</th>
                        <th class="py-3 px-4 text-center">Date</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">{{ $article->titre }}</td>
                        <td class="px-4 text-center">
                            @if($article->statut === 'publie')
                                <span class="badge bg-success">Publié</span>
                            @else
                                <span class="badge bg-secondary">Brouillon</span>
                            @endif
                        </td>
                        <td class="px-4 text-center text-muted small">
                            {{ $article->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 text-center">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet article ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-newspaper text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
        <h4 class="fw-bold mt-3">Aucun article pour le moment</h4>
        <p class="text-muted">Rédigez votre premier article en cliquant sur "Nouvel Article".</p>
    </div>
    @endif
</div>
@endsection
