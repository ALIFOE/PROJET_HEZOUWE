<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    slug: '',
    title: '',
    category: '',
    short: '',
    description: '',
    image: '',
    images_text: '',
    price: 0,
    price_promo: null,
    discount: 0,
    badge: '',
    stars: 5,
    reviews: 0,
    in_stock: true,
    details_text: '',
    features_text: '',
});

const parseJsonField = (value, fallback) => {
    if (!value || !String(value).trim()) {
        return fallback;
    }

    try {
        return JSON.parse(value);
    } catch {
        return fallback;
    }
};

const parseFeatures = (value) => {
    const parsed = parseJsonField(value, null);
    if (Array.isArray(parsed)) {
        return parsed;
    }

    return String(value || '')
        .split('\n')
        .map((item) => item.trim())
        .filter(Boolean);
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
            images: parseJsonField(data.images_text, []),
            price: Number(data.price || 0),
            price_promo: data.price_promo === '' || data.price_promo === null ? null : Number(data.price_promo),
            discount: data.discount === '' || data.discount === null ? 0 : Number(data.discount),
            badge: data.badge || null,
            stars: data.stars === '' || data.stars === null ? 5 : Number(data.stars),
            reviews: data.reviews === '' || data.reviews === null ? 0 : Number(data.reviews),
            in_stock: Boolean(data.in_stock),
            details: parseJsonField(data.details_text, []),
            features: parseFeatures(data.features_text),
        }))
        .post('/admin/products');
};
</script>

<template>
    <Head title="Ajouter un produit" />

    <AdminLayout title="Ajouter un produit">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Nouveau produit</p>
                    <h1>Ajouter un produit</h1>
                    <p class="header-text">Completez les informations principales, les prix, les images et les caracteristiques.</p>
                </div>
                <Link href="/admin/products" class="btn-secondary">
                    <i class="far fa-arrow-left"></i>
                    Retour a la liste
                </Link>
            </div>

            <form @submit.prevent="submit" class="product-form">
                <div class="form-grid-layout">
                    <div class="form-main">
                        <section class="form-card">
                            <div class="card-header">
                                <h2>Informations generales</h2>
                                <span>Obligatoire</span>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="title">Nom du produit *</label>
                                    <input id="title" v-model="form.title" type="text" required placeholder="Riz Blanc Premium 5kg">
                                    <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug *</label>
                                    <input id="slug" v-model="form.slug" type="text" required placeholder="riz-blanc-premium-5kg">
                                    <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="category">Categorie *</label>
                                    <input id="category" v-model="form.category" type="text" required placeholder="Riz Blanc">
                                    <span v-if="form.errors.category" class="error">{{ form.errors.category }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="badge">Badge</label>
                                    <input id="badge" v-model="form.badge" type="text" placeholder="Promo, Nouveau, Bestseller">
                                    <span v-if="form.errors.badge" class="error">{{ form.errors.badge }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short">Description courte *</label>
                                <textarea id="short" v-model="form.short" rows="3" required placeholder="Resume visible dans les cartes produits"></textarea>
                                <span v-if="form.errors.short" class="error">{{ form.errors.short }}</span>
                            </div>

                            <div class="form-group">
                                <label for="description">Description complete *</label>
                                <textarea id="description" v-model="form.description" rows="7" required placeholder="Description detaillee du produit"></textarea>
                                <span v-if="form.errors.description" class="error">{{ form.errors.description }}</span>
                            </div>
                        </section>

                        <section class="form-card">
                            <div class="card-header">
                                <h2>Images et details</h2>
                                <span>Catalogue</span>
                            </div>

                            <div class="form-group">
                                <label for="image">Image principale *</label>
                                <input id="image" v-model="form.image" type="text" required placeholder="Importez une image ou collez son URL">
                                <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                            </div>

                            <div class="form-group">
                                <label for="images_text">Images additionnelles</label>
                                <textarea id="images_text" v-model="form.images_text" rows="3" placeholder='["/storage/products/image.jpg"]'></textarea>
                                <p class="field-help">Format JSON recommande. Laissez vide si aucune image additionnelle.</p>
                                <span v-if="form.errors.images" class="error">{{ form.errors.images }}</span>
                            </div>

                            <div class="form-group">
                                <label for="details_text">Details techniques</label>
                                <textarea id="details_text" v-model="form.details_text" rows="4" placeholder='[{"label":"Poids net","value":"5 kg"},{"label":"Origine","value":"Togo"}]'></textarea>
                                <span v-if="form.errors.details" class="error">{{ form.errors.details }}</span>
                            </div>

                            <div class="form-group">
                                <label for="features_text">Caracteristiques</label>
                                <textarea id="features_text" v-model="form.features_text" rows="4" placeholder="Certifie ITRA&#10;Sans OGM&#10;Riz local"></textarea>
                                <p class="field-help">Une caracteristique par ligne ou tableau JSON.</p>
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
                            <img v-if="form.image" :src="form.image" :alt="form.title || 'Produit'">
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
                        {{ form.processing ? 'Creation en cours...' : 'Creer le produit' }}
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
    display: grid;
    place-items: center;
    align-content: center;
    gap: 8px;
    background: #f8faf7;
    border-bottom: 1px solid #e5ece2;
    color: #68746a;
    text-align: center;
}

.preview-placeholder i {
    color: #9aaa95;
    font-size: 1.8rem;
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
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
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

    .form-card {
        padding: 20px;
    }
}
</style>
