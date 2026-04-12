<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    private function getBoutique()
    {
        return Boutique::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return view('boutique.produits.index', ['produits' => collect(), 'boutique' => null]);
        }
        $produits = Produit::where('boutique_id', $boutique->id)->latest()->get();
        return view('boutique.produits.index', compact('produits', 'boutique'));
    }

    public function create()
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return redirect()->route('boutique.dashboard')
                             ->with('error', 'Vous devez avoir une boutique associée pour ajouter des produits.');
        }
        $categories = Categorie::all();
        return view('boutique.produits.create', compact('categories', 'boutique'));
    }

    public function store(Request $request)
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return redirect()->route('boutique.dashboard')->with('error', 'Boutique introuvable.');
        }

        $request->validate([
            'nom_produit'              => 'required|string|max:150',
            'description_produit'      => 'required|string|max:255',
            'prix_unitaire_produit'    => 'required|numeric|min:0',
            'stock_disponible_produit' => 'required|integer|min:0',
            'id_categorie'             => 'required|string|exists:categories,id_categorie',
            'image'                    => 'nullable|image|max:2048',
        ]);

        $imageName = 'default_product.png';
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $imageName);
        }

        Produit::create([
            'id_produit'               => Str::uuid(),
            'nom_produit'              => $request->nom_produit,
            'description_produit'      => $request->description_produit,
            'prix_unitaire_produit'    => $request->prix_unitaire_produit,
            'stock_disponible_produit' => $request->stock_disponible_produit,
            'image_principale_produit' => $imageName,
            'id_categorie'             => $request->id_categorie,
            'boutique_id'              => $boutique->id,
        ]);

        return redirect()->route('boutique.produits.index')
                         ->with('success', 'Produit ajouté avec succès !');
    }

    public function edit(string $id)
    {
        $boutique = $this->getBoutique();
        $produit = Produit::where('id_produit', $id)
                          ->where('boutique_id', $boutique?->id)
                          ->firstOrFail();
        $categories = Categorie::all();
        return view('boutique.produits.edit', compact('produit', 'categories', 'boutique'));
    }

    public function update(Request $request, string $id)
    {
        $boutique = $this->getBoutique();
        $produit = Produit::where('id_produit', $id)
                          ->where('boutique_id', $boutique?->id)
                          ->firstOrFail();

        $request->validate([
            'nom_produit'              => 'required|string|max:150',
            'description_produit'      => 'required|string|max:255',
            'prix_unitaire_produit'    => 'required|numeric|min:0',
            'stock_disponible_produit' => 'required|integer|min:0',
            'id_categorie'             => 'required|string|exists:categories,id_categorie',
            'image'                    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $imageName);
            $produit->image_principale_produit = $imageName;
        }

        $produit->update([
            'nom_produit'              => $request->nom_produit,
            'description_produit'      => $request->description_produit,
            'prix_unitaire_produit'    => $request->prix_unitaire_produit,
            'stock_disponible_produit' => $request->stock_disponible_produit,
            'id_categorie'             => $request->id_categorie,
        ]);

        return redirect()->route('boutique.produits.index')
                         ->with('success', 'Produit mis à jour !');
    }

    public function destroy(string $id)
    {
        $boutique = $this->getBoutique();
        $produit = Produit::where('id_produit', $id)
                          ->where('boutique_id', $boutique?->id)
                          ->firstOrFail();
        $produit->delete();
        return redirect()->route('boutique.produits.index')
                         ->with('success', 'Produit supprimé.');
    }

    public function show(string $id) { return redirect()->route('boutique.produits.index'); }
}
