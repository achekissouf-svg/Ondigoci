@extends('layouts.admin')

@section('header_title', 'Modifier le Produit')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.produits.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Mise à jour du Produit</h2>
            <p class="text-sm text-slate-500">Modifiez les détails de votre produit ci-dessous.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('admin.produits.update', $produit->id_produit) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Nom du produit</label>
                    <input type="text" name="nom_produit" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none @error('nom_produit') border-red-500 @enderror" 
                           value="{{ old('nom_produit', $produit->nom_produit) }}">
                    @error('nom_produit')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Description détaillée</label>
                    <textarea name="description_produit" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none @error('description_produit') border-red-500 @enderror">{{ old('description_produit', $produit->description_produit) }}</textarea>
                    @error('description_produit')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Prix de vente (FCFA)</label>
                    <div class="relative">
                        <input type="number" name="prix_unitaire_produit" class="w-full pl-4 pr-16 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none @error('prix_unitaire_produit') border-red-500 @enderror" 
                               value="{{ old('prix_unitaire_produit', $produit->prix_unitaire_produit) }}" min="0">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">FCFA</span>
                    </div>
                    @error('prix_unitaire_produit')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Stock disponible</label>
                    <input type="number" name="stock_disponible_produit" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none @error('stock_disponible_produit') border-red-500 @enderror" 
                           value="{{ old('stock_disponible_produit', $produit->stock_disponible_produit) }}" min="0">
                    @error('stock_disponible_produit')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Catégorie</label>
                    <select name="id_categorie" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none bg-white @error('id_categorie') border-red-500 @enderror">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id_categorie }}" {{ $produit->id_categorie == $cat->id_categorie ? 'selected' : '' }}>
                                {{ $cat->libel_categorie }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_categorie')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-tight">Nouvelle Image (Optionnel)</label>
                    <input type="file" name="image" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-all outline-none @error('image') border-red-500 @enderror" accept="image/*">
                    @error('image')<p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>@enderror
                    
                    @if($produit->image_principale_produit)
                        <div class="mt-4 flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                            <img src="{{ asset('images/' . $produit->image_principale_produit) }}" alt="Image actuelle" class="w-12 h-12 rounded-lg object-contain bg-white border border-slate-200 shadow-sm">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center leading-tight">Image actuelle</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4 mt-10 pt-8 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-slate-900 hover:bg-primary-600 text-white font-bold transition-all shadow-lg shadow-slate-900/10 hover:shadow-primary-500/20">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('admin.produits.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

