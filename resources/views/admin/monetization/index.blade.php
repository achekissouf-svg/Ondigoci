@extends('layouts.admin')

@section('header_title', 'Gestion de la Monétisation')

@section('content')
<div class="mb-10">
    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Analyse des Revenus & Monétisation</h2>
    <p class="text-slate-500 font-medium">Suivez la performance financière de la plateforme.</p>
</div>

<!-- Revenue KPIs -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-indigo-500 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
            <i class="fas fa-gem text-9xl"></i>
        </div>
        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-indigo-100">Abonnements Boutiques</p>
        <h3 class="text-3xl font-black mb-1">{{ number_format($revenueAbonnements, 0, ',', ' ') }} FCFA</h3>
        <p class="text-xs font-bold text-indigo-100/60">Revenus mensuels projetés</p>
    </div>

    <div class="bg-emerald-500 p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
            <i class="fas fa-percentage text-9xl"></i>
        </div>
        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-emerald-100">Commissions (10%)</p>
        <h3 class="text-3xl font-black mb-1">{{ number_format($commissions, 0, ',', ' ') }} FCFA</h3>
        <p class="text-xs font-bold text-emerald-100/60">Sur {{ number_format($totalVentesLivrees, 0, ',', ' ') }} FCFA de ventes</p>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-5 text-slate-900 group-hover:scale-110 transition-transform duration-700">
            <i class="fas fa-vault text-9xl"></i>
        </div>
        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-slate-400">Total Revenus Plateforme</p>
        <h3 class="text-3xl font-black text-slate-900 mb-1">{{ number_format($revenueAbonnements + $commissions, 0, ',', ' ') }} FCFA</h3>
        <p class="text-xs font-bold text-slate-400">Abonnements + Commissions</p>
    </div>
</div>

<div class="mb-6 flex items-center justify-between">
    <h3 class="text-xl font-black text-slate-800 tracking-tight">Sponsoring des Produits</h3>
</div>


@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold flex items-center gap-3 animate-fade-in">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-slate-50">
                <tr>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Produit</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Boutique</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Sponsoring</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Priorité</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($produits as $produit)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200">
                                <img src="{{ asset('images/' . $produit->image_principale_produit) }}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <p class="font-black text-slate-800 leading-none mb-1">{{ $produit->nom_produit }}</p>
                                <p class="text-xs font-bold text-primary-500">{{ number_format($produit->prix_unitaire_produit, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-500">
                            {{ $produit->boutique->nom_boutique }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <form action="{{ route('admin.monetization.toggle', $produit->id_produit) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $produit->est_sponsorise ? 'bg-amber-400 text-white shadow-lg shadow-amber-400/30' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' }}">
                                <i class="fas fa-star {{ $produit->est_sponsorise ? '' : 'opacity-30' }}"></i>
                                {{ $produit->est_sponsorise ? 'Sponsorisé' : 'Standard' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-8 py-5 text-center">
                        @if($produit->est_sponsorise)
                        <form action="{{ route('admin.monetization.priority', $produit->id_produit) }}" method="POST" class="inline-flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="priorite_sponsoring" value="{{ $produit->priorite_sponsoring }}" min="0" class="w-16 h-10 bg-slate-100 border-none rounded-lg text-center font-bold text-xs focus:ring-2 focus:ring-amber-400">
                            <button type="submit" class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition-all"><i class="fas fa-check"></i></button>
                        </form>
                        @else
                        <span class="text-xs text-slate-300 italic">N/A</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-end">
                        <a href="{{ route('produit.show', $produit->id_produit) }}" target="_blank" class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl inline-flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $produits->links() }}
</div>
@endsection
