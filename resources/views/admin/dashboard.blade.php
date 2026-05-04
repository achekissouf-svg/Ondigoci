@extends('layouts.admin')

@section('header_title', 'Tableau de Bord')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Bonjour, {{ Auth::user()->name }} 👋</h2>
    <p class="text-slate-500 font-bold mt-1">Voici un aperçu des performances d'Ondigoci aujourd'hui.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Total Clients -->
    <div class="group p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-primary-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-primary-500 flex items-center justify-center text-white mb-6 shadow-lg shadow-primary-500/30">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Clients</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['total_clients']) }}</h3>
            <div class="mt-6">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-primary-500 hover:text-primary-600 group-hover:translate-x-1 transition-all uppercase tracking-tighter">
                    Gérer <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Boutiques en attente -->
    <div class="group p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-orange-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-orange-500 flex items-center justify-center text-white mb-6 shadow-lg shadow-orange-500/30">
                <i class="fas fa-store text-2xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">En Attente</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['boutiques_attente'] }}</h3>
            <div class="mt-6">
                <a href="{{ route('admin.boutiques.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-orange-500 hover:text-orange-600 group-hover:translate-x-1 transition-all uppercase tracking-tighter">
                    Valider <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Produits -->
    <div class="group p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-blue-900 flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-900/30">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Produits</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($stats['total_produits']) }}</h3>
            <div class="mt-6">
                <a href="{{ route('admin.produits.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-blue-900 hover:text-blue-700 group-hover:translate-x-1 transition-all uppercase tracking-tighter">
                    Stock <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Commandes -->
    <div class="group p-8 rounded-[2rem] bg-primary-900 text-white shadow-xl shadow-primary-900/20 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden border border-white/5">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-orange-500 flex items-center justify-center text-white mb-6 shadow-lg shadow-orange-500/30">
                <i class="fas fa-receipt text-2xl"></i>
            </div>
            <p class="text-[10px] font-black text-primary-200/50 uppercase tracking-[0.2em] mb-2">Commandes</p>
            <h3 class="text-4xl font-black text-white tracking-tighter">Gérer</h3>
            <div class="mt-6">
                <a href="{{ route('admin.commandes.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-orange-400 hover:text-orange-300 group-hover:translate-x-1 transition-all uppercase tracking-tighter">
                    Liste <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Quick Actions -->
    <div class="p-10 rounded-[2.5rem] bg-gradient-to-br from-primary-600 to-primary-900 text-white shadow-2xl relative overflow-hidden border border-white/10">
        <div class="absolute top-0 right-0 p-12 opacity-10 rotate-12">
            <i class="fas fa-bolt text-[10rem]"></i>
        </div>
        <h4 class="text-2xl font-black mb-8 flex items-center gap-3">
            <span class="w-3 h-10 bg-orange-500 rounded-full shadow-lg shadow-orange-500/50"></span>
            Actions Rapides
        </h4>
        <div class="grid grid-cols-2 gap-5 relative z-10">
            <a href="{{ route('admin.categories.index') }}" class="p-6 rounded-3xl bg-white/10 border border-white/10 hover:bg-white hover:text-primary-600 transition-all duration-300 group shadow-lg">
                <div class="w-12 h-12 rounded-2xl bg-white/20 group-hover:bg-primary-100 flex items-center justify-center text-white group-hover:text-primary-500 mb-4 transition-colors">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <p class="font-black text-sm tracking-tight">Catégories</p>
                <p class="text-[10px] opacity-60 group-hover:opacity-100 font-bold uppercase tracking-widest mt-1">Gérer le catalogue</p>
            </a>
            <a href="{{ route('admin.avis.index') }}" class="p-6 rounded-3xl bg-white/10 border border-white/10 hover:bg-white hover:text-amber-600 transition-all duration-300 group shadow-lg">
                <div class="w-12 h-12 rounded-2xl bg-white/20 group-hover:bg-amber-100 flex items-center justify-center text-white group-hover:text-amber-500 mb-4 transition-colors">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <p class="font-black text-sm tracking-tight">Avis Clients</p>
                <p class="text-[10px] opacity-60 group-hover:opacity-100 font-bold uppercase tracking-widest mt-1">Modérer les retours</p>
            </a>
            <a href="{{ url('/') }}" target="_blank" class="p-6 rounded-3xl bg-white/10 border border-white/10 hover:bg-white hover:text-slate-900 transition-all duration-300 group shadow-lg col-span-2">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 group-hover:bg-slate-100 flex items-center justify-center text-white group-hover:text-slate-900 transition-colors">
                        <i class="fas fa-external-link-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="font-black text-sm tracking-tight">Visiter la boutique publique</p>
                        <p class="text-[10px] opacity-60 group-hover:opacity-100 font-bold uppercase tracking-widest mt-0.5">Voir le rendu final</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="p-10 rounded-[2.5rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col justify-center relative overflow-hidden group">
        <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="relative z-10">
            <span class="px-3 py-1 rounded-lg bg-orange-50 text-orange-600 text-[10px] font-black uppercase tracking-widest mb-6 inline-block">Conseil du jour</span>
            <h4 class="text-3xl font-black text-slate-900 mb-6 leading-tight tracking-tight">Optimisez votre gestion quotidienne</h4>
            <p class="text-slate-500 mb-8 font-medium leading-relaxed text-lg">
                N'oubliez pas de vérifier régulièrement les <span class="text-orange-500 font-black">boutiques en attente</span>. Une validation rapide améliore l'expérience vendeur et enrichit votre catalogue.
            </p>
            <div class="flex items-center gap-6">
                <div class="flex -space-x-3">
                    @for($i=0; $i<4; $i++)
                        <div class="w-10 h-10 rounded-full border-4 border-white bg-slate-200 shadow-sm flex items-center justify-center text-[10px] font-bold text-slate-400">
                            {{ $i + 1 }}
                        </div>
                    @endfor
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">+25 nouveaux vendeurs ce mois</p>
            </div>
        </div>
    </div>
</div>
@endsection
