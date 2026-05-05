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
            'nom_responsable' => 'required|string|max:255',
            'description'  => 'required|string|max:500',
            'adresse_siege' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'piece_identite_recto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'piece_identite_verso' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rccm' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'photo_magasin' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'nom_boutique' => $request->nom_boutique,
            'nom_responsable' => $request->nom_responsable,
            'description' => $request->description,
            'adresse_siege' => $request->adresse_siege,
            'lieu' => $request->lieu,
            'whatsapp' => $request->whatsapp,
            'statut' => 'en_attente',
        ];

        // Handle File Uploads
        if ($request->hasFile('piece_identite_recto')) {
            $imageName = time() . '_recto.' . $request->piece_identite_recto->extension();
            $request->piece_identite_recto->move(public_path('images/verifications'), $imageName);
            $data['piece_identite_recto'] = 'verifications/' . $imageName;
        }

        if ($request->hasFile('piece_identite_verso')) {
            $imageName = time() . '_verso.' . $request->piece_identite_verso->extension();
            $request->piece_identite_verso->move(public_path('images/verifications'), $imageName);
            $data['piece_identite_verso'] = 'verifications/' . $imageName;
        }

        if ($request->hasFile('rccm')) {
            $fileName = time() . '_rccm.' . $request->rccm->extension();
            $request->rccm->move(public_path('images/verifications'), $fileName);
            $data['rccm'] = 'verifications/' . $fileName;
        }

        if ($request->hasFile('photo_magasin')) {
            $imageName = time() . '_magasin.' . $request->photo_magasin->extension();
            $request->photo_magasin->move(public_path('images/verifications'), $imageName);
            $data['photo_magasin'] = 'verifications/' . $imageName;
        }

        Boutique::create($data);

        return redirect()->route('boutique.pending');
    }
}
