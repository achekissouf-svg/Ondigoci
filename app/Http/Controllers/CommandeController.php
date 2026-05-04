<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $paniers = \App\Models\Panier::with('produit')->where('user_id', $user->id)->get();

        $request->validate([
            'adresse_livraison' => 'required|string|max:255',
            'telephone_commande' => 'required|string|max:50',
            'id_mode_paiement' => 'required|exists:mode_paiements,id_mode_paiement',
        ]);

        if ($paniers->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Votre panier est vide.');
        }

        // Group items by boutique to allow separate management
        $groupedByBoutique = $paniers->groupBy(function($item) {
            return $item->produit->boutique_id;
        });

        foreach ($groupedByBoutique as $boutiqueId => $items) {
            $totalBoutique = 0;
            foreach ($items as $item) {
                $totalBoutique += ($item->produit->prixAvecReduction() * $item->quantite);
            }

            // Create a separate Commande for each boutique
            $commande = Commande::create([
                'id_commande' => \Illuminate\Support\Str::uuid(),
                'num_commande' => 'CMD-' . strtoupper(\Illuminate\Support\Str::random(10)),
                'date_commande' => now(),
                'montant_total_commande' => $totalBoutique,
                'statut_commande' => 'en_attente',
                'id_mode_paiement' => $request->id_mode_paiement,
                'user_id' => $user->id,
                'boutique_id' => $boutiqueId,
                'telephone_commande' => $request->input('telephone_commande') ?? $user->telephone,
            ]);

            // Create LigneCommandes for this boutique's sub-order
            foreach ($items as $item) {
                \App\Models\LigneCommande::create([
                    'id_ligne_commande' => \Illuminate\Support\Str::uuid(),
                    'id_produit' => $item->id_produit,
                    'id_commande' => $commande->id_commande,
                    'quantite_ligne_commande' => $item->quantite,
                    'prix_au_moment_achat' => $item->produit->prixAvecReduction(),
                ]);
            }

            // Create a separate Livraison record for this boutique's order
            \App\Models\Livraison::create([
                'id_livraison' => \Illuminate\Support\Str::uuid(),
                'id_commande' => $commande->id_commande,
                'adresse_livraison' => $request->adresse_livraison,
                'date_estimee' => now()->addDays(3), // Estimated delivery
                'frais_livraison' => 0,
                'statut_livraison' => 'en_attente',
            ]);
        }

        // Empty the cart after all orders are created
        \App\Models\Panier::where('user_id', $user->id)->delete();

        return redirect()->route('home')->with('success', 'Votre commande a été passée avec succès ! Vos articles ont été séparés par vendeur pour une meilleure gestion de la livraison.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
