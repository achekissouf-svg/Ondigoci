<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\AvisBoutique;
use App\Models\AvisProduit;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', auth()->id())->firstOrFail();

        // Get reviews for the boutique
        $avisBoutique = AvisBoutique::with('user')
            ->where('boutique_id', $boutique->id)
            ->orderByDesc('created_at')
            ->get();

        // Get reviews for all products of this boutique
        $avisProduits = AvisProduit::with(['user', 'produit'])
            ->whereHas('produit', function($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('boutique.avis', compact('boutique', 'avisBoutique', 'avisProduits'));
    }
}
