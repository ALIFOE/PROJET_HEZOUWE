<template>
    <AppLayout title="Paiement en ligne" :noindex="true">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Paiement en ligne</li>
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

                        <!-- Step: redirecting to KPRIMEPAY -->
                        <template v-if="step === 'redirecting'">
                            <div class="waiting-state">
                                <i class="fas fa-spinner fa-spin waiting-icon"></i>
                                <h2>Redirection en cours…</h2>
                                <p>Vous allez être redirigé vers la page de paiement sécurisée KPRIMEPAY (carte bancaire ou Mobile Money).</p>
                            </div>
                        </template>

                        <!-- Step: waiting for confirmation -->
                        <template v-else-if="step === 'waiting'">
                            <div class="waiting-state">
                                <i class="fas fa-spinner fa-spin waiting-icon"></i>
                                <h2>En attente de confirmation…</h2>
                                <p>Nous vérifions le paiement de votre commande <strong>{{ order.order_number }}</strong> auprès de KPRIMEPAY.</p>
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
                                <button class="pay-btn" :disabled="loading" @click="startCheckout">
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
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({ order: Object });

const step     = ref('redirecting'); // redirecting | waiting | success | error
const loading  = ref(false);
const errorMsg = ref('');

let pollTimer  = null;
let pollsDone  = 0;
const MAX_POLLS = 22; // ~90s at 4s intervals

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

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

const startCheckout = async () => {
    loading.value = true;
    errorMsg.value = '';
    step.value = 'redirecting';

    try {
        const res = await window.axios.post('/kprimepay/checkout', { order_id: props.order.id });
        window.location.href = res.data.checkout_url;
    } catch (err) {
        errorMsg.value = err.response?.data?.error || 'Impossible d\'initialiser le paiement en ligne. Réessayez.';
        step.value = 'error';
        loading.value = false;
    }
};

onMounted(() => {
    if (props.order.payment_status === 'paid') {
        step.value = 'success';
        return;
    }

    if (props.order.transaction_id) {
        // Retour depuis KPRIMEPAY, ou re-visite de cette page : on vérifie l'état réel.
        step.value = 'waiting';
        pollsDone = 0;
        poll();
        return;
    }

    startCheckout();
});

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

.pay-btn {
    width: auto;
    padding: 12px 24px;
    background: #2d6a4f;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1.05rem;
    font-weight: 800;
    cursor: pointer;
    transition: background .2s, transform .1s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.pay-btn:hover:not(:disabled) { background: #1a3a1a; transform: translateY(-1px); }
.pay-btn:disabled { opacity: .6; cursor: not-allowed; }

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
