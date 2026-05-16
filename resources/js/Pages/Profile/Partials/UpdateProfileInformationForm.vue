<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="profile-section">
        <header class="profile-header">
            <h2>Informations du profil</h2>
            <p>Mettez à jour les informations de votre compte et votre adresse email.</p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="profile-form">
            <div class="form-group">
                <InputLabel for="name" value="Nom complet" />

                <TextInput
                    id="name"
                    type="text"
                    class="form-input"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="form-group">
                <InputLabel for="email" value="Adresse email" />

                <TextInput
                    id="email"
                    type="email"
                    class="form-input"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null" class="verification-warning">
                <p class="text-sm">
                    Votre adresse email n'est pas vérifiée.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="verification-link"
                    >
                        Cliquez ici pour renvoyer l'email de vérification.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="verification-sent"
                >
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" :disabled="form.processing">
                    <span v-if="form.processing">Enregistrement...</span>
                    <span v-else>Enregistrer</span>
                </button>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="success-message">Enregistré avec succès.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
.profile-section {
    background: #fff;
    border: 1px solid #e8eee3;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 2px 8px rgba(27, 58, 28, 0.05);
}

.profile-header {
    margin-bottom: 32px;
}

.profile-header h2 {
    margin: 0 0 8px;
    color: #1a3a1a;
    font-size: 1.5rem;
    font-weight: 900;
}

.profile-header p {
    margin: 0;
    color: #6b7280;
    font-size: 0.95rem;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e8eee3;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.1);
}

.verification-warning {
    padding: 16px;
    background: #fff5d9;
    border: 1px solid #f5d5a8;
    border-radius: 8px;
}

.verification-warning p {
    margin: 0 0 8px;
    color: #9a6b12;
    font-size: 0.9rem;
}

.verification-link {
    color: #a97816;
    font-weight: 700;
    text-decoration: underline;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}

.verification-link:hover {
    color: #8a6a12;
}

.verification-sent {
    margin-top: 8px;
    padding: 8px 12px;
    background: #e7f7e7;
    color: #24782b;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 8px;
}

.btn-submit {
    padding: 12px 24px;
    background: #5cb85c;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit:hover:not(:disabled) {
    background: #4a9e4a;
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.success-message {
    color: #2d7a2d;
    font-size: 0.9rem;
    font-weight: 600;
}

@media (max-width: 640px) {
    .profile-section {
        padding: 20px;
    }

    .profile-header h2 {
        font-size: 1.25rem;
    }

    .form-actions {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-submit {
        width: 100%;
    }
}
</style>
