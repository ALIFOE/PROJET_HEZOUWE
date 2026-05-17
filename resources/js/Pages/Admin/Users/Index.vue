<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    users: Object,
    stats: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const roleFilter = ref(props.filters?.role || '');

let searchTimer = null;
watch([search, roleFilter], () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/users', {
            search: search.value || undefined,
            role: roleFilter.value || undefined,
        }, { preserveState: true, replace: true });
    }, 350);
});

const formatDate = (d) => {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
};

const initials = (name) => {
    if (!name) return '?';
    return name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
};

const deleteUser = (user) => {
    if (!confirm(`Supprimer définitivement l'utilisateur "${user.name}" ?`)) return;
    router.delete(`/admin/users/${user.id}`, { preserveScroll: true });
};
</script>

<template>
    <Head title="Gestion des Utilisateurs" />
    <AdminLayout title="Gestion des Utilisateurs">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Utilisateurs</h1>
                    <p class="header-text">Gérez les comptes, rôles et accès des utilisateurs.</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div>
                        <strong>{{ stats.total }}</strong>
                        <span>Total</span>
                    </div>
                </div>
                <div class="stat-card admin">
                    <i class="fas fa-user-shield stat-icon"></i>
                    <div>
                        <strong>{{ stats.admins }}</strong>
                        <span>Admins</span>
                    </div>
                </div>
                <div class="stat-card verified">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <div>
                        <strong>{{ stats.verified }}</strong>
                        <span>Vérifiés</span>
                    </div>
                </div>
                <div class="stat-card orders">
                    <i class="fas fa-shopping-bag stat-icon"></i>
                    <div>
                        <strong>{{ stats.with_orders }}</strong>
                        <span>Ont commandé</span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <div class="table-toolbar">
                    <div class="toolbar-left">
                        <strong>{{ users.total }}</strong>
                        <span>utilisateur(s)</span>
                    </div>
                    <div class="toolbar-filters">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input v-model="search" type="text" placeholder="Rechercher nom ou email…" class="search-input">
                        </div>
                        <select v-model="roleFilter" class="role-select">
                            <option value="">Tous les rôles</option>
                            <option value="admin">Admin</option>
                            <option value="user">Utilisateur</option>
                        </select>
                    </div>
                </div>

                <div class="table-scroll">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Rôle</th>
                                <th>Commandes</th>
                                <th>Vérifié</th>
                                <th>Inscrit le</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>
                                    <div class="user-cell">
                                        <div class="avatar" :class="user.role === 'admin' ? 'avatar-admin' : 'avatar-user'">
                                            {{ initials(user.name) }}
                                        </div>
                                        <div>
                                            <strong>{{ user.name }}</strong>
                                            <span>{{ user.email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span :class="['role-pill', user.role === 'admin' ? 'role-admin' : 'role-user']">
                                        <i :class="['fas', user.role === 'admin' ? 'fa-shield-alt' : 'fa-user']"></i>
                                        {{ user.role === 'admin' ? 'Admin' : 'Utilisateur' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="orders-count" v-if="user.orders_count > 0">
                                        {{ user.orders_count }} commande{{ user.orders_count > 1 ? 's' : '' }}
                                    </span>
                                    <span class="muted" v-else>Aucune</span>
                                </td>
                                <td>
                                    <span v-if="user.email_verified_at" class="verified-badge">
                                        <i class="fas fa-check-circle"></i> Oui
                                    </span>
                                    <span v-else class="unverified-badge">
                                        <i class="fas fa-times-circle"></i> Non
                                    </span>
                                </td>
                                <td class="date-cell">{{ formatDate(user.created_at) }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <Link :href="`/admin/users/${user.id}`" class="btn-action btn-view" title="Voir le profil">
                                            <i class="far fa-eye"></i>
                                        </Link>
                                        <Link :href="`/admin/users/${user.id}/edit`" class="btn-action btn-edit">
                                            <i class="far fa-edit"></i> Modifier
                                        </Link>
                                        <button
                                            v-if="user.role !== 'admin'"
                                            type="button" class="btn-action btn-delete"
                                            @click="deleteUser(user)"
                                        >
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="users.data.length === 0" class="empty-state">
                    <i class="far fa-users"></i>
                    <h3>Aucun utilisateur trouvé</h3>
                    <p v-if="search || roleFilter">Essayez de modifier vos filtres de recherche.</p>
                    <p v-else>Aucun compte utilisateur enregistré.</p>
                </div>
            </div>

            <div v-if="users.links && users.links.length > 3" class="pagination">
                <template v-for="(link, index) in users.links" :key="index">
                    <Link v-if="link.url" :href="link.url" class="page-link" :class="{ active: link.active }" v-html="link.label" />
                    <span v-else class="page-link disabled" v-html="link.label" />
                </template>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display: flex; flex-direction: column; gap: 24px; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
.eyebrow { margin: 0 0 6px; color: #5cb85c; font-weight: 800; text-transform: uppercase; font-size: 0.78rem; }
.page-header h1 { margin: 0; color: #17351a; font-size: 1.85rem; font-weight: 900; }
.header-text { margin: 8px 0 0; color: #68746a; }

/* Stats */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.stat-card {
    display: flex; align-items: center; gap: 16px;
    padding: 20px 22px; background: #fff;
    border: 1px solid #e5ece2; border-radius: 8px;
    box-shadow: 0 4px 14px rgba(23, 53, 26, 0.05);
}
.stat-card strong { display: block; font-size: 1.6rem; font-weight: 900; color: #17351a; line-height: 1; }
.stat-card span { font-size: 0.82rem; color: #68746a; font-weight: 650; }
.stat-icon { font-size: 1.5rem; color: #5cb85c; flex-shrink: 0; }
.stat-card.admin .stat-icon { color: #9b5de5; }
.stat-card.verified .stat-icon { color: #24782b; }
.stat-card.orders .stat-icon { color: #e8a020; }

/* Table */
.table-card {
    background: #fff; border: 1px solid #e5ece2;
    border-radius: 8px; box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
    overflow: hidden;
}
.table-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 14px;
    padding: 16px 20px; border-bottom: 1px solid #e5ece2; background: #fbfcfa;
}
.toolbar-left { display: flex; align-items: center; gap: 6px; }
.toolbar-left strong { color: #17351a; font-size: 1.1rem; }
.toolbar-left span { color: #68746a; font-weight: 650; }
.toolbar-filters { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.search-box { position: relative; }
.search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9aaa95; font-size: 0.82rem; }
.search-input {
    padding: 8px 12px 8px 32px; border: 1.5px solid #dfe8db;
    border-radius: 6px; font: inherit; font-size: 0.9rem; width: 240px;
    color: #17351a;
}
.search-input:focus { outline: none; border-color: #5cb85c; box-shadow: 0 0 0 3px rgba(92,184,92,0.12); }
.role-select {
    padding: 8px 12px; border: 1.5px solid #dfe8db;
    border-radius: 6px; font: inherit; font-size: 0.9rem;
    color: #17351a; background: #fff; cursor: pointer;
}
.role-select:focus { outline: none; border-color: #5cb85c; }

.table-scroll { overflow-x: auto; }
.users-table { width: 100%; min-width: 820px; border-collapse: collapse; }
.users-table th {
    text-align: left; padding: 14px 16px;
    color: #68746a; font-size: 0.78rem; font-weight: 900; text-transform: uppercase;
    border-bottom: 1px solid #e5ece2; background: #f8faf7;
}
.users-table td {
    padding: 14px 16px; color: #17351a;
    border-bottom: 1px solid #edf2ea; vertical-align: middle;
}
.users-table tr:hover td { background: #fbfcfa; }

.user-cell { display: flex; align-items: center; gap: 14px; min-width: 240px; }
.avatar {
    width: 42px; height: 42px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 0.9rem; flex-shrink: 0;
}
.avatar-admin { background: #ede9ff; color: #6b21a8; border: 2px solid #c4b5fd; }
.avatar-user { background: #e8f5e9; color: #24782b; border: 2px solid #c3ddc0; }
.user-cell strong { display: block; color: #17351a; font-weight: 900; font-size: 0.95rem; }
.user-cell span { display: block; margin-top: 2px; color: #7a857c; font-size: 0.82rem; }

.role-pill {
    display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px;
    border-radius: 999px; font-size: 0.78rem; font-weight: 900; white-space: nowrap;
}
.role-admin { background: #ede9ff; color: #6b21a8; border: 1px solid #c4b5fd; }
.role-user { background: #f0faf0; color: #24782b; border: 1px solid #c3ddc0; }

.orders-count { font-weight: 700; color: #17351a; }
.muted { color: #9aaa95; font-size: 0.88rem; }

.verified-badge { color: #24782b; font-size: 0.85rem; font-weight: 700; }
.unverified-badge { color: #9aaa95; font-size: 0.85rem; font-weight: 600; }

.date-cell { white-space: nowrap; font-size: 0.88rem; color: #68746a; }

.actions-col { width: 200px; }
.action-buttons { display: flex; align-items: center; gap: 6px; }
.btn-action {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    min-height: 34px; padding: 6px 10px; border-radius: 6px;
    text-decoration: none; font-weight: 850; font-size: 0.85rem;
    border: 1px solid transparent; cursor: pointer; transition: all 0.15s;
}
.btn-view { background: #f0faf0; color: #24782b; width: 34px; padding: 0; }
.btn-edit { background: #e8f7e8; color: #24782b; }
.btn-delete { background: #fff; color: #b42323; border-color: #ffd4d4; width: 34px; padding: 0; }
.btn-action:hover { transform: translateY(-1px); }

.empty-state { padding: 60px 24px; text-align: center; color: #68746a; }
.empty-state i { font-size: 2.8rem; color: #cdd6c9; margin-bottom: 16px; display: block; }
.empty-state h3 { margin: 0 0 8px; color: #17351a; }
.empty-state p { margin: 0; }

.pagination { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
.page-link {
    padding: 8px 14px; border: 1px solid #e5ece2; border-radius: 6px;
    background: #fff; color: #17351a; text-decoration: none; font-weight: 800;
}
.page-link.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }
.page-link.disabled { color: #a5aea2; }

@media (max-width: 900px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .stats-row { grid-template-columns: 1fr 1fr; }
    .table-toolbar { flex-direction: column; align-items: flex-start; }
    .search-input { width: 100%; }
}
</style>
