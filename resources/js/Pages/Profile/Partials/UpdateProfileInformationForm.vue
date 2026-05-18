<script setup>
import InputError from '@/Components/InputError.vue';
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
    <section class="profile-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="far fa-user"></i>
            </div>
            <div>
                <h2>Informations personnelles</h2>
                <p>Mettez à jour votre nom et votre adresse email.</p>
            </div>
        </div>

        <form @submit.prevent="form.patch(route('profile.update'))" class="profile-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="field-label">
                        <i class="far fa-id-card"></i>
                        Nom complet
                    </label>
                    <input
                        id="name"
                        type="text"
                        class="field-input"
                        :class="{ 'field-error': form.errors.name }"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Votre nom complet"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="form-group">
                    <label for="email" class="field-label">
                        <i class="far fa-envelope"></i>
                        Adresse email
                    </label>
                    <input
                        id="email"
                        type="email"
                        class="field-input"
                        :class="{ 'field-error': form.errors.email }"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="votre@email.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>
            </div>

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null" class="verify-alert">
                <i class="far fa-exclamation-triangle"></i>
                <div>
                    <p>Votre adresse email n'est pas vérifiée.</p>
                    <Link :href="route('verification.send')" method="post" as="button" class="verify-link">
                        Renvoyer l'email de vérification
                    </Link>
                </div>
            </div>

            <div v-if="props.status === 'verification-link-sent'" class="sent-alert">
                <i class="far fa-check-circle"></i>
                Un nouveau lien de vérification a été envoyé à votre adresse email.
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save" :disabled="form.processing">
                    <i class="far" :class="form.processing ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                    {{ form.processing ? 'Enregistrement...' : 'Enregistrer les modifications' }}
                </button>
                <Transition name="fade">
                    <span v-if="form.recentlySuccessful" class="saved-badge">
                        <i class="far fa-check"></i> Enregistré
                    </span>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
.profile-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(26, 58, 26, 0.06);
}

.card-header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 1px solid #f0f5ee;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #e8f5e8;
    color: #24782b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.card-header h2 {
    margin: 0 0 4px;
    color: #1a3a1a;
    font-size: 1.2rem;
    font-weight: 900;
}

.card-header p {
    margin: 0;
    color: #68746a;
    font-size: 0.9rem;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #1a3a1a;
    font-size: 0.88rem;
    font-weight: 800;
}

.field-label i {
    color: #5cb85c;
    font-size: 0.82rem;
}

.field-input {
    padding: 11px 14px;
    border: 1.5px solid #dde8d9;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #1a3a1a;
    background: #fafcf9;
    transition: border-color 0.18s, box-shadow 0.18s;
    width: 100%;
    box-sizing: border-box;
}

.field-input:focus {
    outline: none;
    border-color: #5cb85c;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.12);
}

.field-input.field-error {
    border-color: #e05252;
    background: #fff8f8;
}

.verify-alert {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px 16px;
    background: #fff8e6;
    border: 1px solid #f0c060;
    border-radius: 8px;
    color: #7a5700;
    font-size: 0.9rem;
}

.verify-alert i {
    color: #c08000;
    margin-top: 2px;
    flex-shrink: 0;
}

.verify-alert p {
    margin: 0 0 6px;
    font-weight: 700;
}

.verify-link {
    background: none;
    border: none;
    padding: 0;
    color: #a97816;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: underline;
    cursor: pointer;
}

.sent-alert {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: #e8f7e8;
    border: 1px solid #a8d8a8;
    border-radius: 8px;
    color: #24782b;
    font-size: 0.9rem;
    font-weight: 700;
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    padding-top: 4px;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    background: #1a3a1a;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 800;
    cursor: pointer;
    transition: background 0.18s;
}

.btn-save:hover:not(:disabled) {
    background: #24562a;
}

.btn-save:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.saved-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    background: #e8f7e8;
    border: 1px solid #a8d8a8;
    border-radius: 999px;
    color: #24782b;
    font-size: 0.85rem;
    font-weight: 800;
}

.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

@media (max-width: 640px) {
    .profile-card { padding: 20px; }
    .form-row { grid-template-columns: 1fr; }
    .btn-save { width: 100%; justify-content: center; }
}
</style>
