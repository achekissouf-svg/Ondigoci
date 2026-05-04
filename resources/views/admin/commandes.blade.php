@extends('layouts.admin')

@section('header_title', 'Gestion des Commandes')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Commandes reçues</h2>
        <p class="text-sm text-slate-500">
            @if($boutique)
                Produits de <strong>{{ $boutique->nom_boutique }}</strong> — commandes passées par vos clients.
            @else
                Vue globale de toutes les commandes de la plateforme.
            @endif
        </p>
    </div>
</div>

@if($lignes->count() > 0)
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary-500 text-white border-0">
                        <tr>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Produit</th>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest">Client</th>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Qté</th>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-end">Total</th>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Statut</th>
                            <th class="py-4 px-6 border-0 text-[10px] font-black uppercase tracking-widest text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lignes as $ligne)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($ligne->produit && $ligne->produit->image_principale_produit)
                                        <img src="{{ asset('images/' . $ligne->produit->image_principale_produit) }}"
                                             alt="{{ $ligne->produit->nom_produit }}"
                                             class="rounded-lg shadow-sm"
                                             style="width: 40px; height: 40px; object-fit: contain; background: #f8fafc; border: 1px solid #f1f5f9; padding: 2px;">
                                    @endif
                                    <span class="font-bold text-slate-700 text-sm">{{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}</span>
                                </div>
                            </td>
                            <td class="px-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 text-sm">{{ $ligne->commande->user->name ?? '—' }}</span>
                                    <span class="text-[10px] font-black text-primary-600 uppercase tracking-tighter">{{ $ligne->commande->telephone_commande ?? ($ligne->commande->user->telephone ?? 'N/A') }}</span>
                                </div>
                            </td>
                            <td class="px-4 text-center font-black text-slate-400">{{ $ligne->quantite_ligne_commande }}</td>
                            <td class="px-4 text-end font-black text-orange-600 text-sm">
                                {{ number_format($ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande, 0, ',', ' ') }} <span class="text-[10px]">FCFA</span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="dropdown">
                                    @php $statut = $ligne->commande->statut_commande ?? 'en_attente'; @endphp
                                    <button class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" 
                                            style="@if($statut === 'livree') background: #dcfce7; color: #166534; 
                                            @elseif($statut === 'en_livraison') background: #e0f2fe; color: #075985; 
                                            @elseif($statut === 'en_preparation') background: #e0e7ff; color: #3730a3; 
                                            @elseif($statut === 'annulee' || $statut === 'rejetee') background: #fee2e2; color: #991b1b; 
                                            @else background: #fef9c3; color: #854d0e; @endif">
                                        @if($statut === 'livree') Livrée 
                                        @elseif($statut === 'en_livraison') En livraison 
                                        @elseif($statut === 'en_preparation') En prép. 
                                        @elseif($statut === 'annulee') Annulée 
                                        @elseif($statut === 'rejetee') Rejetée 
                                        @else En attente @endif
                                    </button>
                                    <ul class="dropdown-menu shadow-2xl border-0 rounded-2xl p-2">
                                        <li>
                                            <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="statut_commande" value="en_preparation">
                                                <button type="submit" class="dropdown-item rounded-xl text-indigo-600 font-bold text-xs py-2"><i class="fas fa-box-open me-2 opacity-50"></i> Préparer</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="statut_commande" value="en_livraison">
                                                <button type="submit" class="dropdown-item rounded-xl text-sky-600 font-bold text-xs py-2"><i class="fas fa-truck me-2 opacity-50"></i> Expédier</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="statut_commande" value="livree">
                                                <button type="submit" class="dropdown-item rounded-xl text-emerald-600 font-bold text-xs py-2"><i class="fas fa-check-double me-2 opacity-50"></i> Livrer</button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider my-2 opacity-5"></li>
                                        <li>
                                            <form action="{{ route('admin.commandes.update', $ligne->commande->id_commande) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="statut_commande" value="annulee">
                                                <button type="submit" class="dropdown-item rounded-xl text-rose-600 font-bold text-xs py-2"><i class="fas fa-times-circle me-2 opacity-50"></i> Annuler</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="px-4 text-center text-slate-400 text-[10px] font-bold">
                                {{ $ligne->commande->date_commande ? \Carbon\Carbon::parse($ligne->commande->date_commande)->format('d/m/Y') : '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="mt-8 flex justify-end">
        <div class="bg-gradient-to-br from-primary-600 to-primary-900 text-white p-8 rounded-[2rem] shadow-2xl border border-white/10 min-w-[350px] relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <i class="fas fa-coins text-6xl"></i>
            </div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-primary-200 uppercase tracking-[0.2em] mb-2">Total des ventes</p>
                <h3 class="text-3xl font-black text-orange-400 tracking-tight">
                    {{ number_format($lignes->sum(fn($l) => $l->prix_au_moment_achat * $l->quantite_ligne_commande), 0, ',', ' ') }} <span class="text-sm font-bold text-white/50">FCFA</span>
                </h3>
                <div class="mt-6 flex items-center gap-3 py-3 px-4 rounded-xl bg-white/10 border border-white/10">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-primary-100">{{ $lignes->count() }} transaction(s) traitée(s)</span>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="bg-white rounded-3xl border border-dashed border-slate-300 py-20 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-inbox text-3xl text-slate-300"></i>
        </div>
        <h4 class="text-xl font-bold text-slate-800">Aucune commande reçue</h4>
        <p class="text-slate-500 max-w-sm mx-auto font-medium">Les commandes apparaîtront ici dès que les clients commenceront à acheter vos produits.</p>
    </div>
@endif
@endsection

