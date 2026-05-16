<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import QRCode from 'qrcode';

const props = defineProps({
    cartItems: Array,
    orders: Array,
    stats: Object,
    appUrl: String,
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const cartSubtotal = computed(() =>
    (props.cartItems || []).reduce((sum, item) => sum + Number(item.line_total || 0), 0)
);

const deliveryRemaining = computed(() => Math.max(10000 - cartSubtotal.value, 0));
const deliveryProgress = computed(() => Math.min((cartSubtotal.value / 10000) * 100, 100));
const hasCart = computed(() => (props.cartItems || []).length > 0);
const hasOrders = computed(() => (props.orders || []).length > 0);
const latestOrder = computed(() => props.orders?.[0] || null);

const statusLabels = {
    pending: 'En attente',
    confirmed: 'Confirmee',
    preparing: 'Preparation',
    shipped: 'En livraison',
    delivered: 'Livree',
    cancelled: 'Annulee',
};

const statusClass = (status) => ({
    pending: 'warning',
    confirmed: 'info',
    preparing: 'info',
    shipped: 'active',
    delivered: 'success',
    cancelled: 'danger',
}[status] || 'warning');

onMounted(() => {
    (props.orders || []).forEach(order => {
        if (order.status === 'shipped') {
            const qrElement = document.getElementById(`qr-${order.id}`);
            if (qrElement) {
                const qrData = `${props.appUrl}/admin/orders/${order.id}/mark-delivered`;
                QRCode.toCanvas(qrElement, qrData, {
                    width: 128,
                    margin: 1,
                    color: {
                        dark: '#1a3a1a',
                        light: '#ffffff'
                    }
                });
            }
        }
    });
});
</script>

<template>
    <Head title="Mon espace client" />

    <AuthenticatedLayout>
        <section class="dash-hero">
            <div class="container">
                <div class="dash-hero-grid">
                    <div>
                        <span class="dash-kicker">Espace client HEZOUWE</span>
                        <h1>Bonjour {{ user?.name }}</h1>
                        <p>
                            Retrouvez votre panier, suivez vos commandes et finalisez vos achats de riz local en quelques clics.
                        </p>
                        <div class="dash-actions">
                            <Link href="/shop" class="dash-btn primary">
                                <i class="far fa-shopping-bag"></i>
                                Commander du riz
                            </Link>
                            <Link href="/shop-cart" class="dash-btn secondary">
                                <i class="far fa-shopping-cart"></i>
                                Voir mon panier
                            </Link>
                            <Link href="/logout" method="post" class="dash-btn logout">
                                <i class="far fa-sign-out"></i>
                                Déconnexion
                            </Link>
                        </div>
                    </div>

                    <div class="dash-summary-card">
                        <span>Derniere activite</span>
                        <strong v-if="latestOrder">{{ latestOrder.order_number }}</strong>
                        <strong v-else>Panier actif</strong>
                        <p v-if="latestOrder">
                            {{ latestOrder.items.length }} article(s), total {{ formatPrice(latestOrder.total) }} FCFA
                        </p>
                        <p v-else>
                            {{ stats.cart_items }} article(s) dans votre panier.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="dash-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="far fa-shopping-basket"></i>
                        <span>Articles au panier</span>
                        <strong>{{ stats.cart_items }}</strong>
                    </div>
                    <div class="stat-card">
                        <i class="far fa-receipt"></i>
                        <span>Commandes passees</span>
                        <strong>{{ stats.orders_count }}</strong>
                    </div>
                    <div class="stat-card">
                        <i class="far fa-wallet"></i>
                        <span>Total commande</span>
                        <strong>{{ formatPrice(stats.orders_total) }} FCFA</strong>
                    </div>
                    <div class="stat-card accent">
                        <i class="far fa-truck"></i>
                        <span>Livraison gratuite</span>
                        <strong>{{ deliveryRemaining === 0 ? 'Active' : formatPrice(deliveryRemaining) + ' FCFA' }}</strong>
                    </div>
                </div>

                <div class="dash-main-grid">
                    <div class="dash-panel cart-panel">
                        <div class="panel-head">
                            <div>
                                <span>Panier</span>
                                <h2>Commande en cours</h2>
                            </div>
                            <Link href="/shop-cart">Gerer</Link>
                        </div>

                        <div class="delivery-box">
                            <div>
                                <strong v-if="deliveryRemaining === 0">Livraison gratuite debloquee</strong>
                                <strong v-else>Plus que {{ formatPrice(deliveryRemaining) }} FCFA</strong>
                                <p>Livraison gratuite a partir de 10 000 FCFA.</p>
                            </div>
                            <div class="delivery-track">
                                <span :style="{ width: `${deliveryProgress}%` }"></span>
                            </div>
                        </div>

                        <div v-if="!hasCart" class="empty-state">
                            <i class="far fa-shopping-cart"></i>
                            <h3>Votre panier est vide</h3>
                            <p>Ajoutez vos sacs de riz preferes pour demarrer une commande.</p>
                            <Link href="/shop" class="dash-btn primary small">Voir les produits</Link>
                        </div>

                        <div v-else class="cart-list">
                            <div v-for="item in cartItems" :key="item.slug" class="cart-item">
                                <img :src="item.image" :alt="item.title">
                                <div>
                                    <strong>{{ item.title }}</strong>
                                    <span>{{ item.qty }} x {{ formatPrice(item.price) }} FCFA</span>
                                </div>
                                <b>{{ formatPrice(item.line_total) }} FCFA</b>
                            </div>
                        </div>

                        <div v-if="hasCart" class="panel-footer">
                            <span>Total panier</span>
                            <strong>{{ formatPrice(cartSubtotal) }} FCFA</strong>
                            <Link href="/checkout" class="dash-btn primary small">Finaliser</Link>
                        </div>
                    </div>

                    <div class="dash-panel orders-panel">
                        <div class="panel-head">
                            <div>
                                <span>Historique</span>
                                <h2>Commandes recentes</h2>
                            </div>
                            <Link href="/shop">Nouvelle commande</Link>
                        </div>

                        <div v-if="!hasOrders" class="empty-state">
                            <i class="far fa-box-open"></i>
                            <h3>Aucune commande</h3>
                            <p>Votre premiere commande apparaitra ici avec son statut.</p>
                        </div>

                        <div v-else class="order-timeline">
                            <div v-for="order in orders" :key="order.id" class="order-card">
                                <div class="order-dot" :class="statusClass(order.status)"></div>
                                <div class="order-content">
                                    <div class="order-top">
                                        <div>
                                            <strong>{{ order.order_number }}</strong>
                                            <span>{{ order.items.length }} article(s)</span>
                                        </div>
                                        <b>{{ formatPrice(order.total) }} FCFA</b>
                                    </div>
                                    <div class="order-products">
                                        <div v-for="item in order.items" :key="item.slug" class="product-item">
                                            <span class="product-name">{{ item.product_title }}</span>
                                            <span class="product-price">{{ formatPrice(item.unit_price) }} FCFA</span>
                                        </div>
                                    </div>
                                    <div v-if="order.status === 'shipped'" class="order-qr">
                                        <strong>Code QR de livraison</strong>
                                        <div class="qr-code" :id="`qr-${order.id}`"></div>
                                        <span class="qr-hint">Présentez ce code au livreur</span>
                                    </div>
                                    <div class="order-meta">
                                        <span class="status-pill" :class="statusClass(order.status)">
                                            {{ statusLabels[order.status] || order.status }}
                                        </span>
                                        <span>{{ order.payment_method }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="quick-grid">
                    <Link href="/profile" class="quick-card">
                        <i class="far fa-user-cog"></i>
                        <strong>Profil</strong>
                        <span>Modifier vos informations</span>
                    </Link>
                    <Link href="/contact" class="quick-card">
                        <i class="far fa-headset"></i>
                        <strong>Assistance</strong>
                        <span>Contacter HEZOUWE</span>
                    </Link>
                    <Link href="/faq" class="quick-card">
                        <i class="far fa-circle-question"></i>
                        <strong>Questions</strong>
                        <span>Livraison et paiement</span>
                    </Link>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
.dash-hero {
    padding: 86px 0 54px;
    color: #fff;
    background:
        linear-gradient(90deg, rgba(21, 55, 23, .94), rgba(21, 55, 23, .68)),
        url('/assets/img/riz2.jpeg') center/cover;
}

.dash-hero-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 330px;
    align-items: end;
    gap: 34px;
}

.dash-kicker,
.panel-head span {
    display: inline-flex;
    color: #d5a741;
    font-size: .76rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.dash-hero h1 {
    margin: 10px 0 12px;
    color: #fff;
    font-size: clamp(2rem, 4vw, 3.8rem);
    line-height: 1.05;
    font-weight: 900;
}

.dash-hero p {
    max-width: 650px;
    margin: 0;
    color: rgba(255,255,255,.84);
    line-height: 1.7;
}

.dash-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 26px;
}

.dash-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    min-height: 46px;
    padding: 0 18px;
    border-radius: 8px;
    font-weight: 900;
    text-decoration: none;
    transition: transform .2s, background .2s, color .2s, border-color .2s;
}

.dash-btn.primary {
    background: #5cb85c;
    color: #fff;
}

.dash-btn.secondary {
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.36);
}

.dash-btn.small {
    min-height: 40px;
    padding: 0 14px;
    font-size: .88rem;
}

.dash-btn:hover {
    transform: translateY(-1px);
}

.dash-summary-card {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.24);
    border-radius: 8px;
    padding: 24px;
    backdrop-filter: blur(8px);
}

.dash-summary-card span,
.dash-summary-card strong,
.dash-summary-card p {
    display: block;
}

.dash-summary-card span {
    color: #ffd66b;
    font-weight: 900;
    font-size: .8rem;
    text-transform: uppercase;
}

.dash-summary-card strong {
    margin-top: 8px;
    font-size: 1.4rem;
    color: #fff;
}

.dash-summary-card p {
    margin: 8px 0 0;
    color: rgba(255,255,255,.78);
}

.dash-section {
    padding: 54px 0 90px;
    background: #f5f7f2;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card,
.dash-panel,
.quick-card {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(27, 58, 28, .07);
}

.stat-card {
    padding: 20px;
}

.stat-card i {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #eaf7ea;
    color: #2d7a2d;
    margin-bottom: 14px;
}

.stat-card.accent i {
    background: #fff5d9;
    color: #a97816;
}

.stat-card span,
.cart-item span,
.order-card span,
.empty-state p,
.delivery-box p,
.quick-card span {
    color: #6b7280;
}

.stat-card strong {
    display: block;
    margin-top: 4px;
    color: #1a3a1a;
    font-size: 1.35rem;
    font-weight: 900;
}

.dash-main-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.08fr) minmax(0, .92fr);
    gap: 24px;
}

.dash-panel {
    padding: 24px;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
}

.panel-head h2 {
    margin: 4px 0 0;
    color: #1a3a1a;
    font-size: 1.28rem;
    font-weight: 900;
}

.panel-head a {
    color: #2d7a2d;
    font-weight: 900;
    text-decoration: none;
}

.delivery-box {
    padding: 16px;
    background: #f4fbf4;
    border: 1px solid #dcefdc;
    border-radius: 8px;
    margin-bottom: 18px;
}

.delivery-box strong {
    color: #1a3a1a;
}

.delivery-track {
    height: 8px;
    margin-top: 12px;
    background: #d6ead6;
    border-radius: 999px;
    overflow: hidden;
}

.delivery-track span {
    display: block;
    height: 100%;
    background: #5cb85c;
    border-radius: inherit;
    transition: width .25s;
}

.cart-list,
.order-timeline {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.cart-item {
    display: grid;
    grid-template-columns: 64px 1fr auto;
    align-items: center;
    gap: 14px;
}

.cart-item img {
    width: 64px;
    height: 64px;
    border-radius: 8px;
    object-fit: cover;
}

.cart-item strong,
.cart-item span {
    display: block;
}

.cart-item strong,
.order-card strong {
    color: #1a3a1a;
}

.cart-item b,
.order-card b {
    color: #1a3a1a;
    white-space: nowrap;
}

.panel-footer {
    display: grid;
    grid-template-columns: 1fr auto auto;
    align-items: center;
    gap: 14px;
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px solid #edf2ea;
}

.panel-footer span {
    color: #6b7280;
}

.panel-footer strong {
    color: #1a3a1a;
    font-size: 1.1rem;
}

.empty-state {
    padding: 34px 18px;
    text-align: center;
    border: 1px dashed #d8e4d4;
    border-radius: 8px;
    background: #fbfdf9;
}

.empty-state i {
    color: #aacdaa;
    font-size: 2.4rem;
}

.empty-state h3 {
    margin: 12px 0 6px;
    color: #1a3a1a;
    font-weight: 900;
}

.order-card {
    position: relative;
    display: grid;
    grid-template-columns: 18px 1fr;
    gap: 12px;
}

.order-dot {
    width: 12px;
    height: 12px;
    margin-top: 7px;
    border-radius: 50%;
    background: #d5a741;
}

.order-content {
    padding: 14px;
    border: 1px solid #edf2ea;
    border-radius: 8px;
}

.order-top,
.order-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.order-card strong,
.order-card span {
    display: block;
}

.order-products {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin: 10px 0;
    padding: 10px;
    background: #f9faf9;
    border-radius: 6px;
}

.product-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    font-size: 0.875rem;
}

.product-name {
    color: #1a3a1a;
    font-weight: 600;
}

.product-price {
    color: #2d7a2d;
    font-weight: 700;
}

.order-qr {
    margin-top: 12px;
    padding: 12px;
    background: #f4fbf4;
    border: 1px solid #dcefdc;
    border-radius: 8px;
    text-align: center;
}

.order-qr strong {
    display: block;
    color: #1a3a1a;
    font-size: 0.875rem;
    margin-bottom: 8px;
}

.qr-code {
    display: flex;
    justify-content: center;
    margin-bottom: 8px;
}

.qr-hint {
    display: block;
    color: #6b7280;
    font-size: 0.75rem;
}

.order-meta {
    margin-top: 10px;
    justify-content: flex-start;
}

.status-pill {
    display: inline-flex;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 900;
}

.success,
.status-pill.success {
    background: #e7f7e7;
    color: #24782b;
}

.warning,
.status-pill.warning {
    background: #fff5d9;
    color: #9a6b12;
}

.info,
.status-pill.info,
.active,
.status-pill.active {
    background: #e8f1ff;
    color: #245ea8;
}

.danger,
.status-pill.danger {
    background: #ffe8e8;
    color: #b42323;
}

.quick-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 24px;
}

.quick-card {
    display: grid;
    grid-template-columns: 46px 1fr;
    gap: 12px;
    padding: 18px;
    text-decoration: none;
}

.quick-card i {
    grid-row: span 2;
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #eaf7ea;
    color: #2d7a2d;
}

.quick-card strong {
    color: #1a3a1a;
}

@media (max-width: 991px) {
    .dash-hero-grid,
    .dash-main-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid,
    .quick-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .dash-hero {
        padding: 58px 0 38px;
    }

    .stats-grid,
    .quick-grid {
        grid-template-columns: 1fr;
    }

    .cart-item {
        grid-template-columns: 56px 1fr;
    }

    .cart-item b {
        grid-column: 2;
    }

    .panel-footer {
        grid-template-columns: 1fr;
    }

    .order-top,
    .order-meta {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
