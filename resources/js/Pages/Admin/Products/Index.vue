<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
});

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';
</script>

<template>
    <Head title="Gestion des Produits" />

    <AdminLayout title="Gestion des Produits">
        <div class="admin-page">
            <div class="page-header">
                <h1>Produits</h1>
                <Link href="/admin/products/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un produit
                </Link>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Promo</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id">
                            <td>
                                <img :src="product.image" :alt="product.title" class="thumb">
                            </td>
                            <td>
                                <strong>{{ product.title }}</strong>
                                <span class="slug">{{ product.slug }}</span>
                            </td>
                            <td>{{ product.category }}</td>
                            <td>{{ formatPrice(product.price) }} FCFA</td>
                            <td>
                                <span v-if="product.price_promo" class="promo-badge">
                                    {{ formatPrice(product.price_promo) }} FCFA
                                </span>
                                <span v-else class="text-muted">-</span>
                            </td>
                            <td>
                                <span :class="['stock-badge', product.in_stock ? 'in-stock' : 'out-stock']">
                                    {{ product.in_stock ? 'En stock' : 'Rupture' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <Link :href="`/admin/products/${product.id}/edit`" class="btn-edit">
                                        <i class="far fa-edit"></i>
                                    </Link>
                                    <button @click="deleteProduct(product.id)" class="btn-delete">
                                        <i class="far fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="products.data.length === 0" class="empty-state">
                    <i class="far fa-box"></i>
                    <h3>Aucun produit</h3>
                    <p>Commencez par ajouter votre premier produit.</p>
                    <Link href="/admin/products/create" class="btn-primary">Ajouter un produit</Link>
                </div>
            </div>

            <div v-if="products.links && products.links.length > 0" class="pagination">
                <template v-for="(link, index) in products.links" :key="index">
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

<script>
import { router } from '@inertiajs/vue3';

const deleteProduct = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(`/admin/products/${id}`);
    }
};
</script>

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

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
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

.thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.slug {
    display: block;
    color: #6b7280;
    font-size: 0.8rem;
    margin-top: 4px;
}

.text-muted {
    color: #9ca3af;
}

.promo-badge {
    display: inline-block;
    padding: 4px 8px;
    background: #fef3c7;
    color: #a97816;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stock-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stock-badge.in-stock {
    background: #e7f7e7;
    color: #24782b;
}

.stock-badge.out-stock {
    background: #fee2e2;
    color: #dc2626;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-edit,
.btn-delete {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-edit {
    background: #e8f4ff;
    color: #245ea8;
    text-decoration: none;
}

.btn-edit:hover {
    background: #d1e9ff;
}

.btn-delete {
    background: #fee2e2;
    color: #dc2626;
}

.btn-delete:hover {
    background: #fecaca;
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
    margin: 0 0 16px;
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

    .thumb {
        width: 48px;
        height: 48px;
    }
}
</style>
