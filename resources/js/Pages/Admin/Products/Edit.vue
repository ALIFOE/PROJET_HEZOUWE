<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    product: Object,
});

const normalizeDetails = (value) => {
    if (Array.isArray(value)) {
        return value.map((item) => ({
            label: item.label || item.name || '',
            value: item.value || '',
        })).filter((item) => item.label || item.value);
    }

    if (value && typeof value === 'object') {
        return Object.entries(value).map(([label, detailValue]) => ({
            label,
            value: detailValue,
        }));
    }

    return [];
};

const uploadInput = ref(null);
const mainImageInput = ref(null);
const uploading = ref(false);
const uploadError = ref('');
const isDragging = ref(false);
const uploadProgress = ref(0);
const imageItems = ref([...(props.product.images || [])].filter(Boolean));

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    // URL absolue contenant /storage/ → extraire le chemin relatif
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `/storage/${path}`;
};

const imageName = (path) => {
    if (!path) return '';
    return path.split('/').pop();
};

const csrfToken = () =>
    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const detailRows = ref(normalizeDetails(props.product.details));
const featureItems = ref(Array.isArray(props.product.features) ? [...props.product.features] : []);

const form = useForm({
    slug: props.product.slug,
    title: props.product.title,
    category: props.product.category,
    short: props.product.short,
    description: props.product.description,
    image: props.product.image,
    price: props.product.price,
    price_promo: props.product.price_promo,
    discount: props.product.discount ?? 0,
    badge: props.product.badge || '',
    stars: props.product.stars ?? 5,
    reviews: props.product.reviews ?? 0,
    in_stock: Boolean(props.product.in_stock),
});

const allImages = computed(() => [form.image, ...imageItems.value].filter(Boolean));

const openUpload = () => uploadInput.value?.click();
const openMainImageUpload = () => mainImageInput.value?.click();

const addImageUrl = () => {
    const url = prompt('Coller une URL ou un chemin image');
    if (!url) {
        return;
    }

    imageItems.value = [...new Set([...imageItems.value, url.trim()])];
};

const uploadFiles = async (files, setAsMain = false) => {
    const selectedFiles = Array.from(files || []).filter((f) => f.type.startsWith('image/'));
    if (!selectedFiles.length) return;

    const payload = new FormData();
    selectedFiles.forEach((f) => payload.append('images[]', f));

    uploading.value = true;
    uploadError.value = '';
    uploadProgress.value = 0;

    try {
        const response = await window.axios.post('/admin/products/upload-image', payload, {
            headers: { 'X-CSRF-TOKEN': csrfToken() },
            onUploadProgress: (e) => {
                if (e.total) uploadProgress.value = Math.round((e.loaded / e.total) * 100);
            },
        });
        const uploaded = response.data.images || [];
        if (setAsMain && uploaded[0]) {
            form.image = uploaded[0];
            imageItems.value = [...new Set([...imageItems.value, ...uploaded.slice(1)])];
        } else {
            imageItems.value = [...new Set([...imageItems.value, ...uploaded])];
        }
    } catch (err) {
        const msg = err.response?.data?.message || err.response?.data?.error;
        uploadError.value = msg || 'Echec de l\'import. Verifiez le format ou la taille (max 10 Mo).';
    } finally {
        uploading.value = false;
        uploadProgress.value = 0;
    }
};

const handleDragEnter = (e) => { e.preventDefault(); isDragging.value = true; };
const handleDragLeave = (e) => { if (!e.currentTarget.contains(e.relatedTarget)) isDragging.value = false; };
const handleDrop = (e) => { isDragging.value = false; uploadFiles(e.dataTransfer.files); };

const removeImage = (index) => {
    imageItems.value.splice(index, 1);
};

const setMainImage = (image) => {
    if (form.image && form.image !== image) {
        imageItems.value = [...new Set([form.image, ...imageItems.value.filter((item) => item !== image)])];
    } else {
        imageItems.value = imageItems.value.filter((item) => item !== image);
    }
    form.image = image;
};

const addDetailRow = () => {
    detailRows.value.push({ label: '', value: '' });
};

const removeDetailRow = (index) => {
    detailRows.value.splice(index, 1);
};

const addFeature = () => {
    featureItems.value.push('');
};

const removeFeature = (index) => {
    featureItems.value.splice(index, 1);
};

const submit = () => {
    form
        .transform((data) => ({
            slug: data.slug,
            title: data.title,
            category: data.category,
            short: data.short,
            description: data.description,
            image: data.image,
            images: imageItems.value.filter(Boolean),
            price: Number(data.price || 0),
            price_promo: data.price_promo === '' || data.price_promo === null ? null : Number(data.price_promo),
            discount: data.discount === '' || data.discount === null ? 0 : Number(data.discount),
            badge: data.badge || null,
            stars: data.stars === '' || data.stars === null ? 5 : Number(data.stars),
            reviews: data.reviews === '' || data.reviews === null ? 0 : Number(data.reviews),
            in_stock: Boolean(data.in_stock),
            details: detailRows.value.filter((item) => item.label || item.value),
            features: featureItems.value.map((item) => String(item).trim()).filter(Boolean),
        }))
        .put(`/admin/products/${props.product.slug}`);
};
</script>

<template>
    <Head :title="`Modifier ${product.title}`" />

    <AdminLayout :title="`Modifier ${product.title}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Modification produit</p>
                    <h1>{{ product.title }}</h1>
                    <p class="header-text">Mettez a jour les informations du produit et son affichage dans la boutique.</p>
                </div>
                <div class="header-actions">
                    <Link :href="`/shop-details/${product.slug}`" class="btn-secondary">
                        <i class="far fa-eye"></i>
                        Voir cote boutique
                    </Link>
                    <Link href="/admin/products" class="btn-secondary">
                        <i class="far fa-arrow-left"></i>
                        Retour a la liste
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="product-form">
                <div class="form-grid-layout">
                    <div class="form-main">
                        <section class="form-card">
                            <div class="card-header">
                                <h2>Informations generales</h2>
                                <span>ID {{ product.id }}</span>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="title">Nom du produit *</label>
                                    <input id="title" v-model="form.title" type="text" required>
                                    <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug *</label>
                                    <input id="slug" v-model="form.slug" type="text" required>
                                    <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="category">Categorie *</label>
                                    <input id="category" v-model="form.category" type="text" required>
                                    <span v-if="form.errors.category" class="error">{{ form.errors.category }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="badge">Badge</label>
                                    <input id="badge" v-model="form.badge" type="text">
                                    <span v-if="form.errors.badge" class="error">{{ form.errors.badge }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short">Description courte *</label>
                                <textarea id="short" v-model="form.short" rows="3" required></textarea>
                                <span v-if="form.errors.short" class="error">{{ form.errors.short }}</span>
                            </div>

                            <div class="form-group">
                                <label for="description">Description complete *</label>
                                <textarea id="description" v-model="form.description" rows="7" required></textarea>
                                <span v-if="form.errors.description" class="error">{{ form.errors.description }}</span>
                            </div>
                        </section>

                        <section class="form-card">
                            <div class="card-header">
                                <h2>Images et details</h2>
                                <span>Catalogue</span>
                            </div>

                            <div class="form-group">
                                <label>Image principale *</label>
                                <div class="main-image-editor">
                                    <img v-if="form.image" :src="resolveImage(form.image)" :alt="form.title || 'Produit'">
                                    <div v-else class="image-placeholder">
                                        <i class="far fa-image"></i>
                                        <span>Aucune image</span>
                                    </div>
                                    <div class="main-image-fields">
                                        <!-- Champ caché pour la soumission du formulaire -->
                                        <input v-model="form.image" type="hidden" required>
                                        <!-- Affichage du nom du fichier uniquement -->
                                        <div class="image-path-display">
                                            <i class="far fa-image"></i>
                                            <span v-if="form.image" :title="form.image">{{ imageName(form.image) }}</span>
                                            <span v-else class="placeholder-text">Aucune image sélectionnée</span>
                                        </div>
                                        <div class="inline-actions">
                                            <button type="button" class="btn-soft" @click="openMainImageUpload">
                                                <i class="far fa-upload"></i>
                                                Importer image principale
                                            </button>
                                            <button v-if="imageItems[0]" type="button" class="btn-soft" @click="setMainImage(imageItems[0])">
                                                Utiliser la premiere image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input
                                    ref="mainImageInput"
                                    class="file-input"
                                    type="file"
                                    accept="image/*"
                                    @change="uploadFiles($event.target.files, true); $event.target.value = ''"
                                >
                                <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                            </div>

                            <div class="form-group">
                                <label>Images additionnelles</label>
                                <div
                                    class="upload-zone"
                                    :class="{ uploading, dragging: isDragging }"
                                    @dragenter="handleDragEnter"
                                    @dragover.prevent
                                    @dragleave="handleDragLeave"
                                    @drop.prevent="handleDrop"
                                >
                                    <i class="far" :class="isDragging ? 'fa-arrow-down' : 'fa-images'"></i>
                                    <strong>{{ isDragging ? 'Relacher pour importer' : 'Glisser deposer des images ici' }}</strong>
                                    <span v-if="!isDragging">ou utilisez le bouton pour importer depuis votre ordinateur</span>
                                    <div v-if="!isDragging" class="inline-actions">
                                        <button type="button" class="btn-soft" @click="openUpload">
                                            <i class="far fa-folder-open"></i>
                                            Importer des images
                                        </button>
                                    </div>
                                </div>
                                <input
                                    ref="uploadInput"
                                    class="file-input"
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    @change="uploadFiles($event.target.files); $event.target.value = ''"
                                >
                                <div v-if="uploading" class="upload-progress">
                                    <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                    <span>Import en cours{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                </div>
                                <p v-if="uploadError" class="error">{{ uploadError }}</p>
                                <div v-if="allImages.length" class="image-list">
                                    <article v-for="(image, index) in allImages" :key="`${image}-${index}`" class="image-item">
                                        <img :src="resolveImage(image)" :alt="`Image ${index + 1}`">
                                        <div>
                                            <strong>{{ index === 0 ? 'Image principale' : `Image ${index}` }}</strong>
                                            <span :title="image">{{ imageName(image) }}</span>
                                        </div>
                                        <button
                                            v-if="index > 0"
                                            type="button"
                                            class="mini-button"
                                            @click="setMainImage(image)"
                                        >
                                            Definir principale
                                        </button>
                                        <button
                                            v-if="index > 0"
                                            type="button"
                                            class="mini-button danger"
                                            @click="removeImage(index - 1)"
                                        >
                                            Retirer
                                        </button>
                                    </article>
                                </div>
                                <span v-if="form.errors.images" class="error">{{ form.errors.images }}</span>
                            </div>

                            <div class="form-group">
                                <div class="label-row">
                                    <label>Details techniques</label>
                                    <button type="button" class="btn-soft small" @click="addDetailRow">
                                        <i class="far fa-plus"></i>
                                        Ajouter un detail
                                    </button>
                                </div>
                                <div class="editable-list">
                                    <div v-for="(detail, index) in detailRows" :key="index" class="editable-row">
                                        <input v-model="detail.label" type="text" placeholder="Libelle ex: Poids net">
                                        <input v-model="detail.value" type="text" placeholder="Valeur ex: 5 kg">
                                        <button type="button" class="icon-button danger" @click="removeDetailRow(index)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="detailRows.length === 0" class="empty-inline">Aucun detail technique ajoute.</p>
                                </div>
                                <span v-if="form.errors.details" class="error">{{ form.errors.details }}</span>
                            </div>

                            <div class="form-group">
                                <div class="label-row">
                                    <label>Caracteristiques</label>
                                    <button type="button" class="btn-soft small" @click="addFeature">
                                        <i class="far fa-plus"></i>
                                        Ajouter une caracteristique
                                    </button>
                                </div>
                                <div class="editable-list">
                                    <div v-for="(feature, index) in featureItems" :key="index" class="editable-row feature-row">
                                        <input v-model="featureItems[index]" type="text" placeholder="Ex: Certifie ITRA">
                                        <button type="button" class="icon-button danger" @click="removeFeature(index)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="featureItems.length === 0" class="empty-inline">Aucune caracteristique ajoutee.</p>
                                </div>
                                <span v-if="form.errors.features" class="error">{{ form.errors.features }}</span>
                            </div>
                        </section>
                    </div>

                    <aside class="form-side">
                        <section class="form-card">
                            <div class="card-header">
                                <h2>Prix et stock</h2>
                            </div>

                            <div class="form-group">
                                <label for="price">Prix normal (FCFA) *</label>
                                <input id="price" v-model="form.price" type="number" required min="0">
                                <span v-if="form.errors.price" class="error">{{ form.errors.price }}</span>
                            </div>

                            <div class="form-group">
                                <label for="price_promo">Prix promo (FCFA)</label>
                                <input id="price_promo" v-model="form.price_promo" type="number" min="0">
                                <span v-if="form.errors.price_promo" class="error">{{ form.errors.price_promo }}</span>
                            </div>

                            <div class="form-grid compact">
                                <div class="form-group">
                                    <label for="discount">Reduction (%)</label>
                                    <input id="discount" v-model="form.discount" type="number" min="0" max="100">
                                    <span v-if="form.errors.discount" class="error">{{ form.errors.discount }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="stars">Note</label>
                                    <input id="stars" v-model="form.stars" type="number" min="1" max="5">
                                    <span v-if="form.errors.stars" class="error">{{ form.errors.stars }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reviews">Nombre d'avis</label>
                                <input id="reviews" v-model="form.reviews" type="number" min="0">
                                <span v-if="form.errors.reviews" class="error">{{ form.errors.reviews }}</span>
                            </div>

                            <label class="switch-row">
                                <input v-model="form.in_stock" type="checkbox">
                                <span>
                                    <strong>Produit en stock</strong>
                                    <small>Disponible a la vente dans la boutique</small>
                                </span>
                            </label>
                        </section>

                        <section class="preview-card">
                            <img v-if="form.image" :src="resolveImage(form.image)" :alt="form.title || 'Produit'">
                            <div v-else class="preview-placeholder">
                                <i class="far fa-image"></i>
                                <span>Aucune image principale</span>
                            </div>
                            <div>
                                <span>{{ form.category || 'Categorie' }}</span>
                                <h3>{{ form.title || 'Nom du produit' }}</h3>
                                <p>{{ form.short || 'Description courte du produit.' }}</p>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement en cours...' : 'Enregistrer les modifications' }}
                    </button>
                    <Link href="/admin/products" class="btn-secondary">Annuler</Link>
                </div>
            </form>
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

.header-text,
.field-help {
    margin: 8px 0 0;
    color: #68746a;
}

.header-actions,
.form-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.product-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.form-grid-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 24px;
    align-items: start;
}

.form-main,
.form-side {
    display: grid;
    gap: 22px;
}

.form-card,
.preview-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.form-card {
    padding: 26px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 22px;
}

.card-header h2 {
    margin: 0;
    color: #17351a;
    font-size: 1.18rem;
    font-weight: 900;
}

.card-header span {
    color: #68746a;
    font-weight: 800;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}

.form-grid.compact {
    gap: 12px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 18px;
}

.form-group label,
.switch-row strong {
    color: #17351a;
    font-weight: 850;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    color: #17351a;
    font: inherit;
}

.form-group textarea {
    resize: vertical;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

.main-image-editor {
    display: grid;
    grid-template-columns: 170px 1fr;
    gap: 16px;
    align-items: center;
}

.main-image-editor img,
.image-placeholder {
    width: 170px;
    height: 130px;
    border-radius: 8px;
    border: 1px solid #e5ece2;
    background: #f8faf7;
}

.main-image-editor img {
    object-fit: cover;
}

.image-placeholder,
.preview-placeholder {
    display: grid;
    place-items: center;
    align-content: center;
    gap: 8px;
    color: #68746a;
    text-align: center;
}

.image-placeholder i,
.preview-placeholder i {
    color: #9aaa95;
    font-size: 1.8rem;
}

.main-image-fields {
    display: grid;
    gap: 10px;
}

.image-path-display {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 14px;
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    background: #f8faf7;
    color: #17351a;
    font-size: 0.95rem;
    min-height: 46px;
}

.image-path-display i {
    color: #5cb85c;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.image-path-display span {
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.image-path-display .placeholder-text {
    color: #9aaa95;
    font-weight: 400;
    font-style: italic;
}

.inline-actions,
.label-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}

.label-row {
    justify-content: space-between;
}

.btn-soft,
.mini-button,
.icon-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 38px;
    padding: 8px 12px;
    border: 1px solid #dfe8db;
    border-radius: 6px;
    background: #fff;
    color: #17351a;
    font-weight: 850;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-soft:hover,
.mini-button:hover,
.icon-button:hover {
    border-color: #5cb85c;
    background: #fbfcfa;
}

.btn-soft.small {
    min-height: 34px;
    padding: 7px 10px;
    font-size: 0.86rem;
}

.file-input {
    display: none;
}

.upload-zone {
    display: grid;
    place-items: center;
    gap: 8px;
    padding: 30px 18px;
    border: 2px dashed #cfe0c9;
    border-radius: 8px;
    background: #fbfcfa;
    text-align: center;
    color: #68746a;
}

.upload-zone.uploading {
    opacity: 0.65;
    pointer-events: none;
}

.upload-zone.dragging {
    border-color: #5cb85c;
    background: #f0faf0;
}

.upload-zone.dragging i,
.upload-zone.dragging strong {
    color: #24782b;
}

.upload-progress {
    position: relative;
    height: 28px;
    background: #e8eee3;
    border-radius: 6px;
    overflow: hidden;
    margin-top: 8px;
    display: flex;
    align-items: center;
    padding: 0 12px;
}

.progress-bar {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    background: #5cb85c;
    transition: width 0.2s;
    z-index: 0;
}

.upload-progress span {
    position: relative;
    z-index: 1;
    font-size: 0.83rem;
    font-weight: 700;
    color: #17351a;
}

.upload-zone > i {
    color: #5cb85c;
    font-size: 2rem;
}

.upload-zone strong {
    color: #17351a;
    font-size: 1.02rem;
}

.image-list {
    display: grid;
    gap: 10px;
    margin-top: 14px;
}

.image-item {
    display: grid;
    grid-template-columns: 72px minmax(0, 1fr) auto auto;
    align-items: center;
    gap: 12px;
    padding: 10px;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    background: #fff;
}

.image-item img {
    width: 72px;
    height: 58px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #edf2ea;
}

.image-item strong {
    display: block;
    color: #17351a;
}

.image-item span {
    display: block;
    margin-top: 3px;
    color: #68746a;
    font-size: 0.84rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.mini-button {
    min-height: 34px;
    padding: 7px 10px;
    font-size: 0.82rem;
}

.mini-button.danger,
.icon-button.danger {
    color: #b42323;
    border-color: #ffd4d4;
}

.editable-list {
    display: grid;
    gap: 10px;
}

.editable-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.4fr) 42px;
    gap: 10px;
    align-items: center;
}

.editable-row.feature-row {
    grid-template-columns: minmax(0, 1fr) 42px;
}

.icon-button {
    width: 42px;
    min-height: 42px;
    padding: 0;
}

.empty-inline {
    margin: 0;
    padding: 14px;
    border: 1px dashed #dfe8db;
    border-radius: 6px;
    color: #68746a;
    background: #fbfcfa;
}

.switch-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    cursor: pointer;
}

.switch-row input {
    width: 20px;
    height: 20px;
    margin-top: 2px;
}

.switch-row span {
    display: grid;
    gap: 3px;
}

.switch-row small {
    color: #68746a;
}

.preview-card {
    overflow: hidden;
}

.preview-card img,
.preview-placeholder {
    width: 100%;
    height: 210px;
}

.preview-card img {
    object-fit: cover;
}

.preview-placeholder {
    background: #f8faf7;
    border-bottom: 1px solid #e5ece2;
}

.preview-card div {
    padding: 18px;
}

.preview-card span {
    color: #5cb85c;
    font-weight: 850;
}

.preview-card h3 {
    margin: 8px 0;
    color: #17351a;
    font-size: 1.1rem;
}

.preview-card p {
    margin: 0;
    color: #68746a;
}

.error {
    color: #b42323;
    font-weight: 750;
    font-size: 0.86rem;
}

.form-actions {
    justify-content: flex-end;
    padding: 18px;
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
}

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 850;
}

.btn-primary {
    background: #5cb85c;
    color: #fff;
    border: none;
    cursor: pointer;
}

.btn-primary:hover:not(:disabled) {
    background: #4a9e4a;
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-secondary {
    background: #fff;
    color: #17351a;
    border: 1.5px solid #dfe8db;
}

.btn-secondary:hover {
    border-color: #5cb85c;
    background: #fbfcfa;
}

@media (max-width: 1100px) {
    .form-grid-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .page-header,
    .form-actions {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .main-image-editor,
    .image-item,
    .editable-row {
        grid-template-columns: 1fr;
    }

    .main-image-editor img,
    .image-placeholder,
    .image-item img {
        width: 100%;
        height: 180px;
    }

    .form-card {
        padding: 20px;
    }
}
</style>
