<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    private function getBoutique()
    {
        return Boutique::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return redirect()->route('boutique.dashboard')->with('error', 'Boutique introuvable.');
        }

        $promotions = Promotion::where('boutique_id', $boutique->id)->latest()->get();
        return view('boutique.promotions.index', compact('promotions', 'boutique'));
    }

    public function create()
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return redirect()->route('boutique.dashboard')->with('error', 'Boutique introuvable.');
        }

        return view('boutique.promotions.create', compact('boutique'));
    }

    public function store(Request $request)
    {
        $boutique = $this->getBoutique();
        if (!$boutique) {
            return redirect()->route('boutique.dashboard')->with('error', 'Boutique introuvable.');
        }

        $request->validate([
            'nom_promo' => 'required|string|max:100',
            'pourcentage_reduction' => 'required|numeric|min:0|max:100',
            'date_debut_promo' => 'required|date',
            'date_fin_promo' => 'required|date|after_or_equal:date_debut_promo',
        ]);

        Promotion::create([
            'id_promo' => Str::uuid(),
            'nom_promo' => $request->nom_promo,
            'pourcentage_reduction' => $request->pourcentage_reduction,
            'date_debut_promo' => $request->date_debut_promo,
            'date_fin_promo' => $request->date_fin_promo,
            'boutique_id' => $boutique->id,
        ]);

        return redirect()->route('boutique.promotions.index')->with('success', 'Promotion créée avec succès.');
    }

    public function edit($id)
    {
        $boutique = $this->getBoutique();
        $promotion = Promotion::where('id_promo', $id)->where('boutique_id', $boutique?->id)->firstOrFail();

        return view('boutique.promotions.edit', compact('promotion', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $boutique = $this->getBoutique();
        $promotion = Promotion::where('id_promo', $id)->where('boutique_id', $boutique?->id)->firstOrFail();

        $request->validate([
            'nom_promo' => 'required|string|max:100',
            'pourcentage_reduction' => 'required|numeric|min:0|max:100',
            'date_debut_promo' => 'required|date',
            'date_fin_promo' => 'required|date|after_or_equal:date_debut_promo',
        ]);

        $promotion->update([
            'nom_promo' => $request->nom_promo,
            'pourcentage_reduction' => $request->pourcentage_reduction,
            'date_debut_promo' => $request->date_debut_promo,
            'date_fin_promo' => $request->date_fin_promo,
        ]);

        return redirect()->route('boutique.promotions.index')->with('success', 'Promotion mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $boutique = $this->getBoutique();
        $promotion = Promotion::where('id_promo', $id)->where('boutique_id', $boutique?->id)->firstOrFail();

        $promotion->delete();

        return redirect()->route('boutique.promotions.index')->with('success', 'Promotion supprimée.');
    }
}
