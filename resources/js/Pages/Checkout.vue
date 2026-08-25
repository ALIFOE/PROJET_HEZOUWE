<template>
    <AppLayout title="Finaliser la commande">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/shop-cart">Mon Panier</Link></li>
                        <li>//</li>
                        <li>Commande</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Finaliser la commande</h1>
                </div>
            </div>
        </section>

        <section class="checkout-section section-padding fix">
            <div class="container">
                <form @submit.prevent="submitOrder" class="checkout-layout">

                    <!-- Left: form -->
                    <div class="checkout-left">

                        <!-- Delivery info -->
                        <div class="co-card">
                            <h3 class="co-card-title">
                                <span class="co-step">1</span>
                                Informations de livraison
                            </h3>
                            <div class="co-grid-2">
                                <div class="co-field">
                                    <label>Nom complet *</label>
                                    <input v-model="form.customer_name" type="text" required placeholder="Prénom Nom">
                                    <InputError :message="form.errors.customer_name" />
                                </div>
                                <div class="co-field">
                                    <label>Email *</label>
                                    <input v-model="form.customer_email" type="email" required placeholder="email@exemple.com">
                                    <InputError :message="form.errors.customer_email" />
                                </div>
                                <div class="co-field">
                                    <label>Téléphone *</label>
                                    <input v-model="form.customer_phone" type="tel" required placeholder="+228 XX XX XX XX">
                                    <InputError :message="form.errors.customer_phone" />
                                </div>
                                <div class="co-field">
                                    <label>Ville *</label>
                                    <input v-model="form.city" type="text" required placeholder="Lomé, Kpalimé…">
                                    <InputError :message="form.errors.city" />
                                </div>
                                <div class="co-field co-full">
                                    <label>Adresse complète *</label>
                                    <input v-model="form.address" type="text" required placeholder="Quartier, rue, point de repère">
                                    <InputError :message="form.errors.address" />
                                </div>
                                <div class="co-field co-full">
                                    <label>Notes de livraison</label>
                                    <textarea v-model="form.notes" rows="3" placeholder="Instructions spéciales pour la livraison…"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment method -->
                        <div class="co-card">
                            <h3 class="co-card-title">
                                <span class="co-step">2</span>
                                Mode de paiement
                            </h3>
                            <InputError :message="form.errors.payment_method" />

                            <div class="pay-methods">
                                <!-- Cash on delivery -->
                                <label class="pay-card" :class="{ selected: form.payment_method === 'cash_on_delivery' }">
                                    <input v-model="form.payment_method" type="radio" value="cash_on_delivery">
                                    <div class="pay-card-inner">
                                        <div class="pay-icon cod-icon">🏠</div>
                                        <div>
                                            <strong>Paiement à la livraison</strong>
                                            <span>50% à l'avance via Mobile Money + solde à la livraison</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Bank transfer (not yet available) -->
                                <label class="pay-card disabled">
                                    <input type="radio" value="bank_transfer" disabled>
                                    <div class="pay-card-inner">
                                        <div class="pay-icon bank-icon">🏦</div>
                                        <div>
                                            <strong>Virement bancaire <span class="soon-badge">Bientôt disponible</span></strong>
                                            <span>Virement vers notre compte bancaire, traitement sous 24-48h</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Mobile money — FedaPay -->
                                <label class="pay-card" :class="{ selected: form.payment_method === 'mobile_money' }">
                                    <input v-model="form.payment_method" type="radio" value="mobile_money">
                                    <div class="pay-card-inner">
                                        <div class="pay-icon mm-icon">📱</div>
                                        <div>
                                            <strong>Mobile Money</strong>
                                            <span>Mixx by YAS · Flooz — paiement sécurisé</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- COD instructions -->
                            <div v-if="form.payment_method === 'cash_on_delivery'" class="pay-panel cod-panel">
                                <div class="panel-header cod-header">
                                    <i class="fas fa-info-circle"></i>
                                    Instructions — Paiement à la livraison
                                </div>
                                <div class="panel-body">
                                    <div class="amount-highlight">
                                        <span class="amount-label">Montant à payer maintenant (50%)</span>
                                        <span class="amount-value">{{ formatPrice(Math.ceil(summary.total / 2)) }} FCFA</span>
                                        <span class="amount-note">Le solde de {{ formatPrice(Math.floor(summary.total / 2)) }} FCFA sera payé à la livraison</span>
                                    </div>

                                    <p class="panel-desc">Effectuez un paiement Mobile Money vers l'un des numéros suivants :</p>

                                    <div class="operator-cards">
                                        <div class="operator-card yas">
                                            <div class="op-logo"><img src="/assets/img/mixx-by-yas.png" alt="Mixx by YAS" class="op-img"></div>
                                            <div>
                                                <strong>Mixx by YAS</strong>
                                                <span class="op-num">+228 70 XX XX XX</span>
                                            </div>
                                        </div>
                                        <div class="operator-card moov">
                                            <div class="op-logo"><img src="/assets/img/flooz logo.png" alt="Flooz" class="op-img"></div>
                                            <div>
                                                <strong>Flooz — Moov Africa</strong>
                                                <span class="op-num">+228 79 XX XX XX</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="co-field" style="margin-top:18px;">
                                        <label>ID de transaction (obligatoire) *</label>
                                        <input
                                            v-model="form.transaction_id"
                                            type="text"
                                            required
                                            placeholder="Ex: TG240518XXXX"
                                            class="txn-input"
                                        >
                                        <p class="field-hint">Saisissez l'identifiant de transaction reçu après votre paiement Mobile Money.</p>
                                        <InputError :message="form.errors.transaction_id" />
                                    </div>

                                    <!-- Preuve de paiement -->
                                    <div class="proof-zone">
                                        <div class="proof-title">
                                            <i class="fas fa-file-image"></i>
                                            Preuve de paiement <span class="proof-optional">(recommandé)</span>
                                        </div>
                                        <p class="proof-desc">
                                            Joignez une <strong>photo du bordereau</strong>, une <strong>capture du SMS Mobile Money</strong> ou tout autre justificatif de votre paiement de {{ formatPrice(Math.ceil(summary.total / 2)) }} FCFA.
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
                                        <InputError :message="form.errors.payment_proof" />
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Money instructions -->
                            <div v-if="form.payment_method === 'mobile_money'" class="pay-panel mm-panel">
                                <div class="panel-header mm-header">
                                    <i class="fas fa-mobile-alt"></i>
                                    Paiement Mobile Money
                                </div>
                                <div class="panel-body">
                                    <p class="panel-desc">Choisissez votre opérateur, puis confirmez votre commande pour finaliser le paiement.</p>
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
                                    <div class="bank-notice" style="margin-top:14px;">
                                        <i class="fas fa-shield-alt"></i>
                                        Paiement sécurisé et certifié. Votre numéro n'est jamais partagé.
                                    </div>
                                </div>
                            </div>

                            <!-- Bank transfer instructions -->
                            <div v-if="form.payment_method === 'bank_transfer'" class="pay-panel bank-panel">
                                <div class="panel-header bank-header">
                                    <i class="fas fa-university"></i>
                                    Coordonnées bancaires — HEZOUWE
                                </div>
                                <div class="panel-body">
                                    <div class="bank-details">
                                        <div class="bank-row"><span>Titulaire</span><strong>COOP CA HEZOUWE</strong></div>
                                        <div class="bank-row"><span>Banque</span><strong>BANQUE ATLANTIQUE TOGO</strong></div>
                                        <div class="bank-row"><span>Numéro de compte</span><strong>À COMPLÉTER</strong></div>
                                        <div class="bank-row"><span>Code SWIFT / BIC</span><strong>À COMPLÉTER</strong></div>
                                        <div class="bank-row highlight"><span>Référence de virement</span><strong>Votre nom + numéro de commande</strong></div>
                                        <div class="bank-row highlight"><span>Montant exact</span><strong class="amount-green">{{ formatPrice(summary.total) }} FCFA</strong></div>
                                    </div>
                                    <div class="bank-notice">
                                        <i class="fas fa-clock"></i>
                                        Votre commande sera traitée dans les <strong>premiers jours ouvrables</strong> après réception du virement.
                                        Envoyez votre justificatif à <a href="mailto:contact@hezouwe.com">contact@hezouwe.com</a>
                                    </div>

                                    <!-- Preuve de virement -->
                                    <div class="proof-zone" style="margin-top:18px;">
                                        <div class="proof-title">
                                            <i class="fas fa-file-image"></i>
                                            Justificatif de virement <span class="proof-optional">(recommandé)</span>
                                        </div>
                                        <p class="proof-desc">
                                            Joignez le <strong>reçu de virement</strong>, une <strong>capture d'écran</strong> de la confirmation bancaire ou tout autre document prouvant votre transfert.
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
                                        <InputError :message="form.errors.payment_proof" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit (mobile) -->
                        <button type="submit" class="submit-btn mobile-submit" :disabled="form.processing">
                            <span v-if="form.processing">Traitement en cours…</span>
                            <span v-else-if="form.payment_method === 'mobile_money'">Continuer vers le paiement Mobile Money <i class="far fa-arrow-right"></i></span>
                            <span v-else>Confirmer la commande <i class="far fa-arrow-right"></i></span>
                        </button>
                    </div>

                    <!-- Right: summary -->
                    <aside class="checkout-right">
                        <div class="co-card summary-card">
                            <h3 class="co-card-title" style="margin-bottom:16px;">Résumé</h3>

                            <div v-for="item in cartItems" :key="item.slug" class="summary-item-row">
                                <img :src="item.image" :alt="item.title" class="s-img">
                                <div class="s-info">
                                    <strong>{{ item.title }}</strong>
                                    <span>{{ item.qty }} × {{ formatPrice(item.price) }} FCFA</span>
                                </div>
                                <span class="s-total">{{ formatPrice(item.line_total) }}</span>
                            </div>

                            <div class="summary-totals">
                                <div class="t-row">
                                    <span>Sous-total</span>
                                    <span>{{ formatPrice(summary.subtotal) }} FCFA</span>
                                </div>
                                <div v-if="summary.discount > 0" class="t-row discount-row">
                                    <span>Remise promo <template v-if="summary.coupon_code">({{ summary.coupon_code }})</template></span>
                                    <span>−{{ formatPrice(summary.discount) }} FCFA</span>
                                </div>
                                <div class="t-row">
                                    <span>Livraison</span>
                                    <span>{{ summary.delivery_cost === 0 ? 'Gratuite' : formatPrice(summary.delivery_cost) + ' FCFA' }}</span>
                                </div>
                                <div v-if="form.payment_method === 'cash_on_delivery'" class="t-row cod-row">
                                    <span>À payer maintenant (50%)</span>
                                    <span class="cod-amount">{{ formatPrice(Math.ceil(summary.total / 2)) }} FCFA</span>
                                </div>
                                <div class="t-row grand">
                                    <span>Total commande</span>
                                    <span>{{ formatPrice(summary.total) }} FCFA</span>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn" :disabled="form.processing">
                                <span v-if="form.processing">Traitement en cours…</span>
                                <span v-else-if="form.payment_method === 'mobile_money'">Continuer vers Mobile Money <i class="far fa-arrow-right"></i></span>
                                <span v-else>Confirmer la commande <i class="far fa-arrow-right"></i></span>
                            </button>

                            <Link href="/shop-cart" class="back-link">
                                <i class="far fa-arrow-left"></i> Modifier le panier
                            </Link>
                        </div>

                        <div class="trust-card">
                            <div class="trust-item"><i class="fas fa-shield-alt"></i><span>Paiement sécurisé</span></div>
                            <div class="trust-item"><i class="fas fa-truck"></i><span>Livraison au Togo</span></div>
                            <div class="trust-item"><i class="fas fa-leaf"></i><span>Riz 100% local</span></div>
                        </div>
                    </aside>

                </form>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    cartItems: Array,
    summary:   Object,
});

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    customer_name:  user?.name  || '',
    customer_email: user?.email || '',
    customer_phone: '',
    city:           '',
    address:        '',
    notes:          '',
    payment_method: 'cash_on_delivery',
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

// Reset proof when switching payment method
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

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

const submitOrder = () => {
    form.post(route('orders.store'));
};
</script>

<style scoped>
/* ── Layout ─────────────────────────────────────────── */
.checkout-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px;
    align-items: start;
}

.checkout-left { display: flex; flex-direction: column; gap: 22px; }

/* ── Card ───────────────────────────────────────────── */
.co-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 10px;
    padding: 26px;
    box-shadow: 0 8px 28px rgba(23,53,26,0.06);
}

.co-card-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 22px;
    color: #1a3a1a;
    font-size: 1.1rem;
    font-weight: 900;
}

.co-step {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #1a3a1a;
    color: #fff;
    font-size: 0.82rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* ── Form fields ────────────────────────────────────── */
.co-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.co-full { grid-column: 1 / -1; }

.co-field { display: flex; flex-direction: column; gap: 6px; }
.co-field label { color: #17351a; font-size: 0.86rem; font-weight: 850; }

.co-field input,
.co-field textarea {
    padding: 12px 14px;
    border: 1.5px solid #dfe8db;
    border-radius: 7px;
    font: inherit;
    color: #17351a;
    background: #fbfcfa;
    transition: border-color .2s, box-shadow .2s;
}
.co-field input:focus,
.co-field textarea:focus {
    outline: none;
    border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92,184,92,0.13);
    background: #fff;
}

/* ── Payment method cards ───────────────────────────── */
.pay-methods { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }

.pay-card {
    border: 2px solid #e5ece2;
    border-radius: 9px;
    padding: 14px 16px;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    background: #fbfcfa;
    display: block;
}
.pay-card input[type=radio] { display: none; }
.pay-card:hover { border-color: #c3ddc0; }
.pay-card.selected { border-color: #5cb85c; background: #f0faf0; }
.pay-card.disabled { opacity: 0.52; cursor: not-allowed; }

.pay-card-inner {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pay-icon { font-size: 1.5rem; flex-shrink: 0; }

.pay-card-inner strong { display: block; color: #17351a; font-size: 0.95rem; font-weight: 900; }
.pay-card-inner span { display: block; color: #68746a; font-size: 0.8rem; margin-top: 2px; }

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

/* ── Payment panels ─────────────────────────────────── */
.pay-panel { border-radius: 9px; overflow: hidden; margin-top: 4px; border: 1px solid; }
.cod-panel { border-color: #ffd54f; }
.bank-panel { border-color: #90caf9; }

.panel-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    font-size: 0.88rem;
    font-weight: 900;
}
.cod-header { background: #fff8e1; color: #8a6200; }
.bank-header { background: #e3f2fd; color: #1565c0; }

.panel-body { padding: 18px 20px; background: #fff; }

/* COD specific */
.amount-highlight {
    background: #f8faf7;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 16px;
    text-align: center;
}
.amount-label { display: block; color: #68746a; font-size: 0.78rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.amount-value { display: block; color: #1a3a1a; font-size: 1.6rem; font-weight: 900; }
.amount-note { display: block; color: #9aaa95; font-size: 0.78rem; margin-top: 4px; }

.panel-desc { color: #5a6b5c; font-size: 0.88rem; margin: 0 0 14px; }

.operator-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.operator-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 8px;
    border: 2px solid;
}
.operator-card.yas { border-color: #e3f2fd; background: #f0f8ff; }
.operator-card.moov { border-color: #e8f5e9; background: #f0faf5; }

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
    width: 48px;
    height: 38px;
    border-radius: 8px;
    background: #fff;
    border: 1px solid #e0ece0;
    color: #d5a741;
    font-size: 0.68rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}
.op-logo.op-text {
    background: #1a3a1a;
    color: #d5a741;
}
.op-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 3px;
}
.operator-card strong { display: block; color: #17351a; font-size: 0.85rem; font-weight: 900; }
.op-num { display: block; color: #5cb85c; font-size: 0.88rem; font-weight: 900; margin-top: 2px; }

.txn-input { font-family: monospace; letter-spacing: 0.5px; }
.field-hint { margin: 4px 0 0; color: #9aaa95; font-size: 0.78rem; }

/* Bank transfer specific */
.bank-details { border: 1px solid #e8eee3; border-radius: 8px; overflow: hidden; margin-bottom: 14px; }
.bank-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 10px 14px;
    border-bottom: 1px solid #f0f4ef;
    font-size: 0.88rem;
}
.bank-row:last-child { border-bottom: none; }
.bank-row span { color: #68746a; font-weight: 700; }
.bank-row strong { color: #17351a; font-weight: 900; }
.bank-row.highlight { background: #f8faf7; }
.amount-green { color: #5cb85c; font-size: 1rem; }

.bank-notice {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 12px 14px;
    background: #fff8e1;
    border: 1px solid #ffd54f;
    border-radius: 8px;
    color: #5a4510;
    font-size: 0.83rem;
    line-height: 1.55;
}
.bank-notice i { color: #b8860b; flex-shrink: 0; margin-top: 2px; }
.bank-notice a { color: #1565c0; }

/* ── Right sidebar ──────────────────────────────────── */
.checkout-right { position: sticky; top: 90px; }
.summary-card { display: flex; flex-direction: column; gap: 0; }

.summary-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f4ef;
}
.s-img { width: 50px; height: 50px; border-radius: 7px; object-fit: cover; border: 1px solid #e5ece2; flex-shrink: 0; }
.s-info { flex: 1; min-width: 0; }
.s-info strong { display: block; color: #1a3a1a; font-size: 0.88rem; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.s-info span { color: #68746a; font-size: 0.78rem; }
.s-total { color: #17351a; font-size: 0.88rem; font-weight: 900; white-space: nowrap; }

.summary-totals { margin: 14px 0; display: flex; flex-direction: column; gap: 8px; }
.t-row { display: flex; justify-content: space-between; gap: 12px; font-size: 0.9rem; color: #5a6b5c; }
.t-row.grand { padding-top: 10px; border-top: 2px solid #e5ece2; font-weight: 900; color: #1a3a1a; font-size: 1rem; }
.t-row.cod-row { color: #b8860b; background: #fffde7; padding: 6px 10px; border-radius: 6px; font-weight: 700; }
.t-row.discount-row { color: #e53935; font-weight: 700; }
.cod-amount { color: #b8860b; font-weight: 900; }

.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    min-height: 50px;
    background: #1a3a1a;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 900;
    font-size: 1rem;
    cursor: pointer;
    transition: background .2s, transform .15s;
    margin-top: 6px;
}
.submit-btn:hover:not(:disabled) { background: #2d5a2d; transform: translateY(-1px); }
.submit-btn:disabled { opacity: 0.55; cursor: not-allowed; }

.mobile-submit { display: none; }

.back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 12px;
    color: #5cb85c;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
}
.back-link:hover { color: #1a3a1a; }

.trust-card {
    margin-top: 14px;
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 10px;
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.trust-item { display: flex; align-items: center; gap: 10px; color: #5a6b5c; font-size: 0.84rem; font-weight: 700; }
.trust-item i { color: #5cb85c; width: 16px; text-align: center; }

/* ── Responsive ─────────────────────────────────────── */
@media (max-width: 1024px) {
    .checkout-layout { grid-template-columns: 1fr; }
    .checkout-right { position: static; }
    .submit-btn:not(.mobile-submit) { display: none; }
    .mobile-submit { display: flex; }
}

@media (max-width: 640px) {
    .co-grid-2 { grid-template-columns: 1fr; }
    .co-full { grid-column: 1; }
    .operator-cards { grid-template-columns: 1fr; }
    .co-card { padding: 18px; }
}

/* ── Proof upload ───────────────────────────────────── */
.proof-zone {
    margin-top: 18px;
    background: #f8faf7;
    border: 1.5px dashed #b5cdb5;
    border-radius: 10px;
    padding: 16px 18px;
}
.proof-title {
    display: flex; align-items: center; gap: 8px;
    font-weight: 900; color: #1a3a1a; font-size: 0.9rem;
    margin-bottom: 6px;
}
.proof-title i { color: #5cb85c; }
.proof-optional { font-weight: 400; color: #9aaa95; font-size: 0.8rem; }
.proof-desc { color: #5a6b5c; font-size: 0.83rem; line-height: 1.5; margin: 0 0 12px; }
.proof-btns { display: flex; gap: 10px; flex-wrap: wrap; }
.proof-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border: 1.5px solid #b5cdb5;
    border-radius: 8px; background: #fff; color: #1a3a1a;
    font-size: 0.85rem; font-weight: 700; cursor: pointer;
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
    width: 64px; height: 64px; object-fit: cover;
    border-radius: 6px; border: 1px solid #e0ece0; flex-shrink: 0;
}
.proof-pdf-row {
    display: flex; align-items: center; gap: 10px;
    color: #e74c3c; font-size: 0.88rem; font-weight: 700;
}
.proof-remove {
    margin-left: auto; display: flex; align-items: center; gap: 5px;
    padding: 6px 12px; background: #fff0f0; border: 1px solid #f5a0a0;
    color: #b42323; border-radius: 6px; font-size: 0.8rem; font-weight: 700;
    cursor: pointer;
}
.proof-remove:hover { background: #ffe0e0; }
</style>
