<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;

class VerificationModerationController extends Controller
{
    public function index()
    {
        $boutiques = Boutique::whereIn('statut_verification', ['en_attente', 'approuve', 'rejete'])
            ->latest()
            ->paginate(20);
        return view('admin.verifications.index', compact('boutiques'));
    }

    public function approve($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->update([
            'statut_verification' => 'approuve'
        ]);

        return back()->with('success', 'Boutique approuvée avec succès !');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        $boutique = Boutique::findOrFail($id);
        $boutique->update([
            'statut_verification' => 'rejete',
            'motif_rejet' => $request->motif_rejet
        ]);

        return back()->with('success', 'Boutique rejetée.');
    }
}
