<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object,
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
    <Head title="Gestion des Commandes" />

    <AdminLayout title="Gestion des Commandes">
        <div class="admin-page">
            <div class="page-header">
                <h1>Commandes</h1>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Commande #</th>
                            <th>Client</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id">
                            <td><strong>{{ order.order_number }}</strong></td>
                            <td>{{ order.user?.name || 'N/A' }}</td>
                            <td>{{ order.items?.length || 0 }} article(s)</td>
                            <td>{{ formatPrice(order.total) }} FCFA</td>
                            <td>
                                <span :class="['status-pill', statusClass(order.status)]">
                                    {{ statusLabels[order.status] || order.status }}
                                </span>
                            </td>
                            <td>{{ new Date(order.created_at).toLocaleDateString('fr-FR') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <Link :href="`/admin/orders/${order.id}`" class="btn-view">
                                        <i class="far fa-eye"></i>
                                    </Link>
                                    <Link :href="`/admin/orders/${order.id}/edit`" class="btn-edit">
                                        <i class="far fa-edit"></i>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="orders.data.length === 0" class="empty-state">
                    <i class="far fa-receipt"></i>
                    <h3>Aucune commande</h3>
                    <p>Les commandes apparaîtront ici.</p>
                </div>
            </div>

            <div v-if="orders.links && orders.links.length > 0" class="pagination">
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

.table-container {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    text-align: left;
    padding: 16px;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    border-bottom: 2px solid #e8eee3;
    background: #f9faf9;
}

.data-table td {
    padding: 16px;
    color: #1a3a1a;
    font-weight: 500;
    border-bottom: 1px solid #e8eee3;
    vertical-align: middle;
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover td {
    background: #f9faf9;
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

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-view,
.btn-edit {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-view {
    background: #e8f4ff;
    color: #245ea8;
}

.btn-view:hover {
    background: #d1e9ff;
}

.btn-edit {
    background: #e3f9e5;
    color: #2d7a2d;
}

.btn-edit:hover {
    background: #d1e9d1;
}

.empty-state {
    padding: 64px 24px;
    text-align: center;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 16px;
}

.empty-state h3 {
    margin: 0 0 8px;
    color: #1a3a1a;
    font-weight: 900;
}

.empty-state p {
    margin: 0;
}

.pagination {
    display: flex;
    gap: 8px;
    justify-content: center;
    padding: 16px;
}

.page-link {
    padding: 8px 16px;
    border: 1px solid #e8eee3;
    border-radius: 6px;
    color: #1a3a1a;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.page-link:hover {
    background: #f9faf9;
    border-color: #5cb85c;
}

.page-link.active {
    background: #5cb85c;
    color: #fff;
    border-color: #5cb85c;
}

.page-link.disabled {
    color: #9ca3af;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .data-table th,
    .data-table td {
        padding: 12px 8px;
    }
}
</style>
