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
        if (auth()->check() && auth()->user()->role !== 'client' && !$request->has('preview')) {
            return auth()->user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('boutique.dashboard');
        }

        $query = $request->input('q');
        
        // Get products with search
        $produits = Produit::with(['categorie', 'boutique'])
            ->join('boutiques', 'produits.boutique_id', '=', 'boutiques.id')
            ->where('boutiques.statut', 'approuve')
            ->select('produits.*');
        
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
        
        $produits = $produits->orderByDesc('boutiques.priorite')
                             ->orderByDesc('produits.created_at')
                             ->paginate(12);
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
    public function show($id)
    {
        if (auth()->check() && auth()->user()->role !== 'client' && !request()->has('preview')) {
            return auth()->user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('boutique.dashboard');
        }

        $produit = Produit::with(['categorie', 'boutique'])->where('id_produit', $id)->firstOrFail();
        
        // Suggest other products from the same boutique or category
        $suggestions = Produit::where('id_categorie', $produit->id_categorie)
            ->where('id_produit', '!=', $id)
            ->whereHas('boutique', function($q) {
                $q->where('statut', 'approuve');
            })
            ->limit(4)
            ->get();

        return view('produit_show', compact('produit', 'suggestions'));
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
    public function storeAvis(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $hasBought = \App\Models\LigneCommande::whereHas('commande', function($q) {
                $q->where('user_id', auth()->id())
                  ->where('statut_commande', 'livree');
            })
            ->where('id_produit', $id)
            ->exists();

        if (!$hasBought) {
            return back()->with('error', 'Désolé, vous devez avoir déjà acheté et reçu ce produit pour pouvoir laisser un avis.');
        }

        \App\Models\AvisProduit::create([
            'id_produit' => $id,
            'user_id' => auth()->id(),
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis sur ce produit a été enregistré.');
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');
        if (!$query || strlen($query) < 2) return response()->json([]);

        $produits = Produit::where('nom_produit', 'LIKE', "%{$query}%")
            ->whereHas('boutique', function($q) {
                $q->where('statut', 'approuve');
            })
            ->limit(5)
            ->get();

        $results = $produits->map(function($p) {
            return [
                'id' => $p->id_produit ?? $p->id,
                'name' => $p->nom_produit,
                'price' => number_format($p->prix_unitaire_produit, 0, ',', ' ') . ' FCFA',
                'image' => asset('images/' . $p->image_principale_produit),
                'url' => route('produit.show', $p->id_produit ?? $p->id)
            ];
        });

        return response()->json($results);
    }
}
