<template>
    <!-- Barre de progression de scroll -->
    <div class="scroll-progress" :style="{ width: scrollProgress + '%' }"></div>

    <header class="hezouwe-header" :class="{ 'is-scrolled': isScrolled, 'is-hidden': isHidden }">
        <!-- Top Bar -->
        <div class="header-top-bar" :class="{ 'collapsed': isScrolled }">
            <div class="container">
                <div class="top-bar-inner">
                    <!-- Ticker d'annonce -->
                    <div class="announcement-ticker">
                        <span class="ticker-badge">
                            <img src="/assets/img/fi.png" alt="TOGO" class="ticker-flag">
                            Nouveauté
                        </span>
                        <div class="ticker-track">
                            <div class="ticker-content" ref="ticker">
                                <span v-for="n in 3" :key="n">
                                    &nbsp;&nbsp;🌾 Riz Local Premium du TOGO &mdash; Qualité Certifiée ITRA &nbsp;&nbsp;|&nbsp;&nbsp;
                                    Récolte fraîche disponible &nbsp;&nbsp;|&nbsp;&nbsp;
                                    Livraison dans toute la région Plateaux &nbsp;&nbsp;|&nbsp;
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Infos de contact -->
                    <div class="top-contacts">
                        <a href="mailto:contact@hezouwe.tg" class="top-contact-item">
                            <i class="far fa-envelope"></i>
                            <span>contact@hezouwe.tg</span>
                        </a>
                        <div class="top-divider"></div>
                        <a href="tel:+22870679448" class="top-contact-item">
                            <i class="far fa-phone"></i>
                            <span>+228 70 67 94 48</span>
                        </a>
                        <div class="top-divider"></div>
                        <span class="top-contact-item">
                            <i class="far fa-clock"></i>
                            <span>Lun–Sam : 08h–18h</span>
                        </span>
                    </div>

                    <!-- Réseaux sociaux -->
                    <div class="top-social">
                        <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="header-main-bar">
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Logo -->
                    <Link href="/" class="nav-logo">
                        <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="Hézouwè" class="logo-img">
                        <div class="logo-text">
                            <span class="logo-name">Hézouwè</span>
                            <span class="logo-tagline">Riz Premium du TOGO</span>
                        </div>
                    </Link>

                    <!-- Menu desktop -->
                    <nav class="desktop-nav" :class="{ 'mobile-open': mobileMenuOpen }">
                        <ul class="nav-list">
                            <li class="nav-item" :class="{ active: $page.url === '/' }">
                                <Link href="/" class="nav-link" @click="closeMobileMenu">
                                    Accueil
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li class="nav-item" :class="{ active: $page.url === '/about' }">
                                <Link href="/about" class="nav-link" @click="closeMobileMenu">
                                    À Propos
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li class="nav-item" :class="{ active: $page.url === '/shop' || $page.url.startsWith('/shop') }">
                                <Link href="/shop" class="nav-link" @click="closeMobileMenu">
                                    Nos Produits
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li class="nav-item" :class="{ active: $page.url === '/news' || $page.url.startsWith('/news') }">
                                <Link href="/news" class="nav-link" @click="closeMobileMenu">
                                    Actualités
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li class="nav-item" :class="{ active: $page.url === '/service' }">
                                <Link href="/service" class="nav-link" @click="closeMobileMenu">
                                    Services
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li class="nav-item" :class="{ active: $page.url === '/contact' }">
                                <Link href="/contact" class="nav-link" @click="closeMobileMenu">
                                    Contact
                                    <span class="nav-underline"></span>
                                </Link>
                            </li>
                            <li v-if="!isAuthenticated" class="mobile-auth-item">
                                <Link href="/login" class="mobile-auth-link" @click="closeMobileMenu">
                                    Se connecter
                                </Link>
                                <Link href="/register" class="mobile-auth-link register" @click="closeMobileMenu">
                                    Creer un compte
                                </Link>
                            </li>
                        </ul>

                        <!-- Overlay mobile -->
                        <div class="mobile-overlay" @click="closeMobileMenu"></div>
                    </nav>

                    <!-- Actions droite -->
                    <div class="nav-actions">
                        <!-- Recherche -->
                        <!-- <div class="search-wrapper" :class="{ 'search-open': searchOpen }">
                            <input
                                ref="searchInput"
                                type="text"
                                v-model="searchQuery"
                                placeholder="Rechercher un produit..."
                                class="search-input"
                                @keyup.enter="submitSearch"
                                @keyup.escape="closeSearch"
                            >
                            <button class="search-toggle" @click="toggleSearch" aria-label="Recherche">
                                <i :class="searchOpen ? 'fal fa-times' : 'fal fa-search'"></i>
                            </button>
                        </div> -->

                        <Link href="/shop-cart" v-if="isAuthenticated" class="cart-btn" aria-label="Panier">
                            <i class="far fa-shopping-bag"></i>
                            <span class="cart-badge" :class="{ 'badge-pulse': cartPulse }">{{ cartCount }}</span>
                        </Link>

                        <Link v-if="isAuthenticated" href="/dashboard" class="account-btn" aria-label="Mon compte">
                            <i class="far fa-user"></i>
                        </Link>

                        <Link href="/shop" class="cta-btn">
                            <span>Commander</span>
                            <i class="far fa-arrow-right"></i>
                        </Link>

                        <template v-if="!isAuthenticated">
                            <Link href="/login" class="auth-nav-btn login-btn">
                                Se connecter
                            </Link>
                            <Link href="/register" class="auth-nav-btn register-btn">
                                Creer un compte
                            </Link>
                        </template>

                        <!-- Hamburger -->
                        <button
                            class="hamburger"
                            :class="{ 'is-active': mobileMenuOpen }"
                            @click="toggleMobileMenu"
                            aria-label="Menu"
                        >
                            <span class="burger-line"></span>
                            <span class="burger-line"></span>
                            <span class="burger-line"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Spacer pour compenser le header fixed -->
    <div class="header-spacer"></div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted, nextTick } from 'vue';

const isScrolled = ref(false);
const isHidden = ref(false);
const scrollProgress = ref(0);
const mobileMenuOpen = ref(false);
const searchOpen = ref(false);
const searchQuery = ref('');
const page = usePage();
const isAuthenticated = computed(() => Boolean(page.props.auth?.user));
const cartCount = computed(() => page.props.cartCount || 0);
const cartPulse = ref(false);
const searchInput = ref(null);

let lastScrollY = 0;

function handleScroll() {
    const scrollY = window.scrollY;
    const docH = document.documentElement.scrollHeight - window.innerHeight;

    scrollProgress.value = docH > 0 ? Math.min((scrollY / docH) * 100, 100) : 0;
    isScrolled.value = scrollY > 60;

    // Masquer en scrollant vers le bas, réafficher en scrollant vers le haut
    if (scrollY > lastScrollY && scrollY > 200) {
        isHidden.value = true;
    } else {
        isHidden.value = false;
    }
    lastScrollY = scrollY;
}

function toggleMobileMenu() {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    document.body.style.overflow = mobileMenuOpen.value ? 'hidden' : '';
}

function closeMobileMenu() {
    mobileMenuOpen.value = false;
    document.body.style.overflow = '';
}

function toggleSearch() {
    searchOpen.value = !searchOpen.value;
    if (searchOpen.value) {
        nextTick(() => searchInput.value?.focus());
    } else {
        searchQuery.value = '';
    }
}

function closeSearch() {
    searchOpen.value = false;
    searchQuery.value = '';
}

function submitSearch() {
    if (searchQuery.value.trim()) {
        // router push vers la page produits avec query
        closeSearch();
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });

    // Animation badge panier au chargement
    setTimeout(() => {
        cartPulse.value = true;
        setTimeout(() => { cartPulse.value = false; }, 1000);
    }, 1500);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.body.style.overflow = '';
});
</script>

<style scoped>
/* ─── Variables ─── */
:root {
    --hz-green: #3a7c3a;
    --hz-green-dark: #2a5c2a;
    --hz-green-light: #5aab5a;
    --hz-gold: #c8902a;
    --hz-white: #ffffff;
    --hz-top-bg: #1a3a1a;
    --header-height: 80px;
    --top-bar-height: 44px;
}

/* ─── Barre de progression ─── */
.scroll-progress {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, #c8902a, #5aab5a);
    z-index: 9999;
    transition: width 0.1s linear;
}

/* ─── Header wrapper ─── */
.hezouwe-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: transform 0.35s ease, box-shadow 0.3s ease;
}

.hezouwe-header.is-hidden {
    transform: translateY(-100%);
}

.hezouwe-header.is-scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
}

/* ─── Top Bar ─── */
.header-top-bar {
    background: #1a3a1a;
    height: var(--top-bar-height);
    overflow: hidden;
    transition: height 0.35s ease, opacity 0.3s ease;
}

.header-top-bar.collapsed {
    height: 0;
    opacity: 0;
}

.top-bar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: var(--top-bar-height);
    gap: 16px;
}

/* Ticker */
.announcement-ticker {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    overflow: hidden;
    min-width: 0;
}

.ticker-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #c8902a;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ticker-flag {
    width: 16px;
    height: 12px;
    object-fit: cover;
    border-radius: 2px;
}

.ticker-track {
    overflow: hidden;
    flex: 1;
}

.ticker-content {
    display: inline-flex;
    white-space: nowrap;
    animation: ticker-scroll 28s linear infinite;
    color: rgba(255,255,255,0.8);
    font-size: 12.5px;
}

@keyframes ticker-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-33.33%); }
}

/* Contacts top */
.top-contacts {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.top-contact-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.8);
    font-size: 12.5px;
    text-decoration: none;
    transition: color 0.2s;
}

.top-contact-item:hover {
    color: #c8902a;
}

.top-contact-item i {
    font-size: 12px;
    color: #5aab5a;
}

.top-divider {
    width: 1px;
    height: 16px;
    background: rgba(255,255,255,0.15);
}

/* Réseaux sociaux */
.top-social {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.social-link {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.7);
    border-radius: 50%;
    font-size: 11px;
    text-decoration: none;
    transition: background 0.25s, color 0.25s, transform 0.25s;
}

.social-link:hover {
    background: #c8902a;
    color: #fff;
    transform: translateY(-2px);
}

/* ─── Main Navigation Bar ─── */
.header-main-bar {
    background: #fff;
    border-bottom: 2px solid rgba(58, 124, 58, 0.12);
    height: var(--header-height);
    transition: background 0.3s, height 0.3s;
}

.is-scrolled .header-main-bar {
    height: 68px;
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(10px);
}

.nav-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    gap: 20px;
}

/* ─── Logo ─── */
.nav-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    flex-shrink: 0;
}

.logo-img {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #3a7c3a;
    transition: transform 0.35s ease, border-color 0.3s;
}

.nav-logo:hover .logo-img {
    transform: rotate(5deg) scale(1.05);
    border-color: #c8902a;
}

.logo-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.logo-name {
    font-size: 18px;
    font-weight: 800;
    color: #1a3a1a;
    letter-spacing: -0.3px;
}

.logo-tagline {
    font-size: 10px;
    color: #c8902a;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

/* ─── Desktop Navigation ─── */
.desktop-nav {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-list {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 14px;
    color: #2d2d2d;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 8px;
    transition: color 0.25s, background 0.25s;
    position: relative;
}

.nav-link:hover,
.nav-item.active .nav-link {
    color: #3a7c3a;
}

.nav-underline {
    position: absolute;
    bottom: 2px;
    left: 14px;
    right: 14px;
    height: 2px;
    background: linear-gradient(90deg, #3a7c3a, #c8902a);
    border-radius: 2px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.nav-link:hover .nav-underline,
.nav-item.active .nav-link .nav-underline {
    transform: scaleX(1);
}

/* ─── Actions droite ─── */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    margin-right: -10px;
}

/* Recherche */
.search-wrapper {
    display: flex;
    align-items: center;
    background: #f4f6f4;
    border: 1.5px solid transparent;
    border-radius: 24px;
    overflow: hidden;
    width: 40px;
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s;
}

.search-wrapper.search-open {
    width: 240px;
    border-color: #3a7c3a;
    background: #fff;
}

.search-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 13.5px;
    padding: 0 0 0 14px;
    color: #2d2d2d;
    width: 0;
    opacity: 0;
    transition: opacity 0.3s;
}

.search-wrapper.search-open .search-input {
    width: auto;
    opacity: 1;
}

.search-toggle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    color: #3a7c3a;
    font-size: 15px;
    cursor: pointer;
    flex-shrink: 0;
    transition: color 0.25s, transform 0.25s;
}

.search-toggle:hover {
    color: #c8902a;
    transform: scale(1.1);
}

/* Panier */
.cart-btn {
    position: relative;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f6f4;
    border: none;
    border-radius: 50%;
    color: #2d2d2d;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.25s, color 0.25s, transform 0.25s;
}

.cart-btn:hover {
    background: #3a7c3a;
    color: #fff;
    transform: scale(1.05);
}

.cart-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    width: 18px;
    height: 18px;
    background: #c8902a;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    transition: transform 0.3s;
}

.cart-badge.badge-pulse {
    animation: badge-pop 0.5s ease;
}

.account-btn {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f6f4;
    border-radius: 50%;
    color: #2d2d2d;
    font-size: 16px;
    text-decoration: none;
    transition: background 0.25s, color 0.25s, transform 0.25s;
}

.account-btn:hover {
    background: #c8902a;
    color: #fff;
    transform: scale(1.05);
}

.auth-nav-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 0 12px;
    border-radius: 24px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.25s, color 0.25s, border-color 0.25s, transform 0.25s;
}

.auth-nav-btn:hover {
    transform: translateY(-1px);
}

.login-btn {
    color: #2d7a2d;
    background: #f4f6f4;
    border: 1.5px solid #dfe7dc;
}

.login-btn:hover {
    color: #fff;
    background: #3a7c3a;
    border-color: #3a7c3a;
}

.register-btn {
    color: #1a3a1a;
    background: #fff5d9;
    border: 1.5px solid #e6c772;
}

.register-btn:hover {
    color: #fff;
    background: #c8902a;
    border-color: #c8902a;
}

@keyframes badge-pop {
    0%, 100% { transform: scale(1); }
    40%       { transform: scale(1.5); }
}

/* Bouton CTA */
.cta-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #3a7c3a, #2a5c2a);
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    padding: 8px 15px;
    border-radius: 24px;
    text-decoration: none;
    transition: transform 0.25s, box-shadow 0.25s, background 0.25s;
    box-shadow: 0 4px 14px rgba(58,124,58,0.3);
    white-space: nowrap;
}

.cta-btn i {
    font-size: 12px;
    transition: transform 0.25s;
}

.cta-btn:hover {
    background: linear-gradient(135deg, #c8902a, #a87020);
    box-shadow: 0 6px 18px rgba(200,144,42,0.4);
    transform: translateY(-1px);
}

.cta-btn:hover i {
    transform: translateX(4px);
}

/* ─── Hamburger ─── */
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 40px;
    height: 40px;
    padding: 8px;
    background: none;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: border-color 0.25s;
}

.hamburger:hover {
    border-color: #3a7c3a;
}

.burger-line {
    display: block;
    height: 2px;
    background: #2d2d2d;
    border-radius: 2px;
    transition: transform 0.3s ease, opacity 0.3s ease, background 0.3s;
}

.hamburger.is-active .burger-line:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
    background: #3a7c3a;
}

.hamburger.is-active .burger-line:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.hamburger.is-active .burger-line:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
    background: #3a7c3a;
}

/* ─── Overlay mobile ─── */
.mobile-overlay {
    display: none;
}

.mobile-auth-item {
    display: none;
}

/* ─── Spacer ─── */
.header-spacer {
    height: calc(var(--top-bar-height) + var(--header-height));
    transition: height 0.35s ease;
}

/* ─── Responsive ─── */
@media (max-width: 991px) {
    .top-contacts {
        display: none;
    }
}

@media (max-width: 767px) {
    .header-top-bar {
        display: none;
    }

    .header-spacer {
        height: var(--header-height);
    }

    .hamburger {
        display: flex;
    }

    .nav-actions {
        margin-right: 0;
    }

    .cta-btn {
        padding: 8px 12px;
        font-size: 12px;
    }

    .auth-nav-btn {
        display: none;
    }

    .mobile-auth-item {
        display: grid;
        gap: 10px;
        padding-top: 18px;
        border-bottom: none;
    }

    .mobile-auth-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        border-radius: 8px;
        color: #2d7a2d;
        background: #f4f6f4;
        border: 1.5px solid #dfe7dc;
        font-weight: 800;
        text-decoration: none;
    }

    .mobile-auth-link.register {
        color: #fff;
        background: #3a7c3a;
        border-color: #3a7c3a;
    }

    .desktop-nav {
        position: fixed;
        top: 0;
        right: -100%;
        width: 80%;
        max-width: 320px;
        height: 100vh;
        background: #fff;
        flex-direction: column;
        justify-content: flex-start;
        padding: 80px 24px 40px;
        box-shadow: -4px 0 40px rgba(0,0,0,0.15);
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1001;
        overflow-y: auto;
    }

    .desktop-nav.mobile-open {
        right: 0;
    }

    .mobile-overlay {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0);
        z-index: 1000;
        pointer-events: none;
        transition: background 0.4s;
    }

    .desktop-nav.mobile-open .mobile-overlay {
        background: rgba(0,0,0,0.5);
        pointer-events: all;
    }

    .nav-list {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        width: 100%;
    }

    .nav-item {
        border-bottom: 1px solid #f0f0f0;
    }

    .nav-link {
        flex-direction: row;
        justify-content: space-between;
        padding: 14px 8px;
        font-size: 15px;
        border-radius: 0;
    }

    .nav-underline {
        display: none;
    }

    .nav-item.active .nav-link {
        color: #3a7c3a;
        background: #f0f7f0;
        border-radius: 8px;
    }

    .logo-text {
        display: none;
    }

    .search-wrapper.search-open {
        width: 180px;
    }
}
</style>
