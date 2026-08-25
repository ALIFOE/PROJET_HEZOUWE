<template>
    <AppLayout title="Paiement Mobile Money" :noindex="true">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Paiement Mobile Money</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Paiement Sécurisé</h1>
                </div>
            </div>
        </section>

        <section class="mm-section section-padding fix">
            <div class="container">
                <div class="mm-wrapper">

                    <div class="order-recap">
                        <div class="recap-header">
                            <i class="fas fa-receipt"></i>
                            Récapitulatif — Commande {{ order.order_number }}
                        </div>
                        <div class="recap-row"><span>Client</span><strong>{{ order.customer_name }}</strong></div>
                        <div class="recap-row"><span>Téléphone</span><strong>{{ order.customer_phone }}</strong></div>
                        <div class="recap-row"><span>Livraison</span><strong>{{ order.city }}</strong></div>
                        <div class="recap-row total-row">
                            <span>Total à payer</span>
                            <strong class="amount">{{ formatPrice(order.total) }} FCFA</strong>
                        </div>
                    </div>

                    <div class="pay-box">

                        <!-- Step: form -->
                        <template v-if="step === 'form'">
                            <div class="pay-box-header">
                                <span class="secure-badge"><i class="fas fa-lock"></i> Paiement sécurisé</span>
                                <h2>Payer avec Mobile Money</h2>
                                <p>Choisissez votre opérateur et votre numéro. Vous recevrez une demande de confirmation directement sur votre téléphone.</p>
                            </div>

                            <div class="operator-cards">
                                <button
                                    type="button"
                                    class="operator-card yas"
                                    :class="{ selected: gateway === 'mixx_yas' }"
                                    @click="gateway = 'mixx_yas'"
                                >
                                    <div class="op-logo"><img src="/assets/img/mixx-by-yas.png" alt="Mixx by YAS" class="op-img"></div>
                                    <div><strong>Mixx by YAS</strong><span class="op-num">Togocel</span></div>
                                    <i class="fas fa-check-circle op-check"></i>
                                </button>
                                <button
                                    type="button"
                                    class="operator-card moov"
                                    :class="{ selected: gateway === 'flooz' }"
                                    @click="gateway = 'flooz'"
                                >
                                    <div class="op-logo"><img src="/assets/img/flooz logo.png" alt="Flooz" class="op-img"></div>
                                    <div><strong>Flooz</strong><span class="op-num">Moov Africa</span></div>
                                    <i class="fas fa-check-circle op-check"></i>
                                </button>
                            </div>

                            <div class="phone-field">
                                <label>Numéro Mobile Money <span class="req">*</span></label>
                                <input
                                    v-model="phoneNumber"
                                    type="tel"
                                    inputmode="numeric"
                                    maxlength="8"
                                    placeholder="Ex: 90010203"
                                    class="phone-input"
                                    @input="phoneNumber = phoneNumber.replace(/\D/g, '').slice(0, 8)"
                                >
                                <p class="field-hint">8 chiffres, sans indicatif pays.</p>
                            </div>

                            <button
                                class="pay-btn"
                                :disabled="!canSubmit || loading"
                                @click="startPayment"
                            >
                                <span v-if="loading"><i class="fas fa-spinner fa-spin"></i> Envoi…</span>
                                <span v-else><i class="fas fa-mobile-alt"></i> Payer {{ formatPrice(order.total) }} FCFA</span>
                            </button>

                            <p v-if="errorMsg" class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ errorMsg }}</p>
                        </template>

                        <!-- Step: waiting for USSD confirmation -->
                        <template v-else-if="step === 'waiting'">
                            <div class="waiting-state">
                                <i class="fas fa-spinner fa-spin waiting-icon"></i>
                                <h2>En attente de confirmation…</h2>
                                <p>Une demande a été envoyée sur le <strong>{{ phoneNumber }}</strong>. Composez votre code secret Mobile Money sur votre téléphone pour valider le paiement.</p>
                            </div>
                        </template>

                        <!-- Step: success -->
                        <template v-else-if="step === 'success'">
                            <div class="result-state success">
                                <i class="fas fa-check-circle"></i>
                                <h2>Paiement reçu !</h2>
                                <p>Votre commande {{ order.order_number }} est confirmée. Redirection en cours…</p>
                            </div>
                        </template>

                        <!-- Step: error / timeout -->
                        <template v-else>
                            <div class="result-state error">
                                <i class="fas fa-times-circle"></i>
                                <h2>Paiement non confirmé</h2>
                                <p>{{ errorMsg || 'Nous n\'avons pas reçu de confirmation. Vérifiez votre solde et réessayez.' }}</p>
                                <button class="pay-btn" @click="resetForm">
                                    <i class="fas fa-redo"></i> Réessayer
                                </button>
                            </div>
                        </template>

                        <div class="help-text">
                            <i class="fas fa-info-circle"></i>
                            Un problème ? Contactez-nous au <strong>+228 70 67 94 48</strong> ou à
                            <a href="mailto:contact@hezouwe.com">contact@hezouwe.com</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, ref } from 'vue';

const props = defineProps({ order: Object });

const step        = ref('form'); // form | waiting | success | error
const gateway     = ref(null);
const phoneNumber = ref('');
const loading     = ref(false);
const errorMsg    = ref('');

let pollTimer  = null;
let pollsDone  = 0;
const MAX_POLLS = 22; // ~90s at 4s intervals

const canSubmit = computed(() => gateway.value && phoneNumber.value.length === 8);

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

const resetForm = () => {
    step.value = 'form';
    errorMsg.value = '';
};

const stopPolling = () => {
    if (pollTimer) {
        clearTimeout(pollTimer);
        pollTimer = null;
    }
};

const poll = async () => {
    try {
        const res = await window.axios.get(`/orders/${props.order.id}/payment-status`);
        if (res.data.payment_status === 'paid') {
            step.value = 'success';
            setTimeout(() => router.visit('/dashboard', { method: 'get' }), 2000);
            return;
        }
    } catch (err) {
        console.error(err);
    }

    pollsDone += 1;
    if (pollsDone >= MAX_POLLS) {
        step.value = 'error';
        errorMsg.value = 'Le délai de confirmation a expiré. Réessayez si le paiement n\'a pas abouti.';
        return;
    }

    pollTimer = setTimeout(poll, 4000);
};

const startPayment = async () => {
    loading.value = true;
    errorMsg.value = '';

    try {
        await window.axios.post('/kprimepay/initiate', {
            order_id:     props.order.id,
            gateway:      gateway.value,
            phone_number: phoneNumber.value,
        });

        pollsDone = 0;
        step.value = 'waiting';
        poll();
    } catch (err) {
        errorMsg.value = err.response?.data?.error || 'Impossible d\'initialiser le paiement. Réessayez.';
    } finally {
        loading.value = false;
    }
};

onBeforeUnmount(stopPolling);
</script>

<style scoped>
.mm-section { background: #f8faf8; }

.mm-wrapper {
    max-width: 780px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: start;
}

.order-recap {
    background: #fff;
    border: 1px solid #e0ece0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(23,53,26,.06);
}

.recap-header {
    background: #1a3a1a;
    color: #fff;
    padding: 16px 22px;
    font-weight: 700;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.recap-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 22px;
    border-bottom: 1px solid #f0f4f0;
    font-size: 0.92rem;
}

.recap-row span { color: #6c757d; }
.recap-row strong { color: #1a3a1a; }

.total-row {
    background: #f0faf0;
    padding: 16px 22px;
    border-bottom: none;
}

.amount {
    font-size: 1.3rem;
    color: #2d6a4f;
}

.pay-box {
    background: #fff;
    border: 1px solid #e0ece0;
    border-radius: 12px;
    padding: 30px 28px;
    box-shadow: 0 4px 16px rgba(23,53,26,.06);
    text-align: center;
}

.secure-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #d4edda;
    color: #155724;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    margin-bottom: 14px;
}

.pay-box h2 {
    font-size: 1.3rem;
    color: #1a3a1a;
    margin: 0 0 8px;
    font-weight: 900;
}

.pay-box p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0 0 20px;
}

.operator-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
.operator-card {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 8px;
    border: 2px solid;
    font-family: inherit;
    text-align: left;
    cursor: pointer;
    position: relative;
    background: #fafcfa;
    transition: border-color .15s, box-shadow .15s;
}
.operator-card.yas { border-color: #e3f2fd; background: #f0f8ff; }
.operator-card.moov { border-color: #e8f5e9; background: #f0faf5; }
.operator-card:hover { border-color: #5cb85c; }
.operator-card.selected { border-color: #5cb85c; box-shadow: 0 0 0 2px rgba(92,184,92,0.18); }
.op-check {
    display: none;
    margin-left: auto;
    color: #5cb85c;
    font-size: 1.1rem;
}
.operator-card.selected .op-check { display: block; }

.op-logo {
    width: 44px; height: 36px; border-radius: 6px;
    background: #fff; border: 1px solid #e0ece0;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; flex-shrink: 0;
}
.op-img { width: 100%; height: 100%; object-fit: contain; padding: 3px; }
.operator-card strong { display: block; color: #17351a; font-size: 0.84rem; font-weight: 900; }
.op-num { display: block; color: #5cb85c; font-size: 0.82rem; font-weight: 700; margin-top: 2px; }

.phone-field { text-align: left; margin-bottom: 20px; }
.phone-field label { display: block; font-weight: 800; color: #1a3a1a; font-size: 0.88rem; margin-bottom: 7px; }
.req { color: #b42323; }
.phone-input {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 8px;
    font-family: monospace; font-size: 1rem;
    color: #1a3a1a; background: #fff;
    outline: none; box-sizing: border-box; transition: border-color .15s;
}
.phone-input:focus { border-color: #2d6a4f; }
.field-hint { margin: 5px 0 0; color: #9aaa95; font-size: 0.78rem; }

.pay-btn {
    width: 100%;
    padding: 16px;
    background: #2d6a4f;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1.05rem;
    font-weight: 800;
    cursor: pointer;
    transition: background .2s, transform .1s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.pay-btn:hover:not(:disabled) { background: #1a3a1a; transform: translateY(-1px); }
.pay-btn:disabled { opacity: .6; cursor: not-allowed; }

.error-msg {
    margin-top: 14px;
    color: #dc3545;
    font-size: 0.88rem;
    display: flex;
    align-items: center;
    gap: 6px;
    justify-content: center;
}

.waiting-state, .result-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 10px 0 20px;
}
.waiting-icon { font-size: 2.4rem; color: #2d6a4f; margin-bottom: 10px; }
.waiting-state h2 { font-size: 1.2rem; color: #1a3a1a; margin: 0 0 6px; font-weight: 900; }
.waiting-state p { color: #6c757d; font-size: 0.9rem; margin: 0; }

.result-state i { font-size: 2.6rem; margin-bottom: 10px; }
.result-state h2 { font-size: 1.2rem; margin: 0 0 6px; font-weight: 900; }
.result-state p { color: #6c757d; font-size: 0.9rem; margin: 0 0 18px; }
.result-state.success i { color: #2d6a4f; }
.result-state.success h2 { color: #1a3a1a; }
.result-state.error i { color: #dc3545; }
.result-state.error h2 { color: #1a3a1a; }
.result-state .pay-btn { width: auto; padding: 12px 24px; }

.help-text {
    margin-top: 20px;
    font-size: 0.82rem;
    color: #6c757d;
}

.help-text a { color: #2d6a4f; }

@media (max-width: 700px) {
    .mm-wrapper { grid-template-columns: 1fr; }
}
</style>
