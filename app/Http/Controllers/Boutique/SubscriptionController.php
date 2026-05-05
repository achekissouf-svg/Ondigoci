<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();
        return view('boutique.subscription.index', compact('boutique'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:standard,premium'
        ]);

        $plan = $request->plan;
        $amount = $plan === 'standard' ? 50000 : 75000;
        $tx_ref = 'SUB-' . Str::upper(Str::random(10));
        $user = Auth::user();

        // Flutterwave Payload
        $payload = [
            'tx_ref' => $tx_ref,
            'amount' => $amount,
            'currency' => 'XOF',
            'redirect_url' => route('boutique.subscription.callback'),
            'payment_options' => 'card,mobilemoney',
            'customer' => [
                'email' => $user->email,
                'name' => $user->name,
                'phone_number' => $user->telephone
            ],
            'customizations' => [
                'title' => 'Abonnement Ondigoci ' . ucfirst($plan),
                'description' => 'Paiement de votre abonnement boutique',
                'logo' => asset('images/logo.ondigo.ci.png')
            ],
            'meta' => [
                'plan' => $plan,
                'user_id' => $user->id
            ]
        ];

        // Call Flutterwave API
        try {
            $response = Http::withToken(config('services.flutterwave.secret_key'))
                ->timeout(30)
                ->withoutVerifying() // Désactive la vérification SSL pour le local
                ->post('https://api.flutterwave.com/v3/payments', $payload);


            if ($response->successful()) {
                return redirect($response->json()['data']['link']);
            }
            
            \Log::error('Flutterwave Error: ' . $response->body());
            return back()->with('error', 'Erreur Flutterwave : ' . ($response->json()['message'] ?? 'Impossible de générer le lien.'));
        } catch (\Exception $e) {
            \Log::error('Payment Exception: ' . $e->getMessage());
            return back()->with('error', 'Erreur de connexion au service de paiement.');
        }
    }


    public function callback(Request $request)
    {
        $status = $request->status;
        $tx_id = $request->transaction_id;

        if ($status === 'successful' || $status === 'completed') {
            // Verify transaction
            $response = Http::withToken(config('services.flutterwave.secret_key'))
                ->get("https://api.flutterwave.com/v3/transactions/{$tx_id}/verify");

            if ($response->successful() && $response->json()['data']['status'] === 'successful') {
                $data = $response->json()['data'];
                $plan = $data['meta']['plan'] ?? 'standard';
                
                $boutique = Boutique::where('user_id', Auth::id())->first();
                if ($boutique) {
                    $boutique->type_abonnement = $plan;
                    $boutique->save();
                    return redirect()->route('boutique.dashboard')->with('success', 'Votre abonnement a été activé avec succès !');
                }
            }
        }

        return redirect()->route('boutique.subscription.index')->with('error', 'Le paiement a échoué ou a été annulé.');
    }
}
