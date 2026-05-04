@props(['product'])

@php
    $originalPrice = $product->prix_unitaire_produit;
    $hasPromo = isset($product->promotion) && $product->promotion && $product->promotion->date_debut_promo <= now() && $product->promotion->date_fin_promo >= now();
    $finalPrice = $hasPromo ? $originalPrice * (1 - $product->promotion->pourcentage_reduction / 100) : $originalPrice;
    $rating = $product->boutique->note_moyenne ?? 0;
    $count = $product->boutique->avis->count() ?? 0;
@endphp

<div class="group bg-white rounded-3xl p-3 shadow-sm hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-500 border border-slate-100 flex flex-col h-full relative overflow-hidden">
    <!-- Wishlist Button -->
    @auth
        <button onclick="toggleWishlist(event, '{{ $product->id_produit ?? $product->id }}')" 
                id="wishlist-btn-{{ $product->id_produit ?? $product->id }}"
                class="absolute top-4 right-4 z-20 w-10 h-10 rounded-xl bg-white/80 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-sm {{ auth()->user()->favoris()->where('id_produit', $product->id_produit ?? $product->id)->exists() ? 'text-rose-500' : 'text-slate-400 hover:text-rose-500' }}">
            <i class="fas fa-heart {{ auth()->user()->favoris()->where('id_produit', $product->id_produit ?? $product->id)->exists() ? '' : 'fa-regular' }}" id="wishlist-icon-{{ $product->id_produit ?? $product->id }}"></i>
        </button>
    @endauth

    @if($product->est_sponsorise)
        <div class="absolute top-4 left-4 z-20 px-3 py-1 bg-amber-400 text-white text-[9px] font-black rounded-lg shadow-lg shadow-amber-400/20 uppercase tracking-widest flex items-center gap-1">
            <i class="fas fa-star text-[8px]"></i> Sponsorisé
        </div>
    @endif

    <!-- Image Wrapper -->
    <a href="{{ route('produit.show', $product->id_produit ?? $product->id) }}" class="relative aspect-square rounded-2xl overflow-hidden bg-slate-50 mb-4 block">
        <img src="{{ asset('images/' . $product->image_principale_produit) }}" 
             alt="{{ $product->nom_produit }}" 
             class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-700">
        
        @if($hasPromo)
            <div class="absolute top-3 right-3 bg-rose-500 text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow-lg">
                -{{ $product->promotion->pourcentage_reduction }}%
            </div>
        @endif

        <!-- Quick View Overlay (Visual only for now) -->
        <div class="absolute inset-0 bg-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-primary-500 shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform">
                <i class="fas fa-eye"></i>
            </div>
        </div>
    </a>

    <!-- Info -->
    <div class="flex flex-col flex-1 px-1">
        <div class="flex items-center gap-2 mb-2">
            <div class="flex items-center gap-1">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest truncate max-w-[80px]">{{ $product->boutique->nom_boutique ?? 'Ondigoci' }}</span>
                @if($product->boutique && $product->boutique->est_verifie)
                    <i class="fas fa-check-circle text-blue-400 text-[8px]" title="Vendeur Vérifié"></i>
                @endif
            </div>
            <div class="h-1 w-1 rounded-full bg-slate-300"></div>
            <div class="flex text-orange-400 text-[8px]">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $rating ? '' : 'opacity-30' }}"></i>
                @endfor
            </div>
        </div>

        <h3 class="text-sm font-bold text-slate-800 line-clamp-2 mb-3 min-h-[2.5rem]">
            <a href="{{ route('produit.show', $product->id_produit ?? $product->id) }}" class="hover:text-primary-500 transition-colors">
                {{ $product->nom_produit }}
            </a>
        </h3>

        <div class="mt-auto flex items-end justify-between gap-2">
            <div class="flex flex-col">
                @if($hasPromo)
                    <span class="text-[10px] text-slate-400 line-through font-bold">{{ number_format($originalPrice, 0, ',', ' ') }} <small>FCFA</small></span>
                @endif
                <span class="text-base font-black text-primary-500">
                    {{ number_format($finalPrice, 0, ',', ' ') }} <small class="text-[10px]">FCFA</small>
                </span>
            </div>

            @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
            <button onclick="addToCart('{{ $product->id_produit ?? $product->id }}')" 
                    class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all shadow-sm hover:shadow-orange-500/20 active:scale-95">
                <i class="fas fa-cart-plus"></i>
            </button>
            @endif
        </div>
    </div>
</div>
