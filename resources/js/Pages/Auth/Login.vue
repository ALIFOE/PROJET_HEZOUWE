<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Connexion" />

        <div class="auth-heading">
            <span>Connexion</span>
            <h2>Bienvenue dans votre espace client</h2>
            <p>Connectez-vous pour retrouver votre panier, vos commandes et vos informations de livraison.</p>
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

            <label class="auth-field" for="password">
                <span>Mot de passe</span>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Votre mot de passe"
                >
                <InputError :message="form.errors.password" />
            </label>

            <div class="auth-options">
                <label class="auth-check">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span>Se souvenir de moi</span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')" class="auth-link">
                    Mot de passe oublie ?
                </Link>
            </div>

            <button class="auth-submit" :class="{ loading: form.processing }" :disabled="form.processing">
                Se connecter
            </button>

            <p class="auth-switch">
                Pas encore de compte ?
                <Link :href="route('register')">Creer un compte</Link>
            </p>
        </form>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';
</style>
