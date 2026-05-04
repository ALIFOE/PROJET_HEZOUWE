<template>
    <AppLayout title="Détails Projet">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/project">Projets</Link></li>
                        <li>//</li>
                        <li>Détails</li>
                    </ul>
                    <h1 class="breadcrumb-title">Détails Projet</h1>
                </div>
            </div>
        </section>
        <section class="section-padding">
            <div class="container">
                <p>Détails du projet de développement.</p>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
