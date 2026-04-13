<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\LigneCommande;
use App\Models\Boutique;
use App\Models\Commande;
use App\Models\Notification;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        // Find the boutique linked to this boutique user
        $boutique = Boutique::where('user_id', auth()->id())->first();

        if (!$boutique) {
            return view('boutique.commandes', ['lignes' => collect(), 'boutique' => null]);
        }

        // Get all order lines for this boutique's products
        $lignes = LigneCommande::with(['produit', 'commande.user'])
            ->whereHas('produit', function ($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('boutique.commandes', compact('lignes', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        
        // Potential check: ensure the order contains products from this boutique
        // For now, keeping it simple as per user request.

        $request->validate([
            'statut_commande' => 'required|in:en_attente,encours,livré,rejeté,annulé',
        ]);

        $oldStatus = $commande->statut_commande;
        $newStatus = $request->statut_commande;

        // Ne créer une notification que si le statut change réellement
        if ($oldStatus !== $newStatus) {
            $commande->update([
                'statut_commande' => $newStatus,
            ]);

            // Créer une notification pour le client
            $this->createStatusChangeNotification($commande, $oldStatus, $newStatus);
        }

        return back()->with('success', 'Le statut de la commande a été mis à jour.');
    }

    /**
     * Crée une notification quand le statut change
     */
    private function createStatusChangeNotification(Commande $commande, string $oldStatus, string $newStatus)
    {
        $statusMessages = [
            'en_attente' => [
                'titre' => 'Commande en attente',
                'message' => 'Votre commande a été reçue et est en attente de confirmation du vendeur.'
            ],
            'encours' => [
                'titre' => 'Commande en cours de traitement',
                'message' => 'Votre commande est en cours de traitement. Elle sera bientôt expédiée.'
            ],
            'livré' => [
                'titre' => 'Commande livrée',
                'message' => 'Félicitations! Votre commande a été livrée avec succès.'
            ],
            'rejeté' => [
                'titre' => 'Commande rejetée',
                'message' => 'Votre commande a été rejetée par le vendeur. Veuillez nous contacter pour plus d\'informations.'
            ],
            'annulé' => [
                'titre' => 'Commande annulée',
                'message' => 'Votre commande a été annulée.'
            ]
        ];

        $notificationData = $statusMessages[$newStatus] ?? [
            'titre' => 'Mise à jour de commande',
            'message' => 'Votre commande a été mise à jour.'
        ];

        Notification::create([
            'user_id' => $commande->user_id,
            'id_commande' => $commande->id_commande,
            'titre' => $notificationData['titre'],
            'message' => $notificationData['message'],
            'statut_commande' => $newStatus,
            'lue' => false
        ]);
    }
}

