<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Page À Propos
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

// Page Boutique
Route::get('/shop', function () {
    return Inertia::render('Shop');
})->name('shop');

// Page Détails Produit
Route::get('/shop-details', function () {
    return Inertia::render('ShopDetails');
})->name('shop-details');

// Page Panier
Route::get('/shop-cart', function () {
    return Inertia::render('ShopCart');
})->name('shop-cart');

// Page Services
Route::get('/service', function () {
    return Inertia::render('Service');
})->name('service');

// Page Détails Service
Route::get('/service-details', function () {
    return Inertia::render('ServiceDetails');
})->name('service-details');

// Page Contact
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

// Page Projets
Route::get('/project', function () {
    return Inertia::render('Project');
})->name('project');

// Page Détails Projet
Route::get('/project-details', function () {
    return Inertia::render('ProjectDetails');
})->name('project-details');

// Page Nouvelles
Route::get('/news', function () {
    return Inertia::render('News');
})->name('news');

// Page Détails Nouvelles
Route::get('/news-details', function () {
    return Inertia::render('NewsDetails');
})->name('news-details');

// Page Équipe
Route::get('/team', function () {
    return Inertia::render('Team');
})->name('team');

// Page Détails Équipe
Route::get('/team-details', function () {
    return Inertia::render('TeamDetails');
})->name('team-details');

// Page Galerie
Route::get('/gallery', function () {
    return Inertia::render('Gallery');
})->name('gallery');

// Page FAQ
Route::get('/faq', function () {
    return Inertia::render('Faq');
})->name('faq');

// Page Témoignages
Route::get('/testimonial', function () {
    return Inertia::render('Testimonial');
})->name('testimonial');

// Page Histoire
Route::get('/history', function () {
    return Inertia::render('History');
})->name('history');

// Page Tarifs
Route::get('/pricing', function () {
    return Inertia::render('Pricing');
})->name('pricing');

// Routes de paiement Stripe
Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/create-session', [PaymentController::class, 'createCheckoutSession'])->name('payment.create-session');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Dashboard et authentification (Breeze)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
