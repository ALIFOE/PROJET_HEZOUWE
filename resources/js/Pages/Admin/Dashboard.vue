<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: Object,
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

const getStatusLabel = (status) => statusLabels[status] || status;
const getStatusClass = (status) => statusClass(status);
</script>

<template>
    <Head title="Dashboard Admin" />

    <AdminLayout title="Dashboard Admin">
        <div class="dashboard-container">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card orders">
                    <div class="stat-icon">
                        <i class="far fa-receipt"></i>
                    </div>
                    <div class="stat-content">
                        <span>Commandes</span>
                        <strong>{{ stats.orders_count }}</strong>
                        <span class="stat-subtitle">{{ formatPrice(stats.orders_total) }} FCFA</span>
                        <Link href="/admin/orders" class="stat-link">Gérer</Link>
                    </div>
                </div>

                <div class="stat-card pending">
                    <div class="stat-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <span>En attente</span>
                        <strong>{{ stats.pending_orders }}</strong>
                        <Link href="/admin/orders" class="stat-link">Voir</Link>
                    </div>
                </div>

                <div class="stat-card products">
                    <div class="stat-icon">
                        <i class="far fa-box"></i>
                    </div>
                    <div class="stat-content">
                        <span>Produits</span>
                        <strong>{{ stats.products_count }}</strong>
                        <Link href="/admin/products" class="stat-link">Gérer</Link>
                    </div>
                </div>

                <div class="stat-card services">
                    <div class="stat-icon">
                        <i class="far fa-cog"></i>
                    </div>
                    <div class="stat-content">
                        <span>Services</span>
                        <strong>{{ stats.services_count }}</strong>
                        <Link href="/admin/services" class="stat-link">Gérer</Link>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h2>Commandes Récentes</h2>
                    <Link href="/admin/orders" class="view-all">Voir tout</Link>
                </div>
                <div v-if="stats.recent_orders && stats.recent_orders.length > 0" class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Commande #</th>
                                <th>Client</th>
                                <th>Articles</th>
                                <th>Total</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in stats.recent_orders" :key="order.id">
                                <td>{{ order.order_number }}</td>
                                <td>{{ order.user?.name || 'N/A' }}</td>
                                <td>{{ order.items?.length || 0 }}</td>
                                <td>{{ formatPrice(order.total) }} FCFA</td>
                                <td>
                                    <span :class="['status-badge', getStatusClass(order.status)]">
                                        {{ getStatusLabel(order.status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="empty-state">
                    <i class="far fa-receipt"></i>
                    <h3>Aucune commande</h3>
                    <p>Les commandes récentes apparaîtront ici.</p>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h2>Produits Récents</h2>
                    <Link href="/admin/products" class="view-all">Voir tout</Link>
                </div>
                <div v-if="stats.recent_products && stats.recent_products.length > 0" class="products-grid">
                    <div v-for="product in stats.recent_products" :key="product.id" class="product-card">
                        <img :src="product.image" :alt="product.title">
                        <div class="product-info">
                            <strong>{{ product.title }}</strong>
                            <span>{{ formatPrice(product.price) }} FCFA</span>
                        </div>
                    </div>
                </div>
                <div v-else class="empty-state">
                    <i class="far fa-box"></i>
                    <h3>Aucun produit</h3>
                    <p>Commencez par ajouter des produits.</p>
                    <Link href="/admin/products/create" class="btn-primary">Ajouter un produit</Link>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h2>Actions Rapides</h2>
                </div>
                <div class="quick-actions-grid">
                    <Link href="/admin/orders" class="quick-action-card">
                        <i class="far fa-receipt"></i>
                        <strong>Gérer les commandes</strong>
                        <span>{{ stats.pending_orders }} en attente</span>
                    </Link>
                    <Link href="/admin/products/create" class="quick-action-card">
                        <i class="far fa-plus-circle"></i>
                        <strong>Ajouter un produit</strong>
                        <span>Nouveau produit</span>
                    </Link>
                    <Link href="/admin/news/create" class="quick-action-card">
                        <i class="far fa-newspaper"></i>
                        <strong>Publier une actualité</strong>
                        <span>Nouvelle publication</span>
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.dashboard-container {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.stat-card {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(27, 58, 28, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.products .stat-icon {
    background: #e3f9e5;
    color: #2d7a2d;
}

.services .stat-icon {
    background: #e8f4ff;
    color: #245ea8;
}

.news .stat-icon {
    background: #fff7ed;
    color: #c2410c;
}

.orders .stat-icon {
    background: #e8f4ff;
    color: #245ea8;
}

.pending .stat-icon {
    background: #fff5d9;
    color: #a97816;
}

.stat-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-content span {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

.stat-content strong {
    color: #1a3a1a;
    font-size: 1.75rem;
    font-weight: 900;
}

.stat-subtitle {
    color: #2d7a2d;
    font-size: 0.875rem;
    font-weight: 600;
}

.stat-link {
    color: #2d7a2d;
    font-weight: 700;
    text-decoration: none;
    font-size: 0.875rem;
}

.stat-link:hover {
    text-decoration: underline;
}

.dashboard-section {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.section-header h2 {
    margin: 0;
    color: #1a3a1a;
    font-size: 1.25rem;
    font-weight: 900;
}

.view-all {
    color: #2d7a2d;
    font-weight: 700;
    text-decoration: none;
}

.view-all:hover {
    text-decoration: underline;
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    text-align: left;
    padding: 12px 16px;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    border-bottom: 2px solid #e8eee3;
}

.data-table td {
    padding: 16px;
    color: #1a3a1a;
    font-weight: 500;
    border-bottom: 1px solid #e8eee3;
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover td {
    background: #f9faf9;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

.product-card {
    border: 1px solid #e8eee3;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 58, 28, 0.1);
}

.product-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
}

.product-info {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.product-info strong {
    color: #1a3a1a;
    font-weight: 700;
    font-size: 0.9rem;
}

.product-info span {
    color: #2d7a2d;
    font-weight: 700;
    font-size: 0.95rem;
}

.empty-state {
    padding: 48px 24px;
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
    margin: 0 0 16px;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #5cb85c;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #4a9e4a;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.quick-action-card {
    display: grid;
    grid-template-columns: 46px 1fr;
    gap: 12px;
    padding: 18px;
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
}

.quick-action-card:hover {
    border-color: #5cb85c;
    transform: translateY(-2px);
}

.quick-action-card i {
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #eaf7ea;
    color: #2d7a2d;
}

.quick-action-card strong {
    color: #1a3a1a;
}

.quick-action-card span {
    color: #6b7280;
    font-size: 0.875rem;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 900;
}

.success,
.status-badge.success {
    background: #e7f7e7;
    color: #24782b;
}

.warning,
.status-badge.warning {
    background: #fff5d9;
    color: #9a6b12;
}

.info,
.status-badge.info,
.active,
.status-badge.active {
    background: #e8f1ff;
    color: #245ea8;
}

.danger,
.status-badge.danger {
    background: #ffe8e8;
    color: #b42323;
}

@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .products-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-section {
        padding: 16px;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
