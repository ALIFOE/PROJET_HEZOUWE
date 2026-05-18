<template>
    <footer class="site-footer">

        <!-- Newsletter -->
        <div class="newsletter-band">
            <div class="footer-container">
                <div class="newsletter-inner">
                    <div class="newsletter-text">
                        <i class="far fa-envelope-open-text"></i>
                        <div>
                            <h3>Rejoignez Notre Newsletter</h3>
                            <p>Recevez nos actualités, offres et conseils agricoles directement dans votre boîte mail.</p>
                        </div>
                    </div>
                    <div class="newsletter-right">
                        <form class="newsletter-form" @submit.prevent="subscribe">
                            <input
                                v-model="email"
                                type="email"
                                placeholder="Votre adresse email…"
                                required
                                :disabled="status === 'loading' || status === 'success'"
                            >
                            <button type="submit" :disabled="status === 'loading' || status === 'success'">
                                <span v-if="status === 'loading'">Envoi…</span>
                                <span v-else-if="status === 'success'">Abonné(e) ✓</span>
                                <span v-else>S'abonner <i class="far fa-arrow-right"></i></span>
                            </button>
                        </form>
                        <p v-if="statusMsg" class="newsletter-feedback" :class="status">{{ statusMsg }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main footer -->
        <div class="footer-main">
            <div class="footer-container">
                <div class="footer-grid">

                    <!-- À propos -->
                    <div class="footer-col about-col">
                        <div class="footer-logo">
                            <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="HEZOUWE" class="logo-img">
                            <div class="logo-text">
                                <span class="logo-name">HEZOUWE</span>
                                <span class="logo-sub">Coopérative du Riz Local</span>
                            </div>
                        </div>
                        <p class="about-text">
                            COOP CA HEZOUWE est une coopérative dédiée à la transformation et commercialisation du riz local togolais, au service des producteurs et des consommateurs.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-btn" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>

                    <!-- Menu rapide -->
                    <div class="footer-col">
                        <h4 class="col-title">
                            <span class="title-bar"></span>
                            Menu Rapide
                        </h4>
                        <ul class="footer-links">
                            <li><Link href="/"><i class="far fa-chevron-right"></i> Accueil</Link></li>
                            <li><Link href="/about"><i class="far fa-chevron-right"></i> À Propos</Link></li>
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Nos Produits</Link></li>
                            <li><Link href="/service"><i class="far fa-chevron-right"></i> Nos Services</Link></li>
                            <li><Link href="/news"><i class="far fa-chevron-right"></i> Actualités</Link></li>
                            <li><Link href="/contact"><i class="far fa-chevron-right"></i> Contact</Link></li>
                        </ul>
                    </div>

                    <!-- Nos produits -->
                    <div class="footer-col">
                        <h4 class="col-title">
                            <span class="title-bar"></span>
                            Nos Produits
                        </h4>
                        <ul class="footer-links">
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Riz Blanc Naturel</Link></li>
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Riz Étuvé Local</Link></li>
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Riz Complet</Link></li>
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Balles de Riz</Link></li>
                            <li><Link href="/shop"><i class="far fa-chevron-right"></i> Son de Riz</Link></li>
                        </ul>
                        <div class="quality-badge">
                            <i class="fas fa-leaf"></i>
                            <span>100% Riz Local du Togo</span>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="footer-col">
                        <h4 class="col-title">
                            <span class="title-bar"></span>
                            Contact
                        </h4>
                        <ul class="contact-list">
                            <li>
                                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div>
                                    <span class="contact-label">Adresse</span>
                                    <span class="contact-value">Tagbega, Wahala, Région Plateaux, TOGO</span>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                                <div>
                                    <span class="contact-label">Téléphone</span>
                                    <a href="tel:+22870679448" class="contact-value contact-link">+228 70 67 94 48</a>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                <div>
                                    <span class="contact-label">Email</span>
                                    <a href="mailto:contact@hezouwe.tg" class="contact-value contact-link">contact@hezouwe.tg</a>
                                </div>
                            </li>
                            <li>
                                <div class="contact-icon"><i class="fas fa-clock"></i></div>
                                <div>
                                    <span class="contact-label">Horaires</span>
                                    <span class="contact-value">Lun – Sam : 8h00 – 18h00</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer bottom -->
        <div class="footer-bottom">
            <div class="footer-container">
                <div class="footer-bottom-inner">
                    <p class="copyright">
                        &copy; {{ currentYear }} <strong>COOP CA HEZOUWE</strong>. Tous droits réservés.
                    </p>
                    <div class="bottom-links">
                        <a href="#">Politique de Confidentialité</a>
                        <span class="sep">|</span>
                        <a href="#">Conditions d'Utilisation</a>
                        <span class="sep">|</span>
                        <a href="/contact">Nous Contacter</a>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentYear = new Date().getFullYear();

const email        = ref('');
const status       = ref(''); // 'loading' | 'success' | 'error' | 'duplicate'
const statusMsg    = ref('');

const subscribe = async () => {
    if (!email.value || status.value === 'loading') return;
    status.value = 'loading';
    statusMsg.value = '';

    try {
        await window.axios.post('/newsletter/subscribe', { email: email.value });
        status.value = 'success';
        statusMsg.value = 'Abonnement confirmé ! Vous recevrez nos prochaines nouveautés.';
        email.value = '';
    } catch (err) {
        const code = err?.response?.status;
        status.value = code === 409 ? 'duplicate' : 'error';
        statusMsg.value = err?.response?.data?.message || 'Une erreur est survenue. Veuillez réessayer.';
    }
};
</script>

<style scoped>
/* ─── Variables ─────────────────────────────────────── */
.site-footer {
    --green-dark: #0f2810;
    --green-mid:  #1a3a1a;
    --green-light: #2d5a2d;
    --gold:       #d5a741;
    --gold-light: #e8c06a;
    --white:      #ffffff;
    --muted:      rgba(255,255,255,0.55);
    --border:     rgba(255,255,255,0.08);
    font-family: inherit;
}

/* ─── Newsletter band ───────────────────────────────── */
.newsletter-band {
    background: var(--gold);
    padding: 36px 0;
}

.footer-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
}

.newsletter-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
}

.newsletter-text {
    display: flex;
    align-items: center;
    gap: 18px;
    flex: 1;
    min-width: 240px;
}

.newsletter-text i {
    font-size: 2rem;
    color: var(--green-dark);
    flex-shrink: 0;
}

.newsletter-text h3 {
    margin: 0 0 4px;
    color: var(--green-dark);
    font-size: 1.2rem;
    font-weight: 900;
}

.newsletter-text p {
    margin: 0;
    color: rgba(15,40,16,0.75);
    font-size: 0.88rem;
    line-height: 1.5;
}

.newsletter-right {
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
    max-width: 480px;
    min-width: 240px;
}

.newsletter-form {
    display: flex;
    gap: 0;
    width: 100%;
}

.newsletter-feedback {
    margin: 0;
    font-size: 0.83rem;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 6px;
}

.newsletter-feedback.success  { background: rgba(15,40,16,0.15); color: #0f2810; }
.newsletter-feedback.duplicate { background: rgba(15,40,16,0.10); color: #1a3a1a; }
.newsletter-feedback.error    { background: rgba(180,35,35,0.12); color: #7a1010; }

.newsletter-form input {
    flex: 1;
    padding: 14px 18px;
    border: none;
    border-radius: 8px 0 0 8px;
    background: rgba(255,255,255,0.92);
    color: #1a3a1a;
    font-size: 0.95rem;
    outline: none;
    min-width: 0;
}

.newsletter-form input:focus {
    background: #fff;
    box-shadow: inset 0 0 0 2px var(--green-dark);
}

.newsletter-form button {
    padding: 14px 22px;
    background: var(--green-dark);
    color: #fff;
    border: none;
    border-radius: 0 8px 8px 0;
    font-weight: 900;
    font-size: 0.9rem;
    cursor: pointer;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}

.newsletter-form button:hover {
    background: var(--green-light);
}

/* ─── Main footer ───────────────────────────────────── */
.footer-main {
    background: var(--green-mid);
    padding: 64px 0 48px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 1.3fr 1fr 1fr 1.2fr;
    gap: 48px;
}

/* ─── About column ──────────────────────────────────── */
.footer-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.logo-img {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid var(--gold);
}

.logo-name {
    display: block;
    color: var(--white);
    font-size: 1.25rem;
    font-weight: 900;
    letter-spacing: 0.5px;
    line-height: 1;
}

.logo-sub {
    display: block;
    color: var(--gold);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 3px;
}

.about-text {
    color: var(--muted);
    font-size: 0.88rem;
    line-height: 1.75;
    margin: 0 0 24px;
}

.social-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.social-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    text-decoration: none;
    font-size: 0.88rem;
    transition: all 0.2s;
}

.social-btn:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: var(--green-dark);
    transform: translateY(-2px);
}

/* ─── Column titles ─────────────────────────────────── */
.col-title {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--white);
    font-size: 1rem;
    font-weight: 900;
    margin: 0 0 22px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.title-bar {
    display: block;
    width: 4px;
    height: 20px;
    background: var(--gold);
    border-radius: 2px;
    flex-shrink: 0;
}

/* ─── Footer links ──────────────────────────────────── */
.footer-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.footer-links li a {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s, gap 0.2s;
}

.footer-links li a i {
    font-size: 0.7rem;
    color: var(--gold);
    transition: transform 0.2s;
}

.footer-links li a:hover {
    color: var(--gold);
    gap: 12px;
}

.footer-links li a:hover i {
    transform: translateX(2px);
}

.quality-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 22px;
    padding: 8px 14px;
    background: rgba(213,167,65,0.12);
    border: 1px solid rgba(213,167,65,0.3);
    border-radius: 999px;
    color: var(--gold);
    font-size: 0.8rem;
    font-weight: 700;
}

.quality-badge i {
    font-size: 0.85rem;
}

/* ─── Contact list ──────────────────────────────────── */
.contact-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.contact-list li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.contact-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(213,167,65,0.15);
    border: 1px solid rgba(213,167,65,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    font-size: 0.9rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.contact-label {
    display: block;
    color: var(--gold);
    font-size: 0.72rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
}

.contact-value {
    display: block;
    color: var(--muted);
    font-size: 0.88rem;
    line-height: 1.45;
}

.contact-link {
    text-decoration: none;
    transition: color 0.2s;
}

.contact-link:hover {
    color: var(--gold);
}

/* ─── Footer bottom ─────────────────────────────────── */
.footer-bottom {
    background: var(--green-dark);
    border-top: 1px solid var(--border);
    padding: 20px 0;
}

.footer-bottom-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.copyright {
    margin: 0;
    color: var(--muted);
    font-size: 0.85rem;
}

.copyright strong {
    color: var(--gold);
}

.bottom-links {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.bottom-links a {
    color: var(--muted);
    text-decoration: none;
    font-size: 0.82rem;
    transition: color 0.2s;
}

.bottom-links a:hover {
    color: var(--gold);
}

.sep {
    color: var(--border);
    font-size: 0.8rem;
}

/* ─── Responsive ────────────────────────────────────── */
@media (max-width: 1100px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 40px 48px;
    }

    .about-col {
        grid-column: 1 / -1;
    }

    .about-text {
        max-width: 600px;
    }

    .social-links {
        flex-direction: row;
    }
}

@media (max-width: 768px) {
    .newsletter-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .newsletter-right {
        width: 100%;
        max-width: 100%;
    }

    .footer-main {
        padding: 48px 0 36px;
    }

    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 36px 32px;
    }

    .about-col {
        grid-column: 1 / -1;
    }
}

@media (max-width: 540px) {
    .newsletter-band {
        padding: 28px 0;
    }

    .newsletter-right {
        width: 100%;
    }

    .newsletter-form {
        flex-direction: column;
        gap: 10px;
    }

    .newsletter-form input {
        border-radius: 8px;
    }

    .newsletter-form button {
        border-radius: 8px;
        justify-content: center;
    }

    .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .footer-bottom-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .bottom-links {
        gap: 8px;
    }
}
</style>
