<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Boutique;
use Illuminate\Http\Request;

class PaymentModerationController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('boutique')->latest()->paginate(20);
        return view('admin.monetization.payments', compact('paiements'));
    }

    public function validatePayment($id)
    {
        $paiement = Paiement::findOrFail($id);
        
        // Update payment status
        $paiement->statut = 'valide';
        $paiement->save();

        // Update boutique subscription
        $boutique = $paiement->boutique;
        $boutique->type_abonnement = $paiement->type_abonnement;
        $boutique->save();

        return back()->with('success', 'Paiement validé et abonnement mis à jour !');
    }

    public function rejectPayment($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->statut = 'rejete';
        $paiement->save();

        return back()->with('success', 'Paiement rejeté.');
    }
}
