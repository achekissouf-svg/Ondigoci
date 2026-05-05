@extends('layouts.app')

@section('title', 'Vérification de la Boutique')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-12 text-center">
                <h1 class="text-3xl lg:text-5xl font-black text-primary-900 tracking-tighter mb-4">Vérification d'Identité</h1>
                <p class="text-slate-500 font-medium">Garantissez la confiance de vos clients en certifiant votre boutique.</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-3xl mb-10 font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Status Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 sticky top-24">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Statut actuel</p>
                        
                        @if($boutique->statut_verification === 'approuve')
                            <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100 text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-emerald-500 mx-auto mb-4 shadow-sm">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                                <h3 class="font-black text-emerald-600 uppercase text-xs tracking-widest">Boutique Vérifiée</h3>
                            </div>
                        @elseif($boutique->statut_verification === 'en_attente')
                            <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100 text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-amber-500 mx-auto mb-4 shadow-sm animate-pulse">
                                    <i class="fas fa-clock text-2xl"></i>
                                </div>
                                <h3 class="font-black text-amber-600 uppercase text-xs tracking-widest">En cours d'examen</h3>
                            </div>
                        @elseif($boutique->statut_verification === 'rejete')
                            <div class="p-6 bg-rose-50 rounded-3xl border border-rose-100 text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-rose-500 mx-auto mb-4 shadow-sm">
                                    <i class="fas fa-times-circle text-2xl"></i>
                                </div>
                                <h3 class="font-black text-rose-600 uppercase text-xs tracking-widest">Demande rejetée</h3>
                                <p class="text-[10px] mt-4 text-rose-400 font-bold italic">{{ $boutique->motif_rejet }}</p>
                            </div>
                        @else
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                                    <i class="fas fa-user-shield text-2xl"></i>
                                </div>
                                <h3 class="font-black text-slate-400 uppercase text-xs tracking-widest">Non vérifiée</h3>
                            </div>
                        @endif

                        <div class="mt-8 space-y-4">
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <i class="fas fa-id-card text-primary-500 w-5"></i> Pièce d'identité
                            </div>
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <i class="fas fa-home text-primary-500 w-5"></i> Preuve de résidence
                            </div>
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <i class="fas fa-map-marker-alt text-primary-500 w-5"></i> Localisation GPS
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Area -->
                <div class="lg:col-span-2">
                    @if($boutique->statut_verification === 'non_verifie' || $boutique->statut_verification === 'rejete')
                        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                            <form action="{{ route('boutique.verification.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-10">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 ps-2">1. Pièce d'Identité (CNI, Passeport, Permis)</label>
                                    <div class="relative group">
                                        <input type="file" name="piece_identite" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 text-center group-hover:border-primary-500 transition-all bg-slate-50">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 mb-2"></i>
                                            <p class="text-xs font-bold text-slate-400 group-hover:text-primary-500">Cliquez pour télécharger le document</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-10">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 ps-2">2. Justificatif de domicile (Facture CIE/SODECI de -3 mois)</label>
                                    <div class="relative group">
                                        <input type="file" name="justificatif_domicile" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 text-center group-hover:border-primary-500 transition-all bg-slate-50">
                                            <i class="fas fa-file-invoice text-2xl text-slate-300 mb-2"></i>
                                            <p class="text-xs font-bold text-slate-400 group-hover:text-primary-500">Cliquez pour télécharger le document</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-12 p-6 bg-primary-50 rounded-3xl border border-primary-100 flex items-start gap-4">
                                    <i class="fas fa-info-circle text-primary-500 mt-1"></i>
                                    <p class="text-xs text-primary-800 font-medium leading-relaxed">
                                        En soumettant ces documents, vous confirmez que les informations fournies sont exactes. L'examen peut prendre entre 24h et 48h.
                                    </p>
                                </div>

                                <button type="submit" class="w-full py-5 bg-primary-900 text-white font-black rounded-3xl shadow-xl shadow-primary-900/20 hover:scale-[1.02] transition-all uppercase tracking-[0.2em] text-sm">
                                    Soumettre mon dossier <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-[2.5rem] p-12 shadow-sm border border-slate-100 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-primary-500 mx-auto mb-8">
                                <i class="fas fa-shield-alt text-3xl"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 mb-4 tracking-tight">Merci pour votre confiance !</h2>
                            <p class="text-slate-500 font-medium leading-relaxed">
                                @if($boutique->statut_verification === 'en_attente')
                                    Nos agents examinent actuellement vos documents. Vous recevrez une notification dès que votre compte sera certifié.
                                @else
                                    Votre boutique est officiellement certifiée ! Vous bénéficiez d'une visibilité accrue et de la confiance totale de vos clients.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
