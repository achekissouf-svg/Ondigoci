@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-primary-900 tracking-tighter mb-2">Gestion des Commandes</h1>
                <p class="text-slate-500 font-medium">
                    @if($boutique)
                        Gérez les ventes de la boutique <span class="text-primary-500 font-bold">{{ $boutique->nom_boutique }}</span>.
                    @else
                        Aucune boutique active associée à votre compte.
                    @endif
                </p>
            </div>
            <a href="{{ route('boutique.dashboard') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-white text-slate-500 font-black rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all uppercase tracking-widest text-xs">
                <i class="fas fa-arrow-left"></i> Tableau de bord
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-500/20 flex items-center gap-3 animate-bounce-in">
                <i class="fas fa-check-circle"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-500 text-white rounded-2xl shadow-lg shadow-rose-500/20 flex items-center gap-3 animate-bounce-in">
                <i class="fas fa-exclamation-circle"></i>
                <span class="font-bold text-sm">{{ session('error') }}</span>
            </div>
        @endif

        @if($lignes->count() > 0)
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-6 text-left">Produit</th>
                                <th class="px-8 py-6 text-left">Client & Livraison</th>
                                <th class="px-8 py-6 text-center">Qté</th>
                                <th class="px-8 py-6 text-right">Sous-total</th>
                                <th class="px-8 py-6 text-center">Statut Actuel</th>
                                <th class="px-8 py-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($lignes as $ligne)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-100 p-1">
                                                @if($ligne->produit && $ligne->produit->image_principale_produit)
                                                    <img src="{{ asset('images/' . $ligne->produit->image_principale_produit) }}"
                                                         class="w-full h-full object-contain">
                                                @else
                                                    <i class="fas fa-image text-slate-200"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm leading-tight mb-1">{{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}</p>
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $ligne->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="space-y-1">
                                            <p class="text-sm font-black text-slate-700">{{ $ligne->commande->user->name ?? '—' }}</p>
                                            <div class="flex items-center gap-2 text-emerald-600">
                                                <i class="fab fa-whatsapp text-xs"></i>
                                                <span class="text-[10px] font-black tracking-widest">{{ $ligne->commande->telephone_commande ?? 'N/A' }}</span>
                                            </div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase truncate max-w-[200px]">
                                                <i class="fas fa-location-dot me-1"></i> {{ $ligne->commande->livraison->adresse_livraison ?? 'Non spécifiée' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="inline-flex w-8 h-8 bg-slate-100 items-center justify-center rounded-xl text-xs font-black text-slate-500">
                                            {{ $ligne->quantite_ligne_commande }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right font-black text-primary-500">
                                        {{ number_format($ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande, 0, ',', ' ') }} <small class="text-[10px] text-slate-400">FCFA</small>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php $statut = $ligne->commande->statut_commande ?? 'en_attente'; @endphp
                                        <div class="inline-flex px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                            @if($statut === 'livree') bg-emerald-50 text-emerald-600 
                                            @elseif($statut === 'en_livraison') bg-blue-50 text-blue-600 
                                            @elseif($statut === 'en_preparation') bg-primary-50 text-primary-600 
                                            @elseif($statut === 'annulee' || $statut === 'rejetee') bg-rose-50 text-rose-600 
                                            @else bg-amber-50 text-amber-600 @endif">
                                            @if($statut === 'livree') <i class="fas fa-check-double me-2"></i> Livrée 
                                            @elseif($statut === 'en_livraison') <i class="fas fa-truck me-2"></i> Livraison 
                                            @elseif($statut === 'en_preparation') <i class="fas fa-box-open me-2"></i> Préparation 
                                            @elseif($statut === 'annulee') <i class="fas fa-ban me-2"></i> Annulée 
                                            @elseif($statut === 'rejetee') <i class="fas fa-times me-2"></i> Rejetée 
                                            @else <i class="fas fa-clock me-2"></i> En attente @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @if(in_array($statut, ['livree', 'annulee', 'rejetee']))
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Action impossible</span>
                                        @else
                                            <div class="dropdown">
                                                <button class="w-10 h-10 bg-slate-100 text-slate-500 rounded-xl hover:bg-primary-500 hover:text-white transition-all dropdown-toggle hide-caret border-0 shadow-none" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-2xl rounded-2xl p-2 mt-2">
                                                    @if($statut === 'en_attente')
                                                    <li>
                                                        <form action="{{ route('boutique.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="statut_commande" value="en_preparation">
                                                            <button type="submit" class="dropdown-item rounded-xl py-2.5 text-xs font-bold text-primary-600 hover:bg-primary-50"><i class="fas fa-box-open me-2"></i> Préparer la commande</button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    
                                                    @if($statut === 'en_preparation')
                                                    <li>
                                                        <form action="{{ route('boutique.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="statut_commande" value="en_livraison">
                                                            <button type="submit" class="dropdown-item rounded-xl py-2.5 text-xs font-bold text-blue-600 hover:bg-blue-50"><i class="fas fa-truck me-2"></i> Expédier au client</button>
                                                        </form>
                                                    </li>
                                                    @endif

                                                    @if($statut === 'en_livraison')
                                                    <li>
                                                        <form action="{{ route('boutique.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="statut_commande" value="livree">
                                                            <button type="submit" class="dropdown-item rounded-xl py-2.5 text-xs font-bold text-emerald-600 hover:bg-emerald-50"><i class="fas fa-check-double me-2"></i> Confirmer Livraison</button>
                                                        </form>
                                                    </li>
                                                    @endif

                                                    <li><hr class="dropdown-divider opacity-5 my-2"></li>
                                                    <li>
                                                        <form action="{{ route('boutique.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="statut_commande" value="rejetee">
                                                            <button type="submit" class="dropdown-item rounded-xl py-2.5 text-xs font-bold text-rose-500 hover:bg-rose-50"><i class="fas fa-times-circle me-2"></i> Rejeter la commande</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-6">
                    <i class="fas fa-receipt text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900 mb-2">Aucune commande reçue</h4>
                <p class="text-slate-400 font-medium">Les nouvelles commandes de vos clients s'afficheront ici.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .dropdown-toggle::after { display: none; }
</style>
@endsection
