<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    title: { type: String, required: true },
    description: { type: String, default: '' },
    image: { type: String, default: '/assets/img/logo/logo_hezouwe.jpeg' },
    type: { type: String, default: 'website' },
    noindex: { type: Boolean, default: false },
    jsonld: { type: [Object, Array], default: null },
});

const SITE_NAME = 'COOP CA HEZOUWE';

const page = usePage();

const fullTitle = computed(() => (
    props.title.includes(SITE_NAME) ? props.title : `${props.title} | ${SITE_NAME}`
));

const canonicalUrl = computed(() => page.props.ziggy?.location ?? '');

const absoluteImage = computed(() => {
    if (/^https?:\/\//i.test(props.image)) {
        return props.image;
    }
    if (typeof window === 'undefined') {
        return props.image;
    }
    return `${window.location.origin}${props.image.startsWith('/') ? '' : '/'}${props.image}`;
});

const robotsContent = computed(() => (props.noindex ? 'noindex, nofollow' : 'index, follow'));

const jsonldContent = computed(() => (props.jsonld ? JSON.stringify(props.jsonld) : ''));
</script>

<template>
    <Head>
        <title>{{ fullTitle }}</title>
        <meta v-if="description" name="description" :content="description" />
        <meta name="robots" :content="robotsContent" />
        <link v-if="canonicalUrl" rel="canonical" :href="canonicalUrl" />

        <meta property="og:site_name" :content="SITE_NAME" />
        <meta property="og:title" :content="fullTitle" />
        <meta v-if="description" property="og:description" :content="description" />
        <meta property="og:type" :content="type" />
        <meta v-if="canonicalUrl" property="og:url" :content="canonicalUrl" />
        <meta property="og:image" :content="absoluteImage" />
        <meta property="og:locale" content="fr_FR" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="fullTitle" />
        <meta v-if="description" name="twitter:description" :content="description" />
        <meta name="twitter:image" :content="absoluteImage" />

        <script v-if="jsonld" type="application/ld+json" v-html="jsonldContent"></script>
    </Head>
</template>
