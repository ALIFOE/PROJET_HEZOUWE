<template>
    <AppLayout title="Nos Produits">
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
                        <li>Nos Produits</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Produits</h1>
                </div>
            </div>
        </section>

        <!-- Shop Section Start -->
        <section class="shop-section section-padding fix">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-6 col-md-7 order-2 order-xl-1">
                        <div class="shop-main-sidebar">
                            <div class="single-sidebar-widget">
                                <div class="wid-title wow fadeInUp" data-wow-delay=".2s">
                                    <h3>Recherche</h3>
                                </div>
                                <div class="search_widget wow fadeInUp">
                                    <form action="#">
                                        <input type="text" placeholder="Entrez un produit...">
                                        <button type="submit"><i class="fal fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="single-sidebar-widget">
                                <div class="wid-title wow fadeInUp" data-wow-delay=".2s">
                                    <h3>Catégories</h3>
                                </div>
                                <div class="widget_categories wow fadeInUp" data-wow-delay=".4s">
                                    <ul>
                                        <li><Link href="/shop-details">Riz Blanc <span>12</span></Link></li>
                                        <li><Link href="/shop-details">Riz Étuvé<span>08</span></Link></li>
                                        <li><Link href="/shop-details">Sous-Produits<span>06</span></Link></li>
                                        <li><Link href="/shop-details">Riz Certification ITRA<span>(10)</span></Link></li>
                                        <li><Link href="/shop-details">Graines de Riz<span>04</span></Link></li>
                                        <li><Link href="/shop-details">Packs Découverte<span>05</span></Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="single-sidebar-widget">
                                <div class="wid-title wow fadeInUp" data-wow-delay=".4s">
                                    <h3>Meilleures Ventes</h3>
                                </div>
                                <div class="popular-posts">
                                    <div class="single-post-item style-2 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="thumb bg-cover" style="background-image: url('/assets/img/riz2.jpeg');"></div>
                                        <div class="post-content">
                                            <div class="star">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h4><Link href="/shop-details">Riz Blanc Premium 5kg</Link></h4>
                                            <p>5 000 - 6 000 FCFA</p>
                                        </div>
                                    </div>
                                    <div class="single-post-item style-2 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="thumb bg-cover" style="background-image: url('/assets/img/riz3.jpeg');"></div>
                                        <div class="post-content">
                                            <div class="star">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h4><Link href="/shop-details">Riz Étuvé Local 5kg</Link></h4>
                                            <p>5 500 - 6 500 FCFA</p>
                                        </div>
                                    </div>
                                    <div class="single-post-item style-2 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="thumb bg-cover" style="background-image: url('/assets/img/riz5.jpeg');"></div>
                                        <div class="post-content">
                                            <div class="star">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h4><Link href="/shop-details">Riz ITRA Certifié 10kg</Link></h4>
                                            <p>7 000 - 8 500 FCFA</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-sidebar-widget">
                                <div class="wid-title wow fadeInUp" data-wow-delay=".4s">
                                    <h3>Filtrer par prix</h3>
                                </div>
                                <div class="price-range-wrapper">
                                        <div class="slider-container">
                                            <input type="range" id="min-slider" class="slider" min="1000" max="15000" value="1000">
                                            <input type="range" id="max-slider" class="slider" min="1000" max="15000" value="10000">
                                        </div>
                                        <div class="price-text pt-4 d-flex gap-3">
                                            <label for="amount">Prix:</label>
                                            <input type="text" id="amount" readonly style="border:0;">
                                        </div>
                                </div>
                            </div>
                            <div class="single-sidebar-widget wow fadeInUp" data-wow-delay=".6s">
                                <div class="wid-title">
                                    <h3>Produits Populaires</h3>
                                </div>
                                <div class="tagcloud">
                                    <Link href="/shop-details">Riz Blanc</Link>     
                                    <Link href="/shop-details">Riz Étuvé</Link>
                                    <Link href="/shop-details">ITRA</Link>
                                    <Link href="/shop-details">Premium</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz2.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <span class="discount-icon">20%</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz Blanc Premium 5kg</Link></h5>
                                        <ul>
                                            <li>
                                                5 000 FCFA
                                            </li>
                                            <li>
                                                <del>6 000 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz2.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz Étuvé Local 5kg</Link></h5>
                                        <ul>
                                            <li>
                                                5 500 FCFA
                                            </li>
                                            <li>
                                                <del>6 500 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz3.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <span class="discount-icon">15%</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz ITRA Certifié 10kg</Link></h5>
                                        <ul>
                                            <li>
                                                7 000 FCFA
                                            </li>
                                            <li>
                                                <del>8 500 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz5.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Balles & Son de Riz 5kg</Link></h5>
                                        <ul>
                                            <li>
                                                2 000 FCFA
                                            </li>
                                            <li>
                                                <del>2 500 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz6.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz Blanc Bulk 25kg</Link></h5>
                                        <ul>
                                            <li>
                                                10 000 FCFA
                                            </li>
                                            <li>
                                                <del>12 000 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz7.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz Étuvé Bulk 25kg</Link></h5>
                                        <ul>
                                            <li>
                                                11 000 FCFA
                                            </li>
                                            <li>
                                                <del>13 000 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz8.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Graines de Riz Premium 1kg</Link></h5>
                                        <ul>
                                            <li>
                                                3 000 FCFA
                                            </li>
                                            <li>
                                                <del>4 000 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz2.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Pack Découverte Riz</Link></h5>
                                        <ul>
                                            <li>
                                                8 000 FCFA
                                            </li>
                                            <li>
                                                <del>10 000 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                <div class="shop-box-items style-inner mt-0">
                                    <div class="shop-image">
                                        <img src="/assets/img/riz8.jpeg" alt="img">
                                        <span class="sale-icon">Promo</span>
                                        <ul class="shop-icon d-flex justify-content-center align-items-center">
                                            <li>
                                                <Link href="/shop-cart"><i class="far fa-heart"></i></Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-cart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link href="/shop-details"><i class="far fa-eye"></i></Link>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5><Link href="/shop-details">Riz Bio Rare 3kg</Link></h5>
                                        <ul>
                                            <li>
                                                4 500 FCFA
                                            </li>
                                            <li>
                                                <del>5 500 FCFA</del>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-nav-wrap text-center">
                            <ul>
                                <li class="active"><a class="page-numbers" href="javascript:void(0)"><i class="fal fa-long-arrow-left"></i></a></li>
                                <li><a class="page-numbers" href="javascript:void(0)">01</a></li>
                                <li><a class="page-numbers" href="javascript:void(0)">02</a></li>
                                <li class="active"><a class="page-numbers" href="javascript:void(0)"><i class="fal fa-long-arrow-right"></i></a></li>
                            </ul>
                        </div>
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
                            <h2 class="text-white text-anim">Commande Groupée? <br> Profitez de Tarifs Spéciaux!</h2>
                        </div>
                    </div>
                    <Link href="/contact" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                       Nous Contacter <i class="far fa-arrow-right"></i>
                    </Link>
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
