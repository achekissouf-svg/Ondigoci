@extends('layouts.admin')

@section('header_title', 'Gestion des Avis')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800">Gestion des Avis</h2>
    <p class="text-sm text-slate-500">Supervisez tous les commentaires et notes laissés par les clients.</p>
</div>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
    <div class="card-header bg-white py-0 px-4 border-b border-slate-100">
        <ul class="nav nav-tabs card-header-tabs border-0 gap-8" id="avisTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active font-bold border-0 py-4 px-0 text-slate-400 hover:text-slate-600 transition-all relative" id="boutiques-tab" data-bs-toggle="tab" data-bs-target="#boutiques-pane" type="button" role="tab">
                    Avis Boutiques
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-bold border-0 py-4 px-0 text-slate-400 hover:text-slate-600 transition-all relative" id="produits-tab" data-bs-toggle="tab" data-bs-target="#produits-pane" type="button" role="tab">
                    Avis Produits
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body p-0">
        <div class="tab-content" id="avisTabContent">
            <!-- Boutiques Avis Pane -->
            <div class="tab-pane fade show active" id="boutiques-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary-500 text-white uppercase text-[10px] font-black tracking-widest border-0">
                            <tr>
                                <th class="px-6 py-4 border-0">Client</th>
                                <th class="px-6 py-4 border-0">Boutique</th>
                                <th class="px-6 py-4 border-0">Note</th>
                                <th class="px-6 py-4 border-0">Commentaire</th>
                                <th class="px-6 py-4 border-0">Date</th>
                                <th class="px-6 py-4 border-0 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($avisBoutiques as $avis)
                                <tr>
                                    <td class="px-4 py-3"><span class="font-bold text-slate-700">{{ $avis->user->name }}</span></td>
                                    <td class="px-4"><span class="px-2 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold">{{ $avis->boutique->nom_boutique }}</span></td>
                                    <td class="px-4">
                                        <div class="flex gap-0.5 text-amber-400 text-xs">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 max-w-xs"><p class="text-xs text-slate-500 italic leading-relaxed line-clamp-1">"{{ $avis->commentaire }}"</p></td>
                                    <td class="px-4 text-xs font-bold text-slate-400 uppercase tracking-tighter">{{ $avis->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 text-end">
                                        <form action="{{ route('admin.avis.boutique.destroy', $avis->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all" onclick="return confirm('Supprimer cet avis ?')">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-50">
                    {{ $avisBoutiques->links() }}
                </div>
            </div>

            <!-- Produits Avis Pane -->
            <div class="tab-pane fade" id="produits-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary-500 text-white uppercase text-[10px] font-black tracking-widest border-0">
                            <tr>
                                <th class="px-6 py-4 border-0">Client</th>
                                <th class="px-6 py-4 border-0">Produit</th>
                                <th class="px-6 py-4 border-0">Note</th>
                                <th class="px-6 py-4 border-0">Commentaire</th>
                                <th class="px-6 py-4 border-0">Date</th>
                                <th class="px-6 py-4 border-0 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($avisProduits as $avis)
                                <tr>
                                    <td class="px-4 py-3"><span class="font-bold text-slate-700">{{ $avis->user->name }}</span></td>
                                    <td class="px-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 text-xs">{{ $avis->produit->nom_produit }}</span>
                                            <span class="text-[10px] text-slate-400">Boutique: {{ $avis->produit->boutique->nom_boutique }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4">
                                        <div class="flex gap-0.5 text-amber-400 text-xs">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 max-w-xs"><p class="text-xs text-slate-500 italic leading-relaxed line-clamp-1">"{{ $avis->commentaire }}"</p></td>
                                    <td class="px-4 text-xs font-bold text-slate-400 uppercase tracking-tighter">{{ $avis->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 text-end">
                                        <form action="{{ route('admin.avis.produit.destroy', $avis->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all" onclick="return confirm('Supprimer cet avis ?')">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-50">
                    {{ $avisProduits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        border-bottom: 2px solid transparent !important;
    }
    .nav-tabs .nav-link.active {
        color: #1e5a9e !important;
        border-bottom: 3px solid #ff6b35 !important;
        background: transparent !important;
    }
</style>
@endsection

