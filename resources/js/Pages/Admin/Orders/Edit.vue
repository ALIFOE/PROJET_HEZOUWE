<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    order: Object,
});

const form = useForm({
    status: props.order.status,
});

const submit = () => {
    form.put(`/admin/orders/${props.order.id}`);
};

const statusLabels = {
    pending: 'En attente',
    confirmed: 'Confirmée',
    preparing: 'En préparation',
    shipped: 'En livraison',
    delivered: 'Livrée',
    cancelled: 'Annulée',
};
</script>

<template>
    <Head :title="`Modifier Commande ${order.order_number}`" />

    <AdminLayout :title="`Modifier Commande ${order.order_number}`">
        <div class="admin-page">
            <div class="page-header">
                <h1>Modifier le Statut</h1>
                <Link href="/admin/orders" class="btn-secondary">
                    <i class="far fa-arrow-left"></i>
                    Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="form-container">
                <div class="form-section">
                    <h2>Statut de la commande</h2>
                    <div class="form-group">
                        <label>Statut actuel</label>
                        <select v-model="form.status" required>
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmée</option>
                            <option value="preparing">En préparation</option>
                            <option value="shipped">En livraison</option>
                            <option value="delivered">Livrée</option>
                            <option value="cancelled">Annulée</option>
                        </select>
                        <span v-if="form.errors.status" class="error">{{ form.errors.status }}</span>
                    </div>

                    <div class="order-info">
                        <div class="info-row">
                            <span>Commande #</span>
                            <strong>{{ order.order_number }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Client</span>
                            <strong>{{ order.user?.name || 'N/A' }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Total</span>
                            <strong>{{ order.total?.toLocaleString('fr-FR') }} FCFA</strong>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                    </button>
                    <Link href="/admin/orders" class="btn-secondary">Annuler</Link>
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
    max-width: 600px;
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

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 24px;
}

.form-group label {
    color: #1a3a1a;
    font-weight: 700;
    font-size: 0.9rem;
}

.form-group select {
    padding: 12px 16px;
    border: 1.5px solid #e8eee3;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
    background: #fff;
}

.form-group select:focus {
    outline: none;
    border-color: #5cb85c;
}

.error {
    color: #dc2626;
    font-size: 0.85rem;
    font-weight: 600;
}

.order-info {
    background: #f9faf9;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.info-row span {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

.info-row strong {
    color: #1a3a1a;
    font-weight: 700;
}

.form-actions {
    display: flex;
    gap: 12px;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-container {
        padding: 20px;
        max-width: 100%;
    }
}
</style>
