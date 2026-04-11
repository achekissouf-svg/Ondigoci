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

        return response()->json(['success' => true, 'message' => 'Produit ajouté']);
    }

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
    public function update(Request $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panier $panier)
    {
        //
    }
}
