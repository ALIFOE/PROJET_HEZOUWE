<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Verification email" />

        <div class="auth-heading">
            <span>Derniere etape</span>
            <h2>Verifiez votre adresse email</h2>
            <p>
                Nous avons envoye un lien de verification a votre adresse. Cliquez dessus pour activer completement votre compte.
            </p>
        </div>

        <div v-if="verificationLinkSent" class="auth-alert success">
            Un nouveau lien de verification vient d'etre envoye a votre adresse email.
        </div>

        <form class="auth-form" @submit.prevent="submit">
            <button class="auth-submit" :class="{ loading: form.processing }" :disabled="form.processing">
                Renvoyer le lien de verification
            </button>

            <div class="auth-actions">
                <Link href="/" class="auth-link">Retour accueil</Link>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="auth-secondary"
                >
                    Se deconnecter
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';
</style>
