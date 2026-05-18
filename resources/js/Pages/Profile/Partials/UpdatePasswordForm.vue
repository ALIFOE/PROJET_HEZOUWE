<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const showCurrent = ref(false);
const showNew = ref(false);
const showConfirm = ref(false);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section class="profile-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="far fa-lock"></i>
            </div>
            <div>
                <h2>Mot de passe</h2>
                <p>Utilisez un mot de passe long et unique pour sécuriser votre compte.</p>
            </div>
        </div>

        <form @submit.prevent="updatePassword" class="profile-form">
            <div class="form-group">
                <label for="current_password" class="field-label">
                    <i class="far fa-key"></i>
                    Mot de passe actuel
                </label>
                <div class="field-wrap">
                    <input
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        :type="showCurrent ? 'text' : 'password'"
                        class="field-input"
                        :class="{ 'field-error': form.errors.current_password }"
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button type="button" class="eye-btn" @click="showCurrent = !showCurrent" tabindex="-1">
                        <i class="far" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <InputError :message="form.errors.current_password" />
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="field-label">
                        <i class="far fa-lock-alt"></i>
                        Nouveau mot de passe
                    </label>
                    <div class="field-wrap">
                        <input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            :type="showNew ? 'text' : 'password'"
                            class="field-input"
                            :class="{ 'field-error': form.errors.password }"
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button type="button" class="eye-btn" @click="showNew = !showNew" tabindex="-1">
                            <i class="far" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <InputError :message="form.errors.password" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="field-label">
                        <i class="far fa-check-double"></i>
                        Confirmer le mot de passe
                    </label>
                    <div class="field-wrap">
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            :type="showConfirm ? 'text' : 'password'"
                            class="field-input"
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <button type="button" class="eye-btn" @click="showConfirm = !showConfirm" tabindex="-1">
                            <i class="far" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <InputError :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div class="security-tip">
                <i class="far fa-shield-alt"></i>
                <p>Choisissez au minimum 8 caractères avec des majuscules, chiffres et symboles.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save" :disabled="form.processing">
                    <i class="far" :class="form.processing ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                    {{ form.processing ? 'Mise à jour...' : 'Mettre à jour le mot de passe' }}
                </button>
                <Transition name="fade">
                    <span v-if="form.recentlySuccessful" class="saved-badge">
                        <i class="far fa-check"></i> Mot de passe mis à jour
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

.field-wrap {
    position: relative;
}

.field-input {
    width: 100%;
    padding: 11px 42px 11px 14px;
    border: 1.5px solid #dde8d9;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #1a3a1a;
    background: #fafcf9;
    transition: border-color 0.18s, box-shadow 0.18s;
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

.eye-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #8a9e8a;
    cursor: pointer;
    padding: 4px;
    font-size: 0.9rem;
    line-height: 1;
}

.eye-btn:hover { color: #1a3a1a; }

.security-tip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: #f5f9f4;
    border: 1px solid #e0ebd8;
    border-radius: 8px;
    color: #4a6b4a;
    font-size: 0.88rem;
}

.security-tip i { color: #5cb85c; flex-shrink: 0; }
.security-tip p { margin: 0; }

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

.btn-save:hover:not(:disabled) { background: #24562a; }
.btn-save:disabled { opacity: 0.6; cursor: not-allowed; }

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
