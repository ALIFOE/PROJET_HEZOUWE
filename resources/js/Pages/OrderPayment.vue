<template>
    <AppLayout title="Reprendre le paiement">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/dashboard">Mon espace</Link></li>
                        <li>//</li>
                        <li>Reprendre le paiement</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Reprendre le paiement</h1>
                </div>
            </div>
        </section>

        <section class="pay-section section-padding fix">
            <div class="container">

                <!-- Flash -->
                <div v-if="$page.props.flash?.error" class="flash-error">
                    <i class="fas fa-exclamation-circle"></i> {{ $page.props.flash.error }}
                </div>

                <div class="pay-grid">

                    <!-- Order summary (read-only) -->
                    <aside class="order-recap">
                        <div class="recap-header">
                            <i class="fas fa-receipt"></i>
                            Commande {{ order.order_number }}
                        </div>
                        <div class="recap-row">
                            <span>Client</span><strong>{{ order.customer_name }}</strong>
                        </div>
                        <div class="recap-row">
                            <span>Livraison</span><strong>{{ order.city }}</strong>
                        </div>
                        <div class="recap-rows-items">
                            <div v-for="item in order.items" :key="item.id" class="recap-item">
                                <span>{{ item.product_title }} × {{ item.quantity }}</span>
                                <strong>{{ formatPrice(item.line_total) }} FCFA</strong>
                            </div>
                        </div>
                        <div class="recap-row delivery-row">
                            <span>Livraison</span>
                            <strong :class="order.delivery_cost === 0 ? 'free' : ''">
                                {{ order.delivery_cost === 0 ? 'Gratuite' : formatPrice(order.delivery_cost) + ' FCFA' }}
                            </strong>
                        </div>
                        <div class="recap-row total-row">
                            <span>Total à payer</span>
                            <strong class="amount">{{ formatPrice(order.total) }} FCFA</strong>
                        </div>
                        <div class="rejection-box">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <p class="rej-title">Motif du rejet précédent</p>
                                <p class="rej-text">{{ order.rejection_reason }}</p>
                            </div>
                        </div>
                    </aside>

                    <!-- Payment form -->
                    <div class="pay-form-wrapper">
                        <h2 class="form-title">Choisissez votre mode de paiement</h2>

                        <!-- Method selector -->
                        <div class="method-cards">
                            <!-- Cash on delivery -->
                            <label class="method-card" :class="{ selected: form.payment_method === 'cash_on_delivery' }">
                                <input v-model="form.payment_method" type="radio" value="cash_on_delivery">
                                <div class="method-icon"><i class="fas fa-home"></i></div>
                                <div>
                                    <strong>Paiement à la livraison</strong>
                                    <span>Versez 50% maintenant, le reste à la livraison</span>
                                </div>
                            </label>

                            <!-- Mobile Money -->
                            <label class="method-card" :class="{ selected: form.payment_method === 'mobile_money' }">
                                <input v-model="form.payment_method" type="radio" value="mobile_money">
                                <div class="method-icon mm"><i class="fas fa-mobile-alt"></i></div>
                                <div>
                                    <strong>Mobile Money — FedaPay</strong>
                                    <span>T-Money · Flooz · Wave — paiement en ligne sécurisé</span>
                                </div>
                            </label>

                            <!-- Bank transfer -->
                            <label class="method-card" :class="{ selected: form.payment_method === 'bank_transfer' }">
                                <input v-model="form.payment_method" type="radio" value="bank_transfer">
                                <div class="method-icon bank"><i class="fas fa-university"></i></div>
                                <div>
                                    <strong>Virement bancaire</strong>
                                    <span>BANQUE ATLANTIQUE TOGO</span>
                                </div>
                            </label>
                        </div>

                        <!-- COD panel -->
                        <div v-if="form.payment_method === 'cash_on_delivery'" class="pay-panel">
                            <div class="panel-header">
                                <i class="fas fa-home"></i> Paiement à la livraison
                            </div>
                            <div class="panel-body">
                                <div class="amount-split">
                                    <div class="split-item now">
                                        <span>À payer maintenant (50%)</span>
                                        <strong>{{ formatPrice(Math.ceil(order.total / 2)) }} FCFA</strong>
                                    </div>
                                    <div class="split-item later">
                                        <span>À la livraison (50%)</span>
                                        <strong>{{ formatPrice(Math.floor(order.total / 2)) }} FCFA</strong>
                                    </div>
                                </div>
                                <p class="panel-desc">Effectuez un paiement Mobile Money vers l'un des numéros HEZOUWE, puis saisissez l'ID de transaction :</p>
                                <div class="operator-cards">
                                    <div class="operator-card yas">
                                        <div class="op-logo"><img src="/assets/img/mixx-by-yas.png" alt="Mixx by YAS" class="op-img"></div>
                                        <div><strong>Mixx by YAS</strong><span class="op-num">+228 70 XX XX XX</span></div>
                                    </div>
                                    <div class="operator-card moov">
                                        <div class="op-logo"><img src="/assets/img/flooz logo.png" alt="Flooz" class="op-img"></div>
                                        <div><strong>Flooz — Moov Africa</strong><span class="op-num">+228 79 XX XX XX</span></div>
                                    </div>
                                </div>
                                <div class="txn-field">
                                    <label>ID de transaction <span class="req">*</span></label>
                                    <input v-model="form.transaction_id" type="text" placeholder="Ex: TG240518XXXX" class="txn-input">
                                    <p v-if="form.errors.transaction_id" class="field-error">{{ form.errors.transaction_id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Money panel -->
                        <div v-if="form.payment_method === 'mobile_money'" class="pay-panel mm-panel">
                            <div class="panel-header mm-header">
                                <i class="fas fa-mobile-alt"></i> Paiement Mobile Money — FedaPay
                            </div>
                            <div class="panel-body">
                                <p class="panel-desc">Après confirmation, vous serez redirigé(e) vers la page de paiement sécurisée FedaPay. Vous pourrez payer avec :</p>
                                <div class="operator-cards">
                                    <div class="operator-card tmoney">
                                        <div class="op-logo op-text">T₿</div>
                                        <div><strong>T-Money</strong><span class="op-num">Togocel</span></div>
                                    </div>
                                    <div class="operator-card moov">
                                        <div class="op-logo"><img src="/assets/img/flooz logo.png" alt="Flooz" class="op-img"></div>
                                        <div><strong>Flooz</strong><span class="op-num">Moov Africa</span></div>
                                    </div>
                                    <div class="operator-card wave">
                                        <div class="op-logo op-text">W</div>
                                        <div><strong>Wave</strong><span class="op-num">Wave Mobile</span></div>
                                    </div>
                                </div>
                                <div class="secure-note">
                                    <i class="fas fa-shield-alt"></i>
                                    Paiement sécurisé et certifié. Votre numéro n'est jamais partagé.
                                </div>
                            </div>
                        </div>

                        <!-- Bank transfer panel -->
                        <div v-if="form.payment_method === 'bank_transfer'" class="pay-panel bank-panel">
                            <div class="panel-header bank-header">
                                <i class="fas fa-university"></i> Coordonnées bancaires — HEZOUWE
                            </div>
                            <div class="panel-body">
                                <div class="bank-details">
                                    <div class="bank-row"><span>Titulaire</span><strong>COOP CA HEZOUWE</strong></div>
                                    <div class="bank-row"><span>Banque</span><strong>BANQUE ATLANTIQUE TOGO</strong></div>
                                    <div class="bank-row highlight"><span>Référence du virement</span><strong>Votre nom + {{ order.order_number }}</strong></div>
                                    <div class="bank-row highlight"><span>Montant exact</span><strong class="amount-green">{{ formatPrice(order.total) }} FCFA</strong></div>
                                </div>
                                <div class="txn-field">
                                    <label>Référence / ID de transaction <span class="req">*</span></label>
                                    <input v-model="form.transaction_id" type="text" placeholder="Votre référence de virement" class="txn-input">
                                    <p class="field-hint">Saisissez la référence après avoir effectué le virement.</p>
                                    <p v-if="form.errors.transaction_id" class="field-error">{{ form.errors.transaction_id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-actions">
                            <Link href="/dashboard" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </Link>
                            <button
                                type="button"
                                class="btn-submit"
                                :disabled="form.processing || !form.payment_method"
                                @click="submit"
                            >
                                <i class="fas" :class="form.processing ? 'fa-spinner fa-spin' : (form.payment_method === 'mobile_money' ? 'fa-mobile-alt' : 'fa-check')"></i>
                                <span v-if="form.processing">Traitement…</span>
                                <span v-else-if="form.payment_method === 'mobile_money'">Continuer vers Mobile Money</span>
                                <span v-else>Soumettre le paiement</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ order: Object });

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

const form = useForm({
    payment_method: props.order.payment_method || 'cash_on_delivery',
    transaction_id: '',
});

const submit = () => {
    form.patch(`/orders/${props.order.id}/pay`);
};
</script>

<style scoped>
.pay-section { background: #f8faf8; }

.flash-error {
    max-width: 900px; margin: 0 auto 20px;
    background: #ffe8e8; border: 1px solid #f5a0a0;
    color: #b42323; padding: 12px 18px; border-radius: 8px;
    font-weight: 700; display: flex; align-items: center; gap: 8px;
}

.pay-grid {
    max-width: 960px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 28px;
    align-items: start;
}

/* Recap */
.order-recap {
    background: #fff;
    border: 1px solid #e0ece0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(23,53,26,.06);
    position: sticky;
    top: 24px;
}
.recap-header {
    background: #1a3a1a; color: #fff;
    padding: 16px 20px; font-weight: 700; font-size: 0.95rem;
    display: flex; align-items: center; gap: 10px;
}
.recap-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 18px; border-bottom: 1px solid #f0f4f0; font-size: 0.9rem;
}
.recap-row span { color: #6c757d; }
.recap-row strong { color: #1a3a1a; }
.recap-rows-items { padding: 10px 18px; border-bottom: 1px solid #f0f4f0; }
.recap-item {
    display: flex; justify-content: space-between;
    font-size: 0.84rem; padding: 4px 0; color: #555;
}
.recap-item strong { color: #1a3a1a; font-weight: 700; }
.delivery-row strong.free { color: #24782b; }
.total-row { background: #f0faf0; padding: 14px 18px; border-bottom: none; }
.amount { font-size: 1.25rem; color: #2d6a4f; font-weight: 900; }

.rejection-box {
    display: flex; gap: 10px; align-items: flex-start;
    background: #fff0f0; border-top: 1px solid #fcc;
    padding: 14px 16px; color: #b42323; font-size: 0.8rem;
}
.rejection-box i { margin-top: 2px; flex-shrink: 0; }
.rej-title { font-weight: 800; margin-bottom: 4px; font-size: 0.78rem; text-transform: uppercase; }
.rej-text { line-height: 1.5; color: #b42323; }

/* Form wrapper */
.pay-form-wrapper {
    background: #fff; border: 1px solid #e0ece0;
    border-radius: 12px; padding: 28px;
    box-shadow: 0 4px 16px rgba(23,53,26,.06);
}
.form-title { margin: 0 0 20px; color: #1a3a1a; font-size: 1.15rem; font-weight: 900; }

/* Method cards */
.method-cards { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
.method-card {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 18px; border: 1.5px solid #dfe8db;
    border-radius: 10px; cursor: pointer; transition: border-color .15s, background .15s;
    background: #fafcfa;
}
.method-card input[type="radio"] { display: none; }
.method-card.selected { border-color: #2d6a4f; background: #f0faf0; }
.method-card:hover { border-color: #9ec99e; }
.method-card strong { display: block; color: #1a3a1a; font-weight: 800; font-size: 0.92rem; }
.method-card span { color: #6c757d; font-size: 0.8rem; }
.method-icon {
    width: 40px; height: 40px; border-radius: 8px;
    background: #1a3a1a; color: #d5a741;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.method-icon.mm { background: #e8f5e9; color: #24782b; }
.method-icon.bank { background: #e8f1ff; color: #1a4da8; }

/* Pay panels */
.pay-panel {
    border: 1.5px solid #dfe8db; border-radius: 10px;
    overflow: hidden; margin-bottom: 20px;
}
.panel-header {
    background: #1a3a1a; color: #fff;
    padding: 12px 18px; font-weight: 700; font-size: 0.9rem;
    display: flex; align-items: center; gap: 8px;
}
.mm-header { background: #2d6a4f; }
.bank-header { background: #1a4da8; }
.panel-body { padding: 18px; }
.panel-desc { margin: 0 0 14px; color: #5a6b5c; font-size: 0.88rem; line-height: 1.6; }

.amount-split {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px;
}
.split-item {
    padding: 12px 14px; border-radius: 8px; font-size: 0.85rem;
}
.split-item span { display: block; color: #6c757d; font-size: 0.78rem; margin-bottom: 4px; }
.split-item strong { font-size: 1rem; }
.split-item.now { background: #fff8e1; border: 1px solid #ffd54f; }
.split-item.now strong { color: #b8860b; }
.split-item.later { background: #f8faf8; border: 1px solid #e0ece0; }
.split-item.later strong { color: #1a3a1a; }

.operator-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
.operator-card {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border: 1.5px solid #e0ece0;
    border-radius: 8px; background: #fafcfa;
}
.operator-card.yas { border-color: #e3f2fd; background: #f0f8ff; }
.operator-card.moov { border-color: #e8f5e9; background: #f0faf5; }
.operator-card.tmoney { border-color: #e3f2fd; background: #f0f8ff; }
.operator-card.wave { border-color: #f3e5f5; background: #fdf5ff; }
.operator-card strong { display: block; color: #17351a; font-size: 0.84rem; font-weight: 900; }
.op-num { display: block; color: #5cb85c; font-size: 0.82rem; font-weight: 700; margin-top: 2px; }

.op-logo {
    width: 44px; height: 36px; border-radius: 6px;
    background: #fff; border: 1px solid #e0ece0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 900; overflow: hidden; flex-shrink: 0;
}
.op-logo.op-text { background: #1a3a1a; color: #d5a741; }
.op-img { width: 100%; height: 100%; object-fit: contain; padding: 3px; }

.bank-details { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
.bank-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 12px; background: #f8faf8; border-radius: 6px; font-size: 0.87rem;
}
.bank-row span { color: #6c757d; }
.bank-row strong { color: #1a3a1a; font-weight: 700; }
.bank-row.highlight { background: #fff8e1; }
.amount-green { color: #24782b !important; font-size: 1.05rem; }

.txn-field { margin-top: 14px; }
.txn-field label { display: block; font-weight: 800; color: #1a3a1a; font-size: 0.88rem; margin-bottom: 7px; }
.req { color: #b42323; }
.txn-input {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid #dfe8db; border-radius: 8px;
    font-family: monospace; font-size: 0.92rem;
    color: #1a3a1a; background: #fff;
    outline: none; box-sizing: border-box; transition: border-color .15s;
}
.txn-input:focus { border-color: #2d6a4f; }
.txn-input::placeholder { color: #9aaa95; font-family: inherit; }
.field-hint { margin: 5px 0 0; color: #9aaa95; font-size: 0.78rem; }
.field-error { margin: 5px 0 0; color: #b42323; font-size: 0.82rem; font-weight: 700; }

.secure-note {
    margin-top: 12px; padding: 10px 14px;
    background: #f0faf0; border: 1px solid #c3ddc0;
    border-radius: 6px; color: #24782b; font-size: 0.82rem;
    display: flex; align-items: center; gap: 8px;
}

/* Actions */
.form-actions {
    display: flex; justify-content: space-between; align-items: center;
    gap: 14px; margin-top: 6px; flex-wrap: wrap;
}
.btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 20px; background: #fff; color: #1a3a1a;
    border: 1.5px solid #dfe8db; border-radius: 8px;
    font-weight: 800; text-decoration: none; font-size: 0.9rem;
    transition: background .15s;
}
.btn-back:hover { background: #f5f5f5; }
.btn-submit {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 10px;
    padding: 14px 24px; background: #2d6a4f; color: #fff;
    border: none; border-radius: 10px; font-size: 1rem; font-weight: 900;
    cursor: pointer; transition: background .2s, transform .1s;
}
.btn-submit:hover:not(:disabled) { background: #1a3a1a; transform: translateY(-1px); }
.btn-submit:disabled { opacity: .6; cursor: not-allowed; }

@media (max-width: 860px) {
    .pay-grid { grid-template-columns: 1fr; }
    .order-recap { position: static; }
    .operator-cards { grid-template-columns: 1fr; }
    .amount-split { grid-template-columns: 1fr; }
}
</style>
