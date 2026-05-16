<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    order: Object,
});

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const statusLabels = {
    pending: 'En attente',
    confirmed: 'Confirmée',
    preparing: 'En préparation',
    shipped: 'En livraison',
    delivered: 'Livrée',
    cancelled: 'Annulée',
};

const statusClass = (status) => ({
    pending: 'warning',
    confirmed: 'info',
    preparing: 'info',
    shipped: 'active',
    delivered: 'success',
    cancelled: 'danger',
}[status] || 'warning');
</script>

<template>
    <Head :title="`Commande ${order.order_number}`" />

    <AdminLayout :title="`Commande ${order.order_number}`">
        <div class="admin-page">
            <div class="page-header">
                <h1>Détails de la Commande</h1>
                <Link href="/admin/orders" class="btn-secondary">
                    <i class="far fa-arrow-left"></i>
                    Retour
                </Link>
            </div>

            <div class="order-details">
                <div class="detail-card">
                    <h2>Informations de la commande</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span>Numéro</span>
                            <strong>{{ order.order_number }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Statut</span>
                            <span :class="['status-pill', statusClass(order.status)]">
                                {{ statusLabels[order.status] || order.status }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span>Date</span>
                            <strong>{{ new Date(order.created_at).toLocaleDateString('fr-FR') }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Méthode de paiement</span>
                            <strong>{{ order.payment_method }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Total</span>
                            <strong class="total">{{ formatPrice(order.total) }} FCFA</strong>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <h2>Informations du client</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span>Nom</span>
                            <strong>{{ order.user?.name || 'N/A' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Email</span>
                            <strong>{{ order.user?.email || 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <h2>Articles commandés</h2>
                    <div class="items-list">
                        <div v-for="item in order.items" :key="item.product_slug" class="order-item">
                            <div class="item-image">
                                <img :src="item.product_image" :alt="item.product_title">
                            </div>
                            <div class="item-details">
                                <strong class="item-name">{{ item.product_title }}</strong>
                                <div class="item-specs">
                                    <div class="spec-item">
                                        <span>Quantité :</span>
                                        <strong>{{ item.quantity }}</strong>
                                    </div>
                                    <div class="spec-item">
                                        <span>Prix unitaire :</span>
                                        <strong>{{ formatPrice(item.unit_price) }} FCFA</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="item-total">
                                <span>Total</span>
                                <strong>{{ formatPrice(item.line_total) }} FCFA</strong>
                            </div>
                        </div>
                    </div>
                    <div class="order-total">
                        <span>Total commande</span>
                        <strong>{{ formatPrice(order.total) }} FCFA</strong>
                    </div>
                </div>
            </div>
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
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.page-header h1 {
    margin: 0;
    color: #1a3a1a;
    font-size: 1.75rem;
    font-weight: 900;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #fff;
    color: #1a3a1a;
    border: 1.5px solid #e8eee3;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #f9faf9;
    border-color: #5cb85c;
}

.order-details {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.detail-card {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.detail-card h2 {
    margin: 0 0 20px;
    color: #1a3a1a;
    font-size: 1.25rem;
    font-weight: 900;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-item span {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

.info-item strong {
    color: #1a3a1a;
    font-weight: 700;
}

.info-item .total {
    font-size: 1.25rem;
    color: #2d7a2d;
}

.status-pill {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
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

.items-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.order-item {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: #f9faf9;
    border-radius: 12px;
    border: 1px solid #e8eee3;
}

.item-image img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #e8eee3;
}

.item-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.item-name {
    color: #1a3a1a;
    font-weight: 700;
    font-size: 1rem;
}

.item-specs {
    display: flex;
    gap: 24px;
}

.spec-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.spec-item span {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

.spec-item strong {
    color: #1a3a1a;
    font-weight: 700;
}

.item-total {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.item-total span {
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.item-total strong {
    color: #2d7a2d;
    font-weight: 900;
    font-size: 1.1rem;
}

.order-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 2px solid #e8eee3;
    margin-top: 8px;
}

.order-total span {
    color: #6b7280;
    font-weight: 600;
}

.order-total strong {
    color: #2d7a2d;
    font-size: 1.5rem;
    font-weight: 900;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .order-item {
        grid-template-columns: 64px 1fr;
        gap: 12px;
        padding: 16px;
    }

    .item-image img {
        width: 64px;
        height: 64px;
    }

    .item-specs {
        flex-direction: column;
        gap: 8px;
    }

    .item-total {
        grid-column: 2;
        align-items: flex-start;
    }
}
</style>
