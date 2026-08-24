<template>
    <Transition name="loader-fade">
        <div v-if="loading" class="global-loader-overlay">
            <div class="global-loader-spinner"></div>
        </div>
    </Transition>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const loading = ref(false);
let removeStart, removeFinish;

onMounted(() => {
    removeStart = router.on('start', () => { loading.value = true; });
    removeFinish = router.on('finish', () => { loading.value = false; });
});

onUnmounted(() => {
    removeStart?.();
    removeFinish?.();
});
</script>

<style scoped>
.global-loader-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(23, 53, 26, 0.25);
    backdrop-filter: blur(1px);
}

.global-loader-spinner {
    width: 56px;
    height: 56px;
    border: 5px solid rgba(255, 255, 255, 0.35);
    border-top-color: #5cb85c;
    border-radius: 50%;
    animation: global-loader-spin 0.7s linear infinite;
}

@keyframes global-loader-spin {
    to { transform: rotate(360deg); }
}

.loader-fade-enter-active,
.loader-fade-leave-active {
    transition: opacity 0.15s ease;
}

.loader-fade-enter-from,
.loader-fade-leave-to {
    opacity: 0;
}
</style>
