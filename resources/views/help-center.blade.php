@extends('layouts.app')

@section('title', 'Centre d\'aide')

@section('content')
<div class="bg-slate-50 min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-5xl font-black text-primary-900 mb-6 tracking-tighter">Centre d'aide</h1>
                <p class="text-lg text-slate-500 font-medium">Comment pouvons-nous vous aider aujourd'hui ?</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 mb-6 group-hover:bg-orange-500 group-hover:text-white transition-all">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4">Commandes & Achats</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Tout ce que vous devez savoir sur le processus d'achat et le suivi de vos colis.</p>
                    <a href="#" class="text-orange-500 font-black text-xs uppercase tracking-widest flex items-center gap-2">En savoir plus <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center text-primary-500 mb-6 group-hover:bg-primary-500 group-hover:text-white transition-all">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4">Vendre sur Ondigoci</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Guide complet pour les boutiques : inscription, gestion des produits et paiements.</p>
                    <a href="#" class="text-primary-500 font-black text-xs uppercase tracking-widest flex items-center gap-2">En savoir plus <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-100">
                <h2 class="text-2xl font-black text-slate-900 mb-8 tracking-tight">Questions Fréquentes</h2>
                <div class="space-y-6">
                    <div class="pb-6 border-b border-slate-100">
                        <h4 class="font-bold text-slate-900 mb-2">Comment puis-je suivre ma commande ?</h4>
                        <p class="text-slate-500 text-sm">Vous pouvez suivre votre commande dans la section "Mes Commandes" de votre profil.</p>
                    </div>
                    <div class="pb-6 border-b border-slate-100">
                        <h4 class="font-bold text-slate-900 mb-2">Quels sont les délais de livraison ?</h4>
                        <p class="text-slate-500 text-sm">La livraison s'effectue généralement sous 24h à 48h selon votre localisation en Côte d'Ivoire.</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Comment devenir vendeur ?</h4>
                        <p class="text-slate-500 text-sm">Cliquez sur "Devenir Vendeur" dans le menu et suivez les étapes d'inscription de votre boutique.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
