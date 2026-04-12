<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LigneCommande;
use App\Models\Boutique;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        // Find the boutique owned by this admin
        $boutique = Boutique::where('user_id', auth()->id())->first();

        if (!$boutique) {
            // Admin has no boutique yet - show all orders (super admin view)
            $lignes = LigneCommande::with(['produit', 'commande.user'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            // Get lines for products belonging to this admin's boutique
            $lignes = LigneCommande::with(['produit.boutique', 'commande.user'])
                ->whereHas('produit', function ($q) use ($boutique) {
                    $q->where('boutique_id', $boutique->id);
                })
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.commandes', compact('lignes', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $commande = \App\Models\Commande::findOrFail($id);
        
        $request->validate([
            'statut_commande' => 'required|in:en_attente,en_cours,livre,annule',
        ]);

        $commande->update([
            'statut_commande' => $request->statut_commande,
        ]);

        return back()->with('success', 'Le statut de la commande a été mis à jour.');
    }
}
