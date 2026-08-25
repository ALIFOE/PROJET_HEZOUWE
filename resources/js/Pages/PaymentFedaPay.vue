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

        <section class="fedapay-section section-padding fix">
            <div class="container">
                <div class="fedapay-wrapper">

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
                        <div class="pay-box-header">
                            <span class="secure-badge"><i class="fas fa-lock"></i> Paiement sécurisé</span>
                            <h2>Payer avec Mobile Money</h2>
                            <p>Cliquez sur le bouton ci-dessous. La fenêtre FedaPay s'ouvrira pour compléter votre paiement.</p>
                        </div>

                        <div class="operators-grid">
                            <div class="op-chip"><span class="op-text-badge">T₿</span> T-Money</div>
                            <div class="op-chip"><span class="op-text-badge">FL</span> Flooz</div>
                            <div class="op-chip"><span class="op-text-badge">W</span> Wave</div>
                        </div>

                        <button
                            class="pay-btn"
                            :disabled="loading || paid"
                            @click="startPayment"
                        >
                            <span v-if="paid"><i class="fas fa-check-circle"></i> Paiement reçu !</span>
                            <span v-else-if="loading"><i class="fas fa-spinner fa-spin"></i> Chargement…</span>
                            <span v-else><i class="fas fa-mobile-alt"></i> Payer {{ formatPrice(order.total) }} FCFA</span>
                        </button>

                        <p v-if="errorMsg" class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ errorMsg }}</p>

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
import { ref, onMounted } from 'vue';

const props = defineProps({ order: Object, fedapayPublicKey: String });

const loading = ref(false);
const paid    = ref(false);
const errorMsg = ref('');

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');

// Charger le SDK FedaPay dynamiquement
const loadFedaPaySDK = () => new Promise((resolve, reject) => {
    if (window.FedaPay) return resolve();
    const script = document.createElement('script');
    script.src = 'https://cdn.fedapay.com/checkout.js?v=1.1.7';
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
});

const startPayment = async () => {
    loading.value = true;
    errorMsg.value = '';

    try {
        await loadFedaPaySDK();

        const res = await window.axios.post('/fedapay/initiate', {
            order_id: props.order.id,
        });

        const { token } = res.data;

        window.FedaPay.init({
            public_key:   props.fedapayPublicKey,
            transaction:  { token },
            onComplete(resp) {
                if (resp.reason === FedaPay.DIALOG_DISMISSED) {
                    errorMsg.value = 'Paiement annulé. Réessayez quand vous voulez.';
                } else if (resp.transaction?.status === 'approved') {
                    paid.value = true;
                    setTimeout(() => {
                        router.visit('/dashboard', { method: 'get' });
                    }, 2000);
                } else {
                    errorMsg.value = 'Le paiement n\'a pas abouti. Vérifiez votre solde et réessayez.';
                }
            },
        }).open();

    } catch (err) {
        errorMsg.value = 'Impossible d\'initialiser le paiement. Réessayez ou contactez-nous.';
        console.error(err);
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.fedapay-section { background: #f8faf8; }

.fedapay-wrapper {
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

.operators-grid {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 24px;
}

.op-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #f0f4f0;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #1a3a1a;
}

.op-text-badge {
    background: #2d6a4f;
    color: #fff;
    border-radius: 6px;
    padding: 2px 6px;
    font-size: 0.72rem;
}

.op-logo-img {
    height: 22px;
    width: auto;
    object-fit: contain;
    border-radius: 4px;
    background: #fff;
    padding: 1px 3px;
    border: 1px solid #d0dfd0;
}

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
}

.help-text {
    margin-top: 20px;
    font-size: 0.82rem;
    color: #6c757d;
}

.help-text a { color: #2d6a4f; }

@media (max-width: 700px) {
    .fedapay-wrapper { grid-template-columns: 1fr; }
}
</style>
