<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    payments: Object,
    totals: Object,
    filters: Object,
});

const form = reactive({
    payment_status: props.filters.payment_status || '',
    payment_method: props.filters.payment_method || '',
    search:         props.filters.search || '',
    date_from:      props.filters.date_from || '',
    date_to:        props.filters.date_to || '',
});

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleString('fr-FR') : 'N/A';

const paymentLabels = {
    unpaid:   'Non payée',
    paid:     'Payée',
    failed:   'Échec',
    refunded: 'Remboursée',
    rejected: 'Rejetée',
};

const methodLabels = {
    cash_on_delivery:   'Paiement à la livraison',
    mobile_money:       'Mobile Money',
    kprimepay_checkout: 'Paiement en ligne',
    bank_transfer:      'Virement bancaire',
};

const gatewayLabels = {
    'MIXX-YAS-TG':   'Mixx by YAS',
    'MOOV-MONEY-TG': 'Flooz',
};

const confirmedViaLabels = {
    kprimepay: 'KPRIMEPAY (auto)',
    manual:    'Validation admin',
};

const statusClass = (status) => ({
    paid:     'success',
    unpaid:   'warning',
    failed:   'danger',
    refunded: 'info',
    rejected: 'danger',
}[status] || 'warning');

const applyFilters = () => {
    router.get('/admin/payments', { ...form }, { preserveState: true, replace: true });
};

const resetFilters = () => {
    form.payment_status = '';
    form.payment_method = '';
    form.search = '';
    form.date_from = '';
    form.date_to = '';
    applyFilters();
};
</script>

<template>
    <Head title="Historique des paiements" />

    <AdminLayout title="Historique des paiements">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Historique des paiements</h1>
                    <p class="header-text">Toutes les commandes, avec méthode, référence et statut de paiement.</p>
                </div>
            </div>

            <div class="totals-row">
                <div class="total-card">
                    <span class="total-label">Paiements confirmés (sélection actuelle)</span>
                    <strong class="total-value">{{ totals.paid_count }}</strong>
                </div>
                <div class="total-card highlight">
                    <span class="total-label">Montant encaissé (sélection actuelle)</span>
                    <strong class="total-value">{{ formatPrice(totals.paid_amount) }}</strong>
                </div>
            </div>

            <div class="filters-card">
                <div class="filters-grid">
                    <div class="filter-field">
                        <label>Recherche</label>
                        <input
                            v-model="form.search"
                            type="text"
                            placeholder="Commande, transaction, client…"
                            @keyup.enter="applyFilters"
                        >
                    </div>
                    <div class="filter-field">
                        <label>Statut paiement</label>
                        <select v-model="form.payment_status" @change="applyFilters">
                            <option value="">Tous</option>
                            <option value="paid">Payée</option>
                            <option value="unpaid">Non payée</option>
                            <option value="failed">Échec</option>
                            <option value="refunded">Remboursée</option>
                            <option value="rejected">Rejetée</option>
                        </select>
                    </div>
                    <div class="filter-field">
                        <label>Méthode</label>
                        <select v-model="form.payment_method" @change="applyFilters">
                            <option value="">Toutes</option>
                            <option value="cash_on_delivery">Paiement à la livraison</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="kprimepay_checkout">Paiement en ligne</option>
                            <option value="bank_transfer">Virement bancaire</option>
                        </select>
                    </div>
                    <div class="filter-field">
                        <label>Du</label>
                        <input v-model="form.date_from" type="date" @change="applyFilters">
                    </div>
                    <div class="filter-field">
                        <label>Au</label>
                        <input v-model="form.date_to" type="date" @change="applyFilters">
                    </div>
                    <div class="filter-actions">
                        <button type="button" class="btn-filter" @click="applyFilters">
                            <i class="far fa-filter"></i> Filtrer
                        </button>
                        <button type="button" class="btn-reset" @click="resetFilters">
                            <i class="far fa-times"></i> Réinitialiser
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-toolbar">
                    <div>
                        <strong>{{ payments.total || payments.data.length }}</strong>
                        <span>résultat(s)</span>
                    </div>
                </div>

                <div class="table-scroll">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Méthode</th>
                                <th>Statut</th>
                                <th>Référence transaction</th>
                                <th>Confirmé via</th>
                                <th>Payée le</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in payments.data" :key="order.id">
                                <td>
                                    <strong class="order-number">{{ order.order_number }}</strong>
                                    <span class="muted">{{ formatDate(order.created_at) }}</span>
                                </td>
                                <td>
                                    <strong>{{ order.customer_name || order.user?.name || 'Client inconnu' }}</strong>
                                    <span class="muted">{{ order.customer_email || order.user?.email || '' }}</span>
                                </td>
                                <td class="total-cell">{{ formatPrice(order.total) }}</td>
                                <td>
                                    <span class="payment-pill">{{ methodLabels[order.payment_method] || order.payment_method || 'N/A' }}</span>
                                    <span v-if="order.payment_gateway" class="muted">{{ gatewayLabels[order.payment_gateway] || order.payment_gateway }}</span>
                                </td>
                                <td>
                                    <span :class="['status-pill', statusClass(order.payment_status)]">
                                        {{ paymentLabels[order.payment_status] || order.payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="txn-id">{{ order.transaction_id || '—' }}</span>
                                    <span v-if="order.payment_reference" class="muted">Réf. opérateur : {{ order.payment_reference }}</span>
                                </td>
                                <td>{{ confirmedViaLabels[order.payment_confirmed_via] || (order.payment_confirmed_via || '—') }}</td>
                                <td>{{ formatDate(order.paid_at) }}</td>
                                <td>
                                    <Link :href="`/admin/orders/${order.id}`" class="btn-action btn-view">
                                        <i class="far fa-eye"></i>
                                        Voir
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="payments.data.length === 0" class="empty-state">
                    <i class="far fa-receipt"></i>
                    <h3>Aucun paiement trouvé</h3>
                    <p>Essayez d'élargir vos filtres.</p>
                </div>
            </div>

            <div v-if="payments.links && payments.links.length > 3" class="pagination">
                <template v-for="(link, index) in payments.links" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="page-link"
                        :class="{ active: link.active }"
                        v-html="link.label"
                    />
                    <span v-else class="page-link disabled" v-html="link.label" />
                </template>
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

.totals-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}

.total-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    padding: 18px 20px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.total-card.highlight {
    background: #f0faf0;
    border-color: #cdeccd;
}

.total-label {
    display: block;
    color: #68746a;
    font-size: 0.82rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.total-value {
    color: #17351a;
    font-size: 1.6rem;
    font-weight: 900;
}

.filters-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    padding: 18px 20px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    align-items: end;
}

.filter-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-field label {
    color: #68746a;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
}

.filter-field input,
.filter-field select {
    padding: 9px 12px;
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #17351a;
    background: #fff;
}

.filter-actions {
    display: flex;
    gap: 8px;
}

.btn-filter,
.btn-reset {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 9px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 800;
    font-size: 0.84rem;
}

.btn-filter {
    background: #2d6a4f;
    color: #fff;
}

.btn-reset {
    background: #f0f3ee;
    color: #4d5a50;
}

.table-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
    overflow: hidden;
}

.table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 18px 20px;
    border-bottom: 1px solid #e5ece2;
    background: #fbfcfa;
}

.table-toolbar strong {
    color: #17351a;
    font-size: 1.15rem;
}

.table-toolbar span {
    color: #68746a;
    font-weight: 600;
}

.table-scroll {
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    min-width: 1180px;
    border-collapse: collapse;
}

.orders-table th {
    text-align: left;
    padding: 14px 16px;
    color: #68746a;
    font-size: 0.78rem;
    font-weight: 900;
    text-transform: uppercase;
    border-bottom: 1px solid #e5ece2;
    background: #f8faf7;
}

.orders-table td {
    padding: 16px;
    color: #17351a;
    border-bottom: 1px solid #edf2ea;
    vertical-align: middle;
}

.orders-table tr:hover td {
    background: #fbfcfa;
}

.order-number,
.orders-table td strong {
    display: block;
    color: #17351a;
    font-weight: 850;
}

.muted {
    display: block;
    margin-top: 4px;
    color: #7a857c;
    font-size: 0.83rem;
}

.total-cell {
    font-weight: 900;
    white-space: nowrap;
}

.txn-id {
    font-family: monospace;
    font-size: 0.85rem;
    color: #4d5a50;
}

.status-pill,
.payment-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 900;
    white-space: nowrap;
}

.status-pill.success {
    background: #e7f7e7;
    color: #24782b;
}

.status-pill.warning {
    background: #fff5d9;
    color: #9a6b12;
}

.status-pill.info {
    background: #e8f1ff;
    color: #245ea8;
}

.status-pill.danger {
    background: #ffe8e8;
    color: #b42323;
}

.payment-pill {
    background: #f0f3ee;
    color: #4d5a50;
}

.actions-col {
    width: 90px;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 36px;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid transparent;
    cursor: pointer;
    font-weight: 800;
    font-size: 0.84rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view {
    background: #e8f4ff;
    color: #245ea8;
}

.btn-action:hover {
    transform: translateY(-1px);
}

.empty-state {
    padding: 64px 24px;
    text-align: center;
    color: #68746a;
}

.empty-state i {
    font-size: 2.8rem;
    color: #cdd6c9;
    margin-bottom: 16px;
}

.empty-state h3 {
    margin: 0 0 8px;
    color: #17351a;
}

.pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
}

.page-link {
    padding: 8px 14px;
    border: 1px solid #e5ece2;
    border-radius: 6px;
    background: #fff;
    color: #17351a;
    text-decoration: none;
    font-weight: 800;
}

.page-link.active {
    background: #5cb85c;
    color: #fff;
    border-color: #5cb85c;
}

.page-link.disabled {
    color: #a5aea2;
}

@media (max-width: 768px) {
    .table-toolbar,
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
