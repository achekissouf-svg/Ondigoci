<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ClientCommandeController extends Controller
{
    /**
     * Affiche toutes les commandes du client
     */
    public function index()
    {
        $commandes = Commande::where('user_id', Auth::id())
            ->orderBy('date_commande', 'desc')
            ->paginate(10);

        return view('client.commandes.index', compact('commandes'));
    }

    /**
     * Affiche les détails d'une commande
     */
    public function show(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $lignees = $commande->lignes;

        return view('client.commandes.show', compact('commande', 'lignees'));
    }

    /**
     * Récupère les notifications non lues du client
     */
    public function notifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('lue', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications
        ]);
    }

    /**
     * Marque une notification comme lue
     */
    public function markNotificationAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $notification->update(['lue' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Affiche le suivi d'une commande (tracking)
     */
    public function tracking(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $notifications = Notification::where('id_commande', $commande->id_commande)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.commandes.tracking', compact('commande', 'notifications'));
    }

    /**
     * Affiche la page des notifications
     */
    public function notificationsPage()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('client.notifications', compact('notifications'));
    }
}
