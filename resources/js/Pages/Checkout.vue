<template>
    <AppLayout title="Checkout">
        <!-- Breadcrumb Section Start -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/inner-page/shape-1.png" alt="img">
            </div>
            <div class="shape-2 float-bob-x">
                <img src="/assets/img/inner-page/shape-2.png" alt="img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/shop">Nos Produits</Link></li>
                        <li>//</li>
                        <li>Checkout</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Checkout</h1>
                </div>
            </div>
        </section>

        <!-- Checkout Section Start -->
        <section class="checkout-section section-padding fix">
            <div class="container">
                <div class="checkout-wrapper">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="checkout-form">
                                <h3>Informations de Livraison</h3>
                                <form>
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="Nom Complet" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="email" placeholder="Email" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="tel" placeholder="Téléphone" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="Ville" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Adresse" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="checkout-summary">
                                <h3>Résumé de la Commande</h3>
                                <div class="summary-item">
                                    <span>Sous-total:</span>
                                    <span>5 000 FCFA</span>
                                </div>
                                <div class="summary-item">
                                    <span>Livraison:</span>
                                    <span>1 000 FCFA</span>
                                </div>
                                <div class="summary-item total">
                                    <span>Total:</span>
                                    <span>6 000 FCFA</span>
                                </div>
                                <button @click="processPayment" class="theme-btn">Payer avec Stripe <i class="far fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const processPayment = () => {
    // Ici vous intégrerez Stripe Checkout
    alert('Intégration Stripe à configurer avec vos clés API');
};
</script>
