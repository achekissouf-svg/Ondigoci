<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $favoris = Favori::with('produit.boutique')->where('user_id', Auth::id())->get();
        return view('wishlist.index', compact('favoris'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit'
        ]);

        $userId = Auth::id();
        $id_produit = $request->id_produit;

        $favori = Favori::where('user_id', $userId)->where('id_produit', $id_produit)->first();

        if ($favori) {
            $favori->delete();
            return response()->json(['status' => 'removed', 'message' => 'Supprimé des favoris']);
        } else {
            Favori::create([
                'user_id' => $userId,
                'id_produit' => $id_produit
            ]);
            return response()->json(['status' => 'added', 'message' => 'Ajouté aux favoris']);
        }
    }
}
