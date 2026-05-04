<template>
    <AppLayout title="Panier">
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
                        <li>Panier</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Mon Panier</h1>
                </div>
            </div>
        </section>

        <!-- Shop Cart Section Start -->
        <section class="shop-cart-section section-padding fix">
            <div class="container">
                <div class="shop-cart-wrapper">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="cart-product">
                                                    <img src="/assets/img/inner-page/shop/shop-cart-01.png" alt="img">
                                                    <h4>Riz Blanc Premium 5kg</h4>
                                                </div>
                                            </td>
                                            <td>5 000 FCFA</td>
                                            <td><input type="number" value="1" min="1"></td>
                                            <td>5 000 FCFA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-total">
                                <h3>Total du Panier</h3>
                                <div class="total-price">
                                    <span>Sous-total:</span>
                                    <span>5 000 FCFA</span>
                                </div>
                                <div class="total-price">
                                    <span>Total:</span>
                                    <span>5 000 FCFA</span>
                                </div>
                                <Link href="/checkout" class="theme-btn">Passer à la Caisse <i class="far fa-arrow-right"></i></Link>
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
