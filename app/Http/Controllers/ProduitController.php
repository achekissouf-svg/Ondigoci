<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        // Get products with search
        $produits = Produit::with(['categorie', 'boutique'])
            ->whereHas('boutique', function($q) {
                $q->where('statut', 'approuve');
            });
        
        // Apply search filter if query exists
        if ($query) {
            $produits = $produits->where(function($q) use ($query) {
                $q->where('nom_produit', 'LIKE', "%{$query}%")
                  ->orWhere('description_produit', 'LIKE', "%{$query}%")
                  ->orWhereHas('categorie', function($q2) use ($query) {
                      $q2->where('libel_categorie', 'LIKE', "%{$query}%");
                  });
            });
        }
        
        $produits = $produits->paginate(12);
        $categories = Categorie::all();
        
        return view('shop', compact('produits', 'categories', 'query'));
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
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }
}
