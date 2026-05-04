<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Produit;
use Illuminate\Http\Request;

class PublicBoutiqueController extends Controller
{
    /**
     * Display the specified boutique and its products.
     */
    public function show($id)
    {
        if (auth()->check() && auth()->user()->role !== 'client') {
            return auth()->user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('boutique.dashboard');
        }

        $boutique = Boutique::with(['user', 'avis.user'])->findOrFail($id);
        
        // Ensure the boutique is approved before displaying it publicly
        if ($boutique->statut !== 'approuve') {
            abort(404, 'Boutique introuvable ou non approuvée.');
        }

        // Fetch products belonging to this boutique
        // We'll paginate them so the page doesn't get overloaded
        $produits = Produit::where('boutique_id', $id)
                           ->latest()
                           ->paginate(12);

        return view('magasin.show', compact('boutique', 'produits'));
    }

    /**
     * Store a new review for the boutique.
     */
    public function storeAvis(Request $request, $id)
    {
        $boutique = Boutique::findOrFail($id);

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Ensure the user has actually purchased and received an item from this boutique
        $hasPurchased = \App\Models\Commande::where('user_id', auth()->id())
            ->where('boutique_id', $id)
            ->where('statut_commande', 'livree')
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Désolé, vous devez avoir déjà effectué et reçu un achat dans cette boutique pour pouvoir laisser un avis.');
        }

        // Create or update review for the current user and boutique
        \App\Models\AvisBoutique::updateOrCreate(
            ['user_id' => auth()->id(), 'boutique_id' => $boutique->id],
            ['note' => $request->note, 'commentaire' => $request->commentaire]
        );

        return back()->with('success', 'Votre avis a été enregistré avec succès.');
    }
}
