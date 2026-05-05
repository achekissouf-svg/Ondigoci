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
use App\Http\Controllers\Boutique\SubscriptionController;
use App\Http\Controllers\BoutiqueRegistrationController;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\WishlistController;
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

    // Chat Routes
    Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/messages/send', [ChatController::class, 'send'])->name('chat.send');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');


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
    // Monetization
    Route::get('/monetization', [\App\Http\Controllers\Admin\MonetizationController::class, 'index'])->name('admin.monetization.index');
    Route::patch('/monetization/produit/{id}/toggle-sponsoring', [\App\Http\Controllers\Admin\MonetizationController::class, 'toggleSponsoring'])->name('admin.monetization.toggle');

    Route::patch('/monetization/produit/{id}/priority', [\App\Http\Controllers\Admin\MonetizationController::class, 'updatePriority'])->name('admin.monetization.priority');
    
    // Payment Moderation
    Route::get('/monetization/payments', [\App\Http\Controllers\Admin\PaymentModerationController::class, 'index'])->name('admin.monetization.payments');
    Route::patch('/monetization/payments/{id}/validate', [\App\Http\Controllers\Admin\PaymentModerationController::class, 'validatePayment'])->name('admin.monetization.payments.validate');
    Route::patch('/monetization/payments/{id}/reject', [\App\Http\Controllers\Admin\PaymentModerationController::class, 'rejectPayment'])->name('admin.monetization.payments.reject');

    // Boutique Verification Moderation
    Route::get('/verifications', [\App\Http\Controllers\Admin\VerificationModerationController::class, 'index'])->name('admin.verifications.index');
    Route::patch('/verifications/{id}/approve', [\App\Http\Controllers\Admin\VerificationModerationController::class, 'approve'])->name('admin.verifications.approve');
    Route::patch('/verifications/{id}/reject', [\App\Http\Controllers\Admin\VerificationModerationController::class, 'reject'])->name('admin.verifications.reject');
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

    // Boutique Subscriptions
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('boutique.subscription.index');
    Route::post('/subscription/pay', [SubscriptionController::class, 'pay'])->name('boutique.subscription.pay');
    Route::get('/subscription/callback', [SubscriptionController::class, 'callback'])->name('boutique.subscription.callback');

    // Manual Payments
    Route::get('/payment/manual', [\App\Http\Controllers\Boutique\ManualPaymentController::class, 'create'])->name('boutique.payment.manual');
    Route::post('/payment/manual', [\App\Http\Controllers\Boutique\ManualPaymentController::class, 'store'])->name('boutique.payment.store');

    // Boutique Verification
    Route::get('/verification', [\App\Http\Controllers\Boutique\VerificationController::class, 'index'])->name('boutique.verification.index');
    Route::post('/verification', [\App\Http\Controllers\Boutique\VerificationController::class, 'store'])->name('boutique.verification.store');
});




    Route::get('/boutique/pending', function () {
    return view('boutique.pending');
})->middleware('auth')->name('boutique.pending');

// Pages Statiques
Route::get('/centre-aide', [HomeController::class, 'helpCenter'])->name('help.center');
Route::get('/aide-support', [HomeController::class, 'helpSupport'])->name('help.support');
Route::get('/informations-legales', [HomeController::class, 'legal'])->name('legal');