<template>
    <AppLayout title="Détails Produit">
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
                        <li>Détails Produit</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Détails Produit</h1>
                </div>
            </div>
        </section>

        <!-- Shop Details Section Start -->
        <section class="shop-details-section section-padding fix">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="shop-details-thumb">
                            <img src="/assets/img/inner-page/shop/shop-details-01.jpg" alt="img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shop-details-content">
                            <h2>Riz Blanc Premium 5kg</h2>
                            <div class="price">
                                <span>5 000 FCFA</span>
                                <del>6 000 FCFA</del>
                            </div>
                            <p>Riz blanc naturellement parfumé de qualité supérieure, certifié ITRA. Cultivé localement au TOGO par les producteurs de la coopérative HEZOUWE.</p>
                            <div class="quantity-wrapper">
                                <label>Quantité:</label>
                                <input type="number" value="1" min="1">
                            </div>
                            <div class="shop-details-btn">
                                <Link href="/shop-cart" class="theme-btn">Ajouter au Panier <i class="fas fa-shopping-basket"></i></Link>
                                <Link href="/checkout" class="theme-btn style-2">Acheter Maintenant <i class="far fa-arrow-right"></i></Link>
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
</script>
