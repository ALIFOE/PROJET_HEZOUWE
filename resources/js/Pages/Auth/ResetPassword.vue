<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Nouveau mot de passe" />

        <div class="auth-heading">
            <span>Securite</span>
            <h2>Choisir un nouveau mot de passe</h2>
            <p>Votre nouveau mot de passe protegera votre panier, vos commandes et vos informations client.</p>
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

            <label class="auth-field" for="password">
                <span>Nouveau mot de passe</span>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Nouveau mot de passe"
                >
                <InputError :message="form.errors.password" />
            </label>

            <label class="auth-field" for="password_confirmation">
                <span>Confirmation</span>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirmez le mot de passe"
                >
                <InputError :message="form.errors.password_confirmation" />
            </label>

            <button class="auth-submit" :class="{ loading: form.processing }" :disabled="form.processing">
                Enregistrer le mot de passe
            </button>
        </form>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';
</style>
