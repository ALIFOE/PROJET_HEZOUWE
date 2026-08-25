<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import QRCode from 'qrcode';

const props = defineProps({
    order_number: String,
    token: String,
    already_used: Boolean,
});

const qrDataUrl = ref('');

onMounted(async () => {
    if (!props.already_used) {
        qrDataUrl.value = await QRCode.toDataURL(props.order_number, {
            width: 300,
            margin: 2,
            color: { dark: '#1a3a1a', light: '#ffffff' },
            errorCorrectionLevel: 'H',
        });
    }
});
</script>

<template>
    <Head>
        <title>Bon de Livraison | COOP CA HEZOUWE</title>
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    <div class="delivery-page">
        <div class="delivery-card">
            <div class="delivery-header">
                <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="HEZOUWE" class="logo">
                <h1>BON DE LIVRAISON</h1>
                <p class="coop-name">COOP CA HEZOUWE</p>
            </div>

            <template v-if="already_used">
                <div class="already-used">
                    <div class="check-icon">✅</div>
                    <h2>Livraison confirmée</h2>
                    <p>Ce bon de livraison a déjà été utilisé et la réception a été confirmée par le client.</p>
                </div>
            </template>

            <template v-else>
                <div class="qr-section">
                    <div v-if="qrDataUrl" class="qr-wrapper">
                        <img :src="qrDataUrl" class="qr-code" alt="QR Code de livraison">
                    </div>
                    <div v-else class="qr-loading">
                        <div class="spinner"></div>
                        <p>Génération du code QR...</p>
                    </div>

                    <div class="order-number-display">
                        <span class="on-label">Numéro de commande</span>
                        <strong class="order-num">{{ order_number }}</strong>
                    </div>

                    <div class="instructions-box">
                        <p>
                            <strong>Instructions :</strong> Présentez ce code QR au client.
                            Il devra le scanner depuis son email ou son espace client pour confirmer la réception.
                        </p>
                    </div>
                </div>
            </template>

            <div class="delivery-footer">
                <span>Bon de livraison unique · Usage unique · COOP CA HEZOUWE</span>
            </div>
        </div>
    </div>
</template>

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #e8f0e8; font-family: 'Segoe UI', Arial, sans-serif; min-height: 100vh; }
</style>

<style scoped>
.delivery-page {
    min-height: 100vh;
    background: #e8f0e8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
}

.delivery-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(26, 58, 26, 0.15);
    width: 100%;
    max-width: 420px;
    overflow: hidden;
}

.delivery-header {
    background: #1a3a1a;
    padding: 28px 24px 22px;
    text-align: center;
}

.logo {
    height: 56px;
    width: auto;
    border-radius: 8px;
    margin-bottom: 12px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.delivery-header h1 {
    color: #fff;
    font-size: 1.3rem;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.coop-name {
    color: #d5a741;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.qr-section {
    padding: 28px 24px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.qr-wrapper {
    padding: 12px;
    border: 3px solid #1a3a1a;
    border-radius: 12px;
    background: #fff;
}

.qr-code {
    display: block;
    width: 260px;
    height: 260px;
}

.qr-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 40px 0;
    color: #68746a;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e5ece2;
    border-top-color: #1a3a1a;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

.order-number-display {
    text-align: center;
}

.on-label {
    display: block;
    color: #68746a;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
}

.order-num {
    display: block;
    font-family: monospace;
    font-size: 1.5rem;
    font-weight: 900;
    color: #1a3a1a;
    letter-spacing: 2px;
    background: #f0faf0;
    padding: 10px 20px;
    border-radius: 8px;
    border: 2px solid #a8d8a8;
}

.instructions-box {
    background: #fffbea;
    border: 1px solid #f0c060;
    border-radius: 8px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: #7a5700;
    line-height: 1.6;
    text-align: center;
}

.already-used {
    padding: 48px 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.check-icon {
    font-size: 4rem;
    line-height: 1;
}

.already-used h2 {
    color: #24782b;
    font-size: 1.5rem;
    font-weight: 900;
}

.already-used p {
    color: #68746a;
    font-size: 0.95rem;
    line-height: 1.6;
}

.delivery-footer {
    background: #f0f4ef;
    border-top: 1px solid #e5ece2;
    padding: 12px 24px;
    text-align: center;
    font-size: 0.75rem;
    color: #9aaa95;
    font-weight: 600;
}
</style>
