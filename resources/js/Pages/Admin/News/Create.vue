<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/RichEditor.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const uploading = ref(false);
const uploadingField = ref('');
const isDragging = ref(false);
const uploadProgress = ref(0);
const uploadError = ref('');

const mainInput = ref(null);
const thumbInput = ref(null);
const image2Input = ref(null);
const image3Input = ref(null);

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    return path;
};
const imageName = (path) => path ? path.split('/').pop() : '';
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const tagItems = ref([]);
const newTag = ref('');
const bodyParagraphs = ref([]);

const form = useForm({
    slug: '',
    title: '',
    category: '',
    author: '',
    date: new Date().toISOString().split('T')[0],
    read: 3,
    comments: 0,
    excerpt: '',
    intro: '',
    quote: '',
    conclusion: '',
    image: '',
    thumb: '',
    image2: '',
    image3: '',
});

const uploadFiles = async (files, field = 'image') => {
    const selected = Array.from(files || []).filter(f => f.type.startsWith('image/'));
    if (!selected.length) return;
    const payload = new FormData();
    selected.forEach(f => payload.append('images[]', f));
    uploading.value = true;
    uploadingField.value = field;
    uploadProgress.value = 0;
    uploadError.value = '';
    try {
        const res = await window.axios.post('/admin/news/upload-image', payload, {
            headers: { 'X-CSRF-TOKEN': csrfToken() },
            onUploadProgress: (e) => {
                if (e.total) uploadProgress.value = Math.round((e.loaded / e.total) * 100);
            },
        });
        if (res.data.images?.[0]) form[field] = res.data.images[0];
    } catch (err) {
        const msg = err.response?.data?.message || err.response?.data?.error;
        uploadError.value = msg || "Echec de l'import. Vérifiez le format ou la taille (max 4 Mo).";
    } finally {
        uploading.value = false;
        uploadingField.value = '';
        uploadProgress.value = 0;
    }
};

const handleDragEnter = (e) => { e.preventDefault(); isDragging.value = true; };
const handleDragLeave = (e) => { if (!e.currentTarget.contains(e.relatedTarget)) isDragging.value = false; };
const handleDrop = (e) => { isDragging.value = false; uploadFiles(e.dataTransfer.files, 'image'); };

const addTag = () => {
    const t = newTag.value.trim();
    if (t && !tagItems.value.includes(t)) tagItems.value.push(t);
    newTag.value = '';
};
const removeTag = (i) => tagItems.value.splice(i, 1);
const onTagKeydown = (e) => { if (e.key === 'Enter') { e.preventDefault(); addTag(); } };

const addParagraph = () => bodyParagraphs.value.push('');
const removeParagraph = (i) => bodyParagraphs.value.splice(i, 1);

const submit = () => {
    form.transform(data => ({
        ...data,
        tag: tagItems.value,
        body: bodyParagraphs.value.map(p => String(p).trim()).filter(Boolean),
        thumb: data.thumb || null,
        image2: data.image2 || null,
        image3: data.image3 || null,
        quote: data.quote || null,
        conclusion: data.conclusion || null,
    })).post('/admin/news');
};
</script>

<template>
    <Head title="Ajouter un Article" />
    <AdminLayout title="Ajouter un Article">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Nouveau</p>
                    <h1>Ajouter un Article</h1>
                </div>
                <Link href="/admin/news" class="btn-secondary">
                    <i class="far fa-arrow-left"></i> Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="news-form">
                <div class="form-grid-layout">
                    <div class="form-main">

                        <!-- Informations générales -->
                        <section class="form-card">
                            <div class="card-header"><h2>Informations générales</h2></div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Slug *</label>
                                    <input v-model="form.slug" type="text" required placeholder="mon-article">
                                    <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Titre *</label>
                                    <input v-model="form.title" type="text" required placeholder="Titre de l'article">
                                    <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Catégorie *</label>
                                    <input v-model="form.category" type="text" required placeholder="Croissance">
                                    <span v-if="form.errors.category" class="error">{{ form.errors.category }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Auteur *</label>
                                    <input v-model="form.author" type="text" required placeholder="Équipe HEZOUWE">
                                    <span v-if="form.errors.author" class="error">{{ form.errors.author }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Date *</label>
                                    <input v-model="form.date" type="date" required>
                                    <span v-if="form.errors.date" class="error">{{ form.errors.date }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Temps de lecture <small>(minutes)</small></label>
                                    <input v-model="form.read" type="number" min="1" placeholder="3">
                                    <span v-if="form.errors.read" class="error">{{ form.errors.read }}</span>
                                </div>
                            </div>
                        </section>

                        <!-- Tags -->
                        <section class="form-card">
                            <div class="card-header"><h2>Tags</h2></div>
                            <div class="form-group">
                                <div class="tag-input-row">
                                    <input v-model="newTag" type="text" placeholder="Ajouter un tag…" @keydown="onTagKeydown" class="tag-input">
                                    <button type="button" class="btn-soft" @click="addTag"><i class="far fa-plus"></i> Ajouter</button>
                                </div>
                                <div class="tags-display" v-if="tagItems.length">
                                    <span v-for="(t, i) in tagItems" :key="i" class="tag-chip editable">
                                        {{ t }}
                                        <button type="button" @click="removeTag(i)" class="tag-remove"><i class="fas fa-times"></i></button>
                                    </span>
                                </div>
                                <p v-else class="empty-inline">Aucun tag ajouté.</p>
                            </div>
                        </section>

                        <!-- Contenu -->
                        <section class="form-card">
                            <div class="card-header"><h2>Contenu</h2></div>

                            <div class="form-group">
                                <label>Extrait * <small>(résumé affiché dans les listes)</small></label>
                                <RichEditor v-model="form.excerpt" :rows="3" placeholder="Résumé court de l'article…" :simple="true" />
                                <span v-if="form.errors.excerpt" class="error">{{ form.errors.excerpt }}</span>
                            </div>

                            <div class="form-group">
                                <label>Introduction * <small>(premier paragraphe)</small></label>
                                <RichEditor v-model="form.intro" :rows="5" placeholder="Introduction développée…" />
                                <span v-if="form.errors.intro" class="error">{{ form.errors.intro }}</span>
                            </div>

                            <div class="form-group">
                                <div class="label-row">
                                    <label>Corps de l'article <small>(paragraphes)</small></label>
                                    <button type="button" class="btn-soft small" @click="addParagraph">
                                        <i class="far fa-plus"></i> Ajouter un paragraphe
                                    </button>
                                </div>
                                <div class="body-list">
                                    <div v-for="(_, i) in bodyParagraphs" :key="i" class="body-row">
                                        <span class="para-num">§{{ i + 1 }}</span>
                                        <RichEditor v-model="bodyParagraphs[i]" :rows="3" :placeholder="`Paragraphe ${i + 1}…`" />
                                        <button type="button" class="icon-button danger" @click="removeParagraph(i)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="bodyParagraphs.length === 0" class="empty-inline">Aucun paragraphe. Cliquez sur "Ajouter".</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Citation <small>(optionnelle)</small></label>
                                <RichEditor v-model="form.quote" :rows="2" placeholder="Une citation marquante…" :simple="true" />
                            </div>

                            <div class="form-group">
                                <label>Conclusion <small>(optionnelle)</small></label>
                                <RichEditor v-model="form.conclusion" :rows="4" placeholder="Paragraphe de conclusion…" />
                            </div>
                        </section>

                        <!-- Images -->
                        <section class="form-card">
                            <div class="card-header"><h2>Images</h2></div>

                            <!-- Image principale -->
                            <div class="form-group">
                                <label>Image principale *</label>
                                <div class="main-image-editor">
                                    <img v-if="form.image" :src="resolveImage(form.image)" alt="Image principale">
                                    <div v-else class="image-placeholder">
                                        <i class="far fa-image"></i><span>Aucune image</span>
                                    </div>
                                    <div class="main-image-fields">
                                        <input v-model="form.image" type="hidden" required>
                                        <div class="image-path-display">
                                            <i class="far fa-image"></i>
                                            <span v-if="form.image" :title="form.image">{{ imageName(form.image) }}</span>
                                            <span v-else class="placeholder-text">Aucune image sélectionnée</span>
                                        </div>
                                        <button type="button" class="btn-soft" @click="mainInput.click()">
                                            <i class="far fa-upload"></i> Importer image principale
                                        </button>
                                    </div>
                                </div>
                                <div class="upload-zone"
                                    :class="{ uploading: uploading && uploadingField === 'image', dragging: isDragging }"
                                    @dragenter="handleDragEnter" @dragover.prevent
                                    @dragleave="handleDragLeave" @drop.prevent="handleDrop">
                                    <i class="far" :class="isDragging ? 'fa-arrow-down' : 'fa-images'"></i>
                                    <strong>{{ isDragging ? 'Relâcher pour importer' : 'Glisser-déposer ici' }}</strong>
                                    <span v-if="!isDragging">ou cliquer sur le bouton ci-dessus</span>
                                </div>
                                <input ref="mainInput" class="file-input" type="file" accept="image/*"
                                    @change="uploadFiles($event.target.files, 'image'); $event.target.value = ''">
                                <div v-if="uploading && uploadingField === 'image'" class="upload-progress">
                                    <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                    <span>Import{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                </div>
                                <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                            </div>

                            <!-- Miniature, Image2, Image3 -->
                            <div class="form-grid-3">
                                <div v-for="([field, label, inputRef]) in [['thumb', 'Miniature', thumbInput], ['image2', 'Image 2', image2Input], ['image3', 'Image 3', image3Input]]" :key="field" class="form-group">
                                    <label>{{ label }} <small>(optionnelle)</small></label>
                                    <div class="mini-image-slot">
                                        <img v-if="form[field]" :src="resolveImage(form[field])" :alt="label">
                                        <div v-else class="mini-placeholder"><i class="far fa-image"></i></div>
                                        <div class="mini-slot-actions">
                                            <div class="image-path-display small">
                                                <i class="far fa-image"></i>
                                                <span v-if="form[field]" :title="form[field]">{{ imageName(form[field]) }}</span>
                                                <span v-else class="placeholder-text">Non définie</span>
                                            </div>
                                            <button type="button" class="btn-soft" @click="$refs[field + 'Input'].click()">
                                                <i class="far fa-upload"></i> Importer
                                            </button>
                                            <button v-if="form[field]" type="button" class="btn-soft danger" @click="form[field] = ''">
                                                <i class="far fa-times"></i> Retirer
                                            </button>
                                        </div>
                                    </div>
                                    <div v-if="uploading && uploadingField === field" class="upload-progress">
                                        <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                        <span>Import…</span>
                                    </div>
                                </div>
                            </div>
                            <input ref="thumbInput" class="file-input" type="file" accept="image/*"
                                @change="uploadFiles($event.target.files, 'thumb'); $event.target.value = ''">
                            <input ref="image2Input" class="file-input" type="file" accept="image/*"
                                @change="uploadFiles($event.target.files, 'image2'); $event.target.value = ''">
                            <input ref="image3Input" class="file-input" type="file" accept="image/*"
                                @change="uploadFiles($event.target.files, 'image3'); $event.target.value = ''">

                            <p v-if="uploadError" class="error">{{ uploadError }}</p>
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside class="form-side">
                        <section class="preview-card">
                            <img v-if="form.image" :src="resolveImage(form.image)" alt="Aperçu">
                            <div v-else class="preview-placeholder">
                                <i class="far fa-newspaper"></i><span>Image principale</span>
                            </div>
                            <div class="preview-body">
                                <div class="preview-meta">
                                    <span class="preview-category">{{ form.category || 'Catégorie' }}</span>
                                    <span class="preview-date">{{ form.date || '—' }}</span>
                                </div>
                                <h3>{{ form.title || 'Titre de l\'article' }}</h3>
                                <p>{{ form.excerpt ? form.excerpt.substring(0, 120) + (form.excerpt.length > 120 ? '…' : '') : 'Extrait de l\'article.' }}</p>
                                <div class="preview-tags" v-if="tagItems.length">
                                    <span v-for="t in tagItems.slice(0, 3)" :key="t" class="tag-chip">{{ t }}</span>
                                </div>
                                <div class="preview-stats">
                                    <span><i class="far fa-user"></i> {{ form.author || '—' }}</span>
                                    <span v-if="form.read"><i class="far fa-clock"></i> {{ form.read }} min</span>
                                    <span><i class="far fa-align-left"></i> {{ bodyParagraphs.length }} §</span>
                                    <span><i class="far fa-tags"></i> {{ tagItems.length }} tags</span>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Publier l\'article' }}
                    </button>
                    <Link href="/admin/news" class="btn-secondary">Annuler</Link>
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

.news-form { display: flex; flex-direction: column; gap: 22px; }

.form-grid-layout {
    display: grid; grid-template-columns: minmax(0, 1fr) 320px;
    gap: 24px; align-items: start;
}
.form-main, .form-side { display: grid; gap: 22px; }

.form-card, .preview-card {
    background: #fff; border: 1px solid #e5ece2;
    border-radius: 8px; box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}
.form-card { padding: 26px; }

.card-header { display: flex; justify-content: space-between; gap: 14px; margin-bottom: 22px; }
.card-header h2 { margin: 0; color: #17351a; font-size: 1.1rem; font-weight: 900; }

.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
.form-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }

.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label { color: #17351a; font-weight: 850; font-size: 0.9rem; }
.form-group label small { font-weight: 500; color: #68746a; }

.form-group input, .form-group textarea {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 6px;
    color: #17351a; font: inherit;
}
.form-group textarea { resize: vertical; }
.form-group input:focus, .form-group textarea:focus {
    outline: none; border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

/* Tags */
.tag-input-row { display: flex; gap: 8px; }
.tag-input { flex: 1; }
.tags-display { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.tag-chip { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; background: #f0faf0; color: #24782b; border: 1px solid #c3ddc0; border-radius: 999px; font-size: 0.78rem; font-weight: 700; }
.tag-chip.editable { padding-right: 6px; }
.tag-remove { background: none; border: none; cursor: pointer; color: #68746a; padding: 0 2px; line-height: 1; font-size: 0.7rem; }
.tag-remove:hover { color: #b42323; }

/* Body paragraphs */
.body-list { display: grid; gap: 12px; }
.body-row { display: grid; grid-template-columns: 28px 1fr 42px; gap: 10px; align-items: start; }
.para-num { font-weight: 900; color: #5cb85c; font-size: 0.85rem; padding-top: 14px; text-align: center; }

/* Images */
.main-image-editor {
    display: grid; grid-template-columns: 160px 1fr;
    gap: 16px; align-items: center; margin-bottom: 12px;
}
.main-image-editor img, .image-placeholder {
    width: 160px; height: 120px;
    border-radius: 8px; border: 1px solid #e5ece2; background: #f8faf7;
}
.main-image-editor img { object-fit: cover; }
.image-placeholder, .preview-placeholder, .mini-placeholder {
    display: grid; place-items: center; align-content: center;
    gap: 8px; color: #68746a; text-align: center;
}
.image-placeholder i, .preview-placeholder i, .mini-placeholder i { color: #9aaa95; font-size: 1.6rem; }
.main-image-fields { display: grid; gap: 10px; }

.image-path-display {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px; border: 1.5px solid #dfe8db; border-radius: 6px;
    background: #f8faf7; color: #17351a; font-size: 0.95rem; min-height: 46px;
}
.image-path-display.small { min-height: 38px; font-size: 0.88rem; padding: 8px 12px; }
.image-path-display i { color: #5cb85c; font-size: 1.1rem; flex-shrink: 0; }
.image-path-display span { font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.image-path-display .placeholder-text { color: #9aaa95; font-weight: 400; font-style: italic; }

.upload-zone {
    display: grid; place-items: center; gap: 8px;
    padding: 20px 18px; border: 2px dashed #cfe0c9;
    border-radius: 8px; background: #fbfcfa; text-align: center; color: #68746a;
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

.mini-image-slot { display: grid; grid-template-columns: 90px 1fr; gap: 10px; align-items: start; }
.mini-image-slot img, .mini-placeholder {
    width: 90px; height: 70px;
    border-radius: 6px; border: 1px solid #e5ece2; background: #f8faf7; object-fit: cover;
}
.mini-slot-actions { display: flex; flex-direction: column; gap: 6px; }

.file-input { display: none; }

.label-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px; }

.btn-soft, .icon-button {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 7px; min-height: 38px; padding: 8px 12px;
    border: 1px solid #dfe8db; border-radius: 6px;
    background: #fff; color: #17351a; font-weight: 850;
    cursor: pointer; transition: all 0.2s;
}
.btn-soft:hover, .icon-button:hover { border-color: #5cb85c; background: #fbfcfa; }
.btn-soft.small { min-height: 32px; padding: 5px 10px; font-size: 0.85rem; }
.btn-soft.danger { color: #b42323; border-color: #ffd4d4; }
.btn-soft.danger:hover { background: #fff5f5; }
.icon-button { width: 42px; min-height: 42px; padding: 0; }
.icon-button.danger { color: #b42323; border-color: #ffd4d4; }

.empty-inline {
    margin: 0; padding: 14px; border: 1px dashed #dfe8db;
    border-radius: 6px; color: #68746a; background: #fbfcfa;
}

/* Preview sidebar */
.preview-card { overflow: hidden; }
.preview-card img, .preview-placeholder { width: 100%; height: 180px; }
.preview-card img { object-fit: cover; }
.preview-placeholder { background: #f8faf7; border-bottom: 1px solid #e5ece2; }
.preview-body { padding: 16px; }
.preview-meta { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
.preview-category {
    display: inline-flex; align-items: center; padding: 3px 9px;
    background: #e8f1ff; color: #245ea8; border-radius: 999px; font-size: 0.75rem; font-weight: 900;
}
.preview-date { font-size: 0.78rem; color: #68746a; }
.preview-body h3 { margin: 0 0 8px; color: #17351a; font-size: 1rem; font-weight: 900; }
.preview-body p { margin: 0 0 12px; color: #68746a; font-size: 0.85rem; line-height: 1.5; }
.preview-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 12px; }
.preview-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
.preview-stats span { font-size: 0.78rem; color: #68746a; display: flex; align-items: center; gap: 5px; }
.preview-stats i { color: #5cb85c; font-size: 0.75rem; }

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
    .form-grid, .form-grid-3, .main-image-editor, .mini-image-slot, .body-row { grid-template-columns: 1fr; }
    .form-card { padding: 18px; }
}
</style>
