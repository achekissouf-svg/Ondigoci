@extends('layouts.app')

@section('title', 'Informations Légales')

@section('content')
<div class="bg-slate-50 min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-slate-100">
                <h1 class="text-4xl font-black text-primary-900 mb-12 tracking-tighter">Informations Légales</h1>
                
                <div class="space-y-12">
                    <section>
                        <h2 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-3">
                            <span class="w-8 h-8 bg-primary-50 text-primary-500 rounded-lg flex items-center justify-center text-xs">01</span>
                            Mentions Légales
                        </h2>
                        <div class="text-slate-500 text-sm leading-relaxed space-y-4">
                            <p>Ondigoci est une plateforme opérée par [Nom de l'entreprise], SARL au capital de [Montant] FCFA.</p>
                            <p><strong>Siège social :</strong> Abidjan, Côte d'Ivoire.</p>
                            <p><strong>RCCM :</strong> CI-ABJ-03-2026-B12-XXXXX</p>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-3">
                            <span class="w-8 h-8 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xs">02</span>
                            Conditions d'Utilisation
                        </h2>
                        <div class="text-slate-500 text-sm leading-relaxed">
                            <p>L'utilisation de la plateforme Ondigoci implique l'acceptation pleine et entière des conditions générales d'utilisation. Ces conditions visent à définir les modalités de mise à disposition des services de la plateforme.</p>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 text-emerald-500 rounded-lg flex items-center justify-center text-xs">03</span>
                            Politique de Confidentialité
                        </h2>
                        <div class="text-slate-500 text-sm leading-relaxed">
                            <p>Nous accordons une importance capitale à la protection de vos données personnelles. Les informations collectées lors de vos commandes sont utilisées exclusivement pour le traitement de celles-ci et l'amélioration de nos services.</p>
                        </div>
                    </section>
                </div>

                <div class="mt-16 pt-8 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-medium">Dernière mise à jour : 04 Mai 2026</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
