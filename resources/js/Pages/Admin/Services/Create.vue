<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    slug: '',
    title: '',
    short: '',
    description: '',
    image: '',
    icon: '',
});

const submit = () => {
    form.post('/admin/services');
};
</script>

<template>
    <Head title="Ajouter un Service" />

    <AdminLayout title="Ajouter un Service">
        <div class="admin-page">
            <div class="page-header">
                <h1>Nouveau Service</h1>
                <Link href="/admin/services" class="btn-secondary">
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
                            <input v-model="form.slug" type="text" required placeholder="collecte-riz">
                            <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                        </div>

                        <div class="form-group">
                            <label>Titre *</label>
                            <input v-model="form.title" type="text" required placeholder="Collecte de Riz Paddy">
                            <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description courte *</label>
                        <textarea v-model="form.short" rows="2" required placeholder="Description courte du service"></textarea>
                        <span v-if="form.errors.short" class="error">{{ form.errors.short }}</span>
                    </div>

                    <div class="form-group">
                        <label>Description complète *</label>
                        <textarea v-model="form.description" rows="5" required placeholder="Description détaillée du service"></textarea>
                        <span v-if="form.errors.description" class="error">{{ form.errors.description }}</span>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Médias</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Image *</label>
                            <input v-model="form.image" type="text" required placeholder="/assets/img/image1.jpg">
                            <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                        </div>

                        <div class="form-group">
                            <label>Icone (optionnel)</label>
                            <input v-model="form.icon" type="text" placeholder="flaticon-tomato">
                            <span v-if="form.errors.icon" class="error">{{ form.errors.icon }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                    </button>
                    <Link href="/admin/services" class="btn-secondary">Annuler</Link>
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

    .form-container {
        padding: 20px;
    }
}
</style>
