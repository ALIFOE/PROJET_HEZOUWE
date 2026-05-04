<template>
    <AppLayout title="Galerie">
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
                        <li>Galerie</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Notre Galerie</h1>
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
                                <img src="/assets/img/home-3/choose-us/choose-01.jpg" alt="img">
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

        <!-- Gallery Section Start -->
        <div class="gallery-section-4 section-padding fix pt-0 section-bg">
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
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/home-4/gallery/gallery-06.jpg" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
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
