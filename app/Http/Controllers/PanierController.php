<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PanierController extends Controller
{
    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
        }

        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit',
            'quantite' => 'required|integer|min:1'
        ]);

        $produit = Produit::findOrFail($request->id_produit);
        $user = auth()->user();
        
        // Vérifier si le produit existe déjà dans le panier
        $panier = Panier::where('user_id', $user->id)
                        ->where('id_produit', $request->id_produit)
                        ->first();

        if ($panier) {
            // Augmenter la quantité
            $panier->quantite += $request->quantite;
            $panier->save();
        } else {
            // Créer un nouveau panier
            Panier::create([
                'id_panier' => Str::uuid(),
                'user_id' => $user->id,
                'id_produit' => $request->id_produit,
                'quantite' => $request->quantite
            ]);
        }

        // Return the current cart count so JS can update the badge
        $cartCount = Panier::where('user_id', $user->id)->sum('quantite');

        return response()->json([
            'success' => true, 
            'message' => 'Produit ajouté avec succès',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paniers = Panier::with('produit')->where('user_id', auth()->id())->get();
        
        $total = 0;
        foreach ($paniers as $item) {
            $prix = $item->produit->prixAvecReduction() ?? $item->produit->prix_unitaire_produit;
            $total += ($prix * $item->quantite);
        }

        $modesPaiement = \App\Models\ModePaiement::all();

        return view('cart.index', compact('paniers', 'total', 'modesPaiement'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Panier $panier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panier $panier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $panier = Panier::where('id_panier', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $action = $request->input('action');

        if ($action === 'increase') {
            $panier->quantite += 1;
        } elseif ($action === 'decrease') {
            $panier->quantite -= 1;
        }

        if ($panier->quantite <= 0) {
            $panier->delete();
            return redirect()->route('cart.index')->with('success', 'Article retiré du panier.');
        }

        $panier->save();
        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $panier = Panier::where('id_panier', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
                        
        $panier->delete();

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}
