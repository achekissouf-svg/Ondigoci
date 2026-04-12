<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\LigneCommande;
use App\Models\Boutique;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        // Find the boutique linked to this boutique user
        $boutique = Boutique::where('user_id', auth()->id())->first();

        if (!$boutique) {
            return view('boutique.commandes', ['lignes' => collect(), 'boutique' => null]);
        }

        // Get all order lines for this boutique's products
        $lignes = LigneCommande::with(['produit', 'commande.user'])
            ->whereHas('produit', function ($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('boutique.commandes', compact('lignes', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $commande = \App\Models\Commande::findOrFail($id);
        
        // Potential check: ensure the order contains products from this boutique
        // For now, keeping it simple as per user request.

        $request->validate([
            'statut_commande' => 'required|in:en_attente,en_cours,livre,annule',
        ]);

        $commande->update([
            'statut_commande' => $request->statut_commande,
        ]);

        return back()->with('success', 'Le statut de la commande a été mis à jour.');
    }
}
