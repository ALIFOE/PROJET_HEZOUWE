<template>
    <AppLayout title="Accueil">
        <!-- Hero Section Start -->
        <section class="hero-section hero-4 fix">
            <div class="shape-1">
                <img src="/assets/img/home-4/hero/shape-1.png" alt="img">
            </div>
            <div class="shape-2">
                <!-- <img src="/assets/img/home-4/hero/organic-shape.png" alt="img"> -->
            </div>
            <div class="array-button">
               <button class="array-prev"><i class="fal fa-long-arrow-left"></i></button>
                <button class="array-next"><i class="fal fa-long-arrow-right"></i></button>
            </div>
            <div class="swiper banner-active">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="hero-height">
                            <div class="hero-bg bg-cover" style="background-image: url('/assets/img/home-4/hero/hero-bg.jpg');"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            <h1>Riz Local HEZOUWE produit au Togo</h1>
                                            <p>COOP CA HEZOUWE - Collecte, transformation et commercialisation de riz local de qualité supérieure. Certifié ITRA. Soutenu par Compassion Internationale Togo.</p>
                                        </div>
                                        <div class="hero-button">
                                            <Link href="/shop" class="theme-btn">Voir Nos Produits <i class="far fa-arrow-right"></i></Link>
                                            <Link href="/service" class="theme-btn style-2">Nos Services <i class="far fa-arrow-right"></i></Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="swiper-slide">
                        <div class="hero-height">
                            <div class="hero-bg bg-cover" style="background-image: url('/assets/img/home-4/hero/hero-bg2.jpg');"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            <h1>Transformation Locale du Riz</h1>
                                            <p>De producteurs togolais à votre table. Riz étuvé IR841 et riz blanc naturellement parfumé, transformation maîtrisée pour votre bien-être.</p>
                                        </div>
                                        <div class="hero-button">
                                            <Link href="/shop" class="theme-btn">Découvrir <i class="far fa-arrow-right"></i></Link>
                                            <Link href="/about" class="theme-btn style-2">En Savoir Plus <i class="far fa-arrow-right"></i></Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Feature Section Start -->
        <section class="service-feature-section-4 section-padding fix">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-feature-thumb-items-4">
                            <img src="/assets/img/home-4/service-feature/image-01.jpg" alt="img">
                            <h4 class="text-title">Transformation Moderne</h4>
                            <div class="content">
                                <div class="icon"><i class="flaticon-price"></i></div>
                                <h3><Link href="/service-details">Équipements Technologiques</Link></h3>
                                <p>Décortiqueuses, calibreuses et installations modernes pour une transformation optimale du riz local.</p>
                                <Link href="/service-details" class="link-btn">Plus d'Info <i class="far fa-arrow-right"></i></Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-feature-thumb-items-4 active">
                            <img src="/assets/img/image9.jpg" alt="img">
                            <h4 class="text-title">Qualité Certifiée</h4>
                            <div class="content">
                                <div class="icon"><i class="flaticon-price"></i></div>
                                <h3><Link href="/service-details">Certification ITRA</Link></h3>
                                <p>Riz blanc naturellement parfumé certifié par l'ITRA, sans additifs chimiques, arôme naturel.</p>
                                <Link href="/service-details" class="link-btn">Plus d'Info <i class="far fa-arrow-right"></i></Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-feature-thumb-items-4">
                            <img src="/assets/img/riz3.jpeg" alt="img">
                            <h4 class="text-title">Riz Étuvé Naturel</h4>
                            <div class="content">
                                <div class="icon"><i class="flaticon-price"></i></div>
                                <h3><Link href="/service-details">Produits Naturels</Link></h3>
                                <p>Riz étuvé avec transformation maîtrisée, meilleure conservation et nutriments préservés.</p>
                                <Link href="/service-details" class="link-btn">Plus d'Info <i class="far fa-arrow-right"></i></Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Counter Section Start -->
        <section class="cr-section section-padding fix pt-0">
            <div class="container">
                <div class="cr-wrapper">
                    <div class="row g-0 align-items-stretch">
                        <!-- Left: texte -->
                        <div class="col-lg-5">
                            <div class="cr-text-side wow fadeInLeft" data-wow-delay=".2s">
                                <span class="cr-sub"><img src="/assets/img/sub-title.svg" alt="">Notre Impact</span>
                                <h2>Soutenir les Producteurs Locaux avec Compassion Internationale</h2>
                                <p>COOP CA HEZOUWE appuie 10 Centres de Développement des Enfants et des Jeunes (CDEJ) à travers la commercialisation du riz local. Notre mission est de contribuer à la souveraineté alimentaire du TOGO tout en créant des emplois et des opportunités pour les jeunes.</p>
                                <Link href="/about" class="cr-btn">En Savoir Plus <i class="far fa-arrow-right"></i></Link>
                            </div>
                        </div>
                        <!-- Right: stats -->
                        <div class="col-lg-7">
                            <div class="cr-stats-side">
                                <div class="cr-stat-box wow fadeInUp" data-wow-delay=".3s">
                                    <div class="cr-stat-icon"><i class="fas fa-users"></i></div>
                                    <h2><span class="odometer" data-count="30">00</span></h2>
                                    <p>Membres de la Coopérative</p>
                                </div>
                                <div class="cr-stat-box wow fadeInUp" data-wow-delay=".4s">
                                    <div class="cr-stat-icon"><i class="fas fa-briefcase"></i></div>
                                    <h2><span class="odometer" data-count="13">00</span></h2>
                                    <p>Emplois Créés Année 1</p>
                                </div>
                                <div class="cr-stat-box wow fadeInUp" data-wow-delay=".5s">
                                    <div class="cr-stat-icon"><i class="fas fa-school"></i></div>
                                    <h2><span class="odometer" data-count="10">00</span></h2>
                                    <p>CDEJ Partenaires</p>
                                </div>
                                <div class="cr-stat-box wow fadeInUp" data-wow-delay=".6s">
                                    <div class="cr-stat-icon"><i class="fas fa-seedling"></i></div>
                                    <h2><span class="odometer" data-count="11">00</span></h2>
                                    <p>Hectares Disponibles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marquee Section with HEZOUWE Content -->
        <div class="marquee-section">
            <div class="marquee">
                <div class="marquee-group">
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Production de Riz</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Riz Local HEZOUWE</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Sans Additifs</div>
                    <!-- <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Arôme Naturel</div> -->
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">TOGO</div>
                </div>
                <div class="marquee-group">
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Riz Blanc Naturel</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Riz Étuvé Local</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Certifié ITRA</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Qualité Premium</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Producteurs Heureux</div>
                </div>
                <div class="marquee-group">
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Coopérative HEZOUWE</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">30 Membres Engagés</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">12 Femmes Actives</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Dirigée par une Femme</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Compassion Intl Soutien</div>
                </div>
                <div class="marquee-group">
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Région Plateaux</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Tagbega-Wahala</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Proximité Producteurs</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">11 ha Disponibles</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">Extension Future</div>
                </div>
                <div class="marquee-group">
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">42 Tonnes IR841</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">12 Tonnes Riz Local</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">23.5 Tonnes Vendues</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">1700kg Balles</div>
                    <div class="text"><img src="/assets/img/home-4/vec.png" alt="">1350kg Son de Riz</div>
                </div>
            </div>
        </div>

        <!-- Product Box Section Start -->
        <section class="product-box-section-4 section-padding fix">
            <div class="container">
                <div class="row g-4">
                    <div
                        v-for="(item, i) in featuredProducts"
                        :key="item.slug"
                        class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp"
                        :data-wow-delay="`.${3 + i * 2}s`"
                    >
                        <div class="products-box-items bg-cover" :style="`background-image: url('${item.bg}');`">
                            <div class="product-content">
                                <span>{{ item.label }}</span>
                                <h3>{{ item.title }}</h3>
                                <Link :href="`/shop-details/${item.slug}`" class="theme-btn">Acheter Maintenant <i class="fas fa-shopping-basket"></i></Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section Start -->
        <section class="about-section-4 section-padding fix pt-0">
            <div class="container">
                <div class="about-wrapper-4">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-6">
                            <div class="about-left-content">
                                <div class="section-title mb-0">
                                    <span class="text-white wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">À Propos de HEZOUWE</span>
                                    <h2 class="text-white text-anim">Notre Riz est Différent</h2>
                                </div>
                                <p class="about-text wow fadeInUp" data-wow-delay=".2s">
                                    COOP CA HEZOUWE est une coopérative avec conseil d'administration créée par le collectif des 10 Centres de Développement des Enfants et des Jeunes Togo. Nos 30 membres (dont 12 femmes) se consacrent à la collecte et transformation du riz local togolais.
                                </p>
                                <div class="about-icon-area wow fadeInUp" data-wow-delay=".3s">
                                    <div class="icon">
                                        <i class="flaticon-eco-friendly"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Production Durable</h3>
                                        <p>Transformation locale maîtrisée pour préserver qualité et nutriments sans additifs chimiques.</p>
                                    </div>
                                </div>
                                <div class="about-icon-area wow fadeInUp" data-wow-delay=".5s">
                                    <div class="icon">
                                        <i class="flaticon-broccoli"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Riz Certifié ITRA</h3>
                                        <p>Riz blanc naturellement parfumé IR841 certifié, cuisson rapide, goût savoureux et arôme naturel.</p>
                                    </div>
                                </div>
                                <div class="about-bottom-area wow fadeInUp" data-wow-delay=".7s">
                                    <Link href="/about" class="theme-btn">En Savoir Plus <i class="far fa-arrow-right"></i></Link>
                                    <div class="phone-box-items">
                                        <div class="icon">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        <div class="content">
                                            <p>Téléphone:</p>
                                            <a href="tel:+22870679448">+228 70 67 94 48</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="about-right-image">
                                <img src="/assets/img/image10.jpg" alt="img">
                                <div class="sm-image">
                                    <img src="/assets/img/home-4/about/about-02.jpg" alt="img">
                                </div>
                                <div class="shape-1 float-bob-y">
                                    <img src="/assets/img/home-4/about/shape-1.png" alt="img">
                                </div>
                                <div class="shape-2 float-bob-x">
                                    <img src="/assets/img/home-4/about/shape-2.png" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Section Start -->
        <section class="service-section-4 section-padding fix">
            <div class="container">
                <div class="section-title text-center">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Nos Services</span>
                    <h2 class="text-anim">Services Proposés</h2>
                    <p class="mt-2 wow fadeInUp" data-wow-delay=".2s">
                        Collecte, transformation et commercialisation de riz local togolais de qualité supérieure, avec support pour les CDEJ et les marchés locaux.
                    </p>
                </div>
            </div>
            <div class="service-wrapper-4">
                <div class="swiper service-slide-4">
                    <div class="swiper-wrapper">
                        <div
                            v-for="service in services"
                            :key="service.slug"
                            class="swiper-slide"
                        >
                            <div class="service-box-items-4">
                                <div class="thumb">
                                    <img :src="service.image || '/assets/img/image1.jpg'" :alt="service.title">
                                </div>
                                <div class="service-content-area">
                                    <div class="icon"><i :class="service.icon || 'flaticon-tomato'"></i></div>
                                    <div class="content">
                                        <h4><Link :href="`/service-details/${service.slug}`">{{ service.title }}</Link></h4>
                                        <p>{{ service.short }}</p>
                                        <Link :href="`/service-details/${service.slug}`" class="link-btn">Plus d'Info <i class="far fa-arrow-right"></i></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Choose Us Section Start -->
        <section class="home-choose-section section-padding fix">
            <div class="hc-shape d-none d-xl-block float-bob-y">
                <img src="/assets/img/home-4/choose/shape-1.png" alt="img">
            </div>
            <div class="container">
                <!-- Section Header -->
                <div class="section-title text-center hc-header">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Pourquoi HEZOUWE</span>
                    <h2 class="text-anim">Une coopérative locale, fiable et engagée</h2>
                    <p class="mt-2 wow fadeInUp" data-wow-delay=".2s">
                        Nous combinons production locale, certification de qualité, impact social et durabilité pour créer un modèle gagnant-gagnant.
                    </p>
                </div>

                <div class="row g-4 align-items-center">
                    <!-- Left: Image + Stats -->
                    <div class="col-xl-5 col-lg-5">
                        <div class="hc-image-wrap wow fadeInLeft" data-wow-delay=".3s">
                            <div class="hc-img-box">
                                <img src="/assets/img/riz3.jpeg" alt="Riz local HEZOUWE">
                                <div class="hc-badge">
                                    <span>ITRA</span>
                                    <strong>Certifié</strong>
                                </div>
                            </div>
                            <div class="hc-stats-row">
                                <div class="hc-stat">
                                    <strong>30</strong>
                                    <span>Membres actifs</span>
                                </div>
                                <div class="hc-stat">
                                    <strong>13</strong>
                                    <span>Emplois créés</span>
                                </div>
                                <div class="hc-stat">
                                    <strong>10</strong>
                                    <span>CDEJ partenaires</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Feature Cards -->
                    <div class="col-xl-7 col-lg-7">
                        <div class="hc-cards-grid">
                            <div class="hc-card wow fadeInUp" data-wow-delay=".3s">
                                <div class="hc-card-icon"><i class="fas fa-award"></i></div>
                                <h4>Qualité Certifiée</h4>
                                <p>Chaque produit passe par le contrôle qualité ITRA pour garantir vos normes de consommation.</p>
                            </div>
                            <div class="hc-card wow fadeInUp" data-wow-delay=".4s">
                                <div class="hc-card-icon"><i class="fas fa-leaf"></i></div>
                                <h4>100% Naturel</h4>
                                <p>Riz blanc naturellement parfumé sans additifs chimiques, préservant arôme et nutriments.</p>
                            </div>
                            <div class="hc-card wow fadeInUp" data-wow-delay=".5s">
                                <div class="hc-card-icon"><i class="fas fa-hands-helping"></i></div>
                                <h4>Soutien aux Producteurs</h4>
                                <p>Paiement juste et direct aux producteurs locaux, renforçant leur autonomie économique.</p>
                            </div>
                            <div class="hc-card wow fadeInUp" data-wow-delay=".6s">
                                <div class="hc-card-icon"><i class="fas fa-truck"></i></div>
                                <h4>Livraison Locale</h4>
                                <p>Tricycles de transport assurant une politique de proximité et fraîcheur du produit livré.</p>
                            </div>
                            <div class="hc-card wow fadeInUp" data-wow-delay=".7s">
                                <div class="hc-card-icon"><i class="fas fa-seedling"></i></div>
                                <h4>Impact Social</h4>
                                <p>Création d'emplois (13 la première année) et contribution à 10 CDEJ via Compassion Intl.</p>
                            </div>
                            <div class="hc-card wow fadeInUp" data-wow-delay=".8s">
                                <div class="hc-card-icon"><i class="fas fa-female"></i></div>
                                <h4>Leadership Féminin</h4>
                                <p>Coopérative dirigée par une femme avec 12 femmes parmi nos 30 membres actifs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section class="partners-section section-padding fix">
            <div class="container">
                <div class="section-title text-center partners-header">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Nos Partenaires</span>
                    <h2 class="text-anim">Ils Nous Font Confiance</h2>
                    <p class="mt-2 wow fadeInUp" data-wow-delay=".2s">
                        COOP CA HEZOUWE bénéficie du soutien de Compassion Internationale Togo et des 10 Centres de Développement des Enfants (CDEJ)
                    </p>
                </div>
                <div class="partners-grid">
                    <div class="partner-item wow fadeInUp" data-wow-delay=".1s">
                        <img src="/assets/img/brand/brand-01.png" alt="Partenaire">
                    </div>
                    <div class="partner-item wow fadeInUp" data-wow-delay=".2s">
                        <img src="/assets/img/brand/brand-02.png" alt="Partenaire">
                    </div>
                    <div class="partner-item wow fadeInUp" data-wow-delay=".3s">
                        <img src="/assets/img/brand/brand-03.png" alt="Partenaire">
                    </div>
                    <div class="partner-item wow fadeInUp" data-wow-delay=".4s">
                        <img src="/assets/img/brand/brand-04.png" alt="Partenaire">
                    </div>
                    <div class="partner-item wow fadeInUp" data-wow-delay=".5s">
                        <img src="/assets/img/brand/brand-05.png" alt="Partenaire">
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section section-padding fix">
            <div class="container">
                <div class="section-title text-center">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Témoignages</span>
                    <h2 class="text-anim">Ce que Disent Nos Clients</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="testi-card">
                            <div class="testi-quote"><i class="fas fa-quote-left"></i></div>
                            <div class="testi-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>Le riz de HEZOUWE est remarquable! Naturellement parfumé, cuisson rapide et très nutritif. Je recommande fortement à toutes mes amies.</p>
                            <div class="testi-author">
                                <img src="/assets/img/user/user-1.jpg" alt="Ama Akosua">
                                <div>
                                    <h4>Ama Akosua</h4>
                                    <span>Cliente CDEJ Kpalimé</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="testi-card">
                            <div class="testi-quote"><i class="fas fa-quote-left"></i></div>
                            <div class="testi-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>Supporter HEZOUWE c'est soutenir les producteurs locaux togolais. Leur engagement envers la qualité est exemplaire!</p>
                            <div class="testi-author">
                                <img src="/assets/img/user/user-2.jpg" alt="Kofi Mensah">
                                <div>
                                    <h4>Kofi Mensah</h4>
                                    <span>Producteur De Riz Région Plateaux</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section-home fix">
            <div class="cta-bg-layer bg-cover" style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');"></div>
            <div class="cta-overlay"></div>
            <div class="container">
                <div class="cta-inner wow fadeInUp">
                    <span class="cta-badge">Rejoignez Notre Mouvement</span>
                    <h2>Achetez Local,<br>Soutenez le Togo</h2>
                    <p>Achetez du riz HEZOUWE certifié ITRA et contribuez au développement local du TOGO</p>
                    <div class="cta-actions">
                        <Link href="/shop" class="cta-btn-primary">Acheter Maintenant <i class="far fa-arrow-right"></i></Link>
                        <Link href="/contact" class="cta-btn-secondary">Nous Contacter <i class="far fa-arrow-right"></i></Link>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';

const props = defineProps({
    products: { type: Array, default: () => [] },
    services: { type: Array, default: () => [] },
});

const featuredProducts = computed(() => {
    const cats = [
        { key: 'Riz Blanc',      label: 'Exclusif Locale',  fallbackImg: '/assets/img/image2.jpg', fallbackTitle: 'Riz Blanc Naturellement Parfumé' },
        { key: 'Riz Étuvé',      label: 'Nutrition Riche',  fallbackImg: '/assets/img/image3.jpg', fallbackTitle: 'Riz Étuvé Local' },
        { key: 'Sous-Produits',  label: 'Sous-Produits',    fallbackImg: '/assets/img/image4.jpg', fallbackTitle: 'Balles et Son de Riz' },
    ];
    return cats.map(({ key, label, fallbackImg, fallbackTitle }) => {
        const p = props.products.find(x => x.category === key);
        return {
            label,
            title: p ? p.title : fallbackTitle,
            slug:  p ? p.slug  : 'shop',
            bg:    p && p.image ? p.image : fallbackImg,
        };
    });
});

onMounted(() => {
    // Initialize Swiper for hero banner
    if (typeof Swiper !== 'undefined') {
        new Swiper('.banner-active', {
            loop: true,
            slidesPerView: 1,
            effect: 'fade',
            autoplay: {
                delay: 8000,
            },
            navigation: {
                nextEl: '.array-next',
                prevEl: '.array-prev',
            },
        });

        // Initialize service slider
        new Swiper('.service-slide-4', {
            loop: true,
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });

        // Initialize brand slider
        new Swiper('.brand-slide', {
            loop: true,
            slidesPerView: 5,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });

        // Initialize testimonial slider
        new Swiper('.testimonial-slide', {
            loop: true,
            slidesPerView: 1,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.testimonial-next',
                prevEl: '.testimonial-prev',
            },
        });
    }
});
</script>

<style scoped>
/* ===== Hero Section text overrides ===== */
.hero-content h1 {
    font-size: clamp(2.1rem, 4.6vw, 4rem) !important;
    line-height: 1.18 !important;
    letter-spacing: -0.5px !important;
    font-weight: 900 !important;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.35) !important;
    margin-bottom: 18px !important;
}

.hero-content p {
    font-size: clamp(1rem, 1.6vw, 1.15rem) !important;
    line-height: 1.75 !important;
    max-width: 680px !important;
    opacity: 0.92 !important;
    margin-bottom: 0 !important;
}

/* ===== Counter Section Redesign ===== */
.cr-section { background: #f8faf5; }

.cr-wrapper {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 16px 56px rgba(20, 52, 28, 0.12);
}

.cr-text-side {
    height: 100%;
    padding: 52px 48px;
    background: linear-gradient(145deg, #163b1e 0%, #1f5128 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.cr-sub {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.70);
    margin-bottom: 20px;
}

.cr-sub img { width: 18px; opacity: 0.7; }

.cr-text-side h2 {
    font-size: clamp(1.35rem, 2.5vw, 1.75rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.35;
    margin-bottom: 18px;
}

.cr-text-side > p {
    font-size: 14px;
    line-height: 1.75;
    color: rgba(255,255,255,0.72);
    margin-bottom: 28px;
}

.cr-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 28px;
    background: var(--theme-color-2, #f5c518);
    color: #17351f;
    font-weight: 700;
    font-size: 14px;
    border-radius: 6px;
    text-decoration: none;
    align-self: flex-start;
    transition: background 0.25s ease, transform 0.2s ease;
}

.cr-btn:hover { background: #e8b912; transform: translateY(-2px); color: #17351f; }

.cr-stats-side {
    height: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    background: #fff;
}

.cr-stat-box {
    padding: 40px 28px;
    text-align: center;
    border-right: 1px solid rgba(91, 140, 81, 0.12);
    border-bottom: 1px solid rgba(91, 140, 81, 0.12);
    transition: background 0.25s ease;
}

.cr-stat-box:nth-child(2n) { border-right: none; }
.cr-stat-box:nth-child(3),
.cr-stat-box:nth-child(4) { border-bottom: none; }

.cr-stat-box:hover { background: #f4f9f0; }

.cr-stat-icon {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #eef7e9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--theme-color);
    margin: 0 auto 16px;
    transition: background 0.25s ease, color 0.25s ease;
}

.cr-stat-box:hover .cr-stat-icon { background: var(--theme-color); color: #fff; }

.cr-stat-box h2 {
    font-size: 3rem;
    font-weight: 900;
    color: #17351f;
    line-height: 1;
    margin-bottom: 10px;
}

.cr-stat-box > p {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    line-height: 1.4;
    margin: 0;
}

@media (max-width: 991px) {
    .cr-text-side { padding: 40px 32px; }
    .cr-stat-box { padding: 30px 20px; }
    .cr-stat-box h2 { font-size: 2.4rem; }
}

@media (max-width: 575px) {
    .cr-text-side { padding: 32px 24px; }
    .cr-stats-side { grid-template-columns: 1fr 1fr; }
}

/* ===== Choose Us Section ===== */
.home-choose-section {
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(circle at 6% 18%, rgba(91, 140, 81, 0.10) 0%, transparent 32%),
        radial-gradient(circle at 94% 82%, rgba(237, 221, 94, 0.14) 0%, transparent 28%),
        linear-gradient(150deg, #f4f9f0 0%, #ffffff 52%, #eef6e6 100%);
}

.hc-shape {
    position: absolute;
    top: 60px;
    right: 0;
    opacity: 0.28;
    pointer-events: none;
}

/* Section header */
.hc-header {
    max-width: 620px;
    margin: 0 auto 56px;
}

/* -- Image block -- */
.hc-image-wrap {
    position: relative;
}

.hc-img-box {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(20, 52, 28, 0.16);
}

.hc-img-box::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 48%, rgba(12, 34, 18, 0.52) 100%);
    border-radius: 16px;
}

.hc-img-box img {
    display: block;
    width: 100%;
    height: 390px;
    object-fit: cover;
    transition: transform 0.55s ease;
}

.hc-image-wrap:hover .hc-img-box img {
    transform: scale(1.04);
}

.hc-badge {
    position: absolute;
    bottom: 22px;
    right: 22px;
    z-index: 2;
    width: 98px;
    height: 98px;
    border-radius: 50%;
    border: 6px solid rgba(255, 255, 255, 0.88);
    background: var(--theme-color-2, #f5c518);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.22);
}

.hc-badge span {
    display: block;
    font-size: 21px;
    font-weight: 900;
    color: #17351f;
    line-height: 1;
}

.hc-badge strong {
    display: block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: #17351f;
    margin-top: 5px;
    letter-spacing: 0.6px;
}

/* -- Stats bar -- */
.hc-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    margin-top: 20px;
    border: 1px solid rgba(91, 140, 81, 0.18);
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(25, 54, 34, 0.07);
}

.hc-stat {
    padding: 22px 12px;
    text-align: center;
}

.hc-stat:not(:last-child) {
    border-right: 1px solid rgba(91, 140, 81, 0.18);
}

.hc-stat strong {
    display: block;
    font-size: 38px;
    font-weight: 900;
    color: var(--theme-color);
    line-height: 1;
}

.hc-stat span {
    display: block;
    margin-top: 7px;
    font-size: 13px;
    font-weight: 600;
    color: #59656f;
    line-height: 1.3;
}

/* -- Cards grid -- */
.hc-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}

.hc-card {
    background: #fff;
    border: 1px solid rgba(91, 140, 81, 0.13);
    border-radius: 14px;
    padding: 28px 24px;
    box-shadow: 0 6px 24px rgba(25, 54, 34, 0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.hc-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(25, 54, 34, 0.13);
    border-color: rgba(91, 140, 81, 0.35);
}

.hc-card-icon {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #eef7e9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--theme-color);
    margin-bottom: 16px;
    transition: background 0.3s ease, color 0.3s ease;
}

.hc-card:hover .hc-card-icon {
    background: var(--theme-color);
    color: #fff;
}

.hc-card h4 {
    font-size: 17px;
    font-weight: 700;
    color: #17351f;
    margin-bottom: 10px;
}

.hc-card p {
    font-size: 14px;
    color: #59656f;
    line-height: 1.68;
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 1199px) {
    .hc-cards-grid { gap: 14px; }
    .hc-card { padding: 22px 18px; }
}

@media (max-width: 991px) {
    .hc-img-box img { height: 300px; }
    .hc-header { margin-bottom: 40px; }
}

@media (max-width: 767px) {
    .hc-cards-grid { grid-template-columns: 1fr; }
    .hc-header { max-width: 100%; }
}

@media (max-width: 575px) {
    .hc-img-box img { height: 240px; }
    .hc-badge { width: 80px; height: 80px; bottom: 14px; right: 14px; }
    .hc-badge span { font-size: 18px; }
    .hc-stats-row { grid-template-columns: 1fr; }
    .hc-stat:not(:last-child) {
        border-right: none;
        border-bottom: 1px solid rgba(91, 140, 81, 0.18);
    }
}

/* ===== Partners Section ===== */
.partners-section {
    background: #f8faf5;
    border-top: 1px solid rgba(91, 140, 81, 0.10);
    border-bottom: 1px solid rgba(91, 140, 81, 0.10);
}

.partners-header p {
    max-width: 600px;
    margin: 12px auto 0;
    font-size: 15px;
    color: #6b7280;
}

.partners-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 48px;
}

.partner-item {
    flex: 0 0 auto;
    width: 210px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 24px;
    border: 1px solid rgba(91, 140, 81, 0.15);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 18px rgba(25, 54, 34, 0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease, opacity 0.3s ease;
    filter: grayscale(40%);
    opacity: 0.80;
}

.partner-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(25, 54, 34, 0.14);
    filter: grayscale(0%);
    opacity: 1;
}

.partner-item img {
    max-width: 100%;
    max-height: 80px;
    object-fit: contain;
}

.partners-header .section-title span,
.partners-header span {
    font-size: 15px;
}

.partners-header h2 {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
}

.partners-header p {
    font-size: 16px;
}

@media (max-width: 575px) {
    .partner-item { width: 155px; height: 96px; }
    .partner-item img { max-height: 62px; }
}

/* ===== Testimonials Section ===== */
.testimonials-section {
    background: linear-gradient(160deg, #f4f9f0 0%, #fff 52%, #eef6e6 100%);
}

.testi-card {
    height: 100%;
    padding: 36px 32px;
    background: #fff;
    border: 1px solid rgba(91, 140, 81, 0.12);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(25, 54, 34, 0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 22px 52px rgba(25, 54, 34, 0.13);
}

.testi-quote {
    font-size: 38px;
    color: var(--theme-color);
    opacity: 0.22;
    margin-bottom: 14px;
    line-height: 1;
}

.testi-stars {
    display: flex;
    gap: 5px;
    margin-bottom: 20px;
    color: #f5a623;
    font-size: 14px;
}

.testi-card > p {
    font-size: 15px;
    line-height: 1.78;
    color: #4b5563;
    margin-bottom: 28px;
    font-style: italic;
}

.testi-author {
    display: flex;
    align-items: center;
    gap: 16px;
    padding-top: 22px;
    border-top: 1px solid rgba(91, 140, 81, 0.12);
}

.testi-author img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(91, 140, 81, 0.22);
    flex-shrink: 0;
}

.testi-author h4 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 700;
    color: #17351f;
}

.testi-author span {
    font-size: 13px;
    color: #6b7280;
}

@media (max-width: 767px) {
    .testi-card { padding: 26px 22px; }
}

/* ===== CTA Section ===== */
.cta-section-home {
    position: relative;
    padding: 110px 0;
    overflow: hidden;
    text-align: center;
}

.cta-bg-layer {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
}

.cta-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10, 34, 15, 0.88) 0%, rgba(20, 60, 28, 0.78) 100%);
}

.cta-inner {
    position: relative;
    z-index: 2;
    max-width: 700px;
    margin: 0 auto;
}

.cta-badge {
    display: inline-block;
    padding: 7px 22px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.30);
    border-radius: 50px;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    margin-bottom: 26px;
}

.cta-inner h2 {
    color: #fff;
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 900;
    line-height: 1.18;
    margin-bottom: 20px;
}

.cta-inner p {
    color: rgba(255, 255, 255, 0.78);
    font-size: 16px;
    line-height: 1.72;
    margin-bottom: 38px;
    max-width: 560px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

.cta-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 34px;
    background: var(--theme-color-2, #f5c518);
    color: #17351f;
    font-weight: 700;
    font-size: 15px;
    border-radius: 6px;
    text-decoration: none;
    transition: background 0.3s ease, transform 0.22s ease;
}

.cta-btn-primary:hover {
    background: #e8b912;
    transform: translateY(-3px);
    color: #17351f;
}

.cta-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 34px;
    background: rgba(255, 255, 255, 0.10);
    border: 2px solid rgba(255, 255, 255, 0.42);
    color: #fff;
    font-weight: 700;
    font-size: 15px;
    border-radius: 6px;
    text-decoration: none;
    transition: background 0.3s ease, border-color 0.3s ease, transform 0.22s ease;
}

.cta-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.20);
    border-color: rgba(255, 255, 255, 0.72);
    transform: translateY(-3px);
    color: #fff;
}

@media (max-width: 575px) {
    .cta-section-home { padding: 72px 0; }
    .cta-btn-primary,
    .cta-btn-secondary { width: 100%; justify-content: center; }
}
</style>
