<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirmation" />

        <div class="auth-heading">
            <span>Zone securisee</span>
            <h2>Confirmez votre mot de passe</h2>
            <p>Cette action concerne une zone sensible de votre compte. Confirmez votre mot de passe pour continuer.</p>
        </div>

        <form class="auth-form" @submit.prevent="submit">
            <label class="auth-field" for="password">
                <span>Mot de passe</span>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="Votre mot de passe"
                >
                <InputError :message="form.errors.password" />
            </label>

            <button class="auth-submit" :class="{ loading: form.processing }" :disabled="form.processing">
                Confirmer
            </button>
        </form>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';
</style>
