<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    user:      Object,
    cart:      Array,
    cartTotal: Number,
});

const formatDate = (d) => {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
};

const formatPrice = (v) => `${Number(v || 0).toLocaleString('fr-FR')} FCFA`;

const statusLabel = (s) => ({ pending: 'En attente', confirmed: 'Confirmée', delivered: 'Livrée', cancelled: 'Annulée' }[s] || s);
const statusClass = (s) => ({ pending: 'status-pending', confirmed: 'status-confirmed', delivered: 'status-delivered', cancelled: 'status-cancelled' }[s] || '');

const initials = (name) => name ? name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase() : '?';
</script>

<template>
    <Head :title="`Profil de ${user.name}`" />
    <AdminLayout :title="`Profil de ${user.name}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Utilisateur</p>
                    <h1>{{ user.name }}</h1>
                </div>
                <div class="header-actions">
                    <Link :href="`/admin/users/${user.id}/edit`" class="btn-primary">
                        <i class="far fa-edit"></i> Modifier
                    </Link>
                    <Link href="/admin/users" class="btn-secondary">
                        <i class="far fa-arrow-left"></i> Retour
                    </Link>
                </div>
            </div>

            <div class="profile-grid">
                <!-- Fiche utilisateur -->
                <aside class="profile-card">
                    <div class="profile-avatar" :class="user.role === 'admin' ? 'avatar-admin' : 'avatar-user'">
                        {{ initials(user.name) }}
                    </div>
                    <h2>{{ user.name }}</h2>
                    <p class="profile-email">{{ user.email }}</p>

                    <span :class="['role-pill', user.role === 'admin' ? 'role-admin' : 'role-user']">
                        <i :class="['fas', user.role === 'admin' ? 'fa-shield-alt' : 'fa-user']"></i>
                        {{ user.role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                    </span>

                    <div class="profile-meta">
                        <div class="meta-row">
                            <i class="far fa-calendar-alt"></i>
                            <span>Inscrit le <strong>{{ formatDate(user.created_at) }}</strong></span>
                        </div>
                        <div class="meta-row">
                            <i :class="['far', user.email_verified_at ? 'fa-check-circle verified' : 'fa-times-circle unverified']"></i>
                            <span>Email <strong>{{ user.email_verified_at ? 'vérifié' : 'non vérifié' }}</strong></span>
                        </div>
                        <div class="meta-row">
                            <i class="fas fa-shopping-bag"></i>
                            <span><strong>{{ user.orders_count }}</strong> commande(s)</span>
                        </div>
                    </div>
                </aside>

                <!-- Commandes récentes -->
                <div class="orders-section">
                    <div class="section-header">
                        <h3>Commandes récentes</h3>
                        <span>{{ user.orders_count }} au total</span>
                    </div>

                    <div v-if="user.orders && user.orders.length" class="orders-list">
                        <div v-for="order in user.orders" :key="order.id" class="order-row">
                            <div class="order-info">
                                <strong>#{{ order.id }}</strong>
                                <span>{{ formatDate(order.created_at) }}</span>
                            </div>
                            <span :class="['status-pill', statusClass(order.status)]">{{ statusLabel(order.status) }}</span>
                            <span class="order-total">{{ formatPrice(order.total) }}</span>
                            <Link :href="`/admin/orders/${order.id}`" class="btn-action btn-view">
                                <i class="far fa-eye"></i>
                            </Link>
                        </div>
                    </div>

                    <div v-else class="empty-orders">
                        <i class="far fa-shopping-cart"></i>
                        <p>Aucune commande enregistrée.</p>
                    </div>
                </div>
            </div>

            <!-- Panier actuel -->
            <section class="cart-section">
                <div class="section-header">
                    <div class="section-title">
                        <i class="far fa-shopping-cart"></i>
                        <h3>Panier actuel</h3>
                    </div>
                    <span class="cart-count" :class="cart && cart.length ? 'count-active' : 'count-empty'">
                        {{ cart && cart.length ? `${cart.length} article(s)` : 'Panier vide' }}
                    </span>
                </div>

                <div v-if="cart && cart.length">
                    <div class="cart-list">
                        <div v-for="item in cart" :key="item.slug" class="cart-row">
                            <img
                                :src="item.image || '/assets/img/riz2.jpeg'"
                                :alt="item.title"
                                class="cart-img"
                            />
                            <div class="cart-info">
                                <strong>{{ item.title }}</strong>
                                <span class="cart-slug">{{ item.slug }}</span>
                            </div>
                            <div class="cart-stat">
                                <span>Prix unitaire</span>
                                <strong>{{ formatPrice(item.price) }}</strong>
                            </div>
                            <div class="cart-stat">
                                <span>Quantité</span>
                                <strong>× {{ item.qty }}</strong>
                            </div>
                            <div class="cart-stat cart-line-total">
                                <span>Sous-total</span>
                                <strong>{{ formatPrice(item.line_total) }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="cart-footer">
                        <div class="cart-totals">
                            <div class="total-row">
                                <span>Sous-total panier</span>
                                <strong>{{ formatPrice(cartTotal) }}</strong>
                            </div>
                            <div class="total-row delivery-row">
                                <span>Livraison estimée</span>
                                <strong :class="cartTotal >= 10000 ? 'free' : ''">
                                    {{ cartTotal >= 10000 ? 'Gratuite' : formatPrice(1500) }}
                                </strong>
                            </div>
                            <div class="total-row grand">
                                <span>Total estimé</span>
                                <strong>{{ formatPrice(cartTotal >= 10000 ? cartTotal : cartTotal + 1500) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="cart-empty">
                    <i class="far fa-shopping-cart"></i>
                    <p>Le panier de cet utilisateur est vide.</p>
                </div>
            </section>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display: flex; flex-direction: column; gap: 24px; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
.eyebrow { margin: 0 0 6px; color: #5cb85c; font-weight: 800; text-transform: uppercase; font-size: 0.78rem; }
.page-header h1 { margin: 0; color: #17351a; font-size: 1.85rem; font-weight: 900; }
.header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

.profile-grid { display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

.profile-card {
    background: #fff; border: 1px solid #e5ece2; border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23,53,26,0.06);
    padding: 28px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 12px;
}

.profile-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 1.4rem;
}
.avatar-admin { background: #ede9ff; color: #6b21a8; border: 3px solid #c4b5fd; }
.avatar-user { background: #e8f5e9; color: #24782b; border: 3px solid #c3ddc0; }

.profile-card h2 { margin: 0; color: #17351a; font-size: 1.15rem; font-weight: 900; }
.profile-email { margin: 0; color: #68746a; font-size: 0.88rem; }

.role-pill {
    display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px;
    border-radius: 999px; font-size: 0.82rem; font-weight: 900;
}
.role-admin { background: #ede9ff; color: #6b21a8; border: 1px solid #c4b5fd; }
.role-user { background: #f0faf0; color: #24782b; border: 1px solid #c3ddc0; }

.profile-meta { width: 100%; display: flex; flex-direction: column; gap: 10px; margin-top: 8px; padding-top: 16px; border-top: 1px solid #e5ece2; }
.meta-row { display: flex; align-items: center; gap: 10px; font-size: 0.88rem; color: #68746a; }
.meta-row i { color: #5cb85c; width: 16px; text-align: center; flex-shrink: 0; }
.meta-row .verified { color: #24782b; }
.meta-row .unverified { color: #9aaa95; }
.meta-row strong { color: #17351a; }

.orders-section {
    background: #fff; border: 1px solid #e5ece2; border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23,53,26,0.06); overflow: hidden;
}
.section-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 20px; border-bottom: 1px solid #e5ece2; background: #f8faf7;
}
.section-header h3 { margin: 0; color: #17351a; font-size: 1.05rem; font-weight: 900; }
.section-header span { color: #68746a; font-size: 0.88rem; }

.orders-list { display: flex; flex-direction: column; }
.order-row {
    display: flex; align-items: center; gap: 16px;
    padding: 14px 20px; border-bottom: 1px solid #edf2ea; flex-wrap: wrap;
}
.order-row:last-child { border-bottom: none; }
.order-info strong { display: block; color: #17351a; font-weight: 900; }
.order-info span { font-size: 0.82rem; color: #68746a; }
.order-total { margin-left: auto; font-weight: 900; color: #17351a; white-space: nowrap; }

.status-pill {
    display: inline-flex; align-items: center; padding: 4px 10px;
    border-radius: 999px; font-size: 0.78rem; font-weight: 900; white-space: nowrap;
}
.status-pending { background: #fff8e1; color: #b8860b; }
.status-confirmed { background: #e3f2fd; color: #1565c0; }
.status-delivered { background: #e8f5e9; color: #24782b; }
.status-cancelled { background: #ffe8e8; color: #b42323; }

.empty-orders { padding: 48px 24px; text-align: center; color: #68746a; }
.empty-orders i { font-size: 2.2rem; color: #cdd6c9; display: block; margin-bottom: 12px; }

.btn-action, .btn-primary, .btn-secondary {
    display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    min-height: 36px; padding: 7px 14px; border-radius: 6px;
    text-decoration: none; font-weight: 850; font-size: 0.88rem;
    border: 1px solid transparent; cursor: pointer;
}
.btn-primary { background: #5cb85c; color: #fff; }
.btn-primary:hover { background: #4a9e4a; }
.btn-secondary { background: #fff; color: #17351a; border-color: #dfe8db; }
.btn-secondary:hover { border-color: #5cb85c; background: #fbfcfa; }
.btn-view { background: #f0faf0; color: #24782b; width: 34px; padding: 0; border: 1px solid #c3ddc0; }

@media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) { .page-header { flex-direction: column; } }

/* ── Panier ── */
.cart-section {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23,53,26,0.06);
    overflow: hidden;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #17351a;
}

.section-title i { color: #5cb85c; font-size: 1rem; }
.section-title h3 { margin: 0; font-size: 1.05rem; font-weight: 900; }

.cart-count {
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 900;
}
.count-active { background: #e8f5e9; color: #24782b; border: 1px solid #c3ddc0; }
.count-empty  { background: #f5f5f5; color: #9aaa95; border: 1px solid #e0e0e0; }

.cart-list { display: flex; flex-direction: column; }

.cart-row {
    display: grid;
    grid-template-columns: 64px 1fr repeat(3, minmax(110px, auto));
    align-items: center;
    gap: 16px;
    padding: 14px 20px;
    border-bottom: 1px solid #edf2ea;
}
.cart-row:last-child { border-bottom: none; }

.cart-img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e5ece2;
}

.cart-info { display: flex; flex-direction: column; gap: 3px; }
.cart-info strong { color: #17351a; font-weight: 900; }
.cart-slug { color: #9aaa95; font-size: 0.8rem; }

.cart-stat { display: flex; flex-direction: column; gap: 3px; }
.cart-stat span { color: #9aaa95; font-size: 0.78rem; font-weight: 700; }
.cart-stat strong { color: #17351a; font-weight: 900; }
.cart-line-total strong { color: #24782b; }

.cart-footer {
    border-top: 2px solid #e5ece2;
    padding: 16px 20px;
    background: #f8faf7;
    display: flex;
    justify-content: flex-end;
}

.cart-totals {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 280px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    font-size: 0.9rem;
    color: #68746a;
}
.total-row strong { color: #17351a; font-weight: 900; }
.total-row .free { color: #24782b; }

.total-row.grand {
    padding-top: 10px;
    border-top: 1.5px solid #e5ece2;
    font-size: 1rem;
    font-weight: 900;
    color: #17351a;
}
.total-row.grand strong { color: #24782b; font-size: 1.1rem; }

.cart-empty {
    padding: 48px 24px;
    text-align: center;
    color: #9aaa95;
}
.cart-empty i { font-size: 2.2rem; display: block; margin-bottom: 12px; color: #cdd6c9; }
.cart-empty p { margin: 0; font-size: 0.95rem; }

@media (max-width: 768px) {
    .cart-row {
        grid-template-columns: 56px 1fr;
    }
    .cart-stat { grid-column: 2; }
}
</style>
