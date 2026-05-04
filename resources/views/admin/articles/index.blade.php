@extends('layouts.admin')

@section('header_title', 'Gestion du Blog')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Articles de Blog</h2>
        <p class="text-sm text-slate-500">Rédigez et gérez vos articles visibles par les clients.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30 transition-all hover:-translate-y-0.5">
        <i class="fas fa-plus"></i> Nouvel Article
    </a>
</div>

@if($articles->count() > 0)
<div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-slate-800 text-white border-0">
                <tr>
                    <th class="py-3 px-4 border-0">Titre</th>
                    <th class="py-3 px-4 border-0 text-center">Statut</th>
                    <th class="py-3 px-4 border-0 text-center">Date</th>
                    <th class="py-3 px-4 border-0 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td class="px-4 py-3">
                        <span class="font-bold text-slate-700 block line-clamp-1">{{ $article->titre }}</span>
                    </td>
                    <td class="px-4 text-center">
                        @if($article->statut === 'publie')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill font-bold">Publié</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 px-3 py-2 rounded-pill font-bold">Brouillon</span>
                        @endif
                    </td>
                    <td class="px-4 text-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">{{ $article->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-4 text-end">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Supprimer cet article ?')">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-3xl border border-dashed border-slate-300 py-20 text-center">
    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-newspaper text-3xl text-slate-300"></i>
    </div>
    <h4 class="text-xl font-bold text-slate-800">Aucun article publié</h4>
    <p class="text-slate-500 mb-8 max-w-sm mx-auto font-medium">Commencez à partager des actualités en créant votre premier article.</p>
    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold transition-all shadow-lg shadow-orange-500/30">
        <i class="fas fa-plus"></i> Écrire un article
    </a>
</div>
@endif
@endsection

