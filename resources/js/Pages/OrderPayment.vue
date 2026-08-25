<template>
    <AppLayout title="Reprendre le paiement" :noindex="true">
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
                                    <strong>Mobile Money</strong>
                                    <span>Mixx by YAS · Flooz — paiement sécurisé</span>
                                </div>
                            </label>

                            <!-- Bank transfer (not yet available) -->
                            <label class="method-card disabled">
                                <input type="radio" value="bank_transfer" disabled>
                                <div class="method-icon bank"><i class="fas fa-university"></i></div>
                                <div>
                                    <strong>Virement bancaire <span class="soon-badge">Bientôt disponible</span></strong>
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

                                <!-- Preuve de paiement -->
                                <div class="proof-zone">
                                    <div class="proof-title">
                                        <i class="fas fa-file-image"></i>
                                        Preuve de paiement <span class="proof-optional">(recommandé)</span>
                                    </div>
                                    <p class="proof-desc">
                                        Joignez une <strong>photo du bordereau</strong>, une <strong>capture du SMS Mobile Money</strong> ou tout autre justificatif de votre paiement de {{ formatPrice(Math.ceil(order.total / 2)) }} FCFA.
                                    </p>
                                    <div v-if="!codProofPreview" class="proof-btns">
                                        <label class="proof-btn">
                                            <i class="fas fa-camera"></i> Prendre une photo
                                            <input type="file" accept="image/*" capture="environment" class="proof-input" @change="setProof('cod', $event)">
                                        </label>
                                        <label class="proof-btn">
                                            <i class="fas fa-folder-open"></i> Choisir un fichier
                                            <input type="file" accept="image/*,application/pdf" class="proof-input" @change="setProof('cod', $event)">
                                        </label>
                                    </div>
                                    <div v-if="codProofPreview" class="proof-preview-box">
                                        <img v-if="codProofIsImage" :src="codProofPreview" class="proof-thumb" alt="Preuve">
                                        <div v-else class="proof-pdf-row">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>{{ codProofFileName }}</span>
                                        </div>
                                        <button type="button" @click="clearProof('cod')" class="proof-remove">
                                            <i class="fas fa-times"></i> Supprimer
                                        </button>
                                    </div>
                                    <p v-if="form.errors.payment_proof" class="field-error">{{ form.errors.payment_proof }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Money panel -->
                        <div v-if="form.payment_method === 'mobile_money'" class="pay-panel mm-panel">
                            <div class="panel-header mm-header">
                                <i class="fas fa-mobile-alt"></i> Paiement Mobile Money
                            </div>
                            <div class="panel-body">
                                <p class="panel-desc">Choisissez votre opérateur, puis continuez pour finaliser le paiement.</p>
                                <div class="operator-cards">
                                    <button
                                        type="button"
                                        class="operator-card yas"
                                        :class="{ selected: mobileOperator === 'mixx_yas' }"
                                        @click="mobileOperator = 'mixx_yas'"
                                    >
                                        <div class="op-logo"><img src="/assets/img/mixx-by-yas.png" alt="Mixx by YAS" class="op-img"></div>
                                        <div><strong>Mixx by YAS</strong><span class="op-num">Togocel</span></div>
                                        <i class="fas fa-check-circle op-check"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="operator-card moov"
                                        :class="{ selected: mobileOperator === 'flooz' }"
                                        @click="mobileOperator = 'flooz'"
                                    >
                                        <div class="op-logo"><img src="/assets/img/flooz logo.png" alt="Flooz" class="op-img"></div>
                                        <div><strong>Flooz</strong><span class="op-num">Moov Africa</span></div>
                                        <i class="fas fa-check-circle op-check"></i>
                                    </button>
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

                                <!-- Preuve de virement -->
                                <div class="proof-zone">
                                    <div class="proof-title">
                                        <i class="fas fa-file-image"></i>
                                        Justificatif de virement <span class="proof-optional">(recommandé)</span>
                                    </div>
                                    <p class="proof-desc">
                                        Joignez le <strong>reçu de virement bancaire</strong>, une capture d'écran de la confirmation ou tout document prouvant votre transfert de {{ formatPrice(order.total) }} FCFA.
                                    </p>
                                    <div v-if="!bankProofPreview" class="proof-btns">
                                        <label class="proof-btn">
                                            <i class="fas fa-camera"></i> Prendre une photo
                                            <input type="file" accept="image/*" capture="environment" class="proof-input" @change="setProof('bank', $event)">
                                        </label>
                                        <label class="proof-btn">
                                            <i class="fas fa-folder-open"></i> Choisir un fichier
                                            <input type="file" accept="image/*,application/pdf" class="proof-input" @change="setProof('bank', $event)">
                                        </label>
                                    </div>
                                    <div v-if="bankProofPreview" class="proof-preview-box">
                                        <img v-if="bankProofIsImage" :src="bankProofPreview" class="proof-thumb" alt="Justificatif">
                                        <div v-else class="proof-pdf-row">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>{{ bankProofFileName }}</span>
                                        </div>
                                        <button type="button" @click="clearProof('bank')" class="proof-remove">
                                            <i class="fas fa-times"></i> Supprimer
                                        </button>
                                    </div>
                                    <p v-if="form.errors.payment_proof" class="field-error">{{ form.errors.payment_proof }}</p>
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
import { ref, watch } from 'vue';

const props = defineProps({ order: Object });

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

const form = useForm({
    payment_method: props.order.payment_method || 'cash_on_delivery',
    transaction_id: '',
    payment_proof:  null,
});

// Selected Mobile Money operator (visual only)
const mobileOperator = ref(null);

// COD proof state
const codProofPreview  = ref(null);
const codProofIsImage  = ref(false);
const codProofFileName = ref('');

// Bank proof state
const bankProofPreview  = ref(null);
const bankProofIsImage  = ref(false);
const bankProofFileName = ref('');

watch(() => form.payment_method, () => {
    clearProof('cod');
    clearProof('bank');
});

const setProof = (type, e) => {
    const file = e.target.files[0];
    if (!file) return;
    form.payment_proof = file;
    const isImage = file.type.startsWith('image/');
    if (type === 'cod') {
        codProofFileName.value = file.name;
        codProofIsImage.value  = isImage;
        if (isImage) {
            const r = new FileReader();
            r.onload = (ev) => { codProofPreview.value = ev.target.result; };
            r.readAsDataURL(file);
        } else { codProofPreview.value = 'pdf'; }
    } else {
        bankProofFileName.value = file.name;
        bankProofIsImage.value  = isImage;
        if (isImage) {
            const r = new FileReader();
            r.onload = (ev) => { bankProofPreview.value = ev.target.result; };
            r.readAsDataURL(file);
        } else { bankProofPreview.value = 'pdf'; }
    }
    e.target.value = '';
};

const clearProof = (type) => {
    form.payment_proof = null;
    if (type === 'cod') {
        codProofPreview.value  = null;
        codProofIsImage.value  = false;
        codProofFileName.value = '';
    } else {
        bankProofPreview.value  = null;
        bankProofIsImage.value  = false;
        bankProofFileName.value = '';
    }
};

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
.method-card.disabled { opacity: 0.52; cursor: not-allowed; }
.method-card.disabled:hover { border-color: #dfe8db; }
.method-card strong { display: block; color: #1a3a1a; font-weight: 800; font-size: 0.92rem; }
.method-card span { color: #6c757d; font-size: 0.8rem; }

.soon-badge {
    display: inline-block;
    background: #fff3e0;
    color: #e65100;
    font-size: 0.68rem;
    font-weight: 900;
    padding: 1px 7px;
    border-radius: 999px;
    border: 1px solid #ffcc80;
    margin-left: 6px;
    vertical-align: middle;
}

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

button.operator-card {
    width: 100%;
    font-family: inherit;
    text-align: left;
    cursor: pointer;
    position: relative;
    transition: border-color .15s, transform .1s;
}
button.operator-card:hover { border-color: #5cb85c; }
button.operator-card.selected { border-color: #5cb85c; box-shadow: 0 0 0 2px rgba(92,184,92,0.18); }
.op-check {
    display: none;
    margin-left: auto;
    color: #5cb85c;
    font-size: 1.1rem;
}
button.operator-card.selected .op-check { display: block; }

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

/* ── Proof upload ───────────────────────────────────── */
.proof-zone {
    margin-top: 16px;
    background: #f8faf7;
    border: 1.5px dashed #b5cdb5;
    border-radius: 10px;
    padding: 14px 16px;
}
.proof-title {
    display: flex; align-items: center; gap: 8px;
    font-weight: 900; color: #1a3a1a; font-size: 0.88rem;
    margin-bottom: 6px;
}
.proof-title i { color: #5cb85c; }
.proof-optional { font-weight: 400; color: #9aaa95; font-size: 0.78rem; }
.proof-desc { color: #5a6b5c; font-size: 0.82rem; line-height: 1.5; margin: 0 0 12px; }
.proof-btns { display: flex; gap: 10px; flex-wrap: wrap; }
.proof-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border: 1.5px solid #b5cdb5;
    border-radius: 8px; background: #fff; color: #1a3a1a;
    font-size: 0.84rem; font-weight: 700; cursor: pointer;
    transition: border-color .15s, background .15s;
}
.proof-btn:hover { border-color: #5cb85c; background: #f0faf0; }
.proof-btn i { color: #5cb85c; }
.proof-input { display: none; }
.proof-preview-box {
    display: flex; align-items: center; gap: 12px;
    margin-top: 10px; padding: 10px 12px;
    background: #fff; border: 1px solid #c3ddc0; border-radius: 8px;
}
.proof-thumb {
    width: 60px; height: 60px; object-fit: cover;
    border-radius: 6px; border: 1px solid #e0ece0; flex-shrink: 0;
}
.proof-pdf-row {
    display: flex; align-items: center; gap: 10px;
    color: #e74c3c; font-size: 0.86rem; font-weight: 700;
}
.proof-remove {
    margin-left: auto; display: flex; align-items: center; gap: 5px;
    padding: 6px 12px; background: #fff0f0; border: 1px solid #f5a0a0;
    color: #b42323; border-radius: 6px; font-size: 0.78rem; font-weight: 700;
    cursor: pointer;
}
.proof-remove:hover { background: #ffe0e0; }
</style>
