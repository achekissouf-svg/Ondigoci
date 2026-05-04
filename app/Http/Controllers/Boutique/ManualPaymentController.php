<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManualPaymentController extends Controller
{
    public function create(Request $request)
    {
        $plan = $request->plan;
        $amount = $plan === 'standard' ? 50000 : 75000;
        $boutique = Boutique::where('user_id', Auth::id())->first();

        return view('boutique.payment.manual', compact('plan', 'amount', 'boutique'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan' => 'required',
            'moyen_paiement' => 'required',
            'montant' => 'required',
            'reference' => 'required',
            'capture_ecran' => 'required|image|max:2048'
        ]);

        $boutique = Boutique::where('user_id', Auth::id())->first();

        $path = $request->file('capture_ecran')->store('paiements', 'public');

        Paiement::create([
            'boutique_id' => $boutique->id,
            'moyen_paiement' => $request->moyen_paiement,
            'type_abonnement' => $request->plan,
            'montant' => $request->montant,
            'reference' => $request->reference,
            'capture_ecran' => $path,
            'statut' => 'en_attente'
        ]);


        return redirect()->route('boutique.dashboard')->with('success', 'Votre demande de paiement a été envoyée. Un administrateur va la valider sous peu.');
    }
}
