@extends('layouts.app')

@section('title', 'Tableau de bord Boutique')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-primary-900 tracking-tighter mb-2">Tableau de bord Vendeur</h1>
                <p class="text-slate-500 font-medium">Ravi de vous revoir, <span class="text-primary-500 font-bold">{{ Auth::user()->name }}</span>.</p>
            </div>
            @if($boutique)
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('boutique.subscription.index') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-primary-500 text-white font-black rounded-2xl shadow-lg shadow-primary-500/20 hover:bg-primary-600 transition-all uppercase tracking-widest text-xs">
                        <i class="fas fa-crown"></i> Gérer mon abonnement
                    </a>
                    <a href="{{ route('magasin.show', $boutique->id) }}" class="inline-flex items-center gap-3 px-6 py-3 bg-white text-primary-500 font-black rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all uppercase tracking-widest text-xs">
                        <i class="fas fa-eye"></i> Voir ma boutique publique
                    </a>
                </div>
            @endif

        </div>

        @if(!$boutique)
            <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex items-center gap-4 text-amber-800 shadow-sm">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
                <p class="font-bold">Votre boutique est en attente de configuration ou d'approbation par l'administrateur.</p>
            </div>
        @else
            <!-- KPIs Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Chiffre d'affaires -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                            <i class="fas fa-wallet text-xl"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Ventes Livrées</p>
                    <h3 class="text-2xl font-black text-slate-900 leading-none">
                        {{ number_format($chiffreAffaires, 0, ',', ' ') }} <small class="text-xs text-slate-400 font-bold">FCFA</small>
                    </h3>
                </div>

                <!-- Commandes -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-all">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        @if($commandesEnAttente > 0)
                            <span class="px-3 py-1 bg-orange-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-orange-500/20">
                                {{ $commandesEnAttente }} NEW
                            </span>
                        @endif
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Commandes Totales</p>
                    <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $totalCommandes }}</h3>
                </div>

                <!-- Produits -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Produits Actifs</p>
                    <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $totalProduits }}</h3>
                </div>

                <!-- Note -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Note Moyenne</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $boutique->note_moyenne }}</h3>
                        <small class="text-xs font-bold text-slate-400">/ 5 ({{ $boutique->avis->count() }} avis)</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Analytics Chart -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <h4 class="text-xl font-black text-primary-900 tracking-tight">Ventes (7 derniers jours)</h4>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenus en FCFA</span>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-4">
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Raccourcis</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('boutique.produits.index') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:border-primary-500 transition-all text-center group">
                            <div class="text-primary-500 mb-3 group-hover:scale-110 transition-transform"><i class="fas fa-boxes-stacked text-2xl"></i></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Mes Produits</span>
                        </a>
                        <a href="{{ route('boutique.commandes.index') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:border-orange-500 transition-all text-center group">
                            <div class="text-orange-500 mb-3 group-hover:scale-110 transition-transform"><i class="fas fa-receipt text-2xl"></i></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Commandes</span>
                        </a>
                        <a href="{{ route('boutique.promotions.index') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:border-rose-500 transition-all text-center group">
                            <div class="text-rose-500 mb-3 group-hover:scale-110 transition-transform"><i class="fas fa-bolt text-2xl"></i></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Promotions</span>
                        </a>
                        <a href="{{ route('chat.index') }}" class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:border-indigo-500 transition-all text-center group relative">
                            <div class="text-indigo-500 mb-3 group-hover:scale-110 transition-transform"><i class="fas fa-comment-dots text-2xl"></i></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Messages</span>
                            @if(isset($unreadChat) && $unreadChat > 0)
                                <span class="absolute top-4 right-4 w-5 h-5 bg-orange-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-bounce">
                                    {{ $unreadChat }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>



            <!-- Recent Orders Table -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h4 class="text-xl font-black text-primary-900 tracking-tight">Commandes Récentes</h4>
                    <a href="{{ route('boutique.commandes.index') }}" class="text-xs font-black text-primary-500 uppercase tracking-widest hover:text-orange-500 transition-colors">Voir tout</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-4 text-left">Client / Contact</th>
                                <th class="px-8 py-4 text-left">Article</th>
                                <th class="px-8 py-4 text-center">Quantité</th>
                                <th class="px-8 py-4 text-right">Total</th>
                                <th class="px-8 py-4 text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentesCommandes as $ligne)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <p class="font-bold text-slate-700 leading-tight mb-1">{{ $ligne->commande->user->name ?? 'Client anonyme' }}</p>
                                        <p class="text-[10px] font-black text-primary-500 tracking-widest uppercase">{{ $ligne->commande->telephone_commande ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-sm font-medium text-slate-600">{{ Str::limit($ligne->produit->nom_produit ?? 'Produit inconnu', 30) }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-sm font-black text-slate-400 bg-slate-100 px-3 py-1 rounded-lg">{{ $ligne->quantite_ligne_commande }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-right font-black text-primary-500 text-sm">
                                        {{ number_format($ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande, 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @php $statut = $ligne->commande->statut_commande ?? 'en_attente'; @endphp
                                        @if($statut === 'livree')
                                            <span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded-full uppercase">Livrée</span>
                                        @elseif($statut === 'en_livraison')
                                            <span class="inline-flex px-3 py-1 bg-blue-100 text-blue-600 text-[10px] font-black rounded-full uppercase">En route</span>
                                        @elseif($statut === 'en_preparation')
                                            <span class="inline-flex px-3 py-1 bg-primary-100 text-primary-600 text-[10px] font-black rounded-full uppercase">Préparation</span>
                                        @elseif(in_array($statut, ['annulee', 'rejetee']))
                                            <span class="inline-flex px-3 py-1 bg-rose-100 text-rose-600 text-[10px] font-black rounded-full uppercase">Annulée</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 bg-orange-100 text-orange-600 text-[10px] font-black rounded-full uppercase">Attente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium italic">
                                        Aucune commande pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Ventes',
                data: {!! json_encode($ventesParJour) !!},
                borderColor: '#1e5a9e',
                backgroundColor: 'rgba(30, 90, 158, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1e5a9e',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8',
                        callback: function(value) {
                            if (value >= 1000) return (value/1000) + 'k';
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection

