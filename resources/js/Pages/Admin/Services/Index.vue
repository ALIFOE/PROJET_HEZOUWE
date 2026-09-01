<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    services: Object,
});

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `/storage/${path}`;
};

const deleteService = (slug) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
        router.delete(`/admin/services/${slug}`);
    }
};

const toggleVisibility = (service) => {
    router.post(`/admin/services/${service.slug}/toggle-visibility`, {}, { preserveScroll: true });
};
</script>

<template>
    <Head title="Gestion des Services" />

    <AdminLayout title="Gestion des Services">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Services</h1>
                </div>
                <Link href="/admin/services/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un service
                </Link>
            </div>

            <div class="table-container">
                <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Icone</th>
                            <th>Description courte</th>
                            <th>Visibilité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="service in services.data" :key="service.id">
                            <td>
                                <img :src="resolveImage(service.image)" :alt="service.title" class="thumb">
                            </td>
                            <td>
                                <strong>{{ service.title }}</strong>
                                <span class="slug">{{ service.slug }}</span>
                            </td>
                            <td>
                                <span class="icon-tag">{{ service.icon || '—' }}</span>
                            </td>
                            <td class="short-col">{{ service.short }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-visibility"
                                    :class="{ 'is-visible': service.is_visible, 'is-hidden': !service.is_visible }"
                                    @click="toggleVisibility(service)"
                                    :title="service.is_visible ? 'Cliquez pour masquer ce service' : 'Cliquez pour afficher ce service'"
                                >
                                    <i :class="service.is_visible ? 'far fa-eye' : 'far fa-eye-slash'"></i>
                                    <span>{{ service.is_visible ? 'Visible' : 'Masqué' }}</span>
                                </button>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <Link :href="`/admin/services/${service.slug}/edit`" class="btn-edit" title="Modifier">
                                        <i class="far fa-edit"></i>
                                    </Link>
                                    <button @click="deleteService(service.slug)" class="btn-delete" title="Supprimer">
                                        <i class="far fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <div v-if="services.data.length === 0" class="empty-state">
                    <i class="far fa-concierge-bell"></i>
                    <h3>Aucun service</h3>
                    <p>Commencez par ajouter votre premier service.</p>
                    <Link href="/admin/services/create" class="btn-primary">Ajouter un service</Link>
                </div>
            </div>

            <div v-if="services.links && services.links.length > 3" class="pagination">
                <template v-for="(link, index) in services.links" :key="index">
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
    gap: 16px;
}

.eyebrow {
    margin: 0 0 4px;
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
    white-space: nowrap;
}

.btn-primary:hover { background: #4a9e4a; }

.table-container {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.table-scroll {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    min-width: 860px;
    /* separate + spacing 0 : rendu identique a collapse, mais indispensable
       pour que la colonne Actions collante garde ses bordures. */
    border-collapse: separate;
    border-spacing: 0;
}

.data-table th {
    text-align: left;
    padding: 14px 16px;
    color: #68746a;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 2px solid #e5ece2;
    background: #f8faf7;
}

.data-table td {
    padding: 14px 16px;
    color: #17351a;
    font-weight: 500;
    background: #fff;
    border-bottom: 1px solid #e5ece2;
    vertical-align: middle;
}

.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: #fafcf9; }

/* La colonne Actions reste visible meme quand le tableau defile horizontalement. */
.data-table th:last-child,
.data-table td:last-child {
    position: sticky;
    right: 0;
    z-index: 1;
    box-shadow: -10px 0 12px -10px rgba(23, 53, 26, 0.22);
}

.thumb {
    width: 60px;
    height: 50px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #e5ece2;
    background: #f8faf7;
}

.slug {
    display: block;
    color: #68746a;
    font-size: 0.8rem;
    margin-top: 3px;
}

.icon-tag {
    display: inline-block;
    padding: 3px 8px;
    background: #f0f7f0;
    border: 1px solid #d4e8d4;
    border-radius: 4px;
    font-size: 0.78rem;
    color: #2d6a2d;
    font-family: monospace;
}

.short-col {
    max-width: 300px;
    color: #68746a !important;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.action-buttons {
    display: flex;
    gap: 6px;
}

.btn-visibility {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 800;
    font-size: 0.85rem;
    border: 1px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
}

.btn-visibility.is-visible {
    background: #c8e6c9;
    color: #1b5e20;
    border-color: #81c784;
}

.btn-visibility.is-visible:hover {
    background: #81c784;
    color: #fff;
}

.btn-visibility.is-hidden {
    background: #ffcdd2;
    color: #b71c1c;
    border-color: #ef9a9a;
}

.btn-visibility.is-hidden:hover {
    background: #ef9a9a;
    color: #fff;
}

.btn-edit,
.btn-delete {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-edit { background: #e8f4ff; color: #245ea8; }
.btn-edit:hover { background: #d1e9ff; }
.btn-delete { background: #fee2e2; color: #dc2626; }
.btn-delete:hover { background: #fecaca; }

.empty-state {
    padding: 64px 24px;
    text-align: center;
    color: #68746a;
}

.empty-state i { font-size: 3rem; color: #c8d9c4; margin-bottom: 16px; display: block; }
.empty-state h3 { margin: 0 0 8px; color: #17351a; font-weight: 900; }
.empty-state p { margin: 0 0 16px; }

.pagination {
    display: flex;
    gap: 6px;
    justify-content: center;
    padding: 16px;
}

.page-link {
    padding: 7px 14px;
    border: 1px solid #e5ece2;
    border-radius: 6px;
    color: #17351a;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.page-link:hover { background: #f8faf7; border-color: #5cb85c; }
.page-link.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }
.page-link.disabled { color: #9ca3af; cursor: default; }

@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; }
    .data-table th, .data-table td { padding: 10px 8px; }
    .short-col { display: none; }
}
</style>
