<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\LigneCommande;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();

        if (!$boutique) {
            return view('boutique.dashboard', ['boutique' => null]);
        }

        // Stats des produits
        $totalProduits = $boutique->produits()->count();

        // Stats des commandes (lignes de commande liées à la boutique)
        $lignes = LigneCommande::with(['commande'])
            ->whereHas('produit', function ($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })->get();

        $totalCommandes = $lignes->count();
        $commandesEnAttente = $lignes->filter(function($ligne) {
            return in_array($ligne->commande->statut_commande ?? '', ['en_attente', 'en_preparation']);
        })->count();

        // Chiffre d'affaires (seulement les commandes livrées)
        $chiffreAffaires = $lignes->filter(function($ligne) {
            return ($ligne->commande->statut_commande ?? '') === 'livree';
        })->sum(function($ligne) {
            return $ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande;
        });

        // Dernières commandes
        $recentesCommandes = LigneCommande::with(['commande.user', 'produit'])
            ->whereHas('produit', function ($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Stats pour le graphique (ventes des 7 derniers jours)
        $ventesParJour = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            
            $totalJour = $lignes->filter(function($ligne) use ($date) {
                return $ligne->created_at->format('Y-m-d') === $date && 
                       ($ligne->commande->statut_commande ?? '') === 'livree';
            })->sum(function($ligne) {
                return $ligne->prix_au_moment_achat * $ligne->quantite_ligne_commande;
            });
            
            $ventesParJour[] = $totalJour;
        }

        // Unread messages count
        $unreadChat = \App\Models\Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('boutique.dashboard', compact(
            'boutique',
            'totalProduits',
            'totalCommandes',
            'commandesEnAttente',
            'chiffreAffaires',
            'recentesCommandes',
            'ventesParJour',
            'labels',
            'unreadChat'
        ));

    }

}
