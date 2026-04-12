@extends('layouts.app')
@section('title', 'Gestion des Produits Admin')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #1e5a9e;">Produits Ondigoci Direct <i class="fas fa-box-open ms-2"></i></h1>
            <p class="text-muted">Gérez les produits vendus directement par l'administration.</p>
        </div>
        <a href="{{ route('admin.produits.create') }}" class="btn fw-bold text-white shadow-sm" style="background: #ff6b35; border-radius: 8px;">
            <i class="fas fa-plus me-2"></i> Nouveau Produit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" style="border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($produits->count() > 0)
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: linear-gradient(135deg, #1e5a9e, #2d6db5); color: white;">
                    <tr>
                        <th class="py-3 px-4">Image</th>
                        <th class="py-3 px-4">Produit</th>
                        <th class="py-3 px-4">Prix</th>
                        <th class="py-3 px-4 text-center">Stock</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td class="px-4 py-3">
                            <img src="{{ asset('images/' . $produit->image_principale_produit) }}" 
                                 alt="{{ $produit->nom_produit }}" 
                                 style="width: 50px; height: 50px; object-fit: contain; border-radius: 5px; background: #f5f5f5;">
                        </td>
                        <td class="px-4 py-3 fw-semibold">{{ $produit->nom_produit }}</td>
                        <td class="px-4 py-3 fw-bold text-primary">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 text-center">
                            <span class="badge {{ $produit->stock_disponible_produit > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $produit->stock_disponible_produit }}
                            </span>
                        </td>
                        <td class="px-4 text-center">
                            <a href="{{ route('admin.produits.edit', $produit->id_produit) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.produits.destroy', $produit->id_produit) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Retirer ce produit de la vente ?')">
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
        <i class="fas fa-box-open text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
        <h4 class="fw-bold mt-3">Aucun produit en vente</h4>
        <p class="text-muted">Commencez à vendre vos produits en cliquant sur "Nouveau Produit".</p>
    </div>
    @endif
</div>
@endsection
