<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    partners: Array,
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

const deletePartner = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')) {
        router.delete(`/admin/partners/${id}`);
    }
};
</script>

<template>
    <Head title="Gestion des Partenaires" />

    <AdminLayout title="Gestion des Partenaires">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Partenaires</h1>
                </div>
                <Link href="/admin/partners/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un partenaire
                </Link>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Nom</th>
                            <th>Lien</th>
                            <th>Ordre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="partner in partners" :key="partner.id">
                            <td>
                                <img :src="resolveImage(partner.image)" :alt="partner.name" class="thumb">
                            </td>
                            <td>
                                <strong>{{ partner.name }}</strong>
                            </td>
                            <td>
                                <a v-if="partner.link" :href="partner.link" target="_blank" rel="noopener noreferrer">{{ partner.link }}</a>
                                <span v-else>—</span>
                            </td>
                            <td>{{ partner.order }}</td>
                            <td>
                                <div class="action-buttons">
                                    <Link :href="`/admin/partners/${partner.id}/edit`" class="btn-edit" title="Modifier">
                                        <i class="far fa-edit"></i>
                                    </Link>
                                    <button @click="deletePartner(partner.id)" class="btn-delete" title="Supprimer">
                                        <i class="far fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="partners.length === 0" class="empty-state">
                    <i class="far fa-handshake"></i>
                    <h3>Aucun partenaire</h3>
                    <p>Commencez par ajouter votre premier partenaire.</p>
                    <Link href="/admin/partners/create" class="btn-primary">Ajouter un partenaire</Link>
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

.data-table {
    width: 100%;
    border-collapse: collapse;
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
    border-bottom: 1px solid #e5ece2;
    vertical-align: middle;
}

.data-table td a { color: #245ea8; }

.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: #fafcf9; }

.thumb {
    width: 80px;
    height: 50px;
    border-radius: 6px;
    object-fit: contain;
    border: 1px solid #e5ece2;
    background: #f8faf7;
    padding: 4px;
}

.action-buttons {
    display: flex;
    gap: 6px;
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

@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; }
    .data-table th, .data-table td { padding: 10px 8px; }
}
</style>
