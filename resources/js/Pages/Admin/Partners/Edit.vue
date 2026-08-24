<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const uploading = ref(false);
const isDragging = ref(false);
const uploadProgress = ref(0);
const uploadError = ref('');
const imageInput = ref(null);

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `/storage/${path}`;
};

const imageName = (path) => path ? path.split('/').pop() : '';
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const props = defineProps({
    partner: Object,
});

const form = useForm({
    name: props.partner.name || '',
    image: props.partner.image || '',
    link: props.partner.link || '',
    order: props.partner.order ?? 0,
});

const uploadFiles = async (files) => {
    const selected = Array.from(files || []).filter(f => f.type.startsWith('image/'));
    if (!selected.length) return;

    const payload = new FormData();
    selected.forEach(f => payload.append('images[]', f));

    uploading.value = true;
    uploadProgress.value = 0;
    uploadError.value = '';

    try {
        const res = await window.axios.post('/admin/partners/upload-image', payload, {
            headers: { 'X-CSRF-TOKEN': csrfToken() },
            onUploadProgress: (e) => {
                if (e.total) uploadProgress.value = Math.round((e.loaded / e.total) * 100);
            },
        });
        if (res.data.images?.[0]) form.image = res.data.images[0];
    } catch (err) {
        const msg = err.response?.data?.message || err.response?.data?.error;
        uploadError.value = msg || 'Echec de l\'import. Vérifiez le format ou la taille (max 4 Mo).';
    } finally {
        uploading.value = false;
        uploadProgress.value = 0;
    }
};

const handleDragEnter = (e) => { e.preventDefault(); isDragging.value = true; };
const handleDragLeave = (e) => { if (!e.currentTarget.contains(e.relatedTarget)) isDragging.value = false; };
const handleDrop = (e) => { isDragging.value = false; uploadFiles(e.dataTransfer.files); };

const submit = () => {
    form
        .transform(data => ({
            ...data,
            link: data.link || null,
            order: data.order || 0,
        }))
        .put(`/admin/partners/${props.partner.id}`);
};
</script>

<template>
    <Head title="Modifier un Partenaire" />

    <AdminLayout title="Modifier un Partenaire">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Modification</p>
                    <h1>Modifier le Partenaire</h1>
                </div>
                <Link href="/admin/partners" class="btn-secondary">
                    <i class="far fa-arrow-left"></i> Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="product-form">
                <div class="form-grid-layout">
                    <div class="form-main">
                        <section class="form-card">
                            <div class="card-header">
                                <h2>Informations</h2>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nom *</label>
                                    <input v-model="form.name" type="text" required placeholder="Nom du partenaire">
                                    <span v-if="form.errors.name" class="error">{{ form.errors.name }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Ordre d'affichage</label>
                                    <input v-model.number="form.order" type="number" min="0" placeholder="0">
                                    <span v-if="form.errors.order" class="error">{{ form.errors.order }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lien du site <small>(optionnel)</small></label>
                                <input v-model="form.link" type="url" placeholder="https://exemple.com">
                                <span v-if="form.errors.link" class="error">{{ form.errors.link }}</span>
                            </div>
                        </section>

                        <section class="form-card">
                            <div class="card-header">
                                <h2>Logo</h2>
                            </div>

                            <div class="form-group">
                                <label>Image du logo *</label>
                                <div class="main-image-editor">
                                    <img v-if="form.image" :src="resolveImage(form.image)" alt="Logo">
                                    <div v-else class="image-placeholder">
                                        <i class="far fa-image"></i>
                                        <span>Aucune image</span>
                                    </div>
                                    <div class="main-image-fields">
                                        <input v-model="form.image" type="hidden" required>
                                        <div class="image-path-display">
                                            <i class="far fa-image"></i>
                                            <span v-if="form.image" :title="form.image">{{ imageName(form.image) }}</span>
                                            <span v-else class="placeholder-text">Aucune image sélectionnée</span>
                                        </div>
                                        <button type="button" class="btn-soft" @click="imageInput.click()">
                                            <i class="far fa-upload"></i> Importer le logo
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="upload-zone"
                                    :class="{ uploading: uploading, dragging: isDragging }"
                                    @dragenter="handleDragEnter"
                                    @dragover.prevent
                                    @dragleave="handleDragLeave"
                                    @drop.prevent="handleDrop"
                                >
                                    <i class="far" :class="isDragging ? 'fa-arrow-down' : 'fa-images'"></i>
                                    <strong>{{ isDragging ? 'Relâcher pour importer' : 'Glisser-déposer ici' }}</strong>
                                    <span v-if="!isDragging">ou cliquer sur le bouton ci-dessus</span>
                                </div>

                                <input ref="imageInput" class="file-input" type="file" accept="image/*"
                                    @change="uploadFiles($event.target.files); $event.target.value = ''">

                                <div v-if="uploading" class="upload-progress">
                                    <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                    <span>Import{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                </div>
                                <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                                <p v-if="uploadError" class="error">{{ uploadError }}</p>
                            </div>
                        </section>
                    </div>

                    <aside class="form-side">
                        <section class="preview-card">
                            <img v-if="form.image" :src="resolveImage(form.image)" alt="Aperçu" class="preview-logo">
                            <div v-else class="preview-placeholder">
                                <i class="far fa-image"></i>
                                <span>Aucune image</span>
                            </div>
                            <div class="preview-body">
                                <h3>{{ form.name || 'Nom du partenaire' }}</h3>
                                <p v-if="form.link">{{ form.link }}</p>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Mettre à jour' }}
                    </button>
                    <Link href="/admin/partners" class="btn-secondary">Annuler</Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display: flex; flex-direction: column; gap: 24px; }

.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
.eyebrow { margin: 0 0 6px; color: #5cb85c; font-weight: 800; text-transform: uppercase; font-size: 0.78rem; }
.page-header h1 { margin: 0; color: #17351a; font-size: 1.85rem; font-weight: 900; }

.product-form { display: flex; flex-direction: column; gap: 22px; }

.form-grid-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 340px;
    gap: 24px;
    align-items: start;
}

.form-main, .form-side { display: grid; gap: 22px; }

.form-card, .preview-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.form-card { padding: 26px; }

.card-header { display: flex; justify-content: space-between; gap: 14px; margin-bottom: 22px; }
.card-header h2 { margin: 0; color: #17351a; font-size: 1.1rem; font-weight: 900; }

.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }

.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label { color: #17351a; font-weight: 850; font-size: 0.9rem; }
.form-group label small { font-weight: 500; color: #68746a; }

.form-group input {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 6px;
    color: #17351a; font: inherit;
}

.form-group input:focus {
    outline: none; border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

.main-image-editor {
    display: grid; grid-template-columns: 170px 1fr;
    gap: 16px; align-items: center; margin-bottom: 12px;
}

.main-image-editor img, .image-placeholder {
    width: 170px; height: 130px;
    border-radius: 8px; border: 1px solid #e5ece2; background: #f8faf7;
}

.main-image-editor img { object-fit: contain; padding: 10px; }

.image-placeholder, .preview-placeholder {
    display: grid; place-items: center; align-content: center;
    gap: 8px; color: #68746a; text-align: center;
}

.image-placeholder i, .preview-placeholder i { color: #9aaa95; font-size: 1.6rem; }

.main-image-fields { display: grid; gap: 10px; }

.image-path-display {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px; border: 1.5px solid #dfe8db; border-radius: 6px;
    background: #f8faf7; color: #17351a; font-size: 0.95rem; min-height: 46px;
}

.image-path-display i { color: #5cb85c; font-size: 1.1rem; flex-shrink: 0; }
.image-path-display span { font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.image-path-display .placeholder-text { color: #9aaa95; font-weight: 400; font-style: italic; }

.upload-zone {
    display: grid; place-items: center; gap: 8px;
    padding: 20px 18px; border: 2px dashed #cfe0c9;
    border-radius: 8px; background: #fbfcfa;
    text-align: center; color: #68746a;
}

.upload-zone.uploading { opacity: 0.65; pointer-events: none; }
.upload-zone.dragging { border-color: #5cb85c; background: #f0faf0; }
.upload-zone.dragging i, .upload-zone.dragging strong { color: #24782b; }
.upload-zone > i { color: #5cb85c; font-size: 1.6rem; }
.upload-zone strong { color: #17351a; font-size: 0.95rem; }
.upload-zone span { font-size: 0.85rem; }

.upload-progress {
    position: relative; height: 28px; background: #e8eee3;
    border-radius: 6px; overflow: hidden; margin-top: 8px;
    display: flex; align-items: center; padding: 0 12px;
}

.progress-bar {
    position: absolute; left: 0; top: 0; height: 100%;
    background: #5cb85c; transition: width 0.2s; z-index: 0;
}

.upload-progress span { position: relative; z-index: 1; font-size: 0.83rem; font-weight: 700; color: #17351a; }

.file-input { display: none; }

.btn-soft {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 7px; min-height: 38px; padding: 8px 12px;
    border: 1px solid #dfe8db; border-radius: 6px;
    background: #fff; color: #17351a; font-weight: 850;
    cursor: pointer; transition: all 0.2s;
}

.btn-soft:hover { border-color: #5cb85c; background: #fbfcfa; }

.preview-card { overflow: hidden; }
.preview-card .preview-logo, .preview-placeholder { width: 100%; height: 200px; }
.preview-card .preview-logo { object-fit: contain; padding: 20px; }
.preview-placeholder { background: #f8faf7; border-bottom: 1px solid #e5ece2; }

.preview-body { padding: 18px; }
.preview-body h3 { margin: 0 0 8px; color: #17351a; font-size: 1.05rem; font-weight: 900; }
.preview-body p { margin: 0; color: #68746a; font-size: 0.85rem; word-break: break-all; }

.error { color: #b42323; font-weight: 750; font-size: 0.86rem; }

.form-actions {
    display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;
    padding: 18px; background: #fff;
    border: 1px solid #e5ece2; border-radius: 8px;
}

.btn-primary, .btn-secondary {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 8px; min-height: 42px; padding: 10px 16px;
    border-radius: 6px; text-decoration: none; font-weight: 850;
}

.btn-primary { background: #5cb85c; color: #fff; border: none; cursor: pointer; }
.btn-primary:hover:not(:disabled) { background: #4a9e4a; }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-secondary { background: #fff; color: #17351a; border: 1.5px solid #dfe8db; }
.btn-secondary:hover { border-color: #5cb85c; background: #fbfcfa; }

@media (max-width: 1100px) { .form-grid-layout { grid-template-columns: 1fr; } }

@media (max-width: 768px) {
    .page-header, .form-actions { flex-direction: column; align-items: flex-start; }
    .form-grid, .main-image-editor { grid-template-columns: 1fr; }
    .form-card { padding: 18px; }
    .main-image-editor img, .image-placeholder { width: 100%; height: 160px; }
}
</style>
