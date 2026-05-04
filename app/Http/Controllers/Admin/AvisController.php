<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvisBoutique;
use App\Models\AvisProduit;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index()
    {
        // Get all boutique reviews
        $avisBoutiques = AvisBoutique::with(['user', 'boutique'])
            ->latest()
            ->paginate(15, ['*'], 'boutique_page');

        // Get all product reviews
        $avisProduits = AvisProduit::with(['user', 'produit.boutique'])
            ->latest()
            ->paginate(15, ['*'], 'produit_page');

        return view('admin.avis.index', compact('avisBoutiques', 'avisProduits'));
    }

    public function destroyBoutiqueAvis($id)
    {
        $avis = AvisBoutique::findOrFail($id);
        $avis->delete();
        return back()->with('success', 'L\'avis sur la boutique a été supprimé.');
    }

    public function destroyProduitAvis($id)
    {
        $avis = AvisProduit::findOrFail($id);
        $avis->delete();
        return back()->with('success', 'L\'avis sur le produit a été supprimé.');
    }
}
