<template>
    <AppLayout title="Paiement Réussi" :noindex="true">
        <section class="section-padding">
            <div class="container">
                <div class="text-center">
                    <h1 style="color: green;">✓ Paiement Réussi!</h1>
                    <p>Merci pour votre commande. Vous recevrez un email de confirmation.</p>
                    <Link href="/" class="theme-btn">Retour à l'Accueil</Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
