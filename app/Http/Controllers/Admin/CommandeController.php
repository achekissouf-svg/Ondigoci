<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LigneCommande;
use App\Models\Boutique;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        // Find the boutique owned by this admin
        $boutique = Boutique::where('user_id', auth()->id())->first();

        if (!$boutique) {
            // Admin has no boutique yet - show all orders (super admin view)
            $lignes = LigneCommande::with(['produit', 'commande.user'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            // Get lines for products belonging to this admin's boutique
            $lignes = LigneCommande::with(['produit.boutique', 'commande.user'])
                ->whereHas('produit', function ($q) use ($boutique) {
                    $q->where('boutique_id', $boutique->id);
                })
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.commandes', compact('lignes', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $commande = \App\Models\Commande::findOrFail($id);
        
        $request->validate([
            'statut_commande' => 'required|in:en_attente,en_preparation,en_livraison,livree,rejetee,annulee',
        ]);

        $oldStatus = $commande->statut_commande;
        $newStatus = $request->statut_commande;

        if ($oldStatus !== $newStatus) {
            $commande->update([
                'statut_commande' => $newStatus,
            ]);

            // Notify client
            $this->createStatusChangeNotification($commande, $oldStatus, $newStatus);
        }

        return back()->with('success', 'Le statut de la commande a été mis à jour.');
    }

    private function createStatusChangeNotification($commande, string $oldStatus, string $newStatus)
    {
        $statusMessages = [
            'en_attente' => ['titre' => 'Commande en attente', 'message' => 'Votre commande a été reçue.'],
            'en_preparation' => ['titre' => 'Commande en préparation', 'message' => 'Nous préparons votre commande.'],
            'en_livraison' => ['titre' => 'En cours de livraison', 'message' => 'Votre commande est en route.'],
            'livree' => ['titre' => 'Commande livrée 🎉', 'message' => 'Votre commande a été livrée. Laissez-nous un avis !'],
            'rejetee' => ['titre' => 'Commande rejetée', 'message' => 'Désolé, votre commande a été rejetée.'],
            'annulee' => ['titre' => 'Commande annulée', 'message' => 'Votre commande a été annulée.'],
        ];

        $data = $statusMessages[$newStatus] ?? ['titre' => 'Mise à jour', 'message' => 'Statut mis à jour.'];

        \App\Models\Notification::create([
            'user_id' => $commande->user_id,
            'id_commande' => $commande->id_commande,
            'titre' => $data['titre'],
            'message' => $data['message'],
            'statut_commande' => $newStatus,
            'lue' => false
        ]);
    }
}
