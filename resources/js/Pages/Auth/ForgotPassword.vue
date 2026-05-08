<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Mot de passe oublie" />

        <div class="auth-heading">
            <span>Recuperation</span>
            <h2>Reinitialiser votre mot de passe</h2>
            <p>Indiquez votre email et nous vous enverrons un lien pour choisir un nouveau mot de passe.</p>
        </div>

        <div v-if="status" class="auth-alert success">
            {{ status }}
        </div>

        <form class="auth-form" @submit.prevent="submit">
            <label class="auth-field" for="email">
                <span>Email</span>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="votre@email.com"
                >
                <InputError :message="form.errors.email" />
            </label>

            <button class="auth-submit" :class="{ loading: form.processing }" :disabled="form.processing">
                Envoyer le lien
            </button>

            <p class="auth-switch">
                Vous vous souvenez du mot de passe ?
                <Link :href="route('login')">Retour connexion</Link>
            </p>
        </form>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';
</style>
