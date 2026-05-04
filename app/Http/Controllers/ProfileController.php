<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->user();
        $user->save();

        // Update WhatsApp if user has a boutique
        if ($request->has('whatsapp_boutique') && $user->boutique) {
            $user->boutique->update(['whatsapp' => $request->whatsapp_boutique]);
        }

        // Redirect based on role to fulfill the "must go back" request
        $route = 'home';
        if ($user->role === 'admin') $route = 'admin.dashboard';
        elseif ($user->role === 'boutique') $route = 'boutique.dashboard';

        return Redirect::route($route)->with('success', 'Votre profil a été mis à jour avec succès !');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
