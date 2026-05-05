@extends('layouts.app')

@section('title', 'Aide & Support')

@section('content')
<div class="bg-white min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-500 rounded-full mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest">Support Client 24/7</span>
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-black text-primary-900 mb-8 tracking-tighter leading-tight">Nous sommes là pour <span class="text-orange-500">vous</span>.</h1>
                    <p class="text-lg text-slate-500 mb-10 leading-relaxed">
                        Besoin d'aide pour une commande, un retour ou une question technique ? Notre équipe est disponible pour vous accompagner.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="p-6 rounded-[2rem] bg-slate-50 border border-slate-100">
                            <i class="fas fa-phone-alt text-2xl text-orange-500 mb-4"></i>
                            <h4 class="font-black text-slate-900 mb-2">Par Téléphone</h4>
                            <p class="text-sm text-slate-500 mb-4">Appelez-nous directement pour une assistance rapide.</p>
                            <p class="font-bold text-primary-500">+225 05 76 15 67 37</p>
                        </div>
                        <div class="p-6 rounded-[2rem] bg-slate-50 border border-slate-100">
                            <i class="fab fa-whatsapp text-2xl text-emerald-500 mb-4"></i>
                            <h4 class="font-black text-slate-900 mb-2">WhatsApp</h4>
                            <p class="text-sm text-slate-500 mb-4">Discutez avec nous instantanément sur WhatsApp.</p>
                            <a href="https://wa.me/2250576156737" class="font-bold text-emerald-500 hover:underline">Démarrer la discussion</a>
                        </div>
                    </div>
                </div>
                <div class="flex-1 w-full lg:w-auto">
                    <div class="bg-primary-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                        <h3 class="text-2xl font-black mb-8 relative z-10">Envoyez-nous un message</h3>
                        <form action="#" class="space-y-4 relative z-10">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-primary-100/50 mb-2 block">Nom Complet</label>
                                <input type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-orange-500 outline-none transition-all" placeholder="Votre nom">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-primary-100/50 mb-2 block">Email</label>
                                <input type="email" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-orange-500 outline-none transition-all" placeholder="votre@email.com">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-primary-100/50 mb-2 block">Message</label>
                                <textarea rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-orange-500 outline-none transition-all" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                            </div>
                            <button class="w-full py-4 bg-orange-500 text-white font-black rounded-2xl hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 uppercase tracking-widest">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
