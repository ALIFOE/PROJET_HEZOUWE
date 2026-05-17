<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    order: Object,
});

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleString('fr-FR') : 'N/A';

const statusLabels = {
    pending: 'En attente',
    confirmed: 'Confirmee',
    preparing: 'En preparation',
    shipped: 'En livraison',
    delivered: 'Livree',
    cancelled: 'Annulee',
};

const paymentLabels = {
    unpaid: 'Non payee',
    paid: 'Payee',
    failed: 'Echec',
    refunded: 'Remboursee',
};

const statusClass = (status) => ({
    pending: 'warning',
    confirmed: 'info',
    preparing: 'info',
    shipped: 'active',
    delivered: 'success',
    cancelled: 'danger',
}[status] || 'warning');

const deleteOrder = () => {
    if (!confirm(`Supprimer definitivement la commande ${props.order.order_number} ?`)) {
        return;
    }

    router.delete(`/admin/orders/${props.order.id}`);
};
</script>

<template>
    <Head :title="`Commande ${order.order_number}`" />

    <AdminLayout :title="`Commande ${order.order_number}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Detail commande</p>
                    <h1>{{ order.order_number }}</h1>
                    <p class="header-text">Consultez les informations client, livraison, paiement et articles commandes.</p>
                </div>
                <div class="header-actions">
                    <Link :href="`/admin/orders/${order.id}/edit`" class="btn-primary">
                        <i class="far fa-edit"></i>
                        Modifier la commande
                    </Link>
                    <Link href="/admin/orders" class="btn-secondary">
                        <i class="far fa-arrow-left"></i>
                        Retour a la liste
                    </Link>
                    <button type="button" class="btn-danger" @click="deleteOrder">
                        <i class="far fa-trash-alt"></i>
                        Supprimer
                    </button>
                </div>
            </div>

            <div class="summary-strip">
                <div>
                    <span>Statut</span>
                    <strong :class="['status-pill', statusClass(order.status)]">
                        {{ statusLabels[order.status] || order.status }}
                    </strong>
                </div>
                <div>
                    <span>Paiement</span>
                    <strong>{{ paymentLabels[order.payment_status] || order.payment_status || 'N/A' }}</strong>
                </div>
                <div>
                    <span>Total</span>
                    <strong class="money">{{ formatPrice(order.total) }}</strong>
                </div>
                <div>
                    <span>Date</span>
                    <strong>{{ formatDate(order.created_at) }}</strong>
                </div>
            </div>

            <div class="details-grid">
                <section class="detail-card">
                    <h2>Informations client</h2>
                    <div class="info-list">
                        <div>
                            <span>Nom</span>
                            <strong>{{ order.customer_name || order.user?.name || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Email</span>
                            <strong>{{ order.customer_email || order.user?.email || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Telephone</span>
                            <strong>{{ order.customer_phone || 'N/A' }}</strong>
                        </div>
                    </div>
                </section>

                <section class="detail-card">
                    <h2>Livraison</h2>
                    <div class="info-list">
                        <div>
                            <span>Ville</span>
                            <strong>{{ order.city || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Adresse</span>
                            <strong>{{ order.address || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Notes</span>
                            <strong>{{ order.notes || 'Aucune note' }}</strong>
                        </div>
                    </div>
                </section>
            </div>

            <section class="detail-card">
                <div class="card-header">
                    <h2>Articles commandes</h2>
                    <span>{{ order.items?.length || 0 }} article(s)</span>
                </div>

                <div class="items-list">
                    <article v-for="item in order.items" :key="item.id || item.product_slug" class="order-item">
                        <img :src="item.product_image || '/assets/img/riz2.jpeg'" :alt="item.product_title">
                        <div class="item-main">
                            <strong>{{ item.product_title }}</strong>
                            <span>{{ item.product_slug }}</span>
                        </div>
                        <div class="item-stat">
                            <span>Quantite</span>
                            <strong>{{ item.quantity }}</strong>
                        </div>
                        <div class="item-stat">
                            <span>Prix unitaire</span>
                            <strong>{{ formatPrice(item.unit_price) }}</strong>
                        </div>
                        <div class="item-stat total">
                            <span>Total ligne</span>
                            <strong>{{ formatPrice(item.line_total) }}</strong>
                        </div>
                    </article>
                </div>

                <div class="totals-box">
                    <div>
                        <span>Sous-total</span>
                        <strong>{{ formatPrice(order.subtotal) }}</strong>
                    </div>
                    <div>
                        <span>Livraison</span>
                        <strong>{{ formatPrice(order.delivery_cost) }}</strong>
                    </div>
                    <div>
                        <span>Remise</span>
                        <strong>{{ formatPrice(order.discount) }}</strong>
                    </div>
                    <div class="grand-total">
                        <span>Total commande</span>
                        <strong>{{ formatPrice(order.total) }}</strong>
                    </div>
                </div>
            </section>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
}

.eyebrow {
    margin: 0 0 6px;
    color: #5cb85c;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 0.78rem;
}

.page-header h1 {
    margin: 0;
    color: #17351a;
    font-size: 1.85rem;
    font-weight: 900;
}

.header-text {
    margin: 8px 0 0;
    color: #68746a;
}

.header-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.btn-primary,
.btn-secondary,
.btn-danger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 850;
    border: 1.5px solid transparent;
    cursor: pointer;
}

.btn-primary {
    background: #5cb85c;
    color: #fff;
}

.btn-secondary {
    background: #fff;
    color: #17351a;
    border-color: #dfe8db;
}

.btn-danger {
    background: #fff;
    color: #b42323;
    border-color: #ffd4d4;
}

.summary-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    overflow: hidden;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    background: #e5ece2;
}

.summary-strip > div {
    background: #fff;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.summary-strip span,
.info-list span,
.item-stat span,
.totals-box span {
    color: #68746a;
    font-size: 0.84rem;
    font-weight: 750;
}

.summary-strip strong,
.info-list strong,
.item-stat strong {
    color: #17351a;
}

.money {
    color: #24782b !important;
    font-size: 1.12rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.detail-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    padding: 24px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.detail-card h2,
.card-header h2 {
    margin: 0;
    color: #17351a;
    font-size: 1.18rem;
    font-weight: 900;
}

.card-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 18px;
}

.card-header span {
    color: #68746a;
    font-weight: 800;
}

.info-list {
    display: grid;
    gap: 14px;
    margin-top: 18px;
}

.info-list div {
    display: grid;
    gap: 4px;
}

.status-pill {
    width: fit-content;
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 900;
}

.status-pill.success {
    background: #e7f7e7;
    color: #24782b;
}

.status-pill.warning {
    background: #fff5d9;
    color: #9a6b12;
}

.status-pill.info,
.status-pill.active {
    background: #e8f1ff;
    color: #245ea8;
}

.status-pill.danger {
    background: #ffe8e8;
    color: #b42323;
}

.items-list {
    display: grid;
    gap: 12px;
}

.order-item {
    display: grid;
    grid-template-columns: 74px minmax(180px, 1fr) repeat(3, minmax(120px, auto));
    align-items: center;
    gap: 16px;
    padding: 14px;
    background: #fbfcfa;
    border: 1px solid #edf2ea;
    border-radius: 8px;
}

.order-item img {
    width: 74px;
    height: 74px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e5ece2;
}

.item-main {
    display: grid;
    gap: 4px;
}

.item-main strong {
    color: #17351a;
}

.item-main span {
    color: #68746a;
    font-size: 0.84rem;
}

.item-stat {
    display: grid;
    gap: 4px;
}

.item-stat.total strong {
    color: #24782b;
}

.totals-box {
    max-width: 420px;
    margin: 22px 0 0 auto;
    border-top: 1px solid #e5ece2;
    padding-top: 14px;
    display: grid;
    gap: 10px;
}

.totals-box div {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.totals-box strong {
    color: #17351a;
}

.grand-total {
    padding-top: 12px;
    border-top: 2px solid #e5ece2;
}

.grand-total strong {
    color: #24782b;
    font-size: 1.35rem;
}

@media (max-width: 1100px) {
    .summary-strip,
    .details-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .order-item {
        grid-template-columns: 74px 1fr;
    }

    .item-stat {
        grid-column: 2;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
    }

    .summary-strip,
    .details-grid {
        grid-template-columns: 1fr;
    }

    .detail-card {
        padding: 18px;
    }
}
</style>
