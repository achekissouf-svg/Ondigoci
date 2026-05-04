<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ClientCommandeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BoutiqueController as AdminBoutiqueController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProduitController as AdminProduitController;
use App\Http\Controllers\Admin\CategorieController as AdminCategorieController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;
use App\Http\Controllers\Boutique\DashboardController as BoutiqueDashboardController;
use App\Http\Controllers\Boutique\ProduitController as BoutiqueProduitController;
use App\Http\Controllers\Boutique\CommandeController as BoutiqueCommandeController;
use App\Http\Controllers\Boutique\PromotionController as BoutiquePromotionController;
use App\Http\Controllers\BoutiqueRegistrationController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Boutique
Route::get('/shop', [ProduitController::class, 'index'])->name('shop');
Route::get('/search/suggestions', [ProduitController::class, 'suggestions'])->name('search.suggestions');
Route::get('/produit/{id}', [ProduitController::class, 'show'])->name('produit.show');
Route::get('/magasin/{id}', [\App\Http\Controllers\PublicBoutiqueController::class, 'show'])->name('magasin.show');
Route::post('/magasin/{id}/avis', [\App\Http\Controllers\PublicBoutiqueController::class, 'storeAvis'])
    ->middleware('auth')
    ->name('magasin.avis.store');
Route::post('/produit/{id}/avis', [\App\Http\Controllers\ProduitController::class, 'storeAvis'])
    ->middleware('auth')
    ->name('produit.avis.store');

// Routes d'authentification (gérées par Breeze)
require __DIR__.'/auth.php';

// Routes protégées (nécessitent d'être connecté)
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [PanierController::class, 'add'])->name('cart.add');
    Route::get('/cart', [PanierController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{id}', [PanierController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [PanierController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout', [CommandeController::class, 'store'])->name('checkout');
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // Client Commandes Routes
    Route::get('/mes-commandes', [ClientCommandeController::class, 'index'])->name('client.commandes');
    Route::get('/commande/{commande}', [ClientCommandeController::class, 'show'])->name('client.commandes.show');
    Route::get('/suivi-commande/{commande}', [ClientCommandeController::class, 'tracking'])->name('client.commandes.tracking');
    Route::get('/notifications', [ClientCommandeController::class, 'notificationsPage'])->name('client.notifications');
    Route::get('/notifications-data', [ClientCommandeController::class, 'notifications'])->name('client.notifications.data');
    Route::post('/notification/{notification}/mark-read', [ClientCommandeController::class, 'markNotificationAsRead'])->name('client.notification.mark-read');

    // Boutique Registration (for clients)
    Route::get('/become-seller', [BoutiqueRegistrationController::class, 'create'])->name('boutique.register');
    Route::post('/become-seller', [BoutiqueRegistrationController::class, 'store'])->name('boutique.register.store');

    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Manage Boutiques
    Route::get('/boutiques', [AdminBoutiqueController::class, 'index'])->name('admin.boutiques.index');
    Route::patch('/boutiques/{id}/approve', [AdminBoutiqueController::class, 'approve'])->name('admin.boutiques.approve');
    Route::patch('/boutiques/{id}/reject', [AdminBoutiqueController::class, 'reject'])->name('admin.boutiques.reject');
    Route::patch('/boutiques/{id}/block', [AdminBoutiqueController::class, 'block'])->name('admin.boutiques.block');
    Route::patch('/boutiques/{id}/plan', [AdminBoutiqueController::class, 'updatePlan'])->name('admin.boutiques.plan');
    
    // Manage Categories
    Route::resource('categories', AdminCategorieController::class)->names('admin.categories');
    
    // Manage Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{id}/block', [AdminUserController::class, 'block'])->name('admin.users.block');
    Route::patch('/users/{id}/unblock', [AdminUserController::class, 'unblock'])->name('admin.users.unblock');
    
    // Manage Produits (Stock Admin)
    Route::resource('produits', AdminProduitController::class)->names('admin.produits');
    
    // Admin Commandes (orders for admin's products)
    Route::get('/commandes', [AdminCommandeController::class, 'index'])->name('admin.commandes.index');
    Route::patch('/commandes/{id}/status', [AdminCommandeController::class, 'update'])->name('admin.commandes.update');
    
    // Manage Avis (Admin moderation)
    Route::get('/avis', [\App\Http\Controllers\Admin\AvisController::class, 'index'])->name('admin.avis.index');
    Route::delete('/avis/boutique/{id}', [\App\Http\Controllers\Admin\AvisController::class, 'destroyBoutiqueAvis'])->name('admin.avis.boutique.destroy');
    Route::delete('/avis/produit/{id}', [\App\Http\Controllers\Admin\AvisController::class, 'destroyProduitAvis'])->name('admin.avis.produit.destroy');
});

// Boutique Routes (Vendeurs)
Route::prefix('boutique')->middleware(['auth', 'boutique'])->group(function () {
    Route::get('/dashboard', [BoutiqueDashboardController::class, 'index'])->name('boutique.dashboard');
    // Boutique Produits CRUD
    Route::resource('produits', BoutiqueProduitController::class)->names('boutique.produits');
    // Boutique Commandes reçues
    Route::get('/commandes', [BoutiqueCommandeController::class, 'index'])->name('boutique.commandes.index');
    Route::patch('/commandes/{id}/status', [BoutiqueCommandeController::class, 'update'])->name('boutique.commandes.update');
    // Boutique Promotions
    Route::resource('promotions', BoutiquePromotionController::class)->names('boutique.promotions');
    // Boutique Avis
    Route::get('/avis', [\App\Http\Controllers\Boutique\AvisController::class, 'index'])->name('boutique.avis.index');
});

Route::get('/boutique/pending', function () {
    return view('boutique.pending');
})->middleware('auth')->name('boutique.pending');