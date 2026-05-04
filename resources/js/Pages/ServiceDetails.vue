<template>
    <AppLayout title="Détails Service">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/service">Services</Link></li>
                        <li>//</li>
                        <li>Détails</li>
                    </ul>
                    <h1 class="breadcrumb-title">Détails Service</h1>
                </div>
            </div>
        </section>
        <section class="section-padding">
            <div class="container">
                <p>Détails de nos services de transformation du riz.</p>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
