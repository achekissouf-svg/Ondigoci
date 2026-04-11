<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Boutique
Route::get('/shop', [ProduitController::class, 'index'])->name('shop');

// Routes d'authentification (gérées par Breeze)
require __DIR__.'/auth.php';

// Routes protégées (nécessitent d'être connecté)
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [PanierController::class, 'add'])->name('cart.add');
    Route::get('/cart', [PanierController::class, 'index'])->name('cart.index');
    Route::post('/checkout', [CommandeController::class, 'store'])->name('checkout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});