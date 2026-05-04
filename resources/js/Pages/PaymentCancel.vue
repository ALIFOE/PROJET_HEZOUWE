<template>
    <AppLayout title="Paiement Annulé">
        <section class="section-padding">
            <div class="container">
                <div class="text-center">
                    <h1 style="color: red;">✗ Paiement Annulé</h1>
                    <p>Le paiement a été annulé. Vous pouvez réessayer ultérieurement.</p>
                    <Link href="/shop" class="theme-btn">Retour à la Boutique</Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
