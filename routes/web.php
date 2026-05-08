<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
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
    return Inertia::render('Home', [
        'products' => config('products_hezouwe'),
        'services' => config('services_hezouwe'),
    ]);
})->name('home');

// Page À Propos
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

// Page Boutique
Route::get('/shop', function () {
    $products = config('products_hezouwe');
    return Inertia::render('Shop', ['products' => $products]);
})->name('shop');

// Page Détails Produit (redirection vers le premier produit par défaut)
Route::get('/shop-details', function () {
    return redirect()->route('shop-details.slug', ['slug' => 'riz-blanc-premium-5kg']);
})->name('shop-details');

// Page Détails Produit par slug
Route::get('/shop-details/{slug}', function ($slug) {
    $allProducts = config('products_hezouwe');
    $product = collect($allProducts)->firstWhere('slug', $slug);
    if (!$product) {
        abort(404);
    }
    $related = collect($allProducts)->where('slug', '!=', $slug)->take(4)->values()->all();
    return Inertia::render('ShopDetails', [
        'product'     => $product,
        'allProducts' => $allProducts,
        'related'     => $related,
    ]);
})->name('shop-details.slug');

// Page Services
Route::get('/service', function () {
    $allServices = config('services_hezouwe');
    return Inertia::render('Service', ['allServices' => $allServices]);
})->name('service');

// Page Détails Service (redirection vers le premier service par défaut)
Route::get('/service-details', function () {
    return redirect()->route('service-details.slug', ['slug' => 'collecte']);
})->name('service-details');

// Page Détails Service par slug
Route::get('/service-details/{slug}', function ($slug) {
    $allServices = config('services_hezouwe');
    $service = collect($allServices)->firstWhere('slug', $slug);
    if (!$service) {
        abort(404);
    }
    return Inertia::render('ServiceDetails', [
        'service'     => $service,
        'allServices' => $allServices,
    ]);
})->name('service-details.slug');

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
    $allNews = config('news_hezouwe');
    return Inertia::render('News', ['allNews' => $allNews]);
})->name('news');

// Page Détails Actualité (redirection vers le premier article par défaut)
Route::get('/news-details', function () {
    return redirect()->route('news-details.slug', ['slug' => '5000-clients-satisfaits']);
})->name('news-details');

// Page Détails Actualité par slug
Route::get('/news-details/{slug}', function ($slug) {
    $allNews = config('news_hezouwe');
    $article = collect($allNews)->firstWhere('slug', $slug);
    if (!$article) {
        abort(404);
    }
    $recent  = collect($allNews)->where('slug', '!=', $slug)->take(3)->values()->all();
    return Inertia::render('NewsDetails', [
        'article' => $article,
        'allNews' => $allNews,
        'recent'  => $recent,
    ]);
})->name('news-details.slug');

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

// Dashboard et authentification (Breeze)
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/shop-cart', [CartController::class, 'index'])->name('shop-cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes de paiement Stripe existantes
Route::post('/payment/create-session', [PaymentController::class, 'createCheckoutSession'])->middleware('auth')->name('payment.create-session');
Route::get('/payment/success', [PaymentController::class, 'success'])->middleware('auth')->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->middleware('auth')->name('payment.cancel');

require __DIR__.'/auth.php';
