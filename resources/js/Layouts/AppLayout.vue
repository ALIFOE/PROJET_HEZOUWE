<template>
    <div>
        <!-- Back To Top Start -->
        <button id="back-top" class="back-to-top">
            <i class="far fa-arrow-up"></i>
        </button>

        <!-- MouseCursor Start -->
        <div class="mouseCursor cursor-outer"></div>
        <div class="mouseCursor cursor-inner"></div>

        <Header />

        <slot />

        <Footer />
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
</script>
