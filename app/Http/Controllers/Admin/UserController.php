<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->update(['statut' => 'bloque']);
        return redirect()->back()->with('success', 'Utilisateur bloqué avec succès.');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['statut' => 'actif']);
        return redirect()->back()->with('success', 'Utilisateur débloqué avec succès.');
    }
}
