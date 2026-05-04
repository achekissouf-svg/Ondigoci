<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class MonetizationController extends Controller
{
    public function index()
    {
        $produits = Produit::with('boutique')->latest()->paginate(20);
        
        // Stats de revenus (Simulées basées sur les abonnements)
        $boutiquesCount = \App\Models\Boutique::select('type_abonnement', \DB::raw('count(*) as total'))
            ->groupBy('type_abonnement')
            ->pluck('total', 'type_abonnement');

        $revenueAbonnements = ($boutiquesCount['standard'] ?? 0) * 50000 + ($boutiquesCount['premium'] ?? 0) * 75000;

        
        // Commissions (10% sur les commandes livrées)
        $totalVentesLivrees = \App\Models\LigneCommande::whereHas('commande', function($q) {
            $q->where('statut_commande', 'livree');
        })->sum(\DB::raw('prix_au_moment_achat * quantite_ligne_commande'));
        
        $commissions = $totalVentesLivrees * 0.10;

        return view('admin.monetization.index', compact('produits', 'revenueAbonnements', 'commissions', 'totalVentesLivrees'));
    }


    public function toggleSponsoring($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->est_sponsorise = !$produit->est_sponsorise;
        $produit->save();

        return back()->with('success', 'Statut de sponsoring mis à jour avec succès.');
    }

    public function updatePriority(Request $request, $id)
    {
        $request->validate(['priorite_sponsoring' => 'required|integer|min:0']);
        $produit = Produit::findOrFail($id);
        $produit->priorite_sponsoring = $request->priorite_sponsoring;
        $produit->save();

        return back()->with('success', 'Priorité de sponsoring mise à jour.');
    }
}
