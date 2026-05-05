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

        // Get all order lines for this boutique's sub-orders
        // Since we split orders by boutique, we can filter directly by boutique_id
        $lignes = LigneCommande::with(['produit', 'commande.user'])
            ->whereHas('commande', function ($q) use ($boutique) {
                $q->where('boutique_id', $boutique->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('boutique.commandes', compact('lignes', 'boutique'));
    }

    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        
        $request->validate([
            'statut_commande' => 'required|in:en_attente,en_preparation,en_livraison,livree,rejetee,annulee',
        ]);

        $oldStatus = $commande->statut_commande;
        $newStatus = $request->statut_commande;

        // Définition de la hiérarchie des statuts pour empêcher le retour en arrière
        $statusPriority = [
            'en_attente' => 1,
            'en_preparation' => 2,
            'en_livraison' => 3,
            'livree' => 4,
            'rejetee' => 5, // Statut final
            'annulee' => 5  // Statut final
        ];

        $oldPriority = $statusPriority[$oldStatus] ?? 0;
        $newPriority = $statusPriority[$newStatus] ?? 0;

        // Si le statut actuel est final (Livrée, Rejetée, Annulée), on ne change plus rien
        if ($oldPriority >= 4) {
            return back()->with('error', 'Cette commande est déjà dans un statut final et ne peut plus être modifiée.');
        }

        // Empêcher le retour en arrière (sauf pour annulation/rejet qui sont possibles depuis n'importe quel stade non-final)
        if ($newPriority < $oldPriority && !in_array($newStatus, ['rejetee', 'annulee'])) {
            return back()->with('error', 'Vous ne pouvez pas revenir à un statut précédent.');
        }

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
                'message' => 'Votre commande a été reçue et est en attente de traitement.'
            ],
            'en_preparation' => [
                'titre' => 'Commande en préparation',
                'message' => 'Le magasin prépare actuellement votre commande.'
            ],
            'en_livraison' => [
                'titre' => 'Livraison à domicile',
                'message' => 'Votre commande est en route pour la livraison à domicile.'
            ],
            'livree' => [
                'titre' => 'Commande livrée 🎉',
                'message' => 'Félicitations ! Votre commande a été livrée avec succès. Qu\'avez-vous pensé de vos articles ? Laissez-nous un avis !'
            ],
            'rejetee' => [
                'titre' => 'Commande rejetée',
                'message' => 'Votre commande a été rejetée par le vendeur.'
            ],
            'annulee' => [
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

