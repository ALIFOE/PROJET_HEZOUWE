<template>
    <footer class="footer-section-4 section-padding section-bg pb-0 pt-0">
        <div class="shape-1 d-none d-xxl-block float-bob-x">
            <img src="/assets/img/home-4/footer-shape-1.png" alt="img">
        </div>
        <div class="shape-2 d-none d-xxl-block float-bob-y">
            <img src="/assets/img/home-4/footer-shape-2.png" alt="img">
        </div>
        <div class="container">
            <div class="footer-widget-top-4 wow fadeInUp">
                <h2>Rejoignez Notre Newsletter</h2>
                <form action="#">
                    <input type="email" placeholder="Votre email..." required>
                    <button type="submit" class="theme-btn">S'abonner <i class="far fa-arrow-right"></i></button>
                </form>
            </div>
            <div class="footer-widget-wrapper-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="footer-widget-4">
                            <h4>À Propos</h4>
                            <div class="widget-content">
                                <p>
                                    COOP CA HEZOUWE est une coopérative dédiée à la transformation et commercialisation du riz local togolais.
                                </p>
                                <div class="social-icon-two">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="footer-widget-4">
                            <h4>Menu Rapide</h4>
                            <div class="widget-content">
                                <ul class="footer-list">
                                    <li><Link href="/">Accueil</Link></li>
                                    <li><Link href="/about">À Propos</Link></li>
                                    <li><Link href="/shop">Nos Produits</Link></li>
                                    <li><Link href="/service">Services</Link></li>
                                    <li><Link href="/contact">Contact</Link></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                        <div class="footer-widget-4">
                            <h4>Nos Produits</h4>
                            <div class="widget-content">
                                <ul class="footer-list">
                                    <li><Link href="/shop">Riz Blanc Naturel</Link></li>
                                    <li><Link href="/shop">Riz Étuvé Local</Link></li>
                                    <li><Link href="/shop">Balles de Riz</Link></li>
                                    <li><Link href="/shop">Son de Riz</Link></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="footer-widget-4">
                            <h4>Contact</h4>
                            <div class="widget-content">
                                <div class="contact-item">
                                    <p>Adresse:</p>
                                    <h4>Tagbega, Wahala, Région Plateaux, TOGO</h4>
                                </div>
                                <div class="contact-item">
                                    <p>Téléphone:</p>
                                    <h4><a href="tel:+22870679448">+228 70 67 94 48</a></h4>
                                </div>
                                <div class="contact-item">
                                    <p>Email:</p>
                                    <h4><a href="mailto:contact@hezouwe.tg">contact@hezouwe.tg</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-wrapper">
                    <p>&copy; 2025 COOP CA HEZOUWE. Tous droits réservés. | <a href="#">Politique de Confidentialité</a> | <a href="#">Conditions d'Utilisation</a></p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
