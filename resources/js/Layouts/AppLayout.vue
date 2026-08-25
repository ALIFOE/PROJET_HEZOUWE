<template>
    <div>
        <SeoHead
            :title="title"
            :description="description"
            :image="image"
            :type="type"
            :noindex="noindex"
            :jsonld="jsonld"
        />

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

        <GlobalLoader />
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import GlobalLoader from '@/Components/GlobalLoader.vue';
import SeoHead from '@/Components/SeoHead.vue';

defineProps({
    title: { type: String, required: true },
    description: {
        type: String,
        default: "COOP CA HEZOUWE est une coopérative togolaise dédiée à la transformation et à la commercialisation du riz local, au service des producteurs et des consommateurs.",
    },
    image: { type: String, default: '/assets/img/logo/logo_hezouwe.jpeg' },
    type: { type: String, default: 'website' },
    noindex: { type: Boolean, default: false },
    jsonld: { type: [Object, Array], default: null },
});
</script>
