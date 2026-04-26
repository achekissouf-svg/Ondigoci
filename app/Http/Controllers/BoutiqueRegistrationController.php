<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoutiqueRegistrationController extends Controller
{
    /**
     * Show the boutique registration form.
     */
    public function create()
    {
        // If user already has a boutique, redirect accordingly
        if (Auth::user()->boutique) {
            if (Auth::user()->boutique->statut === 'approuve') {
                return redirect()->route('boutique.dashboard');
            }
            return redirect()->route('boutique.pending');
        }

        return view('boutique.register');
    }

    /**
     * Store the boutique request and update user role if needed.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_boutique' => 'required|string|max:100|unique:boutiques,nom_boutique',
            'description'  => 'required|string|max:500',
            'adresse_siege' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        Boutique::create([
            'user_id' => $user->id,
            'nom_boutique' => $request->nom_boutique,
            'description' => $request->description,
            'adresse_siege' => $request->adresse_siege,
            'whatsapp' => $request->whatsapp,
            'statut' => 'en_attente',
        ]);

        // We don't change the role to 'boutique' yet, 
        // we'll do it upon approval to keep their access restricted.
        // Or we can change it now and let the middleware handle 'en_attente' status.

        return redirect()->route('boutique.pending');
    }
}
