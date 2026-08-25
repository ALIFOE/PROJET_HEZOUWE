<template>
    <AppLayout title="À Propos">
        <!-- Breadcrumb Section Start -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/inner-page/shape-1.png" alt="img">
            </div>
            <div class="shape-2 float-bob-x">
                <img src="/assets/img/inner-page/shape-2.png" alt="img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>À Propos de Nous</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">À Propos de HEZOUWE</h1>
                </div>
            </div>
        </section>

        <!-- Choose Us Section Start -->
        <section class="choose-us-section-3 section-padding fix">
            <div class="container">
                <div class="choose-us-wrapper-3">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="choose-us-image-items white-style">
                                <img src="/assets/img/riz3.jpeg" alt="img">
                                <div class="award-box-area">
                                    <div class="top-items">
                                        <div class="award-icon">
                                            <i class="flaticon-leaf"></i>
                                        </div>
                                        <h4>Certification ITRA</h4>
                                    </div>
                                    <p>
                                        Notre riz bénéficie de la certification ITRA garantissant la qualité et la traçabilité.
                                    </p>
                                </div>
                                <div class="treat-image">
                                    <img src="/assets/img/home-3/choose-us/teat-shape.png" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="choose-us-content">
                                <div class="section-title mb-0">
                                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Pourquoi HEZOUWE</span>
                                    <h2 class="text-anim">Riz Local Premium du TOGO</h2>
                                </div>
                                <p class="choose-text wow fadeInUp" data-wow-delay=".3s">
                                    COOP CA HEZOUWE est une coopérative engagée dans la collecte, la transformation et la commercialisation du riz local togolais de qualité supérieure. Fondée en 2023, nous unissons 30 producteurs passionnés pour créer un impact positif dans notre région.
                                </p>
                                <div class="icon-items-area">
                                    <div class="icon-items wow fadeInUp" data-wow-delay=".5s">
                                        <div class="icon">
                                            <i class="flaticon-leaf"></i>
                                        </div>
                                        <div class="content">
                                            <h4>Riz Local et Produits Naturels</h4>
                                            <p>
                                                Nous cultivons et transformons le riz local togolais suivant des méthodes respectueuses de l'environnement.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="icon-items wow fadeInUp" data-wow-delay=".7s">
                                        <div class="icon">
                                            <i class="flaticon-food-safety"></i>
                                        </div>
                                        <div class="content">
                                            <h4>Qualité Garantie 100%</h4>
                                            <p>
                                                Notre certification ITRA assure des produits de qualité supérieure et tracés avec précision.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <Link href="/contact" class="theme-btn mt-5 wow fadeInUp" data-wow-delay=".9s">
                                    Nous Contacter <i class="far fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Brand Section Start -->
        <!-- <div class="brand-section section-padding pt-0">
            <div class="container">
                <div class="top-text text-center wow fadeInUp">
                    <p>Riz Hezouwe est utilisé par plus de 5,000+ clients à travers le TOGO et l'Afrique de l'Ouest</p>
                </div>
                <div class="swiper brand-slide">
                    <div class="swiper-wrapper"> -->
                        <!-- <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz1.jpg" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz2.jpg" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz3.jpg" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz4.jpg" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz5.jpg" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-image text-center">
                                <img src="/assets/img/riz6.jpg" alt="img">
                            </div>
                        </div> -->
                    <!-- </div>
                </div>
            </div>
        </div> -->

        <!-- Product Box Section Start -->
        <section class="product-box-section-4 style-about section-padding pt-0">
            <div class="container">
                <div class="section-title text-center mb-50">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Produits en vedette</span>
                    <h2 class="text-anim">Nos meilleures offres de riz local</h2>
                </div>
                <div class="row g-4">
                    <div
                        v-for="(item, i) in dynamicFeaturedProducts"
                        :key="item.slug"
                        class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp"
                        :data-wow-delay="`.${3 + i * 2}s`"
                    >
                        <div class="products-box-items bg-cover" :style="`background-image: url('${item.bg}');`">
                            <div class="product-content">
                                <span>{{ item.label }}</span>
                                <h3>{{ item.title }}</h3>
                                <Link :href="`/shop-details/${item.slug}`" class="theme-btn">
                                    Acheter <i class="fas fa-shopping-basket"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Choose Us Section Start -->
        <section class="choose-us-section-4 fix pt-0 section-padding section-bg">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/home-4/choose/shape-1.png" alt="img">
            </div>
            <div class="container">
                <div class="choose-us-wrapper-4">
                    <div class="award-box-area d-none d-xxl-block wow fadeInUp">
                        <div class="top-items">
                            <div class="award-icon">
                                <i class="flaticon-leaf"></i>
                            </div>
                            <h4>Fondée en 2023</h4>
                        </div>
                        <p>
                            Une jeune coopérative engagée dans la transformation du riz local togolais.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="choose-us-left-img">
                                <img src="/assets/img/riz3.jpeg" alt="img">
                                <div class="sm-thumb"></div>
                                <div class="sm-thumb-2">
                                    <img src="/assets/img/home-4/choose/delivery-shape.png" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 mt-4 mt-lg-0">
                            <div class="choose-us-content">
                                <div class="section-title mb-0">
                                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Notre Mission</span>
                                    <h2 class="text-anim">Soutenir Les Producteurs Locaux</h2>
                                </div>
                                <p class="choose-text wow fadeInUp" data-wow-delay=".2s">
                                    HEZOUWE travaille pour soutenir les petits producteurs de riz du TOGO, améliorer leurs revenus et créer des emplois durables dans notre communauté. Nous croyons en la valeur du riz local et en l'importance de la traçabilité.
                                </p>
                                <ul class="wow fadeInUp" data-wow-delay=".4s">
                                    <li>
                                        <i class="far fa-check"></i>
                                        Soutien direct aux 30 producteurs membres
                                    </li>
                                    <li>
                                        <i class="far fa-check"></i>
                                        Création de 13 emplois directs et indirects
                                    </li>
                                </ul>
                                <div class="progress-area">
                                    <div class="progress-wrap">
                                        <div class="pro-items wow fadeInUp animated" data-wow-delay=".5s">
                                            <div class="pro-head">
                                                <h6 class="title">
                                                    Qualité du Riz
                                                </h6>
                                                <span class="point">
                                                    95%
                                                </span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-value"></div>
                                            </div>
                                        </div>
                                        <div class="pro-items wow fadeInUp animated" data-wow-delay=".7s">
                                            <div class="pro-head">
                                                <h6 class="title">
                                                    Satisfaction Clients
                                                </h6>
                                                <span class="point">
                                                    98%
                                                </span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-value style-two"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <Link href="/contact" class="theme-btn wow fadeInUp" data-wow-delay=".9s">
                                    Nous Contacter <i class="far fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 
        <!-- Gallery Section -->
        <div class="gallery-section-3 fix bg-white section-padding">
            <div class="container">
                <div class="section-title text-center mb-50">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Notre Galerie</span>
                    <h2 class="text-anim">Nos Activités &amp; Produits</h2>
                    <p class="mt-3 wow fadeInUp" data-wow-delay=".2s">
                        Découvrez nos installations, nos producteurs et nos produits riz de qualité premium certifiés par l'ITRA.
                    </p>
                </div>
                <div class="about-gallery-grid">
                    <Link
                        v-for="(item, i) in galleryItems"
                        :key="`${item.title}-${i}`"
                        :href="item.href"
                        class="about-gallery-card wow fadeInUp"
                        :class="{ 'about-gallery-card--large': i === 0, 'about-gallery-card--wide': i === 3 }"
                        :data-wow-delay="`${0.2 + i * 0.1}s`"
                    >
                        <img :src="item.image" :alt="item.title">
                        <div class="about-gallery-info">
                            <span>{{ item.label }}</span>
                            <h3>{{ item.title }}</h3>
                            <p>{{ item.text }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

         <!-- Counter Section Start -->
        <section class="counter-section-51 fix pt-0">
            <div class="container">
                <div class="counter-wrapper-5">
                    <div class="counter-box-items wow fadeInUp" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="flaticon-farmer"></i>
                        </div>
                        <div class="content">
                            <h2><span class="odometer" data-count="30">00</span>+</h2>
                            <p>Producteurs Membres</p>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="counter-box-items wow fadeInUp" data-wow-delay=".4s">
                        <div class="icon">
                            <i class="flaticon-food-safety"></i>
                        </div>
                        <div class="content">
                            <h2><span class="odometer" data-count="5">00</span>K+</h2>
                            <p>Clients Satisfaits</p>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="counter-box-items wow fadeInUp" data-wow-delay=".6s">
                        <div class="icon">
                            <i class="flaticon-like"></i>
                        </div>
                        <div class="content">
                            <h2><span class="odometer" data-count="98">00</span>%</h2>
                            <p>Satisfaction Clients</p>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="counter-box-items wow fadeInUp" data-wow-delay=".8s">
                        <div class="icon">
                            <i class="flaticon-delivery"></i>
                        </div>
                        <div class="content">
                            <h2><span class="odometer" data-count="13">00</span>+</h2>
                            <p>Emplois Créés</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Products Section Start -->
        <section class="products-section-5 section-padding fix">
            <div class="shop-shape-1 d-none d-xxl-block float-bob-y">
                <img src="/assets/img/home-5/products/shape-1.png" alt="img">
            </div>
            <div class="shop-shape-2 d-none d-xxl-block float-bob-x">
                <img src="/assets/img/home-5/products/shape-2.png" alt="img">
            </div>
            <div class="shop-shape-3 d-none d-xxl-block float-bob-y">
                <img src="/assets/img/home-5/products/shape-3.png" alt="img">
            </div>
            <div class="container">
                <div class="section-title text-center">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Nos Produits</span>
                    <h2 class="text-anim">Riz de Qualité Premium</h2>
                </div>
                <div class="row">
                    <div
                        v-for="(product, i) in visibleProducts"
                        :key="product.slug"
                        class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp"
                        :data-wow-delay="`${0.2 + (i % 4) * 0.2}s`"
                    >
                        <div class="products-image-box-5">
                            <div class="thumb">
                                <img :src="product.image || '/assets/img/image1.jpg'" :alt="product.title">
                                <Link :href="`/shop-details/${product.slug}`" class="theme-btn">
                                    Ajouter au panier <i class="fas fa-shopping-basket"></i>
                                </Link>
                            </div>
                            <div class="content">
                                <ul>
                                    <li>{{ product.price ? product.price.toLocaleString('fr-FR') + ' FCFA' : '' }}</li>
                                    <li v-if="product.price_promo"><del>{{ product.price_promo.toLocaleString('fr-FR') }} FCFA</del></li>
                                </ul>
                                <h3><Link :href="`/shop-details/${product.slug}`">{{ product.title }}</Link></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section Start -->
        <section class="about-testi-section section-padding fix pt-0">
            <div class="container">
                <div class="section-title text-center mb-50">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Témoignages</span>
                    <h2 class="text-anim">Ce que Disent Nos Clients</h2>
                </div>
                <div class="row g-4">
                    <div
                        v-for="(testimonial, i) in testimonials"
                        :key="testimonial.name"
                        class="col-lg-4 wow fadeInUp"
                        :data-wow-delay="`${0.2 + i * 0.2}s`"
                    >
                        <div class="at-card" :class="{ 'at-card--featured': i === 1 }">
                            <div class="at-quote"><i class="fas fa-quote-left"></i></div>
                            <div class="at-stars">
                                <i v-for="star in testimonial.rating" :key="star" class="fas fa-star"></i>
                            </div>
                            <p class="at-dynamic-text">{{ testimonial.text }}</p>
                            <p>Le riz de HEZOUWE est de meilleure qualité et les prix sont justes. Je recommande à tous !</p>
                            <div class="at-author">
                                <div class="at-avatar at-dynamic-avatar">{{ testimonial.initials }}</div>
                                <div class="at-dynamic-author">
                                    <h4>{{ testimonial.name }}</h4>
                                    <span>{{ testimonial.role }}</span>
                                </div>
                                <div class="at-avatar"><i class="fas fa-user"></i></div>
                                <div>
                                    <h4>Alassane Sow</h4>
                                    <span>Producteur Partenaire</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay=".4s">
                        <div class="at-card at-card--featured">
                            <div class="at-quote"><i class="fas fa-quote-left"></i></div>
                            <div class="at-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>Naturellement parfumé, cuisson rapide et très nutritif. Le riz HEZOUWE a changé nos habitudes alimentaires !</p>
                            <div class="at-author">
                                <div class="at-avatar"><i class="fas fa-user"></i></div>
                                <div>
                                    <h4>Ama Akosua</h4>
                                    <span>Cliente CDEJ Kpalimé</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay=".6s">
                        <div class="at-card">
                            <div class="at-quote"><i class="fas fa-quote-left"></i></div>
                            <div class="at-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>Supporter HEZOUWE c'est soutenir les producteurs locaux. Leur engagement envers la qualité est exemplaire !</p>
                            <div class="at-author">
                                <div class="at-avatar"><i class="fas fa-user"></i></div>
                                <div>
                                    <h4>Kofi Mensah</h4>
                                    <span>Producteur Région Plateaux</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section Start -->
        <section class="news-section-4 section-padding fix pt-0">
            <div class="news-shape-1 d-none d-xxl-block float-bob-x">
                <img src="/assets/img/home-4/news/shape-1.png" alt="img">
            </div>
            <div class="news-shape-2 d-none d-xxl-block float-bob-y">
                <img src="/assets/img/home-4/news/shape-2.png" alt="img">
            </div>
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Actualités & Blog</span>
                        <h2 class="text-anim">Dernièresres Actualités <br> de HEZOUWE</h2>
                    </div>
                    <Link href="/news" class="theme-btn wow fadeInUp" data-wow-delay=".2s">
                        Voir Toutes les Actualités <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
                <div class="row">
                    <div
                        v-for="(article, i) in latestNews"
                        :key="article.slug"
                        class="col-lg-6 col-md-6 wow fadeInUp"
                        :data-wow-delay="`${0.3 + i * 0.2}s`"
                    >
                        <div class="news-image-box-items-4">
                            <div class="news-image">
                                <img :src="article.image || article.thumb || '/assets/img/inner-page/news/news-01.jpg'" :alt="article.title">
                                <div class="post-date">
                                    <h4>{{ article.dateDay }}</h4>
                                    <p>{{ article.dateMonth }}</p>
                                </div>
                            </div>
                            <div class="content">
                                <ul class="post-date">
                                    <li>
                                        {{ article.category || 'ActualitÃ©' }}
                                    </li>
                                    <li>
                                        {{ article.commentsLabel }}
                                    </li>
                                </ul>
                                <h3 class="about-news-title"><Link :href="`/news-details/${article.slug}`">{{ article.title }}</Link></h3>
                                <Link :href="`/news-details/${article.slug}`" class="link-btn about-news-link">Plus de Détails
                                    <i class="far fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div v-if="!latestNews.length" class="col-12">
                        <p class="about-news-empty">Aucun article pour le moment. Revenez bientôt.</p>
                    </div>
                </div>
            </div>
        </section>

       <!-- Cta Discount Section Start -->
        <section class="cta-discount-section-4 section-padding pt-0">
            <div class="container">
                <div class="cta-wrapper-4 bg-cover" style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');">
                    <div class="cta-discount-area">
                        <div class="circle-bg-icon wow fadeInUp">
                            <img src="/assets/img/home-3/cta-discount/white-circle.png" alt="img" class="circle-icon">
                            <div class="icon">
                                <i class="flaticon-leaf"></i>
                            </div>
                        </div>
                        <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Offre Spéciale</span>
                            <h2 class="text-white text-anim">Profitez de Réductions <br> Jusqu'à  30% sur Nos Produits!</h2>
                        </div>
                    </div>
                    <Link href="/shop" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                       Découvrir Nos Produits <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Gallery Section Start -->
       <!-- <div class="gallery-section-4 section-padding fix pt-0 section-bg">
            <div class="swiper gallery-slide">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image1.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image2.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image3.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image4.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image5.jpg" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';

const props = defineProps({
    products: { type: Array, default: () => [] },
    news:     { type: Array, default: () => [] },
});

const fallbackProducts = [
    { slug: 'riz-blanc-premium-5kg', title: 'Riz Blanc Premium 5kg', category: 'Riz Blanc', image: '/assets/img/riz2.jpeg', price: 5000, price_promo: 6000, short: 'Riz blanc local certifie ITRA.' },
    { slug: 'riz-etuve-local-5kg', title: 'Riz Etuve Local 5kg', category: 'Riz Etuve', image: '/assets/img/riz3.jpeg', price: 5500, price_promo: 6500, short: 'Riz etuve nutritif et parfume.' },
    { slug: 'riz-itra-certifie-10kg', title: 'Riz ITRA Certifie 10kg', category: 'Riz Certifie', image: '/assets/img/riz5.jpeg', price: 7000, price_promo: 8500, short: 'Format familial certifie ITRA.' },
    { slug: 'balles-son-riz-5kg', title: 'Balles & Son de Riz 5kg', category: 'Sous-Produits', image: '/assets/img/riz5.jpeg', price: 2000, price_promo: 2500, short: 'Sous-produits naturels de riz.' },
];

const visibleProducts = computed(() => {
    return (props.products.length ? props.products : fallbackProducts).slice(0, 8);
});

const featuredProducts = computed(() => {
    const cats = [
        { key: 'Riz Blanc',     label: 'Premium',      fallbackImg: '/assets/img/image10.jpg', fallbackTitle: 'Riz Blanc Naturel' },
        { key: 'Riz Étuvé',     label: 'Spécialité',   fallbackImg: '/assets/img/image1.jpg',  fallbackTitle: 'Riz Étuvé Local' },
        { key: 'Riz Certifié',  label: 'Certification', fallbackImg: '/assets/img/image2.jpg',  fallbackTitle: 'Riz ITRA Certifié' },
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

const dynamicFeaturedProducts = computed(() => {
    const labels = ['Premium', 'Specialite', 'Certification'];

    return visibleProducts.value.slice(0, 3).map((product, index) => ({
        label: product.badge || labels[index] || 'HEZOUWE',
        title: product.title,
        slug: product.slug,
        bg: product.image || `/assets/img/riz${index + 2}.jpeg`,
    }));
});

const galleryItems = computed(() => {
    const productItems = visibleProducts.value.slice(0, 4).map((product, index) => ({
        label: product.category || 'Produit',
        title: product.title,
        text: product.short || 'Riz local togolais transforme et conditionne par HEZOUWE.',
        image: product.image || `/assets/img/riz${index + 2}.jpeg`,
        href: `/shop-details/${product.slug}`,
    }));

    const fallbacks = [
        { label: 'Production', title: 'Production de Riz Local', text: 'Suivi des producteurs et recoltes locales.', image: '/assets/img/riz7.jpeg', href: '/gallery' },
        { label: 'Qualite', title: 'Transformation & Certification', text: 'Controle qualite et certification ITRA.', image: '/assets/img/riz5.jpeg', href: '/gallery' },
        { label: 'Terroir', title: 'Riz Premium du TOGO', text: 'Une gamme concue pour les foyers et professionnels.', image: '/assets/img/riz3.jpeg', href: '/shop' },
        { label: 'Cooperative', title: 'Nos Producteurs Partenaires', text: 'Une chaine locale portee par les membres.', image: '/assets/img/riz2.jpeg', href: '/about' },
    ];

    return [...productItems, ...fallbacks].slice(0, 4);
});

const formatNewsDate = (article) => {
    if (article.date && typeof article.date === 'string') {
        const parts = article.date.split(' ');
        if (parts.length === 1 && article.date.includes('-')) {
            const parsed = new Date(article.date);
            if (!Number.isNaN(parsed.getTime())) {
                return {
                    day: String(parsed.getDate()).padStart(2, '0'),
                    month: parsed.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }).toUpperCase(),
                };
            }
        }

        return {
            day: parts[0] || '',
            month: parts.slice(1).join(' ').toUpperCase() || '',
        };
    }

    return { day: '', month: '' };
};

const latestNews = computed(() => {
    return props.news.slice(0, 2).map((article) => {
        const date = formatNewsDate(article);

        return {
            ...article,
            dateDay: date.day,
            dateMonth: date.month,
            commentsLabel: `${String(article.comments || 0).padStart(2, '0')} Commentaires`,
        };
    });
});

const testimonials = [
    {
        name: 'Alassane Sow',
        role: 'Producteur Partenaire',
        initials: 'AS',
        rating: 5,
        text: 'Le riz de HEZOUWE est de meilleure qualite et les prix sont justes. Je recommande a tous !',
    },
    {
        name: 'Ama Akosua',
        role: 'Cliente CDEJ Kpalime',
        initials: 'AA',
        rating: 5,
        text: 'Naturellement parfume, cuisson rapide et tres nutritif. Le riz HEZOUWE a change nos habitudes alimentaires !',
    },
    {
        name: 'Kofi Mensah',
        role: 'Producteur Region Plateaux',
        initials: 'KM',
        rating: 5,
        text: 'Supporter HEZOUWE, c est soutenir les producteurs locaux. Leur engagement envers la qualite est exemplaire !',
    },
];

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
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

        // Initialize gallery slider 3
        new Swiper('.gallery-slide-3', {
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

        // Initialize testimonial slider
        new Swiper('.testimonial-slide', {
            loop: true,
            slidesPerView: 1,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.array-next',
                prevEl: '.array-prev',
            },
        });

        // Initialize gallery slider
        new Swiper('.gallery-slide', {
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
    }
});
</script>

<style scoped>
.about-gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.about-gallery-card {
    position: relative;
    min-height: 280px;
    overflow: hidden;
    border-radius: 8px;
    display: block;
    isolation: isolate;
    background: #111;
}

.about-gallery-card--large {
    grid-column: span 2;
    grid-row: span 2;
    min-height: 584px;
}

.about-gallery-card--wide {
    grid-column: span 2;
}

.about-gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    transition: transform 0.45s ease;
    z-index: -2;
}

.about-gallery-card::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.04), rgba(10, 48, 25, 0.84));
    z-index: -1;
}

.about-gallery-card:hover img {
    transform: scale(1.06);
}

.about-gallery-info {
    min-height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 28px;
    color: #fff;
}

.about-gallery-info span {
    width: fit-content;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.18);
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
}

.about-gallery-info h3 {
    color: #fff;
    font-size: 26px;
    line-height: 1.2;
    margin-bottom: 8px;
}

.about-gallery-info p {
    color: rgba(255, 255, 255, 0.86);
    margin-bottom: 0;
}

.about-testi-section .row.g-4 > .col-lg-4:nth-child(n+4),
.at-card > p:not(.at-dynamic-text),
.at-author > .at-avatar:not(.at-dynamic-avatar),
.at-author > div:not(.at-avatar):not(.at-dynamic-author) {
    display: none;
}

.about-news-empty {
    text-align: center;
    color: #68746a;
    padding: 40px 20px;
}

.at-card {
    height: 100%;
    border: 1px solid rgba(44, 121, 58, 0.14);
    border-radius: 8px;
    padding: 34px;
    background: #fff;
    box-shadow: 0 18px 44px rgba(22, 54, 32, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.at-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 54px rgba(22, 54, 32, 0.14);
}

.at-card--featured {
    background: #163d25;
    color: #fff;
}

.at-card--featured h4,
.at-card--featured p {
    color: #fff;
}

.at-quote {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: rgba(74, 164, 82, 0.12);
    color: var(--theme);
    margin-bottom: 22px;
}

.at-card--featured .at-quote {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
}

.at-stars {
    color: #f6b936;
    margin-bottom: 16px;
}

.at-dynamic-text {
    min-height: 96px;
    color: #5f6b62;
    line-height: 1.7;
}

.at-author {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 26px;
}

.at-avatar {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    flex: 0 0 auto;
    background: #ecf6ee;
    color: #163d25;
    font-weight: 800;
}

.at-card--featured .at-avatar {
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
}

.at-author h4 {
    margin-bottom: 4px;
}

.at-author span {
    color: #718073;
    font-size: 14px;
}

.at-card--featured .at-author span {
    color: rgba(255, 255, 255, 0.76);
}

@media (max-width: 991px) {
    .about-gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .about-gallery-card--large {
        min-height: 420px;
    }
}

@media (max-width: 575px) {
    .about-gallery-grid {
        grid-template-columns: 1fr;
    }

    .about-gallery-card,
    .about-gallery-card--large,
    .about-gallery-card--wide {
        grid-column: auto;
        grid-row: auto;
        min-height: 320px;
    }

    .about-gallery-info {
        padding: 22px;
    }
}
</style>
