<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients' => \App\Models\User::where('role', 'client')->count(),
            'boutiques_attente' => \App\Models\Boutique::where('statut', 'en_attente')->count(),
            'total_produits' => \App\Models\Produit::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
