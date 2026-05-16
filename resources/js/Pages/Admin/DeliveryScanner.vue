<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { QrcodeStream } from 'vue-qr-reader';

const scanning = ref(true);
const result = ref(null);
const error = ref(null);
const success = ref(false);

const onDetect = async (detectedCodes) => {
    if (detectedCodes && detectedCodes.length > 0) {
        const code = detectedCodes[0].rawValue;
        scanning.value = false;
        result.value = code;
        await processQRCode(code);
    }
};

const processQRCode = async (qrData) => {
    try {
        const response = await fetch(qrData, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();
        
        if (data.success) {
            success.value = true;
            error.value = null;
        } else {
            error.value = data.error || 'Erreur lors du traitement du code QR';
        }
    } catch (err) {
        error.value = 'Erreur de connexion au serveur';
    }
};

const startScanning = () => {
    scanning.value = true;
    result.value = null;
    error.value = null;
    success.value = false;
};

onMounted(() => {
    // Request camera permissions on mount
});

onUnmounted(() => {
    // Cleanup if needed
});
</script>

<template>
    <Head title="Scanner de Livraison" />

    <AdminLayout title="Scanner de Livraison">
        <div class="scanner-page">
            <div class="scanner-container">
                <h1>Scanner de Code QR</h1>
                <p>Scannez le code QR du client pour marquer la commande comme livrée</p>

                <div v-if="scanning" class="scanner-wrapper">
                    <QrcodeStream
                        @detect="onDetect"
                        :track="true"
                        :camera="true"
                    />
                </div>

                <div v-if="result" class="result-container">
                    <div v-if="success" class="success-message">
                        <i class="far fa-check-circle"></i>
                        <h3>Commande livrée avec succès !</h3>
                        <p>Le statut de la commande a été mis à jour.</p>
                        <button @click="startScanning" class="btn-primary">Scanner une autre commande</button>
                    </div>

                    <div v-else-if="error" class="error-message">
                        <i class="far fa-exclamation-circle"></i>
                        <h3>Erreur</h3>
                        <p>{{ error }}</p>
                        <button @click="startScanning" class="btn-primary">Réessayer</button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.scanner-page {
    padding: 32px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.scanner-container h1 {
    margin: 0 0 8px;
    color: #1a3a1a;
    font-size: 1.75rem;
    font-weight: 900;
}

.scanner-container p {
    margin: 0 0 24px;
    color: #6b7280;
    font-size: 1rem;
}

.scanner-wrapper {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    border: 2px solid #e8eee3;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
}

.result-container {
    max-width: 500px;
    margin: 24px auto 0;
    text-align: center;
}

.success-message,
.error-message {
    padding: 32px;
    border-radius: 12px;
}

.success-message {
    background: #e7f7e7;
    border: 1px solid #c8e6c8;
}

.success-message i {
    color: #24782b;
    font-size: 3rem;
    margin-bottom: 16px;
}

.success-message h3 {
    margin: 0 0 8px;
    color: #1a3a1a;
    font-size: 1.25rem;
    font-weight: 900;
}

.success-message p {
    margin: 0 0 16px;
    color: #6b7280;
}

.error-message {
    background: #fee;
    border: 1px solid #fcc;
}

.error-message i {
    color: #c33;
    font-size: 3rem;
    margin-bottom: 16px;
}

.error-message h3 {
    margin: 0 0 8px;
    color: #1a3a1a;
    font-size: 1.25rem;
    font-weight: 900;
}

.error-message p {
    margin: 0 0 16px;
    color: #6b7280;
}

.btn-primary {
    padding: 12px 24px;
    background: #5cb85c;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #4a9e4a;
}

@media (max-width: 640px) {
    .scanner-page {
        padding: 20px;
    }

    .scanner-container h1 {
        font-size: 1.5rem;
    }
}
</style>
