<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && !request()->has('preview')) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'boutique') {
                return redirect()->route('boutique.dashboard');
            }
        }

        // Récupérer tous les produits disponibles (Admin + Boutiques approuvées)
        $featuredProducts = Produit::with(['categorie', 'boutique'])
            ->whereHas('boutique', function($query) {
                $query->where('statut', 'approuve');
            })
            ->orderByDesc('est_sponsorise')
            ->orderByDesc('priorite_sponsoring')
            ->latest()
            ->get();

            
        $categories = Categorie::all();
        
        return view('home', compact('featuredProducts', 'categories'));
    }

    public function helpCenter()
    {
        return view('help-center');
    }

    public function helpSupport()
    {
        return view('help-support');
    }

    public function legal()
    {
        return view('legal');
    }
}