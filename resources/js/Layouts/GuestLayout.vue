<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    <div class="auth-shell">
        <div class="auth-media">
            <Link href="/" class="auth-brand">
                <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="HEZOUWE">
                <span>
                    <strong>HEZOUWE</strong>
                    <small>Riz Premium du TOGO</small>
                </span>
            </Link>

            <div class="auth-media-copy">
                <span class="auth-kicker">Espace client</span>
                <h1>Vos commandes de riz local, simples et suivies.</h1>
                <p>
                    Creez votre compte pour garder votre panier, passer commande et retrouver toutes vos informations dans le dashboard.
                </p>
            </div>
        </div>

        <main class="auth-panel">
            <div class="auth-card">
                <slot />
            </div>
        </main>
    </div>
</template>

<style scoped>
.auth-shell {
    min-height: 100vh;
    display: grid;
    grid-template-columns: minmax(360px, 46%) 1fr;
    background: #f5f7f2;
}

.auth-media {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 42px;
    overflow: hidden;
    color: #fff;
    background:
        linear-gradient(180deg, rgba(18, 48, 22, .55), rgba(18, 48, 22, .86)),
        url('/assets/img/riz2.jpeg') center/cover;
}

.auth-brand {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    text-decoration: none;
    width: fit-content;
}

.auth-brand img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,.75);
}

.auth-brand strong,
.auth-brand small {
    display: block;
}

.auth-brand strong {
    font-size: 1.05rem;
    letter-spacing: .04em;
}

.auth-brand small {
    color: rgba(255,255,255,.78);
    font-size: .76rem;
}

.auth-media-copy {
    max-width: 520px;
}

.auth-kicker {
    display: inline-flex;
    color: #ffd66b;
    padding: 6px 12px;
    border: 1px solid rgba(255,255,255,.32);
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.auth-media-copy h1 {
    margin: 18px 0 14px;
    color: #fff;
    font-size: clamp(2.1rem, 4vw, 4rem);
    line-height: 1.04;
    font-weight: 900;
}

.auth-media-copy p {
    margin: 0;
    max-width: 460px;
    color: rgba(255,255,255,.82);
    line-height: 1.7;
}

.auth-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 36px 22px;
}

.auth-card {
    width: min(100%, 480px);
    background: #fff;
    border: 1px solid #e9eee4;
    border-radius: 8px;
    padding: 34px;
    box-shadow: 0 18px 60px rgba(28, 57, 30, .12);
}

@media (max-width: 900px) {
    .auth-shell {
        grid-template-columns: 1fr;
    }

    .auth-media {
        min-height: 280px;
        padding: 28px;
    }

    .auth-media-copy h1 {
        font-size: 2.1rem;
    }
}

@media (max-width: 520px) {
    .auth-panel {
        padding: 18px;
    }

    .auth-card {
        padding: 24px;
    }
}
</style>
