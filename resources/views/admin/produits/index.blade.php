@extends('layouts.admin')

@section('header_title', 'Gestion des Produits')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Produits Ondigoci Direct</h2>
        <p class="text-sm text-slate-500">Gérez les produits vendus directement par l'administration.</p>
    </div>
    <a href="{{ route('admin.produits.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30 transition-all hover:-translate-y-0.5">
        <i class="fas fa-plus"></i> Nouveau Produit
    </a>
</div>

@if($produits->count() > 0)
<div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-primary-500 text-white border-0">
                <tr>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Image</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Produit</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Prix</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Stock</th>
                    <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produits as $produit)
                <tr>
                    <td class="px-4 py-3">
                        <img src="{{ asset('images/' . $produit->image_principale_produit) }}" 
                             alt="{{ $produit->nom_produit }}" 
                             class="rounded-lg shadow-sm"
                             style="width: 48px; height: 48px; object-fit: contain; background: #f8fafc; border: 1px solid #f1f5f9;">
                    </td>
                    <td class="px-4 py-3 fw-bold text-slate-700">{{ $produit->nom_produit }}</td>
                    <td class="px-6 py-4 fw-black text-primary-500">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</td>
                    <td class="px-4 text-center">
                        @if($produit->stock_disponible_produit > 0)
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill font-bold">
                                {{ $produit->stock_disponible_produit }} en stock
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill font-bold">
                                Rupture
                            </span>
                        @endif
                    </td>
                    <td class="px-4 text-end">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.produits.edit', $produit->id_produit) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('admin.produits.destroy', $produit->id_produit) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Retirer ce produit de la vente ?')">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-3xl border border-dashed border-slate-300 py-20 text-center">
    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-box-open text-3xl text-slate-300"></i>
    </div>
    <h4 class="text-xl font-bold text-slate-800">Aucun produit en vente</h4>
    <p class="text-slate-500 mb-8 max-w-sm mx-auto font-medium">Commencez à vendre vos produits en cliquant sur le bouton ci-dessous.</p>
    <a href="{{ route('admin.produits.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold transition-all shadow-lg shadow-orange-500/30">
        <i class="fas fa-plus"></i> Créer mon premier produit
    </a>
</div>
@endif
@endsection

