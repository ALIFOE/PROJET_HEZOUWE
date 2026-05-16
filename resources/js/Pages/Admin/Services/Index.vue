<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    services: Object,
});
</script>

<template>
    <Head title="Gestion des Services" />

    <AdminLayout title="Gestion des Services">
        <div class="admin-page">
            <div class="page-header">
                <h1>Services</h1>
                <Link href="/admin/services/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un service
                </Link>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Description courte</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="service in services.data" :key="service.id">
                            <td>
                                <img :src="service.image" :alt="service.title" class="thumb">
                            </td>
                            <td>
                                <strong>{{ service.title }}</strong>
                                <span class="slug">{{ service.slug }}</span>
                            </td>
                            <td>{{ service.short }}</td>
                            <td>
                                <div class="action-buttons">
                                    <Link :href="`/admin/services/${service.id}/edit`" class="btn-edit">
                                        <i class="far fa-edit"></i>
                                    </Link>
                                    <button @click="deleteService(service.id)" class="btn-delete">
                                        <i class="far fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="services.data.length === 0" class="empty-state">
                    <i class="far fa-cog"></i>
                    <h3>Aucun service</h3>
                    <p>Commencez par ajouter votre premier service.</p>
                    <Link href="/admin/services/create" class="btn-primary">Ajouter un service</Link>
                </div>
            </div>

            <div v-if="services.links && services.links.length > 0" class="pagination">
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

<script>
import { router } from '@inertiajs/vue3';

const deleteService = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
        router.delete(`/admin/services/${id}`);
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
