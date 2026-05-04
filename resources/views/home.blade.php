@extends('layouts.app')

@section('title', 'Votre Shopping Livré en un Clic')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Categories (Visible by default on Home) -->
            <aside class="w-full lg:w-72 flex-shrink-0 hidden lg:block">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="bg-primary-500 p-6">
                        <h3 class="text-white font-black uppercase tracking-widest text-xs flex items-center gap-3">
                            <i class="fas fa-th-large"></i> Catégories
                        </h3>
                    </div>
                    <nav class="p-4">
                        <ul class="space-y-1">
                            @if(isset($layoutCategories))
                                @foreach($layoutCategories as $cat)
                                    <li>
                                        <a href="{{ route('shop', ['q' => $cat->libel_categorie]) }}" 
                                           class="flex items-center justify-between p-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-primary-50 hover:text-primary-600 transition-all group">
                                            {{ $cat->libel_categorie }}
                                            <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                </div>

                <!-- Promo Banner Sidebar -->
                <div class="mt-6 rounded-[2rem] bg-gradient-to-br from-orange-500 to-rose-600 p-8 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-2 opacity-80">Offre Spéciale</p>
                        <h4 class="text-xl font-black mb-4">-20% sur la Mode</h4>
                        <a href="{{ route('shop') }}" class="inline-block px-6 py-2 bg-white text-orange-600 text-xs font-black rounded-xl uppercase tracking-widest hover:scale-105 transition-transform">Voir plus</a>
                    </div>
                    <i class="fas fa-shopping-bag absolute -bottom-4 -right-4 text-7xl opacity-10 group-hover:rotate-12 transition-transform"></i>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 min-w-0">
                <!-- Hero Section -->
                <div class="relative rounded-[2.5rem] bg-slate-900 h-[400px] lg:h-[500px] overflow-hidden shadow-2xl group">
                    <!-- Background Visuals -->
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-900 via-primary-900/80 to-transparent z-10"></div>
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop" 
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                    
                    <!-- Hero Content -->
                    <div class="relative z-20 h-full flex flex-col justify-center px-8 lg:px-16 max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500/20 text-orange-400 rounded-full mb-6 w-fit backdrop-blur-sm border border-orange-500/20">
                            <i class="fas fa-bolt text-xs"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Nouveautés 2026</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 leading-tight tracking-tighter">
                            Achetez local, <br>Vivez <span class="text-orange-500">Mieux</span>.
                        </h1>
                        <p class="text-lg text-slate-300 mb-10 font-medium">
                            Découvrez des produits authentiques sélectionnés parmi les meilleures boutiques de Côte d'Ivoire.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('shop') }}" class="px-8 py-4 bg-orange-500 text-white font-black rounded-2xl hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/25 uppercase tracking-widest flex items-center gap-3">
                                Explorer le catalogue <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('boutique.register') }}" class="px-8 py-4 bg-white/10 text-white font-black rounded-2xl hover:bg-white/20 transition-all backdrop-blur-md uppercase tracking-widest border border-white/10">
                                Devenir Vendeur
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats/Advantages Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                    <div class="p-6 rounded-[2rem] bg-primary-50 border border-primary-100 flex flex-col items-center text-center group hover:bg-primary-500 transition-all duration-500">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h5 class="text-xs font-black uppercase tracking-widest text-primary-900 group-hover:text-white mb-1">Livraison Express</h5>
                        <p class="text-[10px] font-bold text-primary-500/60 group-hover:text-white/60 uppercase">Partout en CI</p>
                    </div>
                    <div class="p-6 rounded-[2rem] bg-orange-50 border border-orange-100 flex flex-col items-center text-center group hover:bg-orange-500 transition-all duration-500">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-orange-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h5 class="text-xs font-black uppercase tracking-widest text-orange-900 group-hover:text-white mb-1">Paiement Sécurisé</h5>
                        <p class="text-[10px] font-bold text-orange-500/60 group-hover:text-white/60 uppercase">100% Garanti</p>
                    </div>
                    <div class="p-6 rounded-[2rem] bg-slate-50 border border-slate-100 flex flex-col items-center text-center group hover:bg-slate-900 transition-all duration-500">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-slate-900 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="text-xs font-black uppercase tracking-widest text-slate-900 group-hover:text-white mb-1">Support H24</h5>
                        <p class="text-[10px] font-bold text-slate-500/60 group-hover:text-white/60 uppercase">Service Client</p>
                    </div>
                    <div class="p-6 rounded-[2rem] bg-emerald-50 border border-emerald-100 flex flex-col items-center text-center group hover:bg-emerald-500 transition-all duration-500">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-emerald-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h5 class="text-xs font-black uppercase tracking-widest text-emerald-900 group-hover:text-white mb-1">Produits Certifiés</h5>
                        <p class="text-[10px] font-bold text-emerald-500/60 group-hover:text-white/60 uppercase">Haute Qualité</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mt-20">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-black tracking-tighter text-slate-900 mb-2">Sélection en Vedette</h2>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Nos meilleures recommandations</p>
                </div>
                <a href="{{ route('shop') }}" class="text-sm font-black text-primary-500 hover:text-orange-500 transition-colors uppercase tracking-widest flex items-center gap-2">
                    Voir tout le shop <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            @if(isset($featuredProducts) && count($featuredProducts) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-6 shadow-sm">
                        <i class="fas fa-store-slash text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-slate-900 mb-2">Pas de produits en vedette</h4>
                    <p class="text-slate-400 font-medium">Revenez bientôt pour nos nouveautés !</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection



