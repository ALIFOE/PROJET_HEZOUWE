<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { QrcodeStream } from 'vue-qrcode-reader';
import axios from 'axios';

const props = defineProps({ order: Object });

const step = ref(props.order.delivery_verified_at ? 'already_done' : 'idle');
const errorMsg = ref('');
const scanning = ref(false);
const cameraError = ref('');

const startScan = () => {
    step.value = 'scanning';
    errorMsg.value = '';
};

const onDetect = async (detectedCodes) => {
    if (scanning.value) return;
    const code = detectedCodes[0]?.rawValue;
    if (!code) return;

    scanning.value = true;
    step.value = 'verifying';

    try {
        const resp = await axios.post(`/orders/${props.order.id}/verify-delivery`, {
            scanned_code: code,
        });
        if (resp.data.success) {
            step.value = 'success';
        } else {
            errorMsg.value = resp.data.message;
            step.value = 'error';
        }
    } catch {
        errorMsg.value = 'Erreur de connexion. Vérifiez votre connexion internet.';
        step.value = 'error';
    } finally {
        scanning.value = false;
    }
};

const onCameraError = (err) => {
    cameraError.value = err.name === 'NotAllowedError'
        ? "L'accès à la caméra a été refusé. Autorisez la caméra dans les paramètres de votre navigateur."
        : `Erreur caméra : ${err.message}`;
    step.value = 'camera_error';
};

const retry = () => {
    errorMsg.value = '';
    cameraError.value = '';
    scanning.value = false;
    step.value = 'scanning';
};
</script>

<template>
    <AppLayout title="Scanner le bon de livraison" :noindex="true">
        <div class="scan-page">

            <div class="scan-card">
                <div class="scan-header">
                    <div class="icon-wrap">
                        <i class="far fa-qrcode"></i>
                    </div>
                    <h1>Confirmer la réception</h1>
                    <p class="order-ref">Commande <strong>{{ order.order_number }}</strong></p>
                </div>

                <!-- Déjà confirmée -->
                <div v-if="step === 'already_done'" class="state-block success-block">
                    <div class="state-icon">✅</div>
                    <h2>Livraison déjà confirmée</h2>
                    <p>La réception de cette commande a déjà été confirmée. Merci !</p>
                </div>

                <!-- Idle - bouton démarrer -->
                <div v-else-if="step === 'idle'" class="state-block idle-block">
                    <div class="info-box">
                        <i class="far fa-info-circle"></i>
                        <div>
                            <strong>Comment ça fonctionne :</strong>
                            <p>Lorsque votre livreur arrive, demandez-lui de vous montrer son code QR.
                               Cliquez sur le bouton ci-dessous et pointez votre caméra sur le code QR du livreur.</p>
                        </div>
                    </div>

                    <div v-if="!order.delivery_token" class="no-token-box">
                        <i class="far fa-exclamation-triangle"></i>
                        <p>Le bon de livraison n'a pas encore été généré par l'équipe HEZOUWE.
                           Vous recevrez une notification dès qu'il sera disponible.</p>
                    </div>

                    <button v-else class="btn-scan" @click="startScan">
                        <i class="far fa-camera"></i>
                        Scanner le code QR du livreur
                    </button>
                </div>

                <!-- Caméra active -->
                <div v-else-if="step === 'scanning'" class="state-block camera-block">
                    <p class="camera-hint">
                        <i class="far fa-crosshairs"></i>
                        Pointez votre caméra vers le code QR du livreur
                    </p>
                    <div class="camera-frame">
                        <QrcodeStream
                            :constraints="{ facingMode: 'environment' }"
                            @detect="onDetect"
                            @error="onCameraError"
                            class="camera-stream"
                        />
                        <div class="scan-overlay">
                            <div class="scan-corner top-left"></div>
                            <div class="scan-corner top-right"></div>
                            <div class="scan-corner bottom-left"></div>
                            <div class="scan-corner bottom-right"></div>
                        </div>
                    </div>
                    <button class="btn-cancel-scan" @click="step = 'idle'">
                        Annuler
                    </button>
                </div>

                <!-- Vérification en cours -->
                <div v-else-if="step === 'verifying'" class="state-block verifying-block">
                    <div class="spin-icon"></div>
                    <h2>Vérification en cours...</h2>
                    <p>Validation du code QR avec votre commande.</p>
                </div>

                <!-- Succès -->
                <div v-else-if="step === 'success'" class="state-block success-block">
                    <div class="state-icon">🎉</div>
                    <h2>Livraison confirmée !</h2>
                    <p>Votre commande <strong>{{ order.order_number }}</strong> a été remise avec succès.
                       Merci de votre confiance !</p>
                    <a href="/dashboard" class="btn-dashboard">
                        <i class="far fa-home"></i>
                        Mon espace client
                    </a>
                </div>

                <!-- Erreur QR -->
                <div v-else-if="step === 'error'" class="state-block error-block">
                    <div class="state-icon">❌</div>
                    <h2>Code QR invalide</h2>
                    <p>{{ errorMsg }}</p>
                    <button class="btn-scan" @click="retry">
                        <i class="far fa-redo"></i>
                        Réessayer
                    </button>
                </div>

                <!-- Erreur caméra -->
                <div v-else-if="step === 'camera_error'" class="state-block error-block">
                    <div class="state-icon">📵</div>
                    <h2>Accès caméra impossible</h2>
                    <p>{{ cameraError }}</p>
                    <button class="btn-scan" @click="retry">
                        <i class="far fa-redo"></i>
                        Réessayer
                    </button>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
.scan-page {
    min-height: 80vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 40px 16px;
    background: #f0f4ef;
}

.scan-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(26, 58, 26, 0.12);
    width: 100%;
    max-width: 480px;
    overflow: hidden;
}

.scan-header {
    background: linear-gradient(135deg, #1a3a1a 0%, #2d6a4f 100%);
    padding: 36px 28px 28px;
    text-align: center;
}

.icon-wrap {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.8rem;
    color: #fff;
}

.scan-header h1 {
    color: #fff;
    font-size: 1.4rem;
    font-weight: 900;
    margin-bottom: 6px;
}

.order-ref {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.order-ref strong {
    color: #d5a741;
    font-family: monospace;
    font-size: 1rem;
}

.state-block {
    padding: 28px 28px 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    text-align: center;
}

.state-icon {
    font-size: 4rem;
    line-height: 1;
}

.state-block h2 {
    font-size: 1.3rem;
    font-weight: 900;
    color: #1a3a1a;
}

.state-block p {
    color: #5a6b5c;
    font-size: 0.95rem;
    line-height: 1.6;
    max-width: 360px;
}

.idle-block {
    align-items: stretch;
    text-align: left;
}

.info-box {
    display: flex;
    gap: 14px;
    background: #f0f8ff;
    border: 1px solid #bcd4f0;
    border-radius: 10px;
    padding: 16px;
    align-items: flex-start;
}

.info-box i {
    color: #1a6ba8;
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.info-box strong {
    display: block;
    color: #1a3a1a;
    font-size: 0.88rem;
    margin-bottom: 6px;
}

.info-box p {
    color: #5a6b5c;
    font-size: 0.85rem;
    line-height: 1.6;
    margin: 0;
}

.no-token-box {
    display: flex;
    gap: 12px;
    background: #fff8e1;
    border: 1px solid #f0c060;
    border-radius: 10px;
    padding: 16px;
    align-items: flex-start;
    color: #7a5700;
    font-size: 0.88rem;
    line-height: 1.6;
}

.no-token-box i {
    color: #c08000;
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.btn-scan {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    background: #2d6a4f;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 900;
    cursor: pointer;
    transition: background 0.18s;
}

.btn-scan:hover { background: #1a3a1a; }

.camera-block {
    padding: 20px 20px 28px;
    gap: 14px;
}

.camera-hint {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #2d6a4f;
    font-weight: 700;
    font-size: 0.9rem;
    text-align: center;
}

.camera-frame {
    position: relative;
    width: 100%;
    max-width: 360px;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
}

.camera-stream {
    width: 100%;
    height: 100%;
}

.scan-overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.scan-corner {
    position: absolute;
    width: 28px;
    height: 28px;
    border-color: #5cb85c;
    border-style: solid;
}

.scan-corner.top-left     { top: 12px; left: 12px; border-width: 3px 0 0 3px; }
.scan-corner.top-right    { top: 12px; right: 12px; border-width: 3px 3px 0 0; }
.scan-corner.bottom-left  { bottom: 12px; left: 12px; border-width: 0 0 3px 3px; }
.scan-corner.bottom-right { bottom: 12px; right: 12px; border-width: 0 3px 3px 0; }

.btn-cancel-scan {
    background: #fff;
    border: 1.5px solid #dfe8db;
    border-radius: 8px;
    padding: 10px 24px;
    color: #5a6b5c;
    font-weight: 700;
    cursor: pointer;
    font-size: 0.9rem;
}

.verifying-block {
    padding: 48px 28px;
}

.spin-icon {
    width: 56px;
    height: 56px;
    border: 5px solid #e5ece2;
    border-top-color: #2d6a4f;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

.success-block { background: #f5fdf5; }
.error-block   { background: #fff8f8; }

.success-block h2 { color: #24782b; }
.error-block h2   { color: #b42323; }

.btn-dashboard {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: #2d6a4f;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 900;
    font-size: 0.95rem;
    margin-top: 8px;
}

.btn-dashboard:hover { background: #1a3a1a; }

@media (max-width: 520px) {
    .scan-page { padding: 16px 8px; }
    .scan-card { border-radius: 12px; }
    .scan-header { padding: 28px 20px 22px; }
    .state-block { padding: 20px 20px 28px; }
}
</style>
