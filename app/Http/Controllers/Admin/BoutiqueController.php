<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Boutique;
use App\Models\User;

class BoutiqueController extends Controller
{
    public function index()
    {
        $boutiques = Boutique::with('user')->latest()->get();
        return view('admin.boutiques.index', compact('boutiques'));
    }

    public function approve($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->update(['statut' => 'approuve']);
        
        // Update user role to boutique
        $boutique->user->update(['role' => 'boutique']);

        return redirect()->back()->with('success', 'La boutique "' . $boutique->nom_boutique . '" a été approuvée !');
    }

    public function reject($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->update(['statut' => 'rejete']);

        return redirect()->back()->with('success', 'La demande pour "' . $boutique->nom_boutique . '" a été rejetée.');
    }

    public function block($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->update(['statut' => 'bloque']);

        return redirect()->back()->with('success', 'La boutique "' . $boutique->nom_boutique . '" a été bloquée.');
    }
}
