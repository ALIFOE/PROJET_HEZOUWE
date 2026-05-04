<template>
    <header class="header-section-4">
        <div class="header-top-4">
            <div class="container">
                <div class="header-top-wrapper3">
                    <p>
                        <img src="/assets/img/fi.png" alt="img">
                        Riz Local Premium du TOGO - Qualité Certifiée ITRA
                    </p>
                    <div class="top-line"></div>
                    <div class="header-info">
                        <div class="list-item">
                            <img src="/assets/img/icon/icon11.svg" alt="img">
                            <span>Tagbega, Wahala, Région Plateaux</span>
                        </div>
                        <div class="top-line"></div>
                        <div class="list-item">
                            <img src="/assets/img/icon/icon22.svg" alt="img">
                            <a href="mailto:contact@hezouwe.tg">contact@hezouwe.tg</a>
                        </div>
                        <div class="top-line"></div>
                        <div class="list-item">
                            <img src="/assets/img/icon/icon33.svg" alt="img">
                            <a href="tel:+22870679448">+228 70 67 94 48</a>
                        </div>
                        <div class="top-line"></div>
                        <div class="list-item">
                            <img src="/assets/img/icon/icon44.svg" alt="img">
                            <span>Lun - Sam: 08.00 to 18.00</span>
                        </div>
                    </div>
                    <div class="head-right">
                        <div class="flag-wrap">
                            <div class="flag">
                                <img src="/assets/img/flag.png" alt="flag">
                            </div>
                            <select class="single-select w-100">
                                <option>FR</option>
                                <option>EN</option>
                            </select>
                        </div>
                        <div class="line-shape"></div>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-sticky" class="header-4">
            <div class="container">
                <div class="mega-menu-wrapper">
                    <div class="header-main">
                        <Link href="/" class="header-logo">
                            <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="img">
                        </Link>
                        <div class="header-right d-flex justify-content-end align-items-center">
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li :class="{ active: $page.url === '/' }">
                                                <Link href="/">Accueil</Link>
                                            </li>
                                            <li :class="{ active: $page.url === '/about' }">
                                                <Link href="/about">À Propos</Link>
                                            </li>
                                            <li :class="{ active: $page.url === '/shop' }">
                                                <Link href="/shop">Nos Produits</Link>
                                            </li>
                                            <li :class="{ active: $page.url === '/service' }">
                                                <Link href="/service">Services</Link>
                                            </li>
                                            <li :class="{ active: $page.url === '/contact' }">
                                                <Link href="/contact">Contact</Link>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="mobile-menu"></div>
                            <div class="header-right-icon">
                                <form action="#" class="search-form">
                                    <input type="text" placeholder="Recherchez un produit...">
                                    <button type="submit"><i class="fal fa-search"></i></button>
                                </form>
                                <button id="openButton" class="cart-icon">
                                    <i class="far fa-shopping-bag"></i>
                                    <span>2</span>
                                </button>
                                <button class="hamburger-menu" id="hamburger-toggle" aria-label="Toggle menu">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                            <Link href="/contact" class="theme-btn">
                                Nous Contacter
                                <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

onMounted(() => {
    // Initialize meanmenu for mobile navigation
    if (typeof $.fn.meanmenu !== 'undefined') {
        $('#mobile-menu').meanmenu({
            meanMenuContainer: '.mobile-menu',
            meanScreenWidth: '991',
            meanExpand: '+',
            meanContract: '-',
        });
    }
});
</script>
