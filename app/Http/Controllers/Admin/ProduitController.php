<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    /**
     * Get or create the Admin's system Boutique.
     */
    private function getAdminBoutique()
    {
        return Boutique::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'nom_boutique' => 'Ondigoci Direct',
                'description' => 'Boutique officielle de l\'administration Ondigoci.',
                'statut' => 'approuve',
                'adresse_siege' => 'Siège Social Ondigoci'
            ]
        );
    }

    public function index()
    {
        $boutique = $this->getAdminBoutique();
        $produits = Produit::where('boutique_id', $boutique->id)->latest()->get();
        return view('admin.produits.index', compact('produits', 'boutique'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $boutique = $this->getAdminBoutique();

        $request->validate([
            'nom_produit'              => 'required|string|max:150',
            'description_produit'      => 'required|string|max:255',
            'prix_unitaire_produit'    => 'required|numeric|min:0',
            'stock_disponible_produit' => 'required|integer|min:0',
            'id_categorie'             => 'required|string|exists:categories,id_categorie',
            'image'                    => 'required|image|max:2048',
        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $imageName);

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

        return redirect()->route('admin.produits.index')
                         ->with('success', 'Produit mis en ligne avec succès !');
    }

    public function edit(string $id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $produit = Produit::findOrFail($id);

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

        return redirect()->route('admin.produits.index')
                         ->with('success', 'Produit mis à jour !');
    }

    public function destroy(string $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return redirect()->route('admin.produits.index')
                         ->with('success', 'Produit retiré de la vente.');
    }
}
