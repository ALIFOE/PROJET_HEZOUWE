<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Support\ProductCatalog;
use App\Support\ServiceCatalog;
use App\Support\NewsCatalog;
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
        'products' => ProductCatalog::all(),
        'services' => ServiceCatalog::all(),
    ]);
})->name('home');

// Page À Propos
Route::get('/about', function () {
    return Inertia::render('About', [
        'products' => ProductCatalog::all(),
        'news'     => NewsCatalog::latest(4),
    ]);
})->name('about');

// Page Boutique
Route::get('/shop', function () {
    $products = ProductCatalog::all();
    return Inertia::render('Shop', ['products' => $products]);
})->name('shop');

// Page Détails Produit (redirection vers le premier produit par défaut)
Route::get('/shop-details', function () {
    return redirect()->route('shop-details.slug', ['slug' => 'riz-blanc-premium-5kg']);
})->name('shop-details');

// Page Détails Produit par slug
Route::get('/shop-details/{slug}', function ($slug) {
    $allProducts = ProductCatalog::all();
    $product = $allProducts->firstWhere('slug', $slug);
    if (!$product) {
        abort(404);
    }
    $related = $allProducts->where('slug', '!=', $slug)->take(4)->values()->all();
    return Inertia::render('ShopDetails', [
        'product'     => $product,
        'allProducts' => $allProducts,
        'related'     => $related,
    ]);
})->name('shop-details.slug');

// Page Services
Route::get('/service', function () {
    $allServices = ServiceCatalog::all();
    return Inertia::render('Service', ['allServices' => $allServices]);
})->name('service');

// Page Détails Service (redirection vers le premier service par défaut)
Route::get('/service-details', function () {
    return redirect()->route('service-details.slug', ['slug' => 'collecte']);
})->name('service-details');

// Page Détails Service par slug
Route::get('/service-details/{slug}', function ($slug) {
    $allServices = ServiceCatalog::all();
    $service = $allServices->firstWhere('slug', $slug);
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
    $allNews = NewsCatalog::all();
    return Inertia::render('News', ['allNews' => $allNews]);
})->name('news');

// Page Détails Actualité (redirection vers le premier article par défaut)
Route::get('/news-details', function () {
    return redirect()->route('news-details.slug', ['slug' => '5000-clients-satisfaits']);
})->name('news-details');

// Page Détails Actualité par slug
Route::get('/news-details/{slug}', function ($slug) {
    $allNews = NewsCatalog::all();
    $article = $allNews->firstWhere('slug', $slug);
    if (!$article) {
        abort(404);
    }
    $recent  = $allNews->where('slug', '!=', $slug)->take(3)->values()->all();
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/shop-cart', [CartController::class, 'index'])->name('shop-cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:5,1')->name('orders.store');
    Route::patch('/orders/{order}/retry-payment', [OrderController::class, 'retryPayment'])->name('orders.retry-payment');
    Route::get('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::patch('/orders/{order}/pay', [OrderController::class, 'processPayment'])->name('orders.process-payment');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/{order}/scan-delivery', [App\Http\Controllers\DeliveryController::class, 'scan'])->name('orders.scan-delivery');
    Route::post('/orders/{order}/verify-delivery', [App\Http\Controllers\DeliveryController::class, 'verify'])->name('orders.verify-delivery');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes de paiement Stripe existantes
Route::post('/payment/create-session', [PaymentController::class, 'createCheckoutSession'])->middleware(['auth', 'verified'])->name('payment.create-session');
Route::get('/payment/success', [PaymentController::class, 'success'])->middleware(['auth', 'verified'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->middleware(['auth', 'verified'])->name('payment.cancel');

// Routes FedaPay — Mobile Money
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payment/mobile-money/{order}', function (\App\Models\Order $order) {
        abort_if($order->user_id !== request()->user()->id, 403);
        return \Inertia\Inertia::render('PaymentFedaPay', [
            'order'            => $order,
            'fedapayPublicKey' => env('FEDAPAY_PUBLIC_KEY'),
        ]);
    })->name('payment.fedapay');
    Route::post('/fedapay/initiate', [App\Http\Controllers\FedaPayController::class, 'initiate'])
        ->middleware('throttle:10,1')
        ->name('fedapay.initiate');
    Route::get('/orders/{order}/fedapay-callback', [App\Http\Controllers\FedaPayController::class, 'callback'])->name('fedapay.callback');
});
// Webhook FedaPay (pas de CSRF — serveur à serveur)
Route::post('/fedapay/webhook', [App\Http\Controllers\FedaPayController::class, 'webhook'])
    ->middleware('throttle:60,1')
    ->name('fedapay.webhook');

// Lien livreur — public, sans authentification
Route::get('/delivery/{token}', [App\Http\Controllers\DeliveryController::class, 'showQR'])->name('delivery.qr');

// Routes Admin
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::post('orders/{order}/mark-delivered', [\App\Http\Controllers\Admin\OrderController::class, 'markAsDelivered'])->name('orders.mark-delivered');
    Route::post('orders/{order}/generate-delivery-token', [App\Http\Controllers\DeliveryController::class, 'generateToken'])->name('orders.generate-delivery-token');
    Route::post('orders/{order}/verify-payment', [\App\Http\Controllers\Admin\OrderController::class, 'verifyPayment'])->name('orders.verify-payment');
    Route::post('orders/{order}/reject-payment', [\App\Http\Controllers\Admin\OrderController::class, 'rejectPayment'])->name('orders.reject-payment');
    Route::post('products/upload-image', [\App\Http\Controllers\Admin\ProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('services/upload-image', [\App\Http\Controllers\Admin\ServiceController::class, 'uploadImage'])->name('services.upload-image');
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::post('news/upload-image', [\App\Http\Controllers\Admin\NewsController::class, 'uploadImage'])->name('news.upload-image');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});

// Newsletter
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

require __DIR__.'/auth.php';
