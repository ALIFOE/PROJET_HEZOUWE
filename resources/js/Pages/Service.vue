<template>
    <AppLayout title="Nos Services">

        <!-- ══════════════════════════════════════════
             BREADCRUMB
        ══════════════════════════════════════════ -->
        <section class="breadcrumb-wrapper bg-cover fix"
                 style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/inner-page/shape-1.png" alt="">
            </div>
            <div class="shape-2 float-bob-x">
                <img src="/assets/img/inner-page/shape-2.png" alt="">
            </div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Nos Services</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Services</h1>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             BARRE DE STATS
        ══════════════════════════════════════════ -->
        <div class="sv-stats-bar">
            <div class="container">
                <div class="sv-stats-inner">
                    <div class="sv-stat-item wow fadeInUp" data-wow-delay=".1s">
                        <span class="sv-stat-num">{{ allServices.length }}</span>
                        <span class="sv-stat-label">Services disponibles</span>
                    </div>
                    <div class="sv-stat-sep"></div>
                    <div class="sv-stat-item wow fadeInUp" data-wow-delay=".2s">
                        <span class="sv-stat-num">30<sup>+</sup></span>
                        <span class="sv-stat-label">Producteurs partenaires</span>
                    </div>
                    <div class="sv-stat-sep"></div>
                    <div class="sv-stat-item wow fadeInUp" data-wow-delay=".3s">
                        <span class="sv-stat-num">5K<sup>+</sup></span>
                        <span class="sv-stat-label">Clients satisfaits</span>
                    </div>
                    <div class="sv-stat-sep"></div>
                    <div class="sv-stat-item wow fadeInUp" data-wow-delay=".4s">
                        <span class="sv-stat-num">98<sup>%</sup></span>
                        <span class="sv-stat-label">Satisfaction client</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════
             INTRO SECTION
        ══════════════════════════════════════════ -->
        <section class="sv-intro section-padding pb-0">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="section-title mb-0">
                            <span><img src="/assets/img/sub-title.svg" alt="">Ce que nous faisons</span>
                            <h2 class="text-anim">Une filière riz locale, intégrée et certifiée</h2>
                        </div>
                        <p class="sv-intro-text mt-4">
                            COOP CA HEZOUWE maîtrise l'intégralité de la chaîne de valeur du riz local togolais :
                            de la collecte en champ jusqu'à la livraison chez le client, en passant par la
                            transformation, la certification ITRA et le conditionnement professionnel.
                        </p>
                        <div class="sv-intro-checks mt-4">
                            <div class="sv-check"><i class="far fa-check-circle"></i> Qualité certifiée ITRA</div>
                            <div class="sv-check"><i class="far fa-check-circle"></i> Traçabilité complète</div>
                            <div class="sv-check"><i class="far fa-check-circle"></i> Livraison partout au TOGO</div>
                            <div class="sv-check"><i class="far fa-check-circle"></i> Support client 6j/7</div>
                        </div>
                        <Link href="/contact" class="theme-btn mt-5">
                            Prendre Contact <i class="far fa-arrow-right"></i>
                        </Link>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".4s">
                        <div class="sv-intro-images">
                            <img src="/assets/img/riz6.jpeg" alt="Collecte HEZOUWE" class="sv-img-main">
                            <img src="/assets/img/image4.jpg" alt="Transformation HEZOUWE" class="sv-img-float">
                            <div class="sv-img-badge">
                                <i class="flaticon-broccoli"></i>
                                <span>Certifié<br>ITRA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             GRILLE DES SERVICES (dynamique)
        ══════════════════════════════════════════ -->
        <section class="sv-grid-section section-padding">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="">Nos Prestations</span>
                    <h2 class="text-anim">Tous nos Services</h2>
                    <p class="sv-section-sub mt-3">
                        Chaque service est conçu pour garantir la qualité du riz local togolais à chaque étape.
                    </p>
                </div>

                <div class="row g-4">
                    <div
                        v-for="(s, i) in allServices"
                        :key="s.slug"
                        class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp"
                        :data-wow-delay="`${(i % 4) * 0.15 + 0.2}s`"
                    >
                        <div class="sv-card">
                            <!-- Image + overlay -->
                            <div class="sv-card-img">
                                <img :src="s.image" :alt="s.title">
                                <div class="sv-card-num">{{ String(i + 1).padStart(2,'0') }}</div>
                                <div class="sv-card-overlay">
                                    <Link :href="'/service-details/' + s.slug" class="sv-card-overlay-btn">
                                        <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                            <!-- Contenu -->
                            <div class="sv-card-body">
                                <div class="sv-card-icon">
                                    <i :class="s.icon"></i>
                                </div>
                                <h4 class="sv-card-title">
                                    <Link :href="'/service-details/' + s.slug">{{ s.title }}</Link>
                                </h4>
                                <p class="sv-card-text">{{ s.short }}</p>
                                <Link :href="'/service-details/' + s.slug" class="sv-card-link">
                                    Voir les détails <i class="far fa-long-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             PROCESSUS EN 4 ÉTAPES
        ══════════════════════════════════════════ -->
        <section class="sv-process-section section-padding pt-0">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="">Comment ça marche</span>
                    <h2 class="text-anim">Notre Processus en 4 Étapes</h2>
                </div>
                <div class="sv-process-line">
                    <div
                        v-for="(step, i) in process"
                        :key="i"
                        class="sv-process-item wow fadeInUp"
                        :data-wow-delay="`${i * 0.2 + 0.2}s`"
                    >
                        <div class="sv-process-circle">
                            <i :class="step.icon"></i>
                            <span class="sv-process-num">{{ String(i+1).padStart(2,'0') }}</span>
                        </div>
                        <h5>{{ step.title }}</h5>
                        <p>{{ step.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             BANNER VIDÉO + POURQUOI NOUS
        ══════════════════════════════════════════ -->
        <section class="sv-why-section section-padding fix section-bg">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5 wow fadeInUp" data-wow-delay=".2s">
                        <div class="sv-why-video">
                            <img src="/assets/img/image5.jpg" alt="HEZOUWE">
                            <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I"
                               class="video-btn video-popup sv-play-btn">
                                <i class="fas fa-play"></i>
                            </a>
                            <div class="sv-why-badge">
                                <strong>2023</strong>
                                <span>Fondée</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay=".4s">
                        <div class="section-title mb-4">
                            <span><img src="/assets/img/sub-title.svg" alt="">Pourquoi nous choisir</span>
                            <h2 class="text-anim">HEZOUWE, l'excellence du riz local togolais</h2>
                        </div>
                        <p class="sv-why-text">
                            Nos services s'appuient sur une infrastructure moderne, des équipes formées et
                            une certification ITRA garantissant à chaque client un produit de qualité supérieure,
                            tracé de la parcelle jusqu'à votre assiette.
                        </p>
                        <div class="sv-why-grid mt-4">
                            <div v-for="w in whyUs" :key="w.title" class="sv-why-item">
                                <div class="sv-why-icon">
                                    <i :class="w.icon"></i>
                                </div>
                                <div>
                                    <h6>{{ w.title }}</h6>
                                    <p>{{ w.text }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 d-flex align-items-center gap-4 flex-wrap">
                            <Link href="/about" class="theme-btn">
                                En savoir plus <i class="far fa-arrow-right"></i>
                            </Link>
                            <div class="sv-phone">
                                <i class="fas fa-phone-alt"></i>
                                <div>
                                    <small>Appelez-nous</small>
                                    <a href="tel:+22870679448">+228 70 67 94 48</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             CTA BANNER
        ══════════════════════════════════════════ -->
        <section class="cta-banner-5 section-padding bg-cover"
                 style="background-image: url('/assets/img/image5.jpg');">
            <div class="container text-center">
                <h2 class="text-anim text-white">
                    Riz Local de Qualité.<br>
                    Pour un TOGO meilleur et prospère.
                </h2>
                <p class="text-white mt-3 mb-5" style="opacity:.85;font-size:1.05rem;">
                    De la collecte à la livraison, chaque grain est une promesse de qualité.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <Link href="/shop" class="theme-btn">
                        Nos Produits <i class="far fa-arrow-right"></i>
                    </Link>
                    <Link href="/contact" class="sv-btn-outline">
                        Nous Contacter <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             TÉMOIGNAGE CLIENT
        ══════════════════════════════════════════ -->
        <section class="sv-testi-section section-padding fix">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="">Témoignages</span>
                    <h2 class="text-anim">Ce que disent nos clients</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <div v-for="(t, i) in testimonials" :key="i"
                         class="col-lg-4 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${i * 0.2 + 0.2}s`">
                        <div class="sv-testi-card">
                            <div class="sv-testi-stars">
                                <i v-for="n in 5" :key="n" class="fas fa-star"></i>
                            </div>
                            <p class="sv-testi-text">"{{ t.text }}"</p>
                            <div class="sv-testi-author">
                                <div class="sv-testi-avatar">{{ t.initials }}</div>
                                <div>
                                    <strong>{{ t.name }}</strong>
                                    <small>{{ t.role }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             CTA DISCOUNT
        ══════════════════════════════════════════ -->
        <section class="cta-discount-section-4 section-padding pt-0">
            <div class="container">
                <div class="cta-wrapper-4 bg-cover"
                     style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');">
                    <div class="cta-discount-area">
                        <div class="circle-bg-icon wow fadeInUp">
                            <img src="/assets/img/home-3/cta-discount/white-circle.png" alt="" class="circle-icon">
                            <div class="icon"><i class="flaticon-leaf"></i></div>
                        </div>
                        <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="">Offre Spéciale</span>
                            <h2 class="text-white text-anim">
                                Service de Qualité<br>Pour Votre Satisfaction!
                            </h2>
                        </div>
                    </div>
                    <Link href="/contact" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Nous Contacter <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             GALERIE SLIDER
        ══════════════════════════════════════════ -->
        <div class="gallery-section-4 section-padding fix pt-0 section-bg">
            <div class="swiper gallery-slide">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/image1.jpg" alt=""></div></div>
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/image2.jpg" alt=""></div></div>
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/image3.jpg" alt=""></div></div>
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/image4.jpg" alt=""></div></div>
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/image5.jpg" alt=""></div></div>
                    <div class="swiper-slide"><div class="gallery-image-4"><img src="/assets/img/home-4/gallery/gallery-06.jpg" alt=""></div></div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

defineProps({
    allServices: { type: Array, required: true },
});

const process = [
    { icon: 'flaticon-eco-friendly',  title: 'Collecte',         text: 'Récolte directe auprès des 30 producteurs partenaires avec contrôle qualité sur le terrain.' },
    { icon: 'flaticon-dairy-products', title: 'Transformation',   text: 'Décorticage, blanchiment et triage optique selon les normes ITRA dans nos installations modernes.' },
    { icon: 'flaticon-broccoli',       title: 'Certification',    text: 'Chaque lot est analysé et certifié ITRA avant d\'être conditionné pour la vente.' },
    { icon: 'flaticon-delivery',       title: 'Livraison',        text: 'Expédition sécurisée partout au TOGO et en Afrique de l\'Ouest avec suivi en temps réel.' },
];

const whyUs = [
    { icon: 'flaticon-leaf',         title: 'Riz 100% Local',      text: 'Produit exclusivement au TOGO par des agriculteurs locaux certifiés.' },
    { icon: 'flaticon-food-safety',  title: 'Certification ITRA',  text: 'Label qualité reconnu garantissant traçabilité et sécurité alimentaire.' },
    { icon: 'flaticon-delivery',     title: 'Livraison Rapide',    text: 'Disponible sous 48h dans tout le TOGO, sans rupture de stock.' },
    { icon: 'flaticon-farmer',       title: '30 Producteurs',      text: 'Une coopérative solide qui soutient directement les familles rurales.' },
];

const testimonials = [
    { name: 'Alassane Sow',      role: 'Revendeur, Lomé',       initials: 'AS', text: 'Le riz HEZOUWE est d\'une qualité remarquable. Mes clients sont fidèles depuis que j\'ai commencé à le proposer. Je ne changerai pour rien au monde.' },
    { name: 'Akosua Mensah',     role: 'Restauratrice, Atakpamé', initials: 'AM', text: 'La cuisson est parfaite, le grain est entier et le goût est incomparable. C\'est le riz local que j\'ai toujours cherché pour mon restaurant.' },
    { name: 'Ibrahim Tchakpele', role: 'Grossiste, Kpalimé',    initials: 'IT', text: 'Les délais de livraison sont toujours respectés et le conditionnement est professionnel. Un partenaire fiable sur qui on peut compter.' },
];

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
        new Swiper('.gallery-slide', {
            loop: true, slidesPerView: 5, spaceBetween: 30,
            autoplay: { delay: 3000 },
            breakpoints: {
                1200: { slidesPerView: 5 },
                992:  { slidesPerView: 4 },
                768:  { slidesPerView: 3 },
                576:  { slidesPerView: 2 },
                0:    { slidesPerView: 1 },
            },
        });
    }
});
</script>

<style scoped>
/* ── Variables ── */
:root { --green: #5cb85c; }

/* ════════════════════════════════
   BARRE STATS
════════════════════════════════ */
.sv-stats-bar {
    background: #1a3a1a;
    padding: 18px 0;
}
.sv-stats-inner {
    display: flex; align-items: center;
    justify-content: center; flex-wrap: wrap; gap: 0;
}
.sv-stat-item {
    display: flex; flex-direction: column; align-items: center;
    padding: 10px 40px; text-align: center;
}
.sv-stat-num {
    font-size: 1.75rem; font-weight: 800; color: #fff; line-height: 1;
}
.sv-stat-num sup { font-size: .9rem; }
.sv-stat-label { font-size: .75rem; color: rgba(255,255,255,.65); text-transform: uppercase; letter-spacing: .06em; margin-top: 4px; }
.sv-stat-sep { width: 1px; height: 40px; background: rgba(255,255,255,.2); }

/* ════════════════════════════════
   INTRO
════════════════════════════════ */
.sv-intro-text { font-size: 1rem; line-height: 1.8; color: #555; }
.sv-intro-checks { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.sv-check { display: flex; align-items: center; gap: 10px; font-size: .9rem; color: #444; font-weight: 500; }
.sv-check i { color: var(--green, #5cb85c); font-size: 1rem; }

.sv-intro-images { position: relative; }
.sv-img-main { width: 100%; height: 420px; object-fit: cover; border-radius: 16px; }
.sv-img-float {
    position: absolute; bottom: -20px; left: -20px;
    width: 180px; height: 180px; object-fit: cover;
    border-radius: 12px; border: 5px solid #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,.2);
}
.sv-img-badge {
    position: absolute; top: 20px; right: 20px;
    background: var(--green, #5cb85c); color: #fff;
    border-radius: 50%; width: 90px; height: 90px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; font-size: .75rem; font-weight: 700; line-height: 1.3;
    box-shadow: 0 6px 20px rgba(92,184,92,.4);
}
.sv-img-badge i { font-size: 1.4rem; margin-bottom: 2px; }

/* ════════════════════════════════
   SECTION SUB TEXTE
════════════════════════════════ */
.sv-section-sub { font-size: .95rem; color: #666; max-width: 560px; margin: 0 auto; }

/* ════════════════════════════════
   CARDS SERVICES
════════════════════════════════ */
.sv-card {
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
    background: #fff;
    transition: transform .35s ease, box-shadow .35s ease;
    height: 100%;
    display: flex; flex-direction: column;
}
.sv-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(92,184,92,.18);
}

/* Image */
.sv-card-img { position: relative; height: 220px; overflow: hidden; }
.sv-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .5s ease;
}
.sv-card:hover .sv-card-img img { transform: scale(1.08); }

/* Numéro */
.sv-card-num {
    position: absolute; top: 14px; left: 14px;
    background: rgba(0,0,0,.55); color: #fff;
    font-size: .7rem; font-weight: 800; letter-spacing: .08em;
    padding: 4px 10px; border-radius: 20px;
}

/* Overlay hover */
.sv-card-overlay {
    position: absolute; inset: 0;
    background: rgba(26, 58, 26, .55);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .35s;
}
.sv-card:hover .sv-card-overlay { opacity: 1; }
.sv-card-overlay-btn {
    width: 54px; height: 54px; border-radius: 50%;
    background: var(--green, #5cb85c);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem;
    text-decoration: none;
    transform: scale(.7); transition: transform .3s;
}
.sv-card:hover .sv-card-overlay-btn { transform: scale(1); }

/* Corps */
.sv-card-body {
    padding: 24px 22px; flex: 1; display: flex; flex-direction: column;
}
.sv-card-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: linear-gradient(135deg, #f0faf0 0%, #d8f0d8 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--green, #5cb85c);
    margin-bottom: 14px;
}
.sv-card-title { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
.sv-card-title a { color: inherit; text-decoration: none; transition: color .2s; }
.sv-card-title a:hover { color: var(--green, #5cb85c); }
.sv-card-text { font-size: .875rem; color: #666; line-height: 1.6; flex: 1; margin-bottom: 16px; }
.sv-card-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .875rem; font-weight: 600; color: var(--green, #5cb85c);
    text-decoration: none; transition: gap .2s;
    margin-top: auto;
}
.sv-card-link:hover { gap: 14px; color: var(--green, #5cb85c); }

/* ════════════════════════════════
   PROCESSUS
════════════════════════════════ */
.sv-process-line {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 0; position: relative;
}
.sv-process-line::before {
    content: ''; position: absolute;
    top: 40px; left: calc(12.5%); right: calc(12.5%);
    height: 2px; background: linear-gradient(90deg, var(--green, #5cb85c), #9de89d);
    z-index: 0;
}
.sv-process-item {
    text-align: center; padding: 0 20px; position: relative; z-index: 1;
}
.sv-process-circle {
    width: 80px; height: 80px; border-radius: 50%;
    background: #fff; border: 3px solid var(--green, #5cb85c);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    margin: 0 auto 20px; position: relative;
    font-size: 22px; color: var(--green, #5cb85c);
    box-shadow: 0 4px 16px rgba(92,184,92,.2);
    transition: background .3s, color .3s;
}
.sv-process-item:hover .sv-process-circle {
    background: var(--green, #5cb85c); color: #fff;
}
.sv-process-num {
    font-size: .65rem; font-weight: 800; color: #bbb;
    position: absolute; bottom: -8px; right: -4px;
    background: #fff; padding: 1px 5px; border-radius: 6px;
    border: 1px solid #e0e0e0; line-height: 1;
}
.sv-process-item h5 { font-size: .95rem; font-weight: 700; margin-bottom: 8px; }
.sv-process-item p  { font-size: .83rem; color: #666; line-height: 1.6; }

@media (max-width: 767px) {
    .sv-process-line { grid-template-columns: 1fr 1fr; gap: 30px; }
    .sv-process-line::before { display: none; }
}
@media (max-width: 480px) {
    .sv-process-line { grid-template-columns: 1fr; }
}

/* ════════════════════════════════
   POURQUOI NOUS
════════════════════════════════ */
.sv-why-video {
    position: relative; border-radius: 16px; overflow: hidden;
}
.sv-why-video img { width: 100%; height: 440px; object-fit: cover; border-radius: 16px; }
.sv-play-btn {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 70px; height: 70px; border-radius: 50%;
    background: var(--green, #5cb85c); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    z-index: 2; text-decoration: none;
}
.sv-why-badge {
    position: absolute; bottom: 20px; right: 20px;
    background: #fff; border-radius: 12px; padding: 12px 18px; text-align: center;
    box-shadow: 0 6px 24px rgba(0,0,0,.15);
}
.sv-why-badge strong { display: block; font-size: 1.5rem; font-weight: 800; color: var(--green, #5cb85c); line-height: 1; }
.sv-why-badge span   { font-size: .75rem; color: #888; text-transform: uppercase; }

.sv-why-text { font-size: .95rem; color: #555; line-height: 1.8; }

.sv-why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.sv-why-item { display: flex; gap: 14px; align-items: flex-start; }
.sv-why-icon {
    width: 44px; height: 44px; border-radius: 10px;
    background: linear-gradient(135deg, #f0faf0, #d8f0d8);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: var(--green, #5cb85c); flex-shrink: 0;
}
.sv-why-item h6 { font-size: .9rem; font-weight: 700; margin-bottom: 4px; }
.sv-why-item p  { font-size: .8rem; color: #666; margin: 0; line-height: 1.5; }

.sv-phone { display: flex; align-items: center; gap: 12px; }
.sv-phone i {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--green, #5cb85c); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: .9rem;
}
.sv-phone small { display: block; font-size: .75rem; color: #888; }
.sv-phone a { font-weight: 700; color: #222; font-size: .95rem; text-decoration: none; }

/* ════════════════════════════════
   BUTTON OUTLINE (CTA banner)
════════════════════════════════ */
.sv-btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 32px; border-radius: 6px;
    border: 2px solid #fff; color: #fff; font-weight: 700;
    font-size: .95rem; text-decoration: none;
    transition: background .3s, color .3s;
}
.sv-btn-outline:hover { background: #fff; color: #1a3a1a; }

/* ════════════════════════════════
   TÉMOIGNAGES
════════════════════════════════ */
.sv-testi-card {
    background: #fff; border-radius: 16px; padding: 28px;
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
    border: 1px solid #e8f5e8;
    transition: transform .3s, box-shadow .3s;
    height: 100%;
}
.sv-testi-card:hover { transform: translateY(-5px); box-shadow: 0 12px 36px rgba(92,184,92,.15); }
.sv-testi-stars { color: #f5a623; margin-bottom: 14px; font-size: .9rem; letter-spacing: 2px; }
.sv-testi-text { font-size: .9rem; color: #555; line-height: 1.7; font-style: italic; margin-bottom: 20px; }
.sv-testi-author { display: flex; align-items: center; gap: 12px; }
.sv-testi-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: linear-gradient(135deg, #2d7a2d, #5cb85c);
    color: #fff; font-weight: 700; font-size: .85rem;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.sv-testi-author strong { display: block; font-size: .9rem; font-weight: 700; }
.sv-testi-author small  { color: #888; font-size: .8rem; }
</style>
