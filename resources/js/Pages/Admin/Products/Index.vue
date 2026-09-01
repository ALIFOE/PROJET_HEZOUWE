<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    products: Object,
});

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;

const deleteProduct = (product) => {
    if (!confirm(`Supprimer definitivement le produit "${product.title}" ?`)) {
        return;
    }

    router.delete(`/admin/products/${product.slug}`, {
        preserveScroll: true,
    });
};

const toggleVisibility = (product) => {
    router.post(`/admin/products/${product.slug}/toggle-visibility`, {}, { preserveScroll: true });
};
</script>

<template>
    <Head title="Gestion des produits" />

    <AdminLayout title="Gestion des produits">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Catalogue</p>
                    <h1>Produits</h1>
                    <p class="header-text">Gerez les produits visibles dans la boutique et les sections dynamiques du site.</p>
                </div>
                <Link href="/admin/products/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un produit
                </Link>
            </div>

            <div class="table-card">
                <div class="table-toolbar">
                    <div>
                        <strong>{{ products.total || products.data.length }}</strong>
                        <span>produit(s)</span>
                    </div>
                    <span class="toolbar-note">Actions disponibles : modifier, supprimer</span>
                </div>

                <div class="table-scroll">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Categorie</th>
                                <th>Prix</th>
                                <th>Promo</th>
                                <th>Badge</th>
                                <th>Stock</th>
                                <th>Visibilite</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products.data" :key="product.id">
                                <td>
                                    <div class="product-cell">
                                        <img v-if="product.image" :src="product.image" :alt="product.title">
                                        <div v-else class="thumb-placeholder">
                                            <i class="far fa-image"></i>
                                        </div>
                                        <div>
                                            <strong>{{ product.title }}</strong>
                                            <span>{{ product.slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ product.category }}</td>
                                <td class="price-cell">{{ formatPrice(product.price) }}</td>
                                <td>
                                    <span v-if="product.price_promo" class="promo-pill">
                                        {{ formatPrice(product.price_promo) }}
                                    </span>
                                    <span v-else class="muted">Aucune</span>
                                </td>
                                <td>
                                    <span v-if="product.badge" class="badge-pill">{{ product.badge }}</span>
                                    <span v-else class="muted">Aucun</span>
                                </td>
                                <td>
                                    <span :class="['stock-pill', product.in_stock ? 'in-stock' : 'out-stock']">
                                        {{ product.in_stock ? 'En stock' : 'Rupture' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="visibility-cell">
                                        <button
                                            type="button"
                                            class="btn-visibility"
                                            :class="{ 'is-visible': product.is_visible, 'is-hidden': !product.is_visible }"
                                            @click="toggleVisibility(product)"
                                            :title="product.is_visible ? 'Cliquez pour masquer ce produit' : 'Cliquez pour afficher ce produit'"
                                        >
                                            <i :class="product.is_visible ? 'far fa-eye' : 'far fa-eye-slash'"></i>
                                            <span>{{ product.is_visible ? 'Visible' : 'Masque' }}</span>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <Link :href="`/admin/products/${product.slug}/edit`" class="btn-action btn-edit" title="Modifier">
                                            <i class="far fa-edit"></i>
                                        </Link>
                                        <button type="button" class="btn-action btn-delete" @click="deleteProduct(product)" title="Supprimer">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="products.data.length === 0" class="empty-state">
                    <i class="far fa-box"></i>
                    <h3>Aucun produit</h3>
                    <p>Commencez par ajouter votre premier produit au catalogue.</p>
                    <Link href="/admin/products/create" class="btn-primary">Ajouter un produit</Link>
                </div>
            </div>

            <div v-if="products.links && products.links.length > 3" class="pagination">
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

.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 40px;
    padding: 9px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 850;
    border: 1px solid transparent;
    cursor: pointer;
    white-space: nowrap;
}

/* Boutons icone seuls, comme sur la page Services : la colonne Actions
   reste etroite et ne peut plus deborder de l'ecran. */
.btn-action {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 6px;
    border: 1px solid transparent;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #5cb85c;
    color: #fff;
}

.btn-primary:hover {
    background: #4a9e4a;
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
    font-weight: 650;
}

.table-scroll {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    min-width: 900px;
    /* separate + spacing 0 : rendu identique a collapse, mais indispensable
       pour que la colonne Actions collante garde ses bordures. */
    border-collapse: separate;
    border-spacing: 0;
}

.products-table th {
    text-align: left;
    padding: 14px 12px;
    color: #68746a;
    font-size: 0.78rem;
    font-weight: 900;
    text-transform: uppercase;
    border-bottom: 1px solid #e5ece2;
    background: #f8faf7;
}

.products-table td {
    padding: 14px 12px;
    color: #17351a;
    background: #fff;
    border-bottom: 1px solid #edf2ea;
    vertical-align: middle;
}

.products-table tr:hover td {
    background: #fbfcfa;
}

/* La colonne Actions reste visible meme quand le tableau defile horizontalement. */
.products-table th:last-child,
.products-table td:last-child {
    position: sticky;
    right: 0;
    z-index: 1;
    box-shadow: -10px 0 12px -10px rgba(23, 53, 26, 0.22);
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 210px;
}

.product-cell img,
.thumb-placeholder {
    width: 52px;
    height: 52px;
    flex: 0 0 auto;
    border-radius: 6px;
    border: 1px solid #e5ece2;
}

.product-cell img {
    object-fit: cover;
}

.thumb-placeholder {
    display: grid;
    place-items: center;
    flex: 0 0 auto;
    background: #f8faf7;
    color: #9aaa95;
}

.product-cell strong {
    display: block;
    color: #17351a;
    font-weight: 900;
}

.product-cell span,
.muted {
    display: block;
    margin-top: 4px;
    color: #7a857c;
    font-size: 0.84rem;
}

.price-cell {
    font-weight: 900;
    white-space: nowrap;
}

.promo-pill,
.badge-pill,
.stock-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 900;
    white-space: nowrap;
}

.promo-pill {
    background: #fff5d9;
    color: #9a6b12;
}

.badge-pill {
    background: #e8f1ff;
    color: #245ea8;
}

.stock-pill.in-stock {
    background: #e7f7e7;
    color: #24782b;
}

.stock-pill.out-stock {
    background: #ffe8e8;
    color: #b42323;
}

.visibility-cell {
    display: flex;
    align-items: center;
}

.btn-visibility {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 800;
    font-size: 0.82rem;
    border: 1px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.btn-visibility.is-visible {
    background: #c8e6c9;
    color: #1b5e20;
    border-color: #81c784;
}

.btn-visibility.is-visible:hover {
    background: #81c784;
    color: #fff;
    transform: translateY(-1px);
}

.btn-visibility.is-hidden {
    background: #ffcdd2;
    color: #b71c1c;
    border-color: #ef9a9a;
}

.btn-visibility.is-hidden:hover {
    background: #ef9a9a;
    color: #fff;
    transform: translateY(-1px);
}

.actions-col {
    width: 100px;
}

.action-buttons {
    display: flex;
    gap: 6px;
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

.empty-state p {
    margin: 0 0 18px;
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
    .page-header,
    .table-toolbar {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
