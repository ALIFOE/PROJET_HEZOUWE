<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    order: Object,
});

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status || 'unpaid',
});

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleString('fr-FR') : 'N/A';

const submit = () => {
    form.put(`/admin/orders/${props.order.id}`);
};

const statuses = [
    { value: 'pending', label: 'En attente', hint: 'Commande recue, pas encore traitee' },
    { value: 'confirmed', label: 'Confirmee', hint: 'Commande verifiee et acceptee' },
    { value: 'preparing', label: 'En preparation', hint: 'Articles en cours de preparation' },
    { value: 'shipped', label: 'En livraison', hint: 'Commande remise a la livraison' },
    { value: 'delivered', label: 'Livree', hint: 'Commande recue par le client' },
    { value: 'cancelled', label: 'Annulee', hint: 'Commande annulee' },
];

const paymentStatuses = [
    { value: 'unpaid', label: 'Non payee' },
    { value: 'paid', label: 'Payee' },
    { value: 'failed', label: 'Paiement echoue' },
    { value: 'refunded', label: 'Remboursee' },
];
</script>

<template>
    <Head :title="`Modifier ${order.order_number}`" />

    <AdminLayout :title="`Modifier ${order.order_number}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Modification</p>
                    <h1>Mettre a jour la commande</h1>
                    <p class="header-text">Changez le statut de traitement et le statut de paiement.</p>
                </div>
                <div class="header-actions">
                    <Link :href="`/admin/orders/${order.id}`" class="btn-secondary">
                        <i class="far fa-eye"></i>
                        Voir la commande
                    </Link>
                    <Link href="/admin/orders" class="btn-secondary">
                        <i class="far fa-arrow-left"></i>
                        Retour a la liste
                    </Link>
                </div>
            </div>

            <div class="edit-grid">
                <form @submit.prevent="submit" class="form-card">
                    <div class="form-card-header">
                        <h2>Statuts de la commande</h2>
                        <span>{{ order.order_number }}</span>
                    </div>

                    <div class="form-group">
                        <label for="status">Statut de traitement</label>
                        <select id="status" v-model="form.status" required>
                            <option v-for="status in statuses" :key="status.value" :value="status.value">
                                {{ status.label }}
                            </option>
                        </select>
                        <p class="field-help">
                            {{ statuses.find((status) => status.value === form.status)?.hint }}
                        </p>
                        <span v-if="form.errors.status" class="error">{{ form.errors.status }}</span>
                    </div>

                    <div class="form-group">
                        <label for="payment_status">Statut du paiement</label>
                        <select id="payment_status" v-model="form.payment_status">
                            <option v-for="status in paymentStatuses" :key="status.value" :value="status.value">
                                {{ status.label }}
                            </option>
                        </select>
                        <span v-if="form.errors.payment_status" class="error">{{ form.errors.payment_status }}</span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" :disabled="form.processing">
                            <i class="far fa-save"></i>
                            {{ form.processing ? 'Enregistrement en cours...' : 'Enregistrer les modifications' }}
                        </button>
                        <Link href="/admin/orders" class="btn-secondary">Annuler</Link>
                    </div>
                </form>

                <aside class="summary-card">
                    <h2>Resume commande</h2>
                    <div class="summary-list">
                        <div>
                            <span>Commande</span>
                            <strong>{{ order.order_number }}</strong>
                        </div>
                        <div>
                            <span>Client</span>
                            <strong>{{ order.customer_name || order.user?.name || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Telephone</span>
                            <strong>{{ order.customer_phone || 'N/A' }}</strong>
                        </div>
                        <div>
                            <span>Date</span>
                            <strong>{{ formatDate(order.created_at) }}</strong>
                        </div>
                        <div>
                            <span>Articles</span>
                            <strong>{{ order.items?.length || 0 }} article(s)</strong>
                        </div>
                        <div>
                            <span>Total</span>
                            <strong class="total">{{ formatPrice(order.total) }}</strong>
                        </div>
                    </div>
                </aside>
            </div>
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

.header-text {
    margin: 8px 0 0;
    color: #68746a;
}

.header-actions,
.form-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.edit-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 24px;
    align-items: start;
}

.form-card,
.summary-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.form-card {
    padding: 28px;
}

.summary-card {
    padding: 24px;
}

.form-card-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding-bottom: 20px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e5ece2;
}

.form-card h2,
.summary-card h2 {
    margin: 0;
    color: #17351a;
    font-size: 1.2rem;
    font-weight: 900;
}

.form-card-header span {
    color: #68746a;
    font-weight: 800;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 22px;
}

.form-group label {
    color: #17351a;
    font-weight: 850;
}

.form-group select {
    min-height: 46px;
    padding: 10px 14px;
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    background: #fff;
    color: #17351a;
    font-weight: 700;
}

.form-group select:focus {
    outline: none;
    border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

.field-help {
    margin: 0;
    color: #68746a;
    font-size: 0.9rem;
}

.error {
    color: #b42323;
    font-weight: 750;
    font-size: 0.86rem;
}

.summary-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-top: 20px;
}

.summary-list div {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #edf2ea;
}

.summary-list span {
    color: #68746a;
    font-weight: 700;
}

.summary-list strong {
    color: #17351a;
    text-align: right;
}

.summary-list .total {
    color: #24782b;
    font-size: 1.12rem;
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
    color: #17351a;
    border: 1.5px solid #dfe8db;
}

.btn-secondary:hover {
    border-color: #5cb85c;
    background: #fbfcfa;
}

@media (max-width: 1024px) {
    .edit-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
    }

    .form-card {
        padding: 20px;
    }
}
</style>
