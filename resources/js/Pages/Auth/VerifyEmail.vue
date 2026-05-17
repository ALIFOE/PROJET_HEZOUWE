<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    status: String,
});

const page = usePage();
const userEmail = computed(() => page.props.auth?.user?.email || '');

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Vérification de votre email — HEZOUWE" />

        <div class="verify-wrapper">
            <!-- Icon -->
            <div class="mail-icon-circle">
                <i class="far fa-envelope-open"></i>
            </div>

            <!-- Heading -->
            <div class="auth-heading">
                <span>Dernière étape</span>
                <h2>Vérifiez votre boîte mail</h2>
                <p>
                    Votre compte a bien été créé ! Nous avons envoyé un lien de vérification à
                    <strong class="email-highlight">{{ userEmail }}</strong>.
                    Cliquez sur le bouton dans l'email pour activer votre compte.
                </p>
            </div>

            <!-- Steps -->
            <div class="steps-card">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        <strong>Ouvrez votre boîte mail</strong>
                        <span>Cherchez un email de <em>HEZOUWE</em></span>
                    </div>
                </div>
                <div class="step-divider"></div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        <strong>Cliquez sur le bouton de vérification</strong>
                        <span>Dans l'email, appuyez sur "Vérifier mon adresse email"</span>
                    </div>
                </div>
                <div class="step-divider"></div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        <strong>Accédez à votre espace</strong>
                        <span>Vous serez redirigé automatiquement vers votre tableau de bord</span>
                    </div>
                </div>
            </div>

            <!-- Success alert -->
            <div v-if="verificationLinkSent" class="auth-alert success">
                <i class="fas fa-check-circle"></i>
                Un nouveau lien de vérification a été envoyé à votre adresse email.
            </div>

            <!-- Actions -->
            <form class="auth-form" @submit.prevent="submit">
                <button
                    class="auth-submit"
                    :class="{ loading: form.processing }"
                    :disabled="form.processing"
                >
                    <i class="far fa-paper-plane"></i>
                    {{ form.processing ? 'Envoi en cours…' : 'Renvoyer le lien de vérification' }}
                </button>

                <div class="auth-actions">
                    <Link href="/" class="auth-link">
                        <i class="far fa-home"></i> Retour à l'accueil
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="auth-secondary"
                    >
                        Se déconnecter
                    </Link>
                </div>
            </form>

            <p class="spam-note">
                <i class="far fa-info-circle"></i>
                Si vous ne trouvez pas l'email, vérifiez votre dossier <strong>spam</strong> ou courrier indésirable.
            </p>
        </div>
    </GuestLayout>
</template>

<style scoped>
@import './auth.css';

.verify-wrapper {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.mail-icon-circle {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f5e9, #f0faf0);
    border: 2px solid #c3ddc0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 4px;
    font-size: 1.9rem;
    color: #2d7a2d;
}

.email-highlight {
    color: #1a3a1a;
    font-weight: 900;
    word-break: break-all;
}

.steps-card {
    background: #f8faf7;
    border: 1px solid #e5ece2;
    border-radius: 10px;
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 10px 0;
}

.step-num {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #1a3a1a;
    color: #fff;
    font-weight: 900;
    font-size: 0.82rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.step-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.step-text strong {
    color: #17351a;
    font-size: 0.9rem;
    font-weight: 900;
}

.step-text span {
    color: #68746a;
    font-size: 0.82rem;
    line-height: 1.45;
}

.step-divider {
    height: 1px;
    background: #e5ece2;
    margin: 0 0 0 42px;
}

.auth-alert.success {
    display: flex;
    align-items: center;
    gap: 8px;
}

.auth-alert.success i {
    color: #24782b;
    flex-shrink: 0;
}

.auth-submit i {
    margin-right: 4px;
    font-size: 0.9rem;
}

.auth-link i {
    font-size: 0.82rem;
    margin-right: 2px;
}

.spam-note {
    margin: 0;
    color: #9aaa95;
    font-size: 0.82rem;
    text-align: center;
    line-height: 1.55;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}

.spam-note i {
    color: #b8c8b5;
    font-size: 0.88rem;
}

.spam-note strong {
    color: #68746a;
}
</style>
