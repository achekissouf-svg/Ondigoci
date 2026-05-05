@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-3xl lg:text-4xl font-black text-primary-900 tracking-tighter">Mes Favoris</h1>
            <span class="px-4 py-2 bg-white rounded-xl text-xs font-black text-slate-400 shadow-sm border border-slate-100 uppercase tracking-widest">
                {{ $favoris->count() }} Articles
            </span>
        </div>

        @if($favoris->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($favoris as $favori)
                    <x-product-card :product="$favori->produit" />
                @endforeach
            </div>
        @else
            <div class="max-w-md mx-auto text-center py-20">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-slate-200 mx-auto mb-8 shadow-xl shadow-slate-200/50">
                    <i class="fas fa-heart text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-primary-900 mb-4 tracking-tight">Votre liste est vide</h3>
                <p class="text-slate-500 font-medium mb-8">Parcourez nos produits et ajoutez vos articles préférés à vos favoris.</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-500 text-white font-black rounded-2xl shadow-lg shadow-primary-500/30 hover:scale-105 transition-all uppercase tracking-widest text-sm">
                    Découvrir la boutique <i class="fas fa-shopping-bag"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
