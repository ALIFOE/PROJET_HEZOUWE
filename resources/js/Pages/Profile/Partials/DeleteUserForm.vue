<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({ password: '' });

const openModal = () => {
    confirmingDeletion.value = true;
    nextTick(() => passwordInput.value?.focus());
};

const closeModal = () => {
    confirmingDeletion.value = false;
    form.reset();
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: closeModal,
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <section class="danger-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="far fa-trash-alt"></i>
            </div>
            <div>
                <h2>Supprimer le compte</h2>
                <p>Une fois supprimé, toutes vos données seront définitivement effacées.</p>
            </div>
        </div>

        <div class="danger-body">
            <p class="danger-text">
                Avant de supprimer votre compte, pensez à sauvegarder les données importantes
                (historique de commandes, etc.). Cette action est <strong>irréversible</strong>.
            </p>
            <button type="button" class="btn-danger" @click="openModal">
                <i class="far fa-trash-alt"></i>
                Supprimer mon compte
            </button>
        </div>
    </section>

    <!-- Modal overlay -->
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="confirmingDeletion" class="modal-overlay" @click.self="closeModal">
                <div class="modal-box">
                    <div class="modal-header">
                        <div class="modal-icon">
                            <i class="far fa-exclamation-triangle"></i>
                        </div>
                        <h3>Confirmer la suppression</h3>
                        <button type="button" class="modal-close" @click="closeModal">
                            <i class="far fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Êtes-vous sûr(e) de vouloir supprimer votre compte ? Toutes vos
                        données, commandes et informations seront définitivement effacées.</p>

                        <div class="form-group">
                            <label for="delete_password" class="field-label">
                                <i class="far fa-lock"></i>
                                Entrez votre mot de passe pour confirmer
                            </label>
                            <input
                                id="delete_password"
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                class="field-input"
                                :class="{ 'field-error': form.errors.password }"
                                placeholder="Votre mot de passe actuel"
                                @keyup.enter="deleteUser"
                            />
                            <InputError :message="form.errors.password" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" @click="closeModal">
                            Annuler
                        </button>
                        <button
                            type="button"
                            class="btn-confirm-delete"
                            :disabled="form.processing"
                            @click="deleteUser"
                        >
                            <i class="far" :class="form.processing ? 'fa-spinner fa-spin' : 'fa-trash-alt'"></i>
                            {{ form.processing ? 'Suppression...' : 'Oui, supprimer mon compte' }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.danger-card {
    background: #fff;
    border: 1px solid #ffd4d4;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(180, 35, 35, 0.06);
}

.card-header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #ffeaea;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #ffe8e8;
    color: #b42323;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.card-header h2 {
    margin: 0 0 4px;
    color: #b42323;
    font-size: 1.2rem;
    font-weight: 900;
}

.card-header p {
    margin: 0;
    color: #9a6868;
    font-size: 0.9rem;
}

.danger-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
}

.danger-text {
    margin: 0;
    color: #68746a;
    font-size: 0.92rem;
    line-height: 1.6;
    max-width: 480px;
}

.btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: #fff;
    color: #b42323;
    border: 1.5px solid #ffd4d4;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
}

.btn-danger:hover {
    background: #b42323;
    color: #fff;
    border-color: #b42323;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-box {
    background: #fff;
    border-radius: 14px;
    width: 100%;
    max-width: 480px;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.modal-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 24px 24px 20px;
    border-bottom: 1px solid #ffeaea;
    background: #fff8f8;
}

.modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #ffe8e8;
    color: #b42323;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.modal-header h3 {
    margin: 0;
    color: #b42323;
    font-size: 1.1rem;
    font-weight: 900;
    flex: 1;
}

.modal-close {
    background: none;
    border: none;
    color: #9a8888;
    cursor: pointer;
    font-size: 1rem;
    padding: 4px;
    line-height: 1;
}

.modal-close:hover { color: #b42323; }

.modal-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.modal-body > p {
    margin: 0;
    color: #68746a;
    font-size: 0.92rem;
    line-height: 1.6;
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

.field-label i { color: #b42323; font-size: 0.82rem; }

.field-input {
    width: 100%;
    padding: 11px 14px;
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
    border-color: #e05252;
    box-shadow: 0 0 0 3px rgba(224, 82, 82, 0.12);
}

.field-input.field-error { border-color: #e05252; background: #fff8f8; }

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #f5e8e8;
    background: #fdfafa;
}

.btn-cancel {
    padding: 10px 20px;
    background: #fff;
    color: #68746a;
    border: 1.5px solid #dde8d9;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
}

.btn-cancel:hover { background: #f5f7f4; }

.btn-confirm-delete {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #b42323;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 800;
    cursor: pointer;
    transition: background 0.18s;
}

.btn-confirm-delete:hover:not(:disabled) { background: #921c1c; }
.btn-confirm-delete:disabled { opacity: 0.6; cursor: not-allowed; }

/* Transition */
.modal-enter-active, .modal-leave-active { transition: opacity 0.22s; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .modal-box, .modal-leave-active .modal-box { transition: transform 0.22s; }
.modal-enter-from .modal-box { transform: scale(0.95) translateY(10px); }
.modal-leave-to .modal-box { transform: scale(0.95) translateY(10px); }

@media (max-width: 640px) {
    .danger-card { padding: 20px; }
    .danger-body { flex-direction: column; align-items: flex-start; }
    .btn-danger { width: 100%; justify-content: center; }
    .modal-footer { flex-direction: column-reverse; }
    .btn-cancel, .btn-confirm-delete { width: 100%; justify-content: center; }
}
</style>
