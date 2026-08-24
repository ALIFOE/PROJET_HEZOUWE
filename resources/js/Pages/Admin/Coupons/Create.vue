<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    code: '',
    type: 'percent',
    value: '',
    min_order_amount: '',
    max_uses: '',
    max_uses_per_user: '',
    starts_at: '',
    expires_at: '',
    is_active: true,
});

const submit = () => {
    form
        .transform(data => ({
            ...data,
            code: data.code.toUpperCase(),
            min_order_amount: data.min_order_amount || null,
            max_uses: data.max_uses || null,
            max_uses_per_user: data.max_uses_per_user || null,
            starts_at: data.starts_at || null,
            expires_at: data.expires_at || null,
        }))
        .post('/admin/coupons');
};
</script>

<template>
    <Head title="Ajouter un Code Promo" />

    <AdminLayout title="Ajouter un Code Promo">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Nouveau</p>
                    <h1>Ajouter un Code Promo</h1>
                </div>
                <Link href="/admin/coupons" class="btn-secondary">
                    <i class="far fa-arrow-left"></i> Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="product-form">
                <div class="form-card">
                    <div class="card-header">
                        <h2>Informations générales</h2>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Code *</label>
                            <input v-model="form.code" type="text" required placeholder="HEZOUWE10" class="code-input" style="text-transform: uppercase;">
                            <span v-if="form.errors.code" class="error">{{ form.errors.code }}</span>
                        </div>
                        <div class="form-group">
                            <label>Type de réduction *</label>
                            <select v-model="form.type" required>
                                <option value="percent">Pourcentage (%)</option>
                                <option value="fixed">Montant fixe (FCFA)</option>
                            </select>
                            <span v-if="form.errors.type" class="error">{{ form.errors.type }}</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Valeur * <small>{{ form.type === 'percent' ? '(1-100)' : '(en FCFA)' }}</small></label>
                            <input v-model.number="form.value" type="number" min="1" :max="form.type === 'percent' ? 100 : undefined" required placeholder="10">
                            <span v-if="form.errors.value" class="error">{{ form.errors.value }}</span>
                        </div>
                        <div class="form-group">
                            <label>Montant minimum de commande <small>(optionnel)</small></label>
                            <input v-model.number="form.min_order_amount" type="number" min="0" placeholder="Aucun minimum">
                            <span v-if="form.errors.min_order_amount" class="error">{{ form.errors.min_order_amount }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="card-header">
                        <h2>Limites d'utilisation</h2>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nombre d'utilisations max <small>(total, optionnel)</small></label>
                            <input v-model.number="form.max_uses" type="number" min="1" placeholder="Illimité">
                            <span v-if="form.errors.max_uses" class="error">{{ form.errors.max_uses }}</span>
                        </div>
                        <div class="form-group">
                            <label>Utilisations max par client <small>(optionnel)</small></label>
                            <input v-model.number="form.max_uses_per_user" type="number" min="1" placeholder="Illimité">
                            <span v-if="form.errors.max_uses_per_user" class="error">{{ form.errors.max_uses_per_user }}</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Date de début <small>(optionnel)</small></label>
                            <input v-model="form.starts_at" type="datetime-local">
                            <span v-if="form.errors.starts_at" class="error">{{ form.errors.starts_at }}</span>
                        </div>
                        <div class="form-group">
                            <label>Date d'expiration <small>(optionnel)</small></label>
                            <input v-model="form.expires_at" type="datetime-local">
                            <span v-if="form.errors.expires_at" class="error">{{ form.errors.expires_at }}</span>
                        </div>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input v-model="form.is_active" type="checkbox">
                            Code actif
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Créer le code promo' }}
                    </button>
                    <Link href="/admin/coupons" class="btn-secondary">Annuler</Link>
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

.product-form { display: flex; flex-direction: column; gap: 22px; max-width: 800px; }

.form-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
    padding: 26px;
}

.card-header { display: flex; justify-content: space-between; gap: 14px; margin-bottom: 22px; }
.card-header h2 { margin: 0; color: #17351a; font-size: 1.1rem; font-weight: 900; }

.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }

.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label { color: #17351a; font-weight: 850; font-size: 0.9rem; }
.form-group label small { font-weight: 500; color: #68746a; }

.form-group input, .form-group select {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 6px;
    color: #17351a; font: inherit;
}

.code-input { font-family: monospace; font-weight: 700; letter-spacing: 0.5px; }

.form-group input:focus, .form-group select:focus {
    outline: none; border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

.checkbox-group { flex-direction: row; align-items: center; }
.checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.checkbox-label input { width: 18px; height: 18px; accent-color: #5cb85c; }

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

@media (max-width: 768px) {
    .page-header, .form-actions { flex-direction: column; align-items: flex-start; }
    .form-grid { grid-template-columns: 1fr; }
    .form-card { padding: 18px; }
}
</style>
