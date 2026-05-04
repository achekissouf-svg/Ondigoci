@extends('layouts.admin')

@section('header_title', 'Modération des Paiements')

@section('content')
<div class="mb-10">
    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Validation des Paiements Manuels</h2>
    <p class="text-slate-500 font-medium">Vérifiez les captures d'écran et validez les abonnements des vendeurs.</p>
</div>

@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-slate-50">
                <tr>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Boutique</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Plan / Montant</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Preuve</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Statut</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($paiements as $paiement)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5 text-xs font-bold text-slate-400">
                        {{ $paiement->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-black text-slate-800 leading-none mb-1">{{ $paiement->boutique->nom_boutique }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[9px] font-black uppercase text-primary-500 bg-primary-50 px-2 py-0.5 rounded">{{ $paiement->moyen_paiement }}</span>
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Ref: {{ $paiement->reference }}</span>
                        </div>
                    </td>

                    <td class="px-8 py-5">
                        <span class="px-2 py-1 bg-primary-50 text-primary-600 rounded text-[9px] font-black uppercase tracking-widest mb-1 inline-block">
                            {{ $paiement->type_abonnement }}
                        </span>
                        <p class="font-black text-slate-800">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <button onclick="window.open('{{ asset('storage/' . $paiement->capture_ecran) }}')" class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl hover:bg-primary-500 hover:text-white transition-all inline-flex items-center justify-center">
                            <i class="fas fa-image"></i>
                        </button>
                    </td>
                    <td class="px-8 py-5 text-center">
                        @if($paiement->statut === 'en_attente')
                            <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest">En attente</span>
                        @elseif($paiement->statut === 'valide')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Validé</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Rejeté</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-end">
                        @if($paiement->statut === 'en_attente')
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('admin.monetization.payments.validate', $paiement->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-10 bg-emerald-500 text-white rounded-xl hover:scale-110 transition-all shadow-lg shadow-emerald-500/20">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.monetization.payments.reject', $paiement->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-10 bg-rose-500 text-white rounded-xl hover:scale-110 transition-all shadow-lg shadow-rose-500/20">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-slate-300 italic">Traité</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $paiements->links() }}
</div>
@endsection
