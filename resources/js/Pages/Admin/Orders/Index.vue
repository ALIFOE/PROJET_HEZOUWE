<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    orders: Object,
});

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleDateString('fr-FR') : 'N/A';

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

const deleteOrder = (order) => {
    if (!confirm(`Supprimer definitivement la commande ${order.order_number} ?`)) {
        return;
    }

    router.delete(`/admin/orders/${order.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Gestion des commandes" />

    <AdminLayout title="Gestion des commandes">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Commandes clients</h1>
                    <p class="header-text">Suivez, consultez et mettez a jour les commandes depuis un seul tableau.</p>
                </div>
            </div>

            <div class="table-card">
                <div class="table-toolbar">
                    <div>
                        <strong>{{ orders.total || orders.data.length }}</strong>
                        <span>commande(s)</span>
                    </div>
                    <span class="toolbar-note">Actions disponibles : voir, modifier, supprimer</span>
                </div>

                <div class="table-scroll">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Articles</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Paiement</th>
                                <th>Date</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders.data" :key="order.id">
                                <td>
                                    <strong class="order-number">{{ order.order_number }}</strong>
                                    <span class="muted">ID {{ order.id }}</span>
                                </td>
                                <td>
                                    <strong>{{ order.customer_name || order.user?.name || 'Client inconnu' }}</strong>
                                    <span class="muted">{{ order.customer_phone || order.user?.email || 'Aucun contact' }}</span>
                                </td>
                                <td>{{ order.items?.length || 0 }} article(s)</td>
                                <td class="total-cell">{{ formatPrice(order.total) }}</td>
                                <td>
                                    <span :class="['status-pill', statusClass(order.status)]">
                                        {{ statusLabels[order.status] || order.status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="payment-pill">{{ paymentLabels[order.payment_status] || order.payment_status || 'N/A' }}</span>
                                </td>
                                <td>{{ formatDate(order.created_at) }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <Link :href="`/admin/orders/${order.id}`" class="btn-action btn-view">
                                            <i class="far fa-eye"></i>
                                            Voir
                                        </Link>
                                        <Link :href="`/admin/orders/${order.id}/edit`" class="btn-action btn-edit">
                                            <i class="far fa-edit"></i>
                                            Modifier
                                        </Link>
                                        <button type="button" class="btn-action btn-delete" @click="deleteOrder(order)">
                                            <i class="far fa-trash-alt"></i>
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="orders.data.length === 0" class="empty-state">
                    <i class="far fa-receipt"></i>
                    <h3>Aucune commande</h3>
                    <p>Les nouvelles commandes apparaitront ici.</p>
                </div>
            </div>

            <div v-if="orders.links && orders.links.length > 3" class="pagination">
                <template v-for="(link, index) in orders.links" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="page-link"
                        :class="{ active: link.active }"
                        v-html="link.label"
                    />
                    <span v-else class="page-link disabled" v-html="link.label" />
                </template>
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

.table-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
    overflow: hidden;
}

.table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 18px 20px;
    border-bottom: 1px solid #e5ece2;
    background: #fbfcfa;
}

.table-toolbar strong {
    color: #17351a;
    font-size: 1.15rem;
}

.table-toolbar span,
.toolbar-note {
    color: #68746a;
    font-weight: 600;
}

.table-scroll {
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    min-width: 1060px;
    border-collapse: collapse;
}

.orders-table th {
    text-align: left;
    padding: 14px 16px;
    color: #68746a;
    font-size: 0.78rem;
    font-weight: 900;
    text-transform: uppercase;
    border-bottom: 1px solid #e5ece2;
    background: #f8faf7;
}

.orders-table td {
    padding: 16px;
    color: #17351a;
    border-bottom: 1px solid #edf2ea;
    vertical-align: middle;
}

.orders-table tr:hover td {
    background: #fbfcfa;
}

.order-number,
.orders-table td strong {
    display: block;
    color: #17351a;
    font-weight: 850;
}

.muted {
    display: block;
    margin-top: 4px;
    color: #7a857c;
    font-size: 0.83rem;
}

.total-cell {
    font-weight: 900;
    white-space: nowrap;
}

.status-pill,
.payment-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 900;
    white-space: nowrap;
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

.payment-pill {
    background: #f0f3ee;
    color: #4d5a50;
}

.actions-col {
    width: 310px;
}

.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 36px;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid transparent;
    cursor: pointer;
    font-weight: 800;
    font-size: 0.84rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view {
    background: #e8f4ff;
    color: #245ea8;
}

.btn-edit {
    background: #e8f7e8;
    color: #24782b;
}

.btn-delete {
    background: #fff;
    color: #b42323;
    border-color: #ffd4d4;
}

.btn-action:hover {
    transform: translateY(-1px);
}

.empty-state {
    padding: 64px 24px;
    text-align: center;
    color: #68746a;
}

.empty-state i {
    font-size: 2.8rem;
    color: #cdd6c9;
    margin-bottom: 16px;
}

.empty-state h3 {
    margin: 0 0 8px;
    color: #17351a;
}

.pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
}

.page-link {
    padding: 8px 14px;
    border: 1px solid #e5ece2;
    border-radius: 6px;
    background: #fff;
    color: #17351a;
    text-decoration: none;
    font-weight: 800;
}

.page-link.active {
    background: #5cb85c;
    color: #fff;
    border-color: #5cb85c;
}

.page-link.disabled {
    color: #a5aea2;
}

@media (max-width: 768px) {
    .table-toolbar,
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
