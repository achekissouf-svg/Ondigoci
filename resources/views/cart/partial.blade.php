<div data-cart-total="{{ number_format($total, 0, ',', ' ') }}">
    @forelse($paniers as $item)
        <div class="flex items-center gap-4 group">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center p-1 border border-slate-100">
                @if($item->produit->image_principale_produit)
                    <img src="{{ asset('images/' . $item->produit->image_principale_produit) }}" class="w-full h-full object-contain">
                @else
                    <i class="fas fa-image text-slate-200"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate mb-1">{{ $item->produit->nom_produit }}</p>
                <div class="flex items-center justify-between">
                    <p class="text-xs font-black text-primary-500">{{ number_format($item->produit->prixAvecReduction(), 0, ',', ' ') }} FCFA</p>
                    <p class="text-[10px] font-black text-slate-400 bg-slate-100 px-2 py-0.5 rounded">x{{ $item->quantite }}</p>
                </div>
            </div>
            <form action="{{ route('cart.destroy', $item->id_panier) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                @csrf @method('DELETE')
                <button type="submit" class="w-8 h-8 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-all">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
            </form>
        </div>
    @empty
        <div class="text-center py-10">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-4">
                <i class="fas fa-shopping-basket text-xl"></i>
            </div>
            <p class="text-slate-400 font-medium italic">Votre panier est vide</p>
        </div>
    @endforelse
</div>
