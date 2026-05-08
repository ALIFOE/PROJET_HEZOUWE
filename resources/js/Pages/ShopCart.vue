<template>
    <AppLayout title="Mon Panier">
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt="img"></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt="img"></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/shop">Nos Produits</Link></li>
                        <li>//</li>
                        <li>Mon Panier</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Mon Panier</h1>
                </div>
            </div>
        </section>

        <!-- Cart Section -->
        <section class="sc-section">
            <div class="container">

                <!-- Empty state -->
                <div v-if="cartItems.length === 0" class="sc-empty wow fadeInUp">
                    <i class="far fa-shopping-cart"></i>
                    <h3>Votre panier est vide</h3>
                    <p>Découvrez nos produits de riz de qualité et commencez vos achats.</p>
                    <Link href="/shop" class="sc-btn-primary">
                        <i class="fal fa-arrow-left"></i> Continuer les Achats
                    </Link>
                </div>

                <div v-else class="row g-4">
                    <!-- Cart table -->
                    <div class="col-lg-8 wow fadeInLeft">
                        <div class="sc-card">
                            <div class="sc-card-header">
                                <h4>Articles ({{ cartItems.length }})</h4>
                                <button class="sc-clear-btn" @click="clearCart">
                                    <i class="far fa-trash-alt"></i> Vider le panier
                                </button>
                            </div>

                            <div class="sc-table-wrap">
                                <table class="sc-table">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th class="text-center">Prix unitaire</th>
                                            <th class="text-center">Quantité</th>
                                            <th class="text-center">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in cartItems" :key="item.slug" class="sc-row">
                                            <td>
                                                <div class="sc-product">
                                                    <div class="sc-product-img">
                                                        <img :src="item.image" :alt="item.title">
                                                    </div>
                                                    <div class="sc-product-info">
                                                        <div class="sc-product-cat">{{ item.category }}</div>
                                                        <h6>
                                                            <Link :href="`/shop-details/${item.slug}`">{{ item.title }}</Link>
                                                        </h6>
                                                        <span class="sc-product-stock" :class="item.in_stock ? 'in' : 'out'">
                                                            <i :class="item.in_stock ? 'fas fa-circle' : 'fas fa-circle'"></i>
                                                            {{ item.in_stock ? 'En stock' : 'Rupture' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="sc-price-cell">
                                                    <span class="sc-unit-price">{{ formatPrice(item.price) }} FCFA</span>
                                                    <span v-if="item.price_promo" class="sc-unit-old">
                                                        <del>{{ formatPrice(item.price_promo) }}</del>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="sc-qty-ctrl">
                                                    <button @click="updateQuantity(item, item.qty - 1)" :disabled="item.qty <= 1" class="sc-qty-btn">−</button>
                                                    <span class="sc-qty-num">{{ item.qty }}</span>
                                                    <button @click="updateQuantity(item, item.qty + 1)" class="sc-qty-btn">+</button>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="sc-line-total">{{ formatPrice(item.price * item.qty) }} FCFA</span>
                                            </td>
                                            <td>
                                                <button class="sc-remove-btn" @click="removeItem(item)" title="Supprimer">
                                                    <i class="far fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="sc-card-footer">
                                <Link href="/shop" class="sc-btn-outline">
                                    <i class="fal fa-arrow-left"></i> Continuer les achats
                                </Link>
                                <button class="sc-btn-update" @click="router.reload({ only: ['cartItems', 'cartCount'] })">
                                    <i class="far fa-sync"></i> Actualiser
                                </button>
                            </div>
                        </div>

                        <!-- Coupon -->
                        <div class="sc-coupon wow fadeInUp" data-wow-delay=".2s">
                            <h5>Avez-vous un code promo?</h5>
                            <div class="sc-coupon-form">
                                <input v-model="couponCode" type="text" placeholder="Entrez votre code promo">
                                <button @click="applyCoupon" class="sc-btn-primary">Appliquer</button>
                            </div>
                            <p v-if="couponMsg" class="sc-coupon-msg" :class="couponValid ? 'success' : 'error'">
                                <i :class="couponValid ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                {{ couponMsg }}
                            </p>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-4 wow fadeInRight">
                        <div class="sc-summary">
                            <h4 class="sc-summary-title">Récapitulatif</h4>

                            <div class="sc-summary-rows">
                                <div class="sc-sum-row">
                                    <span>Sous-total</span>
                                    <span>{{ formatPrice(subtotal) }} FCFA</span>
                                </div>
                                <div v-if="couponDiscount > 0" class="sc-sum-row discount">
                                    <span>Remise promo ({{ couponDiscount }}%)</span>
                                    <span>−{{ formatPrice(discountAmount) }} FCFA</span>
                                </div>
                                <div class="sc-sum-row">
                                    <span>Livraison</span>
                                    <span :class="deliveryFree ? 'sc-free' : ''">{{ deliveryFree ? 'Gratuite' : `${formatPrice(deliveryCost)} FCFA` }}</span>
                                </div>
                                <div class="sc-sum-row sc-sum-total">
                                    <span>Total TTC</span>
                                    <span>{{ formatPrice(total) }} FCFA</span>
                                </div>
                            </div>

                            <!-- Delivery info -->
                            <div class="sc-delivery-info">
                                <i class="flaticon-delivery"></i>
                                <p v-if="deliveryFree">Livraison <strong>gratuite</strong> pour commandes &gt; 10 000 FCFA</p>
                                <p v-else>
                                    Plus que <strong>{{ formatPrice(10000 - subtotal) }} FCFA</strong> pour la livraison gratuite
                                </p>
                                <div class="sc-delivery-bar">
                                    <div class="sc-delivery-progress" :style="`width: ${Math.min((subtotal / 10000) * 100, 100)}%`"></div>
                                </div>
                            </div>

                            <Link href="/checkout" class="sc-btn-checkout">
                                Passer à la Caisse <i class="far fa-arrow-right"></i>
                            </Link>

                            <!-- Payment icons -->
                            <div class="sc-payment-methods">
                                <p>Paiement sécurisé</p>
                                <div class="sc-pay-icons">
                                    <span class="sc-pay-icon">Mobile Money</span>
                                    <span class="sc-pay-icon">Virement</span>
                                    <span class="sc-pay-icon">Espèces</span>
                                </div>
                            </div>
                        </div>

                        <!-- Trust widget -->
                        <div class="sc-trust">
                            <div class="sc-trust-item">
                                <i class="flaticon-leaf"></i>
                                <div>
                                    <strong>100% Naturel</strong>
                                    <p>Riz cultivé localement au Togo</p>
                                </div>
                            </div>
                            <div class="sc-trust-item">
                                <i class="flaticon-delivery"></i>
                                <div>
                                    <strong>Livraison rapide</strong>
                                    <p>Sous 24–48h dans tout le Togo</p>
                                </div>
                            </div>
                            <div class="sc-trust-item">
                                <i class="flaticon-organic"></i>
                                <div>
                                    <strong>Certifié ITRA</strong>
                                    <p>Qualité garantie et traçable</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Suggested products -->
        <section class="sc-suggest section-bg">
            <div class="container">
                <div class="sc-suggest-header">
                    <h3>Vous aimerez aussi</h3>
                    <Link href="/shop" class="sc-see-all">Voir tous <i class="far fa-arrow-right"></i></Link>
                </div>
                <div class="row g-4">
                    <div v-for="p in suggested" :key="p.slug" class="col-lg-3 col-md-6 wow fadeInUp">
                        <div class="sc-sug-card">
                            <div class="sc-sug-img">
                                <img :src="p.image" :alt="p.title">
                                <span v-if="p.badge" class="sc-sug-badge">{{ p.badge }}</span>
                            </div>
                            <div class="sc-sug-body">
                                <h6><Link :href="`/shop-details/${p.slug}`">{{ p.title }}</Link></h6>
                                <div class="sc-sug-price">{{ formatPrice(p.price) }} FCFA</div>
                                <button @click="addToCart(p)" class="sc-sug-add">
                                    <i class="far fa-cart-plus"></i> Ajouter
                                </button>
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
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    products: Array,
    cartItems: Array,
});

const cartItems = computed(() => props.cartItems || []);

const couponCode = ref('');
const couponMsg = ref('');
const couponValid = ref(false);
const couponDiscount = ref(0);
const deliveryCost = 1500;

const subtotal = computed(() => cartItems.value.reduce((sum, i) => sum + i.price * i.qty, 0));
const deliveryFree = computed(() => subtotal.value >= 10000);
const discountAmount = computed(() => Math.round(subtotal.value * couponDiscount.value / 100));
const total = computed(() => subtotal.value - discountAmount.value + (deliveryFree.value ? 0 : deliveryCost));

const suggested = computed(() =>
    props.products.filter(p => !cartItems.value.find(c => c.slug === p.slug)).slice(0, 4)
);

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const removeItem = (item) => {
    router.delete(route('cart.destroy', item.cart_item_id), { preserveScroll: true });
};

const clearCart = () => {
    router.delete(route('cart.clear'), { preserveScroll: true });
};

const addToCart = (p) => {
    router.post(route('cart.store'), {
        product_slug: p.slug,
        quantity: 1,
        redirect_to: '/shop-cart',
    }, { preserveScroll: true });
};

const updateQuantity = (item, quantity) => {
    if (quantity < 1) return;

    router.patch(route('cart.update', item.cart_item_id), { quantity }, { preserveScroll: true });
};

const applyCoupon = () => {
    const validCodes = { 'HEZOUWE10': 10, 'TOGO20': 20, 'RIZ15': 15 };
    const code = couponCode.value.trim().toUpperCase();
    if (validCodes[code]) {
        couponDiscount.value = validCodes[code];
        couponValid.value = true;
        couponMsg.value = `Code appliqué ! Réduction de ${validCodes[code]}%`;
    } else {
        couponDiscount.value = 0;
        couponValid.value = false;
        couponMsg.value = 'Code promo invalide ou expiré.';
    }
};
</script>

<style scoped>
.sc-section { padding: 90px 0; }
.sc-suggest { padding: 80px 0; }

/* Empty */
.sc-empty { text-align: center; padding: 80px 20px; }
.sc-empty i { font-size: 4rem; color: #c8e6c9; display: block; margin-bottom: 20px; }
.sc-empty h3 { font-size: 1.5rem; color: #1a3a1a; margin-bottom: 10px; }
.sc-empty p { color: #777; margin-bottom: 24px; }

/* Card */
.sc-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 24px; }
.sc-card-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #f0f0f0; }
.sc-card-header h4 { font-size: 1.1rem; color: #1a3a1a; margin: 0; font-weight: 700; }
.sc-clear-btn { background: none; border: 1px solid #ffcdd2; color: #e53935; padding: 6px 14px; border-radius: 8px; font-size: .8rem; cursor: pointer; transition: all .25s; }
.sc-clear-btn:hover { background: #ffebee; }

.sc-table-wrap { overflow-x: auto; }
.sc-table { width: 100%; border-collapse: collapse; min-width: 600px; }
.sc-table thead tr { background: #f8fdf8; }
.sc-table th { padding: 12px 16px; text-align: left; font-size: .8rem; font-weight: 700; color: #1a3a1a; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid #e8f5e9; }
.sc-table th.text-center { text-align: center; }
.sc-row { border-bottom: 1px solid #f5f5f5; transition: background .2s; }
.sc-row:hover { background: #fafff8; }
.sc-row td { padding: 16px; vertical-align: middle; }
.text-center { text-align: center; }

.sc-product { display: flex; align-items: center; gap: 14px; }
.sc-product-img { width: 70px; height: 70px; border-radius: 10px; overflow: hidden; flex-shrink: 0; }
.sc-product-img img { width: 100%; height: 100%; object-fit: cover; }
.sc-product-cat { font-size: .68rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; margin-bottom: 3px; }
.sc-product-info h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin: 0 0 4px; }
.sc-product-info h6 a { color: inherit; text-decoration: none; }
.sc-product-info h6 a:hover { color: #5cb85c; }
.sc-product-stock { font-size: .72rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }
.sc-product-stock.in { color: #5cb85c; }
.sc-product-stock.in i { font-size: .5rem; }

.sc-price-cell { display: flex; flex-direction: column; align-items: center; gap: 3px; }
.sc-unit-price { font-weight: 700; color: #2d7a2d; font-size: .95rem; }
.sc-unit-old { font-size: .75rem; color: #bbb; }

.sc-qty-ctrl { display: inline-flex; align-items: center; border: 1.5px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
.sc-qty-btn { width: 34px; height: 34px; background: #f5f5f5; border: none; font-size: 1rem; cursor: pointer; transition: all .2s; color: #1a3a1a; }
.sc-qty-btn:hover { background: #5cb85c; color: #fff; }
.sc-qty-num { padding: 0 14px; font-weight: 700; font-size: .9rem; color: #1a3a1a; }

.sc-line-total { font-weight: 800; color: #1a3a1a; font-size: 1rem; }

.sc-remove-btn { width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid #ffcdd2; background: none; color: #e53935; cursor: pointer; transition: all .25s; font-size: .85rem; }
.sc-remove-btn:hover { background: #e53935; color: #fff; }

.sc-card-footer { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-top: 1px solid #f0f0f0; flex-wrap: wrap; gap: 12px; }

/* Coupon */
.sc-coupon { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
.sc-coupon h5 { font-size: 1rem; color: #1a3a1a; margin-bottom: 14px; }
.sc-coupon-form { display: flex; gap: 10px; }
.sc-coupon-form input { flex: 1; border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px 14px; font-size: .9rem; outline: none; transition: border-color .3s; }
.sc-coupon-form input:focus { border-color: #5cb85c; }
.sc-coupon-msg { margin-top: 10px; font-size: .85rem; font-weight: 600; display: flex; align-items: center; gap: 6px; }
.sc-coupon-msg.success { color: #2d7a2d; }
.sc-coupon-msg.error { color: #e53935; }

/* Summary */
.sc-summary { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 4px 24px rgba(0,0,0,.08); margin-bottom: 20px; }
.sc-summary-title { font-size: 1.1rem; font-weight: 700; color: #1a3a1a; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid #e8f5e9; }
.sc-summary-rows { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }
.sc-sum-row { display: flex; justify-content: space-between; align-items: center; font-size: .9rem; color: #555; }
.sc-sum-row.discount { color: #e53935; }
.sc-sum-total { font-size: 1.1rem; font-weight: 800; color: #1a3a1a; padding-top: 12px; border-top: 2px solid #e8f5e9; }
.sc-free { color: #2d7a2d; font-weight: 700; }

.sc-delivery-info { background: #e8f5e9; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px; display: flex; flex-direction: column; gap: 8px; }
.sc-delivery-info i { font-size: 1.2rem; color: #5cb85c; }
.sc-delivery-info p { font-size: .82rem; color: #555; margin: 0; }
.sc-delivery-bar { height: 6px; background: #c8e6c9; border-radius: 3px; overflow: hidden; }
.sc-delivery-progress { height: 100%; background: #5cb85c; border-radius: 3px; transition: width .5s; }

.sc-btn-checkout { display: flex; justify-content: center; align-items: center; gap: 8px; width: 100%; padding: 15px; background: linear-gradient(135deg, #5cb85c, #2d7a2d); color: #fff; border-radius: 12px; text-decoration: none; font-size: .95rem; font-weight: 700; transition: opacity .3s; margin-bottom: 20px; }
.sc-btn-checkout:hover { opacity: .9; color: #fff; }

.sc-payment-methods { text-align: center; }
.sc-payment-methods p { font-size: .78rem; color: #aaa; margin-bottom: 8px; }
.sc-pay-icons { display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
.sc-pay-icon { padding: 4px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: .72rem; color: #777; }

.sc-trust { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,.06); display: flex; flex-direction: column; gap: 16px; }
.sc-trust-item { display: flex; align-items: flex-start; gap: 14px; }
.sc-trust-item i { font-size: 1.4rem; color: #5cb85c; margin-top: 2px; flex-shrink: 0; }
.sc-trust-item strong { display: block; font-size: .9rem; color: #1a3a1a; margin-bottom: 2px; }
.sc-trust-item p { font-size: .78rem; color: #777; margin: 0; }

/* Shared buttons */
.sc-btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #5cb85c; color: #fff; border: none; border-radius: 10px; font-size: .9rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: background .3s; }
.sc-btn-primary:hover { background: #2d7a2d; color: #fff; }
.sc-btn-outline { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border: 2px solid #e0e0e0; background: none; color: #555; border-radius: 10px; font-size: .88rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all .3s; }
.sc-btn-outline:hover { border-color: #5cb85c; color: #5cb85c; }
.sc-btn-update { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border: 2px solid #5cb85c; background: none; color: #5cb85c; border-radius: 10px; font-size: .88rem; font-weight: 600; cursor: pointer; transition: all .3s; }
.sc-btn-update:hover { background: #5cb85c; color: #fff; }

/* Suggested */
.sc-suggest-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.sc-suggest-header h3 { font-size: 1.5rem; font-weight: 800; color: #1a3a1a; margin: 0; }
.sc-see-all { color: #5cb85c; text-decoration: none; font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: 6px; }
.sc-see-all:hover { color: #2d7a2d; }

.sc-sug-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.07); transition: transform .3s; }
.sc-sug-card:hover { transform: translateY(-5px); }
.sc-sug-img { position: relative; height: 180px; overflow: hidden; }
.sc-sug-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.sc-sug-card:hover .sc-sug-img img { transform: scale(1.06); }
.sc-sug-badge { position: absolute; top: 10px; left: 10px; background: #5cb85c; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; }
.sc-sug-body { padding: 14px; }
.sc-sug-body h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin: 0 0 6px; }
.sc-sug-body h6 a { color: inherit; text-decoration: none; }
.sc-sug-body h6 a:hover { color: #5cb85c; }
.sc-sug-price { font-size: 1rem; font-weight: 800; color: #2d7a2d; margin-bottom: 10px; }
.sc-sug-add { width: 100%; padding: 8px; background: #1a3a1a; color: #fff; border: none; border-radius: 8px; font-size: .82rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background .3s; }
.sc-sug-add:hover { background: #5cb85c; }
</style>

