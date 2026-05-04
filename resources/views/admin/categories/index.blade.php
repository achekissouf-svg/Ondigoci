@extends('layouts.admin')

@section('header_title', 'Gestion des Catégories')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Catégories du catalogue</h2>
        <p class="text-sm text-slate-500">Gérez les catégories de produits pour maintenir l'ordre.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30 transition-all hover:-translate-y-0.5">
        <i class="fas fa-plus"></i> Nouvelle Catégorie
    </a>
</div>

<div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary-500 text-white border-0">
                    <tr>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">ID</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">Libellé</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">Slug</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest text-center">Produits</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="px-4 py-3 text-slate-400 font-bold text-xs uppercase tracking-tighter">#{{ $cat->id_categorie }}</td>
                        <td class="px-4 py-3 font-bold text-slate-700">{{ $cat->libel_categorie }}</td>
                        <td class="px-4 py-3 text-slate-400 font-medium text-sm italic">{{ $cat->slug_categorie }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $cat->produits_count }} produits
                            </span>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $cat->id_categorie) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat->id_categorie) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Supprimer cette catégorie ?')" title="Supprimer">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 text-slate-400">
                            <i class="fas fa-folder-open text-5xl mb-4 opacity-10"></i>
                            <p class="font-bold">Aucune catégorie trouvée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

