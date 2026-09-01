<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    order: Object,
    kprimepay: { type: Object, default: null },
});

const verifying = ref(false);
const checkingKprime = ref(false);
const showRejectModal = ref(false);

const rejectForm = useForm({ rejection_reason: '' });

const formatPrice = (value) => `${Number(value || 0).toLocaleString('fr-FR')} FCFA`;
const formatDate = (value) => value ? new Date(value).toLocaleString('fr-FR') : 'N/A';

const statusLabels = {
    pending:   'En attente',
    confirmed: 'Confirmée',
    preparing: 'En préparation',
    shipped:   'En livraison',
    delivered: 'Livrée',
    cancelled: 'Annulée',
};

const paymentLabels = {
    unpaid:   'Non payée',
    paid:     'Payée',
    failed:   'Échec',
    refunded: 'Remboursée',
    rejected: 'Rejetée',
};

const paymentMethodLabels = {
    cash_on_delivery: 'Paiement à la livraison',
    bank_transfer:    'Virement bancaire',
    mobile_money:     'Mobile Money',
};

const statusClass = (status) => ({
    pending:   'warning',
    confirmed: 'info',
    preparing: 'info',
    shipped:   'active',
    delivered: 'success',
    cancelled: 'danger',
}[status] || 'warning');

const isCOD = computed(() => props.order.payment_method === 'cash_on_delivery');
const upfrontAmount  = computed(() => Math.ceil((props.order.total || 0) / 2));
const remainingAmount = computed(() => Math.floor((props.order.total || 0) / 2));

// --- KPRIMEPAY -------------------------------------------------------------
const gatewayLabels = {
    'MIXX-YAS-TG':   'Mixx by YAS (Togocom)',
    'MOOV-MONEY-TG': 'Flooz (Moov Africa)',
};

const isMobileMoney = computed(() => props.order.payment_method === 'mobile_money');

// Vrai uniquement si c'est KPRIMEPAY qui a confirmé le débit, pas un admin.
const confirmedByKprimepay = computed(
    () => props.order.payment_status === 'paid' && props.order.payment_confirmed_via === 'kprimepay'
);

const kprimeStatusLabel = computed(() => ({
    paid:        'Paiement confirmé par KPRIMEPAY',
    pending:     'Transaction en attente — le client n\'a pas encore validé sur son téléphone',
    failed:      'Transaction échouée — aucun montant débité',
    unavailable: 'KPRIMEPAY injoignable — statut inconnu pour le moment',
    skipped:     'Aucune transaction KPRIMEPAY lancée',
}[props.kprimepay?.status] || null));

const kprimeStatusTone = computed(() => ({
    paid:        'success',
    pending:     'warning',
    failed:      'danger',
    unavailable: 'warning',
    skipped:     'warning',
}[props.kprimepay?.status] || 'warning'));

const checkKprimepay = () => {
    checkingKprime.value = true;
    router.post(`/admin/orders/${props.order.id}/check-kprimepay`, {}, {
        preserveScroll: true,
        onFinish: () => { checkingKprime.value = false; },
    });
};

const verifyPayment = () => {
    if (!confirm('Confirmer la vérification du paiement ? Le client sera notifié par email.')) return;
    verifying.value = true;
    router.post(`/admin/orders/${props.order.id}/verify-payment`, {}, {
        onFinish: () => { verifying.value = false; },
    });
};

const submitRejection = () => {
    rejectForm.post(`/admin/orders/${props.order.id}/reject-payment`, {
        onSuccess: () => { showRejectModal.value = false; rejectForm.reset(); },
    });
};

const deleteOrder = () => {
    if (!confirm(`Supprimer définitivement la commande ${props.order.order_number} ?`)) return;
    router.delete(`/admin/orders/${props.order.id}`);
};

// Bon de livraison QR
const generatingToken = ref(false);
const deliveryUrl = ref('');
const copiedUrl = ref(false);

const generateDeliveryToken = async () => {
    generatingToken.value = true;
    try {
        const resp = await axios.post(`/admin/orders/${props.order.id}/generate-delivery-token`);
        deliveryUrl.value = resp.data.url;
    } catch {
        alert('Erreur lors de la génération du lien. Réessayez.');
    } finally {
        generatingToken.value = false;
    }
};

const copyDeliveryUrl = async () => {
    if (!deliveryUrl.value) return;
    await navigator.clipboard.writeText(deliveryUrl.value);
    copiedUrl.value = true;
    setTimeout(() => { copiedUrl.value = false; }, 2500);
};
</script>

<template>
    <Head :title="`Commande ${order.order_number}`" />

    <AdminLayout :title="`Commande ${order.order_number}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Détail commande</p>
                    <h1>{{ order.order_number }}</h1>
                    <p class="header-text">Consultez les informations client, livraison, paiement et articles commandés.</p>
                </div>
                <div class="header-actions">
                    <Link :href="`/admin/orders/${order.id}/edit`" class="btn-secondary">
                        <i class="far fa-edit"></i> Modifier
                    </Link>
                    <Link href="/admin/orders" class="btn-secondary">
                        <i class="far fa-arrow-left"></i> Retour
                    </Link>
                    <button type="button" class="btn-danger" @click="deleteOrder">
                        <i class="far fa-trash-alt"></i> Supprimer
                    </button>
                </div>
            </div>

            <!-- Flash -->
            <div v-if="$page.props.flash?.success" class="flash-success">
                <i class="far fa-check-circle"></i> {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash?.error" class="flash-error">
                <i class="far fa-exclamation-circle"></i> {{ $page.props.flash.error }}
            </div>

            <div class="summary-strip">
                <div>
                    <span>Statut</span>
                    <strong :class="['status-pill', statusClass(order.status)]">
                        {{ statusLabels[order.status] || order.status }}
                    </strong>
                </div>
                <div>
                    <span>Paiement</span>
                    <strong :class="['status-pill', order.payment_status === 'paid' ? 'success' : order.payment_status === 'rejected' ? 'danger' : 'warning']">
                        {{ paymentLabels[order.payment_status] || order.payment_status || 'N/A' }}
                    </strong>
                </div>
                <div>
                    <span>Total</span>
                    <strong class="money">{{ formatPrice(order.total) }}</strong>
                </div>
                <div>
                    <span>Date</span>
                    <strong>{{ formatDate(order.created_at) }}</strong>
                </div>
            </div>

            <div class="details-grid">
                <section class="detail-card">
                    <h2>Informations client</h2>
                    <div class="info-list">
                        <div><span>Nom</span><strong>{{ order.customer_name || order.user?.name || 'N/A' }}</strong></div>
                        <div><span>Email</span><strong>{{ order.customer_email || order.user?.email || 'N/A' }}</strong></div>
                        <div><span>Téléphone</span><strong>{{ order.customer_phone || 'N/A' }}</strong></div>
                    </div>
                </section>

                <section class="detail-card">
                    <h2>Livraison</h2>
                    <div class="info-list">
                        <div><span>Ville</span><strong>{{ order.city || 'N/A' }}</strong></div>
                        <div><span>Adresse</span><strong>{{ order.address || 'N/A' }}</strong></div>
                        <div><span>Notes</span><strong>{{ order.notes || 'Aucune note' }}</strong></div>
                    </div>
                </section>
            </div>

            <!-- Payment Panel -->
            <section class="detail-card pay-verify-card"
                :class="order.payment_status === 'paid' ? 'pay-verified' : order.payment_status === 'rejected' ? 'pay-rejected' : 'pay-pending'">
                <div class="card-header">
                    <h2>
                        <i class="far" :class="order.payment_status === 'paid' ? 'fa-check-circle' : order.payment_status === 'rejected' ? 'fa-times-circle' : 'fa-credit-card'"></i>
                        Paiement
                    </h2>
                    <span :class="['status-pill', order.payment_status === 'paid' ? 'success' : order.payment_status === 'rejected' ? 'danger' : 'warning']">
                        {{ paymentLabels[order.payment_status] || order.payment_status }}
                    </span>
                </div>

                <!-- Rejection reason display -->
                <div v-if="order.rejection_reason" class="rejection-box">
                    <div class="rejection-label"><i class="far fa-exclamation-triangle"></i> Motif de rejet</div>
                    <div class="rejection-text">{{ order.rejection_reason }}</div>
                </div>

                <div class="pay-grid">
                    <div class="pay-row">
                        <span>Mode de paiement</span>
                        <strong>{{ paymentMethodLabels[order.payment_method] || order.payment_method || 'N/A' }}</strong>
                    </div>
                    <template v-if="isCOD">
                        <div class="pay-row highlight">
                            <span>Acompte versé (50%)</span>
                            <strong class="money">{{ formatPrice(upfrontAmount) }}</strong>
                        </div>
                        <div class="pay-row">
                            <span>Reste à la livraison (50%)</span>
                            <strong>{{ formatPrice(remainingAmount) }}</strong>
                        </div>
                        <div class="pay-row" :class="order.transaction_id ? 'highlight-id' : 'missing-id'">
                            <span>ID de transaction déclaré</span>
                            <strong class="txn-id">{{ order.transaction_id || 'Non renseigné' }}</strong>
                        </div>
                    </template>
                    <template v-else-if="order.payment_method === 'bank_transfer'">
                        <div class="pay-row">
                            <span>Total à virer</span>
                            <strong class="money">{{ formatPrice(order.total) }}</strong>
                        </div>
                        <div class="pay-row" :class="order.transaction_id ? 'highlight-id' : 'missing-id'">
                            <span>Référence virement</span>
                            <strong class="txn-id">{{ order.transaction_id || 'En attente de virement' }}</strong>
                        </div>
                    </template>
                    <template v-else-if="isMobileMoney">
                        <div class="pay-row">
                            <span>Montant débité</span>
                            <strong class="money">{{ formatPrice(order.total) }}</strong>
                        </div>
                        <div class="pay-row" :class="order.transaction_id ? 'highlight-id' : 'missing-id'">
                            <span>ID transaction KPRIMEPAY</span>
                            <strong class="txn-id">{{ order.transaction_id || 'Aucun paiement lancé' }}</strong>
                        </div>
                        <div class="pay-row" v-if="order.payment_gateway">
                            <span>Opérateur</span>
                            <strong>{{ gatewayLabels[order.payment_gateway] || order.payment_gateway }}</strong>
                        </div>
                        <div class="pay-row" v-if="order.payment_phone">
                            <span>Numéro Mobile Money</span>
                            <strong>{{ order.payment_phone }}</strong>
                        </div>
                        <div class="pay-row" v-if="order.paid_at">
                            <span>Payée le</span>
                            <strong>{{ formatDate(order.paid_at) }}</strong>
                        </div>
                    </template>
                </div>

                <!-- Etat KPRIMEPAY : source de verite du paiement Mobile Money -->
                <div v-if="isMobileMoney" class="kprime-box" :class="`kprime-${kprimeStatusTone}`">
                    <div class="kprime-head">
                        <span class="kprime-title">
                            <i class="fas fa-bolt"></i>
                            Statut KPRIMEPAY
                        </span>
                        <span :class="['status-pill', kprimeStatusTone]">
                            {{ confirmedByKprimepay ? 'Payé' : (kprimepay?.status === 'paid' ? 'Payé' : kprimepay?.status === 'failed' ? 'Échec' : kprimepay?.status === 'unavailable' ? 'Indisponible' : 'En attente') }}
                        </span>
                    </div>

                    <p v-if="confirmedByKprimepay" class="kprime-text kprime-confirmed">
                        <i class="far fa-check-circle"></i>
                        Le paiement a bien été encaissé sur KPRIMEPAY. La commande a été confirmée
                        automatiquement<template v-if="order.paid_at"> le {{ formatDate(order.paid_at) }}</template> —
                        aucune validation manuelle n'est nécessaire.
                    </p>
                    <p v-else-if="order.payment_status === 'paid'" class="kprime-text">
                        <i class="far fa-user-check"></i>
                        Paiement validé manuellement par un administrateur<template v-if="order.paid_at"> le {{ formatDate(order.paid_at) }}</template>,
                        et non par une confirmation KPRIMEPAY.
                    </p>
                    <p v-else-if="kprimeStatusLabel" class="kprime-text">
                        <i class="far fa-info-circle"></i>
                        {{ kprimeStatusLabel }}<template v-if="kprimepay?.raw"> (réponse KPRIMEPAY : « {{ kprimepay.raw }} »)</template><template v-else-if="kprimepay?.message"> — {{ kprimepay.message }}</template>.
                    </p>
                    <p v-else class="kprime-text">
                        <i class="far fa-info-circle"></i>
                        Le client n'a pas encore lancé de paiement Mobile Money pour cette commande.
                    </p>

                    <button
                        v-if="order.payment_status !== 'paid' && order.transaction_id"
                        type="button"
                        class="btn-kprime-check"
                        :disabled="checkingKprime"
                        @click="checkKprimepay"
                    >
                        <i class="far" :class="checkingKprime ? 'fa-spinner fa-spin' : 'fa-sync'"></i>
                        {{ checkingKprime ? 'Vérification…' : 'Revérifier auprès de KPRIMEPAY' }}
                    </button>
                </div>

                <!-- Preuve de paiement -->
                <div v-if="order.payment_proof" class="proof-admin-box">
                    <div class="proof-admin-label">
                        <i class="fas fa-file-image"></i> Preuve de paiement fournie par le client
                    </div>
                    <div class="proof-admin-content">
                        <template v-if="order.payment_proof.match(/\.(jpg|jpeg|png|gif|webp)$/i)">
                            <a :href="`/storage/${order.payment_proof}`" target="_blank">
                                <img :src="`/storage/${order.payment_proof}`" class="proof-admin-img" alt="Preuve">
                            </a>
                            <span class="proof-admin-hint">Cliquez sur l'image pour l'agrandir</span>
                        </template>
                        <template v-else>
                            <a :href="`/storage/${order.payment_proof}`" target="_blank" class="proof-admin-pdf">
                                <i class="fas fa-file-pdf fa-2x"></i>
                                <span>Ouvrir le document PDF</span>
                            </a>
                        </template>
                        <a :href="`/storage/${order.payment_proof}`" download class="proof-admin-download">
                            <i class="fas fa-download"></i>
                            <span>Télécharger la preuve</span>
                        </a>
                    </div>
                </div>
                <div v-else-if="order.payment_method !== 'mobile_money'" class="proof-admin-missing">
                    <i class="fas fa-exclamation-triangle"></i>
                    Aucune preuve de paiement jointe par le client
                </div>

                <!-- Actions -->
                <div v-if="order.payment_status === 'paid'" class="verified-badge">
                    <i class="far fa-check-circle"></i>
                    <template v-if="confirmedByKprimepay">
                        Paiement encaissé et confirmé automatiquement par KPRIMEPAY — le client a été notifié.
                    </template>
                    <template v-else>
                        Paiement confirmé — le client a été notifié par email.
                    </template>
                </div>
                <div v-else class="verify-action">
                    <div v-if="isCOD" class="verify-hint">
                        <i class="far fa-info-circle"></i>
                        Vérifiez que l'ID <strong>{{ order.transaction_id }}</strong> correspond à un paiement de <strong>{{ formatPrice(upfrontAmount) }}</strong> via Mixx by YAS ou Flooz.
                    </div>
                    <div v-else-if="order.payment_method === 'bank_transfer'" class="verify-hint">
                        <i class="far fa-info-circle"></i>
                        Vérifiez que le virement de <strong>{{ formatPrice(order.total) }}</strong> a bien été reçu sur le compte bancaire HEZOUWE avant de valider.
                    </div>
                    <div v-else-if="isMobileMoney" class="verify-hint warn">
                        <i class="far fa-exclamation-triangle"></i>
                        KPRIMEPAY n'a pas confirmé cette transaction. Utilisez d'abord
                        <strong>« Revérifier auprès de KPRIMEPAY »</strong> ci-dessus : ne validez manuellement
                        que si vous avez la preuve que le montant a bien été encaissé.
                    </div>
                    <div class="action-buttons">
                        <button class="btn-verify" :disabled="verifying" @click="verifyPayment">
                            <i class="far" :class="verifying ? 'fa-spinner fa-spin' : 'fa-check-double'"></i>
                            {{ verifying ? 'Validation...' : 'Valider le paiement' }}
                        </button>
                        <button
                            v-if="order.payment_status !== 'rejected'"
                            class="btn-reject"
                            @click="showRejectModal = true"
                        >
                            <i class="far fa-times-circle"></i>
                            Rejeter le paiement
                        </button>
                        <span v-else class="rejected-pending-hint">
                            <i class="far fa-clock"></i>
                            En attente de correction par le client
                        </span>
                    </div>
                </div>
            </section>

            <!-- Items -->
            <section class="detail-card">
                <div class="card-header">
                    <h2>Articles commandés</h2>
                    <span>{{ order.items?.length || 0 }} article(s)</span>
                </div>
                <div class="items-list">
                    <article v-for="item in order.items" :key="item.id || item.product_slug" class="order-item">
                        <img :src="item.product_image || '/assets/img/riz2.jpeg'" :alt="item.product_title">
                        <div class="item-main">
                            <strong>{{ item.product_title }}</strong>
                            <span>{{ item.product_slug }}</span>
                        </div>
                        <div class="item-stat"><span>Quantité</span><strong>{{ item.quantity }}</strong></div>
                        <div class="item-stat"><span>Prix unitaire</span><strong>{{ formatPrice(item.unit_price) }}</strong></div>
                        <div class="item-stat total"><span>Total ligne</span><strong>{{ formatPrice(item.line_total) }}</strong></div>
                    </article>
                </div>
                <div class="totals-box">
                    <div><span>Sous-total</span><strong>{{ formatPrice(order.subtotal) }}</strong></div>
                    <div><span>Livraison</span><strong>{{ order.delivery_cost == 0 ? 'Gratuite' : formatPrice(order.delivery_cost) }}</strong></div>
                    <div><span>Remise{{ order.coupon_code ? ` (${order.coupon_code})` : '' }}</span><strong>{{ formatPrice(order.discount) }}</strong></div>
                    <div class="grand-total"><span>Total commande</span><strong>{{ formatPrice(order.total) }}</strong></div>
                </div>
            </section>
        </div>

            <!-- Bon de livraison QR -->
            <section class="detail-card delivery-card">
                <div class="card-header">
                    <h2><i class="far fa-qrcode"></i> Bon de livraison (Code QR)</h2>
                    <span :class="['status-pill', order.delivery_verified_at ? 'success' : 'warning']">
                        {{ order.delivery_verified_at ? 'Livraison confirmée' : 'En attente' }}
                    </span>
                </div>

                <div v-if="order.delivery_verified_at" class="verified-badge">
                    <i class="far fa-check-circle"></i>
                    Livraison confirmée par le client le {{ formatDate(order.delivery_verified_at) }}
                </div>

                <div v-else class="delivery-generate">
                    <p class="delivery-hint">
                        <i class="far fa-info-circle"></i>
                        Générez un lien unique à envoyer au livreur. Ce lien affiche le code QR à présenter au client pour valider la réception. Utilisation unique.
                    </p>

                    <div v-if="deliveryUrl" class="delivery-url-box">
                        <label>Lien livreur (à partager)</label>
                        <div class="url-row">
                            <input type="text" :value="deliveryUrl" readonly class="url-input">
                            <button class="btn-copy" @click="copyDeliveryUrl">
                                <i class="far" :class="copiedUrl ? 'fa-check' : 'fa-copy'"></i>
                                {{ copiedUrl ? 'Copié !' : 'Copier' }}
                            </button>
                        </div>
                        <a :href="deliveryUrl" target="_blank" class="url-preview-link">
                            <i class="far fa-external-link"></i> Aperçu du lien livreur
                        </a>
                        <p class="regen-hint">Générer à nouveau invalidera l'ancien lien.</p>
                    </div>

                    <button class="btn-generate" :disabled="generatingToken" @click="generateDeliveryToken">
                        <i class="far" :class="generatingToken ? 'fa-spinner fa-spin' : 'fa-qrcode'"></i>
                        {{ deliveryUrl ? 'Regénérer le lien' : 'Générer le lien livreur' }}
                    </button>
                </div>
            </section>

        <!-- Reject Modal -->
        <Teleport to="body">
            <div v-if="showRejectModal" class="modal-backdrop" @click.self="showRejectModal = false">
                <div class="modal-box">
                    <div class="modal-header">
                        <h3><i class="far fa-times-circle"></i> Rejeter le paiement</h3>
                        <button class="modal-close" @click="showRejectModal = false">×</button>
                    </div>
                    <div class="modal-body">
                        <p>Le client recevra un email avec ce motif et pourra resoumettre son ID de transaction depuis son dashboard.</p>
                        <label>Motif du rejet <span class="required">*</span></label>
                        <textarea
                            v-model="rejectForm.rejection_reason"
                            rows="4"
                            placeholder="Ex : L'ID de transaction TG240518XXXX ne correspond à aucun paiement enregistré. Veuillez vérifier l'identifiant et resoumettre."
                            :class="{ 'has-error': rejectForm.errors.rejection_reason }"
                        ></textarea>
                        <p v-if="rejectForm.errors.rejection_reason" class="field-error">{{ rejectForm.errors.rejection_reason }}</p>
                        <p class="char-hint">{{ rejectForm.rejection_reason.length }}/500 caractères (minimum 10)</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-cancel" @click="showRejectModal = false">Annuler</button>
                        <button
                            class="btn-reject-confirm"
                            :disabled="rejectForm.processing || rejectForm.rejection_reason.length < 10"
                            @click="submitRejection"
                        >
                            <i class="far" :class="rejectForm.processing ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                            {{ rejectForm.processing ? 'Envoi...' : 'Envoyer le rejet' }}
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display:flex; flex-direction:column; gap:24px; }

.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:20px; }
.eyebrow { margin:0 0 6px; color:#5cb85c; font-weight:800; text-transform:uppercase; font-size:0.78rem; }
.page-header h1 { margin:0; color:#17351a; font-size:1.85rem; font-weight:900; }
.header-text { margin:8px 0 0; color:#68746a; }
.header-actions { display:flex; flex-wrap:wrap; gap:10px; }

.flash-success, .flash-error {
    display:flex; align-items:center; gap:10px;
    padding:14px 20px; border-radius:8px; font-weight:700;
}
.flash-success { background:#e7f7e7; color:#24782b; border:1px solid #a8d8a8; }
.flash-error   { background:#ffe8e8; color:#b42323; border:1px solid #f5a0a0; }

.btn-primary, .btn-secondary, .btn-danger {
    display:inline-flex; align-items:center; justify-content:center;
    gap:8px; min-height:42px; padding:10px 16px; border-radius:6px;
    text-decoration:none; font-weight:850; border:1.5px solid transparent; cursor:pointer;
}
.btn-primary   { background:#5cb85c; color:#fff; }
.btn-secondary { background:#fff; color:#17351a; border-color:#dfe8db; }
.btn-danger    { background:#fff; color:#b42323; border-color:#ffd4d4; }

.summary-strip {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:1px; overflow:hidden; border:1px solid #e5ece2; border-radius:8px; background:#e5ece2;
}
.summary-strip > div { background:#fff; padding:18px; display:flex; flex-direction:column; gap:8px; }
.summary-strip span, .info-list span, .item-stat span, .totals-box span {
    color:#68746a; font-size:0.84rem; font-weight:750;
}
.summary-strip strong, .info-list strong, .item-stat strong { color:#17351a; }
.money { color:#24782b !important; font-size:1.12rem; }

.details-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:24px; }

.detail-card {
    background:#fff; border:1px solid #e5ece2; border-radius:8px;
    padding:24px; box-shadow:0 16px 42px rgba(23,53,26,.06);
}
.detail-card h2, .card-header h2 { margin:0; color:#17351a; font-size:1.18rem; font-weight:900; }
.card-header { display:flex; justify-content:space-between; gap:16px; margin-bottom:18px; }
.card-header > span { color:#68746a; font-weight:800; }
.info-list { display:grid; gap:14px; margin-top:18px; }
.info-list div { display:grid; gap:4px; }

.status-pill {
    width:fit-content; display:inline-flex; align-items:center;
    padding:6px 10px; border-radius:999px; font-size:0.78rem; font-weight:900;
}
.status-pill.success { background:#e7f7e7; color:#24782b; }
.status-pill.warning { background:#fff5d9; color:#9a6b12; }
.status-pill.info, .status-pill.active { background:#e8f1ff; color:#245ea8; }
.status-pill.danger { background:#ffe8e8; color:#b42323; }

/* Payment card variants */
.pay-verify-card.pay-pending  { border-color:#f0c060; background:#fffdf5; }
.pay-verify-card.pay-verified { border-color:#a8d8a8; background:#f5fdf5; }
.pay-verify-card.pay-rejected { border-color:#f5a0a0; background:#fff8f8; }
.pay-verify-card .card-header { margin-bottom:18px; }
.pay-verify-card h2 { display:flex; align-items:center; gap:8px; }

.rejection-box {
    background:#fff0f0; border:1.5px solid #f5c6cb; border-radius:8px;
    padding:14px 18px; margin-bottom:16px;
}
.rejection-label { font-weight:800; color:#721c24; font-size:0.85rem; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; display:flex; align-items:center; gap:6px; }
.rejection-text  { color:#721c24; font-size:0.95rem; line-height:1.5; }

.pay-grid { display:grid; gap:10px; margin-bottom:20px; }
.pay-row {
    display:flex; justify-content:space-between; align-items:center;
    gap:20px; padding:10px 14px; border-radius:6px; background:#fff; border:1px solid #e5ece2;
}
.pay-row span  { color:#68746a; font-size:0.88rem; font-weight:700; }
.pay-row strong { color:#17351a; }
.pay-row.highlight    { background:#fff8e6; border-color:#f0c060; }
.pay-row.highlight-id { background:#e8f4ff; border-color:#7ab5e8; }
.pay-row.missing-id   { background:#fff0f0; border-color:#f5a0a0; }
.txn-id { font-family:monospace; font-size:1rem; letter-spacing:0.5px; color:#1a4da8 !important; }

.verify-hint {
    display:flex; align-items:flex-start; gap:8px;
    padding:12px 16px; background:#fff8e1; border:1px solid #f0c060; border-radius:6px;
    color:#7a5700; font-size:0.9rem; margin-bottom:14px; line-height:1.5;
}
.verify-hint i { margin-top:2px; flex-shrink:0; color:#c08000; }
.verify-hint.warn { background:#fff0f0; border-color:#f0a0a0; color:#8a2020; }
.verify-hint.warn i { color:#c04040; }

/* Bloc statut KPRIMEPAY */
.kprime-box {
    border:1.5px solid #dfe7db; border-radius:8px;
    padding:16px 18px; margin:16px 0; background:#fff;
}
.kprime-box.kprime-success { border-color:#a8d8a8; background:#f4fcf4; }
.kprime-box.kprime-warning { border-color:#f0c060; background:#fffcf2; }
.kprime-box.kprime-danger  { border-color:#f0a0a0; background:#fff7f7; }

.kprime-head {
    display:flex; align-items:center; justify-content:space-between;
    gap:12px; flex-wrap:wrap; margin-bottom:10px;
}
.kprime-title {
    display:inline-flex; align-items:center; gap:8px;
    font-weight:900; color:#17351a; font-size:0.95rem;
}
.kprime-title i { color:#c08000; }

.kprime-text {
    display:flex; align-items:flex-start; gap:8px;
    margin:0; color:#4a5a4c; font-size:0.92rem; line-height:1.55;
}
.kprime-text i { margin-top:3px; flex-shrink:0; }
.kprime-text.kprime-confirmed { color:#1b5e20; font-weight:650; }
.kprime-text.kprime-confirmed i { color:#24782b; }

.btn-kprime-check {
    display:inline-flex; align-items:center; gap:8px; margin-top:14px;
    padding:10px 18px; background:#fff; color:#245ea8;
    border:1.5px solid #b8d0f0; border-radius:8px;
    font-weight:850; font-size:0.9rem; cursor:pointer; transition:all .18s;
}
.btn-kprime-check:hover:not(:disabled) { background:#e8f1ff; border-color:#245ea8; }
.btn-kprime-check:disabled { opacity:.65; cursor:not-allowed; }

.action-buttons { display:flex; gap:12px; flex-wrap:wrap; }

.btn-verify {
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    padding:12px 24px; background:#24782b; color:#fff;
    border:none; border-radius:8px; font-size:1rem; font-weight:900; cursor:pointer; transition:background .18s;
}
.btn-verify:hover:not(:disabled) { background:#1a5e20; }
.btn-verify:disabled { opacity:.65; cursor:not-allowed; }

.btn-reject {
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    padding:12px 24px; background:#fff; color:#b42323;
    border:1.5px solid #f5a0a0; border-radius:8px; font-size:1rem; font-weight:900; cursor:pointer; transition:all .18s;
}
.btn-reject:hover { background:#fff0f0; border-color:#e05555; }

.rejected-pending-hint {
    display:inline-flex; align-items:center; gap:7px;
    padding:12px 18px; background:#fff8e1; border:1px solid #f0c060;
    border-radius:8px; color:#7a5700; font-size:0.88rem; font-weight:700;
}

.verified-badge {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 20px; background:#e7f7e7; border:1.5px solid #a8d8a8;
    border-radius:8px; color:#24782b; font-weight:800; font-size:0.95rem;
}

/* Items */
.items-list { display:grid; gap:12px; }
.order-item {
    display:grid; grid-template-columns:74px minmax(180px,1fr) repeat(3,minmax(120px,auto));
    align-items:center; gap:16px; padding:14px;
    background:#fbfcfa; border:1px solid #edf2ea; border-radius:8px;
}
.order-item img { width:74px; height:74px; object-fit:cover; border-radius:6px; border:1px solid #e5ece2; }
.item-main { display:grid; gap:4px; }
.item-main strong { color:#17351a; }
.item-main span { color:#68746a; font-size:0.84rem; }
.item-stat { display:grid; gap:4px; }
.item-stat.total strong { color:#24782b; }

.totals-box {
    max-width:420px; margin:22px 0 0 auto;
    border-top:1px solid #e5ece2; padding-top:14px; display:grid; gap:10px;
}
.totals-box div { display:flex; justify-content:space-between; gap:20px; }
.totals-box strong { color:#17351a; }
.grand-total { padding-top:12px; border-top:2px solid #e5ece2; }
.grand-total strong { color:#24782b; font-size:1.35rem; }

/* Modal */
.modal-backdrop {
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    display:flex; align-items:center; justify-content:center; z-index:1000; padding:20px;
}
.modal-box {
    background:#fff; border-radius:12px; width:100%; max-width:520px;
    box-shadow:0 20px 60px rgba(0,0,0,.25); overflow:hidden;
}
.modal-header {
    display:flex; justify-content:space-between; align-items:center;
    padding:20px 24px; background:#fff0f0; border-bottom:1px solid #ffd4d4;
}
.modal-header h3 { margin:0; color:#b42323; font-size:1.1rem; font-weight:900; display:flex; align-items:center; gap:8px; }
.modal-close {
    background:none; border:none; font-size:1.6rem; color:#b42323;
    cursor:pointer; line-height:1; padding:0; width:32px; height:32px;
    display:flex; align-items:center; justify-content:center; border-radius:4px;
}
.modal-close:hover { background:#ffd4d4; }
.modal-body { padding:24px; }
.modal-body p { margin:0 0 14px; color:#5a6b5c; font-size:0.92rem; line-height:1.6; }
.modal-body label { display:block; font-weight:800; color:#17351a; font-size:0.88rem; margin-bottom:8px; }
.required { color:#b42323; }
.modal-body textarea {
    width:100%; border:1.5px solid #dfe8db; border-radius:8px;
    padding:12px 14px; font-size:0.92rem; font-family:inherit;
    resize:vertical; outline:none; transition:border-color .15s; box-sizing:border-box;
}
.modal-body textarea:focus { border-color:#5cb85c; }
.modal-body textarea.has-error { border-color:#e05555; }
.field-error { margin:6px 0 0; color:#b42323; font-size:0.82rem; }
.char-hint { margin:6px 0 0; color:#9aaa95; font-size:0.78rem; }
.modal-footer {
    display:flex; justify-content:flex-end; gap:12px;
    padding:16px 24px; background:#f8faf8; border-top:1px solid #e5ece2;
}
.btn-cancel {
    padding:10px 20px; background:#fff; border:1.5px solid #dfe8db;
    border-radius:8px; color:#5a6b5c; font-weight:800; cursor:pointer;
}
.btn-cancel:hover { background:#f5f5f5; }
.btn-reject-confirm {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 22px; background:#b42323; color:#fff;
    border:none; border-radius:8px; font-weight:900; cursor:pointer; transition:background .15s;
}
.btn-reject-confirm:hover:not(:disabled) { background:#8c1a1a; }
.btn-reject-confirm:disabled { opacity:.6; cursor:not-allowed; }

/* Delivery QR section */
.delivery-card { border-color: #bcd4f0; background: #f8fbff; }
.delivery-card h2 { display: flex; align-items: center; gap: 8px; }

.delivery-hint {
    display: flex; align-items: flex-start; gap: 10px;
    background: #f0f8ff; border: 1px solid #bcd4f0; border-radius: 8px;
    padding: 13px 16px; color: #1a4a7a; font-size: 0.88rem; line-height: 1.6;
    margin-bottom: 18px;
}
.delivery-hint i { color: #1a6ba8; margin-top: 2px; flex-shrink: 0; }

.delivery-generate { display: flex; flex-direction: column; gap: 14px; margin-top: 16px; }

.delivery-url-box {
    background: #fff; border: 1.5px solid #a8d8a8;
    border-radius: 10px; padding: 16px 18px;
    display: flex; flex-direction: column; gap: 10px;
}
.delivery-url-box label { font-size: 0.82rem; font-weight: 800; color: #17351a; text-transform: uppercase; letter-spacing: .5px; }

.url-row { display: flex; gap: 8px; }
.url-input {
    flex: 1; border: 1.5px solid #e5ece2; border-radius: 7px;
    padding: 10px 12px; font-size: 0.82rem; font-family: monospace;
    color: #1a4da8; background: #f8faf7; outline: none;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.btn-copy {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 16px; background: #2d6a4f; color: #fff;
    border: none; border-radius: 7px; font-size: 0.85rem; font-weight: 800; cursor: pointer; white-space: nowrap;
    transition: background .15s;
}
.btn-copy:hover { background: #1a3a1a; }

.url-preview-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.82rem; color: #2d6a4f; font-weight: 700; text-decoration: none;
}
.url-preview-link:hover { text-decoration: underline; }

.regen-hint { font-size: 0.78rem; color: #9aaa95; margin: 0; }

.btn-generate {
    display: inline-flex; align-items: center; justify-content: center; gap: 10px;
    align-self: flex-start; padding: 12px 24px; background: #1a4da8; color: #fff;
    border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 900;
    cursor: pointer; transition: background .15s;
}
.btn-generate:hover:not(:disabled) { background: #0f3070; }
.btn-generate:disabled { opacity: .65; cursor: not-allowed; }

@media (max-width:1100px) {
    .summary-strip, .details-grid { grid-template-columns:repeat(2,1fr); }
    .order-item { grid-template-columns:74px 1fr; }
    .item-stat { grid-column:2; }
}
@media (max-width:768px) {
    .page-header { flex-direction:column; }
    .summary-strip, .details-grid { grid-template-columns:1fr; }
    .detail-card { padding:18px; }
    .action-buttons { flex-direction:column; }
}

/* Proof admin */
.proof-admin-box {
    margin-top: 14px; padding: 14px 16px;
    background: #f0faf0; border: 1.5px solid #b5dbb5; border-radius: 10px;
}
.proof-admin-label {
    display: flex; align-items: center; gap: 8px;
    font-weight: 900; color: #1a3a1a; font-size: 0.88rem;
    margin-bottom: 12px;
}
.proof-admin-label i { color: #5cb85c; }
.proof-admin-content { display: flex; flex-direction: column; align-items: flex-start; gap: 8px; }
.proof-admin-img {
    max-width: 280px; max-height: 200px; object-fit: contain;
    border-radius: 8px; border: 1px solid #c3ddc0;
    cursor: zoom-in; transition: transform .2s;
}
.proof-admin-img:hover { transform: scale(1.03); }
.proof-admin-hint { color: #6c9c6c; font-size: 0.78rem; }
.proof-admin-pdf {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 12px 18px; background: #fff3f3; border: 1.5px solid #f5a0a0;
    border-radius: 8px; color: #c0392b; font-weight: 700; text-decoration: none;
    font-size: 0.88rem; transition: background .15s;
}
.proof-admin-pdf:hover { background: #ffe0e0; }
.proof-admin-download {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 14px; background: #eaf5ea; border: 1.5px solid #b5dbb5;
    border-radius: 8px; color: #2c6b2c; font-weight: 700; text-decoration: none;
    font-size: 0.82rem; transition: background .15s;
}
.proof-admin-download:hover { background: #d9ecd9; }
.proof-admin-missing {
    margin-top: 12px; padding: 10px 14px;
    background: #fff8e1; border: 1px solid #ffd54f;
    border-radius: 8px; color: #8d6c0f; font-size: 0.84rem;
    display: flex; align-items: center; gap: 8px;
}
</style>
