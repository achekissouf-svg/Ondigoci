<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();
        return view('boutique.verification.index', compact('boutique'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'piece_identite' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'justificatif_domicile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $boutique = Boutique::where('user_id', Auth::id())->first();

        // Stockage des fichiers
        $pathIdentite = $request->file('piece_identite')->store('verifications/identites', 'public');
        $pathDomicile = $request->file('justificatif_domicile')->store('verifications/domiciles', 'public');

        $boutique->update([
            'piece_identite' => $pathIdentite,
            'justificatif_domicile' => $pathDomicile,
            'statut_verification' => 'en_attente'
        ]);

        return redirect()->route('boutique.verification.index')->with('success', 'Documents envoyés avec succès. Votre boutique est en cours de vérification.');
    }
}
