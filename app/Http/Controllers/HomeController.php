<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer quelques produits pour la page d'accueil
        $featuredProducts = Produit::with(['categorie', 'promotion'])->take(3)->get();
        $categories = Categorie::all();
        
        return view('home', compact('featuredProducts', 'categories'));
    }
}