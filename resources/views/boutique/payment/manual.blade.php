@extends('layouts.app')

@section('title', 'Confirmation de Paiement')

@section('content')
<div class="bg-slate-50 min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="bg-primary-900 p-10 text-white text-center">
                    <h2 class="text-3xl font-black tracking-tight mb-2 uppercase">Paiement Manuel</h2>
                    <p class="text-primary-300 font-medium italic">Veuillez envoyer le montant exact sur l'un de nos numéros ci-dessous.</p>
                </div>

                <div class="p-10">
                    <!-- Numbers Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                        <div class="p-6 bg-orange-50 rounded-3xl border border-orange-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-500 shadow-sm">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest leading-none mb-1">Orange Money</p>
                                <p class="text-sm font-black text-slate-800">07 02 44 85 92</p>
                            </div>
                        </div>
                        <div class="p-6 bg-yellow-50 rounded-3xl border border-yellow-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-yellow-500 shadow-sm">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-yellow-600 uppercase tracking-widest leading-none mb-1">MTN MoMо</p>
                                <p class="text-sm font-black text-slate-800">05 76 15 67 37</p>
                            </div>
                        </div>
                        <div class="p-6 bg-sky-50 rounded-3xl border border-sky-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1dcad3] rounded-2xl flex items-center justify-center shadow-sm overflow-hidden p-1">
                                <!-- Wave Stylized Penguin SVG -->
                                <svg viewBox="0 0 64 64" class="w-10 h-10">
                                    <path d="M32 4C18.7 4 8 14.7 8 28c0 5.1 1.6 9.8 4.3 13.7l-4.1 15.3 16.1-4.3c3.7 1.9 7.9 3 12.3 3 13.3 0 24-10.7 24-24S45.3 4 32 4z" fill="white"/>
                                    <circle cx="24" cy="24" r="3" fill="#1dcad3"/>
                                    <circle cx="40" cy="24" r="3" fill="#1dcad3"/>
                                    <path d="M32 32c-3 0-5.5 2.5-5.5 5.5S29 43 32 43s5.5-2.5 5.5-5.5-2.5-5.5-5.5-5.5z" fill="#ff9800"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-sky-600 uppercase tracking-widest leading-none mb-1">Wave</p>
                                <p class="text-sm font-black text-slate-800">05 76 15 67 37</p>
                            </div>
                        </div>


                    </div>


                    <form action="{{ route('boutique.payment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan }}">
                        <input type="hidden" name="montant" value="{{ $amount }}">

                        <div class="mb-8 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-slate-500">Plan sélectionné</span>
                                <span class="px-3 py-1 bg-primary-500 text-white text-[10px] font-black rounded-lg uppercase tracking-widest">{{ $plan }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-500">Montant à payer</span>
                                <span class="text-2xl font-black text-primary-900">{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ps-2">Moyen utilisé pour le transfert</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="moyen_paiement" value="Orange Money" class="peer hidden" required>
                                    <div class="p-4 border-2 border-slate-50 rounded-2xl text-center font-black text-[10px] uppercase tracking-widest text-slate-400 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-600 transition-all">
                                        Orange
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="moyen_paiement" value="MTN MoMo" class="peer hidden">
                                    <div class="p-4 border-2 border-slate-50 rounded-2xl text-center font-black text-[10px] uppercase tracking-widest text-slate-400 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-600 transition-all">
                                        MTN
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="moyen_paiement" value="Wave" class="peer hidden">
                                    <div class="p-4 border-2 border-slate-50 rounded-2xl text-center font-black text-[10px] uppercase tracking-widest text-slate-400 peer-checked:border-sky-500 peer-checked:bg-sky-50 peer-checked:text-sky-600 transition-all">
                                        Wave
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ps-2">Référence de la transaction</label>
                            <input type="text" name="reference" placeholder="Ex: ID Transaction, Numero expediteur..." required 
                                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 font-bold text-slate-800 focus:ring-2 focus:ring-primary-500 transition-all">
                        </div>


                        <div class="mb-10">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ps-2">Capture d'écran (Preuve)</label>
                            <div class="relative group">
                                <input type="file" name="capture_ecran" id="proofInput" required accept="image/*"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="w-full border-2 border-dashed border-slate-200 rounded-3xl py-12 text-center group-hover:border-primary-500 transition-all bg-slate-50 group-hover:bg-primary-50">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm group-hover:text-primary-500 transition-all">
                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                    </div>
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest group-hover:text-primary-900 transition-all" id="fileName">Télécharger la capture d'écran</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-5 bg-primary-900 text-white font-black rounded-3xl shadow-xl shadow-primary-900/20 hover:scale-[1.02] transition-all uppercase tracking-[0.2em] text-sm">
                            Confirmer mon paiement <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-8 text-slate-400 text-xs font-medium">
                En soumettant ce formulaire, vous certifiez avoir effectué le paiement. <br>
                Toute fausse déclaration entraînera la suspension de votre boutique.
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('proofInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0].name;
        document.getElementById('fileName').innerText = fileName;
        document.getElementById('fileName').classList.remove('text-slate-400');
        document.getElementById('fileName').classList.add('text-primary-600');
    });
</script>
@endsection
