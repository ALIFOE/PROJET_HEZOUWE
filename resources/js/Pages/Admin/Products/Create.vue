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
    images: [],
    price: 0,
    price_promo: null,
    discount: null,
    badge: null,
    stars: null,
    reviews: null,
    in_stock: true,
    details: [],
    features: [],
});

const submit = () => {
    form.post('/admin/products');
};
</script>

<template>
    <Head title="Ajouter un Produit" />

    <AdminLayout title="Ajouter un Produit">
        <div class="admin-page">
            <div class="page-header">
                <h1>Nouveau Produit</h1>
                <Link href="/admin/products" class="btn-secondary">
                    <i class="far fa-arrow-left"></i>
                    Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="form-container">
                <div class="form-section">
                    <h2>Informations générales</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Slug *</label>
                            <input v-model="form.slug" type="text" required placeholder="riz-blanc-premium-5kg">
                            <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                        </div>

                        <div class="form-group">
                            <label>Titre *</label>
                            <input v-model="form.title" type="text" required placeholder="Riz Blanc Premium 5kg">
                            <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                        </div>

                        <div class="form-group">
                            <label>Catégorie *</label>
                            <input v-model="form.category" type="text" required placeholder="Riz">
                            <span v-if="form.errors.category" class="error">{{ form.errors.category }}</span>
                        </div>

                        <div class="form-group">
                            <label>Badge (optionnel)</label>
                            <input v-model="form.badge" type="text" placeholder="Nouveau, Promo, etc.">
                            <span v-if="form.errors.badge" class="error">{{ form.errors.badge }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description courte *</label>
                        <textarea v-model="form.short" rows="2" required placeholder="Description courte du produit"></textarea>
                        <span v-if="form.errors.short" class="error">{{ form.errors.short }}</span>
                    </div>

                    <div class="form-group">
                        <label>Description complète *</label>
                        <textarea v-model="form.description" rows="5" required placeholder="Description détaillée du produit"></textarea>
                        <span v-if="form.errors.description" class="error">{{ form.errors.description }}</span>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Images</h2>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Image principale *</label>
                            <input v-model="form.image" type="text" required placeholder="/assets/img/image1.jpg">
                            <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                        </div>

                        <div class="form-group full-width">
                            <label>Images additionnelles (JSON array)</label>
                            <input v-model="form.images" type="text" placeholder='["/assets/img/image2.jpg", "/assets/img/image3.jpg"]'>
                            <span v-if="form.errors.images" class="error">{{ form.errors.images }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Prix et Stock</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Prix (FCFA) *</label>
                            <input v-model="form.price" type="number" required min="0" placeholder="15000">
                            <span v-if="form.errors.price" class="error">{{ form.errors.price }}</span>
                        </div>

                        <div class="form-group">
                            <label>Prix promo (FCFA)</label>
                            <input v-model="form.price_promo" type="number" min="0" placeholder="12000">
                            <span v-if="form.errors.price_promo" class="error">{{ form.errors.price_promo }}</span>
                        </div>

                        <div class="form-group">
                            <label>Réduction (%)</label>
                            <input v-model="form.discount" type="number" min="0" max="100" placeholder="20">
                            <span v-if="form.errors.discount" class="error">{{ form.errors.discount }}</span>
                        </div>

                        <div class="form-group">
                            <label>Note (1-5)</label>
                            <input v-model="form.stars" type="number" min="1" max="5" placeholder="5">
                            <span v-if="form.errors.stars" class="error">{{ form.errors.stars }}</span>
                        </div>

                        <div class="form-group">
                            <label>Nombre d'avis</label>
                            <input v-model="form.reviews" type="number" min="0" placeholder="42">
                            <span v-if="form.errors.reviews" class="error">{{ form.errors.reviews }}</span>
                        </div>

                        <div class="form-group checkbox-group">
                            <label>
                                <input v-model="form.in_stock" type="checkbox">
                                En stock
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Détails additionnels</h2>
                    <div class="form-group">
                        <label>Détails (JSON array)</label>
                        <textarea v-model="form.details" rows="3" placeholder='{"Poids": "5kg", "Origine": "Togo"}'></textarea>
                        <span v-if="form.errors.details" class="error">{{ form.errors.details }}</span>
                    </div>

                    <div class="form-group">
                        <label>Caractéristiques (JSON array)</label>
                        <textarea v-model="form.features" rows="3" placeholder='["Certifié ITRA", "Sans additifs", "Arôme naturel"]'></textarea>
                        <span v-if="form.errors.features" class="error">{{ form.errors.features }}</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
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

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.2s;
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
    color: #1a3a1a;
    border: 1.5px solid #e8eee3;
}

.btn-secondary:hover {
    background: #f9faf9;
    border-color: #5cb85c;
}

.form-container {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.form-section {
    padding-bottom: 32px;
    border-bottom: 1px solid #e8eee3;
    margin-bottom: 32px;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.form-section h2 {
    margin: 0 0 20px;
    color: #1a3a1a;
    font-size: 1.25rem;
    font-weight: 900;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.full-width {
    grid-column: span 2;
}

.form-group label {
    color: #1a3a1a;
    font-weight: 700;
    font-size: 0.9rem;
}

.form-group input,
.form-group textarea {
    padding: 12px 16px;
    border: 1.5px solid #e8eee3;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #5cb85c;
}

.form-group textarea {
    resize: vertical;
    font-family: inherit;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-group input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.error {
    color: #dc2626;
    font-size: 0.85rem;
    font-weight: 600;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid #e8eee3;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group.full-width {
        grid-column: span 1;
    }

    .form-container {
        padding: 20px;
    }
}
</style>
