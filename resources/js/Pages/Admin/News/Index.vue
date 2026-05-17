<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ news: Object });

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    return path;
};

const formatDate = (d) => {
    if (!d) return '';
    return new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
};

const deleteNews = (article) => {
    if (!confirm(`Supprimer définitivement l'article "${article.title}" ?`)) return;
    router.delete(`/admin/news/${article.slug}`, { preserveScroll: true });
};
</script>

<template>
    <Head title="Gestion des Actualités" />
    <AdminLayout title="Gestion des Actualités">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Contenu</p>
                    <h1>Actualités</h1>
                    <p class="header-text">Gérez les articles publiés sur le site HEZOUWE.</p>
                </div>
                <Link href="/admin/news/create" class="btn-primary">
                    <i class="far fa-plus"></i>
                    Ajouter un article
                </Link>
            </div>

            <div class="table-card">
                <div class="table-toolbar">
                    <div>
                        <strong>{{ news.total ?? news.data.length }}</strong>
                        <span>article(s)</span>
                    </div>
                    <span class="toolbar-note">Actions disponibles : modifier, supprimer</span>
                </div>

                <div class="table-scroll">
                    <table class="news-table">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Catégorie</th>
                                <th>Auteur</th>
                                <th>Date</th>
                                <th>Tags</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="article in news.data" :key="article.id">
                                <td>
                                    <div class="article-cell">
                                        <img v-if="article.thumb || article.image" :src="resolveImage(article.thumb || article.image)" :alt="article.title">
                                        <div v-else class="thumb-placeholder"><i class="far fa-newspaper"></i></div>
                                        <div>
                                            <strong>{{ article.title }}</strong>
                                            <span>{{ article.slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="category-pill">{{ article.category }}</span></td>
                                <td>{{ article.author }}</td>
                                <td class="date-cell">{{ formatDate(article.date) }}</td>
                                <td>
                                    <div class="tags-list" v-if="article.tag && article.tag.length">
                                        <span v-for="t in (article.tag || []).slice(0, 2)" :key="t" class="tag-chip">{{ t }}</span>
                                        <span v-if="(article.tag || []).length > 2" class="tag-more">+{{ (article.tag || []).length - 2 }}</span>
                                    </div>
                                    <span v-else class="muted">—</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <Link :href="`/admin/news/${article.slug}/edit`" class="btn-action btn-edit">
                                            <i class="far fa-edit"></i> Modifier
                                        </Link>
                                        <button type="button" class="btn-action btn-delete" @click="deleteNews(article)">
                                            <i class="far fa-trash-alt"></i> Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="news.data.length === 0" class="empty-state">
                    <i class="far fa-newspaper"></i>
                    <h3>Aucun article</h3>
                    <p>Commencez par publier votre premier article d'actualité.</p>
                    <Link href="/admin/news/create" class="btn-primary">Ajouter un article</Link>
                </div>
            </div>

            <div v-if="news.links && news.links.length > 3" class="pagination">
                <template v-for="(link, index) in news.links" :key="index">
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

.btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    min-height: 40px; padding: 9px 16px;
    background: #5cb85c; color: #fff; border-radius: 6px;
    text-decoration: none; font-weight: 850; border: none;
}
.btn-primary:hover { background: #4a9e4a; }

.table-card {
    background: #fff; border: 1px solid #e5ece2;
    border-radius: 8px; box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
    overflow: hidden;
}

.table-toolbar {
    display: flex; align-items: center; justify-content: space-between; gap: 16px;
    padding: 18px 20px; border-bottom: 1px solid #e5ece2; background: #fbfcfa;
}
.table-toolbar strong { color: #17351a; font-size: 1.15rem; }
.table-toolbar span, .toolbar-note { color: #68746a; font-weight: 650; }

.table-scroll { overflow-x: auto; }

.news-table { width: 100%; min-width: 900px; border-collapse: collapse; }

.news-table th {
    text-align: left; padding: 14px 16px;
    color: #68746a; font-size: 0.78rem; font-weight: 900; text-transform: uppercase;
    border-bottom: 1px solid #e5ece2; background: #f8faf7;
}

.news-table td {
    padding: 14px 16px; color: #17351a;
    border-bottom: 1px solid #edf2ea; vertical-align: middle;
}
.news-table tr:hover td { background: #fbfcfa; }

.article-cell { display: flex; align-items: center; gap: 14px; min-width: 300px; }
.article-cell img, .thumb-placeholder {
    width: 64px; height: 48px; border-radius: 6px;
    border: 1px solid #e5ece2; flex-shrink: 0;
}
.article-cell img { object-fit: cover; }
.thumb-placeholder {
    display: grid; place-items: center;
    background: #f8faf7; color: #9aaa95; font-size: 1.2rem;
}
.article-cell strong { display: block; color: #17351a; font-weight: 900; font-size: 0.95rem; }
.article-cell span { display: block; margin-top: 3px; color: #7a857c; font-size: 0.82rem; }

.category-pill {
    display: inline-flex; align-items: center; padding: 4px 10px;
    background: #e8f1ff; color: #245ea8;
    border-radius: 999px; font-size: 0.78rem; font-weight: 900; white-space: nowrap;
}

.date-cell { white-space: nowrap; font-size: 0.9rem; color: #68746a; }

.tags-list { display: flex; flex-wrap: wrap; gap: 4px; }
.tag-chip {
    display: inline-flex; align-items: center; padding: 3px 8px;
    background: #f0faf0; color: #24782b;
    border: 1px solid #c3ddc0; border-radius: 999px;
    font-size: 0.72rem; font-weight: 700; white-space: nowrap;
}
.tag-more { font-size: 0.72rem; color: #9aaa95; font-weight: 700; align-self: center; }
.muted { color: #9aaa95; font-size: 0.88rem; }

.actions-col { width: 220px; }
.action-buttons { display: flex; flex-wrap: wrap; gap: 8px; }

.btn-action {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    min-height: 36px; padding: 7px 12px; border-radius: 6px;
    text-decoration: none; font-weight: 850; font-size: 0.88rem;
    border: 1px solid transparent; cursor: pointer;
}
.btn-edit { background: #e8f7e8; color: #24782b; }
.btn-delete { background: #fff; color: #b42323; border-color: #ffd4d4; }
.btn-action:hover { transform: translateY(-1px); }

.empty-state { padding: 64px 24px; text-align: center; color: #68746a; }
.empty-state i { font-size: 2.8rem; color: #cdd6c9; margin-bottom: 16px; display: block; }
.empty-state h3 { margin: 0 0 8px; color: #17351a; }
.empty-state p { margin: 0 0 18px; }

.pagination { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
.page-link {
    padding: 8px 14px; border: 1px solid #e5ece2; border-radius: 6px;
    background: #fff; color: #17351a; text-decoration: none; font-weight: 800;
}
.page-link.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }
.page-link.disabled { color: #a5aea2; }

@media (max-width: 768px) {
    .page-header, .table-toolbar { flex-direction: column; align-items: flex-start; }
}
</style>
