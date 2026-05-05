@extends('layouts.app')

@section('title', 'Abonnements Boutique')

@section('content')
<div class="bg-slate-50 min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-black text-primary-900 tracking-tighter mb-6">Boostez votre visibilité</h1>
            <p class="text-slate-500 text-lg font-medium">Choisissez le plan qui correspond à vos ambitions et profitez d'avantages exclusifs.</p>
        </div>

        @if(session('error'))
            <div class="max-w-4xl mx-auto bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl mb-12 font-bold flex items-center gap-3">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Plan Gratuit -->
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center relative overflow-hidden group">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-400 mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-seedling text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2 uppercase tracking-widest">Gratuit</h3>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-black text-slate-900">0</span>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">FCFA / mois</span>
                </div>
                <ul class="space-y-4 mb-10 flex-1">
                    <li class="flex items-center gap-3 text-slate-500 text-sm font-medium"><i class="fas fa-check text-emerald-500"></i> Jusqu'à 5 produits</li>
                    <li class="flex items-center gap-3 text-slate-500 text-sm font-medium"><i class="fas fa-check text-emerald-500"></i> Support par email</li>
                    <li class="flex items-center gap-3 text-slate-300 text-sm font-medium"><i class="fas fa-times"></i> Badge Vérifié</li>
                    <li class="flex items-center gap-3 text-slate-300 text-sm font-medium"><i class="fas fa-times"></i> Ventes Flash</li>
                </ul>
                <div class="w-full py-4 bg-slate-50 text-slate-400 font-black rounded-2xl text-xs uppercase tracking-widest border border-slate-100">
                    {{ $boutique->type_abonnement === 'gratuit' ? 'Plan Actuel' : 'Inclus par défaut' }}
                </div>
            </div>

            <!-- Plan Standard -->
            <div class="bg-white p-10 rounded-[3rem] border-4 border-primary-500 shadow-2xl shadow-primary-500/20 flex flex-col items-center text-center relative overflow-hidden group scale-105 z-10">
                <div class="absolute top-6 right-6 px-3 py-1 bg-primary-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest">Populaire</div>
                <div class="w-20 h-20 bg-primary-50 rounded-[2rem] flex items-center justify-center text-primary-500 mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-gem text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-primary-900 mb-2 uppercase tracking-widest">Standard</h3>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-black text-primary-600">50 000</span>
                    <span class="text-xs font-black text-primary-300 uppercase tracking-widest">FCFA / mois</span>
                </div>
                <ul class="space-y-4 mb-10 flex-1">
                    <li class="flex items-center gap-3 text-slate-600 text-sm font-bold"><i class="fas fa-check text-primary-500"></i> Produits Illimités</li>
                    <li class="flex items-center gap-3 text-slate-600 text-sm font-bold"><i class="fas fa-check text-primary-500"></i> Badge "Vendeur Vérifié"</li>
                    <li class="flex items-center gap-3 text-slate-600 text-sm font-bold"><i class="fas fa-check text-primary-500"></i> Support Prioritaire</li>
                    <li class="flex items-center gap-3 text-slate-600 text-sm font-bold"><i class="fas fa-check text-primary-500"></i> Ventes Flash</li>
                </ul>
                @if($boutique->type_abonnement === 'standard')
                    <div class="w-full py-4 bg-primary-50 text-primary-600 font-black rounded-2xl text-xs uppercase tracking-widest border border-primary-100">
                        Votre Plan Actuel
                    </div>
                @else
                    <form action="{{ route('boutique.subscription.pay') }}" method="POST" class="w-full mb-3">
                        @csrf
                        <input type="hidden" name="plan" value="standard">
                        <button type="submit" class="w-full py-4 bg-primary-500 text-white font-black rounded-2xl text-xs uppercase tracking-widest shadow-lg shadow-primary-500/30 hover:scale-105 transition-all">
                            Paiement Automatique <i class="fas fa-bolt ms-2"></i>
                        </button>
                    </form>
                    <a href="{{ route('boutique.payment.manual', ['plan' => 'standard']) }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary-500 transition-colors">
                        Ou Payer Manuellement <i class="fas fa-hand-holding-usd ms-1"></i>
                    </a>
@endif

            </div>

            <!-- Plan Premium -->
            <div class="bg-primary-900 p-10 rounded-[3rem] shadow-sm flex flex-col items-center text-center relative overflow-hidden group">
                <div class="w-20 h-20 bg-white/5 rounded-[2rem] flex items-center justify-center text-amber-400 mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-crown text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-white mb-2 uppercase tracking-widest">Premium</h3>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-black text-white">75 000</span>
                    <span class="text-xs font-black text-primary-300 uppercase tracking-widest">FCFA / mois</span>
                </div>
                <ul class="space-y-4 mb-10 flex-1">
                    <li class="flex items-center gap-3 text-primary-100/60 text-sm font-medium"><i class="fas fa-check text-amber-400"></i> Tout le pack Standard</li>
                    <li class="flex items-center gap-3 text-primary-100/60 text-sm font-medium"><i class="fas fa-check text-amber-400"></i> Sponsoring Automatique</li>
                    <li class="flex items-center gap-3 text-primary-100/60 text-sm font-medium"><i class="fas fa-check text-amber-400"></i> Analyse de Ventes Avancée</li>
                    <li class="flex items-center gap-3 text-primary-100/60 text-sm font-medium"><i class="fas fa-check text-amber-400"></i> Compte Account Manager</li>
                </ul>
                @if($boutique->type_abonnement === 'premium')
                    <div class="w-full py-4 bg-white/5 text-amber-400 font-black rounded-2xl text-xs uppercase tracking-widest border border-white/10">
                        Votre Plan Actuel
                    </div>
                @else
                    <form action="{{ route('boutique.subscription.pay') }}" method="POST" class="w-full mb-3">
                        @csrf
                        <input type="hidden" name="plan" value="premium">
                        <button type="submit" class="w-full py-4 bg-amber-400 text-primary-900 font-black rounded-2xl text-xs uppercase tracking-widest shadow-lg shadow-amber-400/20 hover:scale-105 transition-all">
                            Paiement Automatique <i class="fas fa-bolt ms-2"></i>
                        </button>
                    </form>
                    <a href="{{ route('boutique.payment.manual', ['plan' => 'premium']) }}" class="text-[10px] font-black text-primary-300 uppercase tracking-widest hover:text-white transition-colors">
                        Ou Payer Manuellement <i class="fas fa-hand-holding-usd ms-1"></i>
                    </a>
@endif

            </div>
        </div>
    </div>
</div>
@endsection
