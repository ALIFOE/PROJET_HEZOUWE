<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ user: Object });

const showPassword = ref(false);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role || 'user',
    password: '',
    password_confirmation: '',
});

const submit = () => form.put(`/admin/users/${props.user.id}`);

const initials = (name) => name ? name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase() : '?';
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : '—';
</script>

<template>
    <Head :title="`Modifier ${user.name}`" />
    <AdminLayout :title="`Modifier ${user.name}`">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Modification utilisateur</p>
                    <h1>{{ user.name }}</h1>
                </div>
                <div class="header-actions">
                    <Link :href="`/admin/users/${user.id}`" class="btn-secondary">
                        <i class="far fa-eye"></i> Voir le profil
                    </Link>
                    <Link href="/admin/users" class="btn-secondary">
                        <i class="far fa-arrow-left"></i> Retour
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="edit-layout">
                <div class="form-main">

                    <!-- Informations générales -->
                    <section class="form-card">
                        <div class="card-header">
                            <h2>Informations générales</h2>
                            <span>ID #{{ user.id }}</span>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>Nom complet *</label>
                                <input v-model="form.name" type="text" required placeholder="Prénom Nom">
                                <span v-if="form.errors.name" class="error">{{ form.errors.name }}</span>
                            </div>
                            <div class="form-group">
                                <label>Adresse email *</label>
                                <input v-model="form.email" type="email" required placeholder="email@exemple.com">
                                <span v-if="form.errors.email" class="error">{{ form.errors.email }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Rôle *</label>
                            <div class="role-picker">
                                <label class="role-option" :class="{ selected: form.role === 'user' }">
                                    <input v-model="form.role" type="radio" value="user">
                                    <div class="role-card">
                                        <i class="fas fa-user role-icon user-icon"></i>
                                        <div>
                                            <strong>Utilisateur</strong>
                                            <span>Accès à la boutique, commandes personnelles uniquement.</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="role-option" :class="{ selected: form.role === 'admin' }">
                                    <input v-model="form.role" type="radio" value="admin">
                                    <div class="role-card">
                                        <i class="fas fa-shield-alt role-icon admin-icon"></i>
                                        <div>
                                            <strong>Administrateur</strong>
                                            <span>Accès complet au panneau d'administration.</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <span v-if="form.errors.role" class="error">{{ form.errors.role }}</span>
                        </div>
                    </section>

                    <!-- Mot de passe -->
                    <section class="form-card">
                        <div class="card-header">
                            <h2>Réinitialiser le mot de passe</h2>
                            <span class="optional-label">Optionnel</span>
                        </div>
                        <p class="help-text">Laisser vide pour conserver le mot de passe actuel.</p>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>Nouveau mot de passe</label>
                                <div class="password-field">
                                    <input
                                        v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        placeholder="8 caractères minimum"
                                        autocomplete="new-password"
                                    >
                                    <button type="button" class="show-pw" @click="showPassword = !showPassword" :title="showPassword ? 'Masquer' : 'Afficher'">
                                        <i :class="['fas', showPassword ? 'fa-eye-slash' : 'fa-eye']"></i>
                                    </button>
                                </div>
                                <span v-if="form.errors.password" class="error">{{ form.errors.password }}</span>
                            </div>
                            <div class="form-group">
                                <label>Confirmer le mot de passe</label>
                                <input
                                    v-model="form.password_confirmation"
                                    :type="showPassword ? 'text' : 'password'"
                                    placeholder="Répétez le mot de passe"
                                    autocomplete="new-password"
                                >
                                <span v-if="form.errors.password_confirmation" class="error">{{ form.errors.password_confirmation }}</span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <aside class="form-side">
                    <section class="profile-summary">
                        <div class="summary-avatar" :class="user.role === 'admin' ? 'avatar-admin' : 'avatar-user'">
                            {{ initials(user.name) }}
                        </div>
                        <h3>{{ form.name || user.name }}</h3>
                        <p>{{ form.email || user.email }}</p>
                        <span :class="['role-pill', form.role === 'admin' ? 'role-admin' : 'role-user']">
                            <i :class="['fas', form.role === 'admin' ? 'fa-shield-alt' : 'fa-user']"></i>
                            {{ form.role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                        </span>
                        <div class="summary-meta">
                            <div class="meta-row">
                                <i class="far fa-calendar-alt"></i>
                                <span>Inscrit le {{ formatDate(user.created_at) }}</span>
                            </div>
                            <div class="meta-row">
                                <i :class="['far', user.email_verified_at ? 'fa-check-circle' : 'fa-times-circle']"
                                   :style="{ color: user.email_verified_at ? '#24782b' : '#9aaa95' }"></i>
                                <span>Email {{ user.email_verified_at ? 'vérifié' : 'non vérifié' }}</span>
                            </div>
                            <div class="meta-row">
                                <i class="fas fa-shopping-bag"></i>
                                <span>{{ user.orders_count }} commande(s)</span>
                            </div>
                        </div>
                    </section>

                    <div class="form-actions side-actions">
                        <button type="submit" class="btn-primary full" :disabled="form.processing">
                            <i class="far fa-save"></i>
                            {{ form.processing ? 'Enregistrement…' : 'Enregistrer les modifications' }}
                        </button>
                        <Link href="/admin/users" class="btn-secondary full">Annuler</Link>
                    </div>
                </aside>
            </form>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display: flex; flex-direction: column; gap: 24px; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
.eyebrow { margin: 0 0 6px; color: #5cb85c; font-weight: 800; text-transform: uppercase; font-size: 0.78rem; }
.page-header h1 { margin: 0; color: #17351a; font-size: 1.85rem; font-weight: 900; }
.header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

.edit-layout { display: grid; grid-template-columns: minmax(0, 1fr) 300px; gap: 24px; align-items: start; }
.form-main { display: grid; gap: 22px; }
.form-side { display: grid; gap: 18px; }

.form-card {
    background: #fff; border: 1px solid #e5ece2;
    border-radius: 8px; box-shadow: 0 16px 42px rgba(23,53,26,0.06);
    padding: 26px;
}
.card-header { display: flex; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 22px; }
.card-header h2 { margin: 0; color: #17351a; font-size: 1.1rem; font-weight: 900; }
.card-header span { color: #68746a; font-weight: 700; font-size: 0.88rem; }
.optional-label { background: #f8faf7; padding: 3px 8px; border-radius: 4px; border: 1px solid #e5ece2; }

.help-text { margin: -12px 0 18px; color: #9aaa95; font-size: 0.85rem; font-style: italic; }

.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label { color: #17351a; font-weight: 850; font-size: 0.9rem; }

.form-group input {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 6px;
    color: #17351a; font: inherit;
}
.form-group input:focus {
    outline: none; border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92,184,92,0.14);
}

/* Role picker */
.role-picker { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.role-option { cursor: pointer; }
.role-option input { display: none; }
.role-card {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; border: 2px solid #e5ece2;
    border-radius: 8px; background: #fbfcfa;
    transition: all 0.15s;
}
.role-option:hover .role-card { border-color: #c3ddc0; }
.role-option.selected .role-card { border-color: #5cb85c; background: #f0faf0; }
.role-icon { font-size: 1.3rem; flex-shrink: 0; }
.user-icon { color: #5cb85c; }
.admin-icon { color: #9b5de5; }
.role-option.selected[data-role="admin"] .role-card { border-color: #9b5de5; background: #f5f3ff; }
.role-card strong { display: block; color: #17351a; font-size: 0.92rem; font-weight: 900; }
.role-card span { display: block; margin-top: 3px; color: #68746a; font-size: 0.78rem; line-height: 1.4; }

/* Password */
.password-field { position: relative; }
.password-field input { padding-right: 44px; }
.show-pw {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #9aaa95; font-size: 0.9rem;
}
.show-pw:hover { color: #5cb85c; }

/* Profile summary sidebar */
.profile-summary {
    background: #fff; border: 1px solid #e5ece2; border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23,53,26,0.06);
    padding: 24px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 10px;
}
.summary-avatar {
    width: 64px; height: 64px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 1.3rem;
}
.avatar-admin { background: #ede9ff; color: #6b21a8; border: 3px solid #c4b5fd; }
.avatar-user { background: #e8f5e9; color: #24782b; border: 3px solid #c3ddc0; }
.profile-summary h3 { margin: 0; color: #17351a; font-size: 1.05rem; font-weight: 900; }
.profile-summary p { margin: 0; color: #68746a; font-size: 0.85rem; }

.role-pill {
    display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px;
    border-radius: 999px; font-size: 0.78rem; font-weight: 900;
}
.role-admin { background: #ede9ff; color: #6b21a8; border: 1px solid #c4b5fd; }
.role-user { background: #f0faf0; color: #24782b; border: 1px solid #c3ddc0; }

.summary-meta { width: 100%; padding-top: 14px; border-top: 1px solid #e5ece2; display: flex; flex-direction: column; gap: 8px; }
.meta-row { display: flex; align-items: center; gap: 8px; font-size: 0.84rem; color: #68746a; }
.meta-row i { color: #5cb85c; width: 14px; text-align: center; font-size: 0.82rem; flex-shrink: 0; }

.side-actions { display: flex; flex-direction: column; gap: 10px; }
.btn-primary, .btn-secondary {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    min-height: 42px; padding: 10px 16px; border-radius: 6px;
    text-decoration: none; font-weight: 850;
}
.btn-primary { background: #5cb85c; color: #fff; border: none; cursor: pointer; }
.btn-primary:hover:not(:disabled) { background: #4a9e4a; }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-secondary { background: #fff; color: #17351a; border: 1.5px solid #dfe8db; }
.btn-secondary:hover { border-color: #5cb85c; background: #fbfcfa; }
.full { width: 100%; justify-content: center; }

.error { color: #b42323; font-weight: 750; font-size: 0.86rem; }

@media (max-width: 1000px) { .edit-layout { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
    .page-header, .header-actions { flex-direction: column; align-items: flex-start; }
    .form-grid, .role-picker { grid-template-columns: 1fr; }
    .form-card { padding: 18px; }
}
</style>
