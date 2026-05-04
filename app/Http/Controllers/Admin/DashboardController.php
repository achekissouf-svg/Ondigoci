<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients' => \App\Models\User::where('role', 'client')->count(),
            'boutiques_attente' => \App\Models\Boutique::where('statut', 'en_attente')->count(),
            'total_produits' => \App\Models\Produit::count(),
            'total_revenu' => \App\Models\LigneCommande::whereHas('commande', function($q) {
                $q->where('statut_commande', 'livree');
            })->sum(\DB::raw('prix_au_moment_achat * quantite_ligne_commande')),
        ];

        // Stats pour le graphique (30 derniers jours)
        $ventesGlobales = [];
        $labels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            
            $totalJour = \App\Models\LigneCommande::whereHas('commande', function($q) {
                $q->where('statut_commande', 'livree');
            })->whereDate('created_at', $date)
              ->sum(\DB::raw('prix_au_moment_achat * quantite_ligne_commande'));
            
            $ventesGlobales[] = $totalJour;
        }

        return view('admin.dashboard', compact('stats', 'ventesGlobales', 'labels'));
    }

}
