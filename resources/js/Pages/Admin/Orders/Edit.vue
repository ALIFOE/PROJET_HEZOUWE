<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    order: Object,
});

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status || 'unpaid',
});

// Rejet modal
const showRejectModal = ref(false);
const rejectForm = useForm({ rejection_reason: '' });

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleString('fr-FR') : 'N/A';

const submit = () => {
    form.put(`/admin/orders/${props.order.id}`);
};

const verifyPayment = () => {
    router.post(`/admin/orders/${props.order.id}/verify-payment`);
};

const submitRejection = () => {
    rejectForm.post(`/admin/orders/${props.order.id}/reject-payment`, {
        onSuccess: () => {
            showRejectModal.value = false;
            rejectForm.reset();
        },
    });
};

const statuses = [
    { value: 'pending',   label: 'En attente',      hint: 'Commande reçue, pas encore traitée' },
    { value: 'confirmed', label: 'Confirmée',        hint: 'Commande vérifiée et acceptée' },
    { value: 'preparing', label: 'En préparation',   hint: 'Articles en cours de préparation' },
    { value: 'shipped',   label: 'En livraison',     hint: 'Commande remise à la livraison' },
    { value: 'delivered', label: 'Livrée',           hint: 'Commande reçue par le client' },
    { value: 'cancelled', label: 'Annulée',          hint: 'Commande annulée' },
];

const paymentStatuses = [
    { value: 'unpaid',   label: 'Non payée' },
    { value: 'paid',     label: '✅ Payée' },
    { value: 'rejected', label: '❌ Rejetée' },
    { value: 'failed',   label: 'Paiement échoué' },
    { value: 'refunded', label: 'Remboursée' },
];

const paymentMethodLabel = {
    cash_on_delivery:   '🏠 Paiement à la livraison',
    mobile_money:       '📱 Mobile Money',
    bank_transfer:      '🏦 Virement bancaire',
    kprimepay_checkout: '💳 Paiement en ligne',
};
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

                    <!-- Motif de rejet existant -->
                    <div v-if="order.rejection_reason" class="rejection-alert">
                        <div class="rejection-label">❌ Motif de rejet envoyé au client</div>
                        <div class="rejection-text">{{ order.rejection_reason }}</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" :disabled="form.processing">
                            <i class="far fa-save"></i>
                            {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                        </button>

                        <!-- Vérifier le paiement -->
                        <button
                            v-if="order.payment_status !== 'paid'"
                            type="button"
                            class="btn-verify"
                            @click="verifyPayment"
                        >
                            <i class="fas fa-check-circle"></i> Valider le paiement
                        </button>

                        <!-- Rejeter le paiement -->
                        <button
                            v-if="order.payment_status !== 'paid'"
                            type="button"
                            class="btn-reject"
                            @click="showRejectModal = true"
                        >
                            <i class="fas fa-times-circle"></i> Rejeter le paiement
                        </button>

                        <Link href="/admin/orders" class="btn-secondary">Annuler</Link>
                    </div>
                </form>

                <aside class="summary-card">
                    <h2>Résumé commande</h2>
                    <div class="summary-list">
                        <div><span>Commande</span><strong>{{ order.order_number }}</strong></div>
                        <div><span>Client</span><strong>{{ order.customer_name || order.user?.name || 'N/A' }}</strong></div>
                        <div><span>Email</span><strong>{{ order.customer_email || 'N/A' }}</strong></div>
                        <div><span>Téléphone</span><strong>{{ order.customer_phone || 'N/A' }}</strong></div>
                        <div><span>Mode paiement</span><strong>{{ paymentMethodLabel[order.payment_method] || order.payment_method }}</strong></div>
                        <div v-if="order.transaction_id">
                            <span>ID Transaction</span>
                            <strong class="txn-id">{{ order.transaction_id }}</strong>
                        </div>
                        <div><span>Date</span><strong>{{ formatDate(order.created_at) }}</strong></div>
                        <div><span>Articles</span><strong>{{ order.items?.length || 0 }} article(s)</strong></div>
                        <div><span>Total</span><strong class="total">{{ formatPrice(order.total) }}</strong></div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Modal rejet -->
        <Teleport to="body">
            <div v-if="showRejectModal" class="modal-overlay" @click.self="showRejectModal = false">
                <div class="modal-box">
                    <div class="modal-header">
                        <h3>❌ Rejeter le paiement</h3>
                        <button class="modal-close" @click="showRejectModal = false">✕</button>
                    </div>
                    <p class="modal-desc">
                        Le client recevra un email avec ce motif et les instructions pour régulariser.
                    </p>
                    <div class="modal-order-info">
                        <strong>{{ order.order_number }}</strong> — {{ order.customer_name }}<br>
                        <span v-if="order.transaction_id">ID Transaction : <code>{{ order.transaction_id }}</code></span>
                    </div>
                    <form @submit.prevent="submitRejection">
                        <div class="modal-field">
                            <label>Motif du rejet <span class="required">*</span></label>
                            <textarea
                                v-model="rejectForm.rejection_reason"
                                rows="4"
                                placeholder="Ex : L'identifiant de transaction TG240518XXXX ne correspond à aucun paiement reçu. Veuillez vérifier l'ID et le renvoyer, ou effectuer un nouveau paiement."
                                required
                                minlength="10"
                            ></textarea>
                            <span v-if="rejectForm.errors.rejection_reason" class="error">
                                {{ rejectForm.errors.rejection_reason }}
                            </span>
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn-reject-confirm" :disabled="rejectForm.processing">
                                <i class="fas fa-paper-plane"></i>
                                {{ rejectForm.processing ? 'Envoi...' : 'Rejeter et notifier le client' }}
                            </button>
                            <button type="button" class="btn-secondary" @click="showRejectModal = false">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
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

.btn-verify {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 850;
    border: none;
    cursor: pointer;
    background: #28a745;
    color: #fff;
    transition: background .2s;
}
.btn-verify:hover { background: #1e7e34; }

.btn-reject {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 850;
    border: none;
    cursor: pointer;
    background: #dc3545;
    color: #fff;
    transition: background .2s;
}
.btn-reject:hover { background: #b02a37; }

.txn-id {
    font-family: monospace;
    background: #f0f4f0;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.85rem;
}

.rejection-alert {
    background: #fff8f8;
    border: 1.5px solid #f5c6cb;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 18px;
}
.rejection-label {
    font-weight: 800;
    color: #721c24;
    font-size: 0.85rem;
    margin-bottom: 6px;
}
.rejection-text {
    color: #721c24;
    font-size: 0.92rem;
    line-height: 1.5;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}
.modal-box {
    background: #fff;
    border-radius: 12px;
    width: 100%;
    max-width: 520px;
    padding: 28px;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.modal-header h3 {
    margin: 0;
    color: #17351a;
    font-size: 1.15rem;
    font-weight: 900;
}
.modal-close {
    background: none;
    border: none;
    font-size: 1.1rem;
    cursor: pointer;
    color: #6c757d;
    padding: 4px 8px;
}
.modal-close:hover { color: #dc3545; }
.modal-desc {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0 0 14px;
}
.modal-order-info {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 0.88rem;
    color: #495057;
    margin-bottom: 18px;
}
.modal-order-info code {
    background: #e9ecef;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.82rem;
}
.modal-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 18px;
}
.modal-field label {
    font-weight: 800;
    color: #17351a;
    font-size: 0.92rem;
}
.required { color: #dc3545; }
.modal-field textarea {
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 0.92rem;
    resize: vertical;
    font-family: inherit;
    color: #17351a;
}
.modal-field textarea:focus {
    outline: none;
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220,53,69,.12);
}
.modal-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.btn-reject-confirm {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    background: #dc3545;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: 850;
    cursor: pointer;
    transition: background .2s;
}
.btn-reject-confirm:hover:not(:disabled) { background: #b02a37; }
.btn-reject-confirm:disabled { opacity: .6; cursor: not-allowed; }

@media (max-width: 1024px) {
    .edit-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .page-header { flex-direction: column; }
    .form-card { padding: 20px; }
}
</style>
