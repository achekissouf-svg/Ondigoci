@extends('layouts.admin')

@section('header_title', 'Vérification des Boutiques')

@section('content')
<div class="mb-10">
    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Modération de l'Identité Vendeur</h2>
    <p class="text-slate-500 font-medium">Examinez les documents officiels pour certifier les boutiques.</p>
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
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Boutique</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400">Documents</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Statut</th>
                    <th class="py-5 px-8 border-0 text-[10px] font-black uppercase tracking-widest text-slate-400 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($boutiques as $boutique)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $boutique->logo) }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm border border-slate-100" alt="">
                            <div>
                                <p class="font-black text-slate-800 leading-none mb-1">{{ $boutique->nom_boutique }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $boutique->adresse_siege }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <a href="{{ asset('storage/' . $boutique->piece_identite) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-500 hover:text-white transition-all">
                                <i class="fas fa-id-card"></i> ID
                            </a>
                            <a href="{{ asset('storage/' . $boutique->justificatif_domicile) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-500 hover:text-white transition-all">
                                <i class="fas fa-home"></i> Domicile
                            </a>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-center">
                        @if($boutique->statut_verification === 'en_attente')
                            <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest">En attente</span>
                        @elseif($boutique->statut_verification === 'approuve')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Vérifiée</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Rejetée</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-end">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('admin.verifications.approve', $boutique->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-10 bg-emerald-500 text-white rounded-xl hover:scale-110 transition-all shadow-lg shadow-emerald-500/20">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            
                            <button type="button" onclick="openRejectModal({{ $boutique->id }})" class="w-10 h-10 bg-rose-500 text-white rounded-xl hover:scale-110 transition-all shadow-lg shadow-rose-500/20">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl">
        <h3 class="text-2xl font-black text-slate-800 mb-2">Rejeter la demande</h3>
        <p class="text-slate-500 font-medium mb-8">Veuillez indiquer le motif du rejet.</p>
        
        <form id="rejectForm" method="POST">
            @csrf @method('PATCH')
            <textarea name="motif_rejet" required class="w-full bg-slate-50 border-none rounded-2xl p-6 font-bold text-slate-800 mb-8" placeholder="Ex: Pièce d'identité floue, justificatif non valide..." rows="4"></textarea>
            
            <div class="flex gap-4">
                <button type="button" onclick="closeRejectModal()" class="flex-1 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl text-[10px] uppercase tracking-widest">Annuler</button>
                <button type="submit" class="flex-1 py-4 bg-rose-500 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest shadow-lg shadow-rose-500/20">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id) {
        document.getElementById('rejectForm').action = `/admin/verifications/${id}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection
