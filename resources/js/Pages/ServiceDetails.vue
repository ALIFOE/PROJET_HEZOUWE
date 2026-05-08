<template>
    <AppLayout :title="service.title">

        <!-- ══════════════════════════════════════════
             BREADCRUMB
        ══════════════════════════════════════════ -->
        <section class="breadcrumb-wrapper bg-cover fix"
                 style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt=""></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt=""></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/service">Services</Link></li>
                        <li>//</li>
                        <li>{{ service.title }}</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">{{ service.title }}</h1>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             CONTENU PRINCIPAL (8 col) + SIDEBAR (4 col)
        ══════════════════════════════════════════ -->
        <section class="section-padding fix">
            <div class="container">
                <div class="row g-5">

                    <!-- ─── COLONNE PRINCIPALE ─── -->
                    <div class="col-lg-8">

                        <!-- Hero image -->
                        <div class="sdd-hero wow fadeInUp">
                            <img :src="service.image" :alt="service.title">
                            <div class="sdd-hero-ribbon">
                                <i :class="service.icon"></i>
                                <span>{{ service.title }}</span>
                            </div>
                        </div>

                        <!-- Titre + descriptions -->
                        <div class="sdd-block wow fadeInUp" data-wow-delay=".2s">
                            <div class="section-title mb-4">
                                <span><img src="/assets/img/sub-title.svg" alt="">HEZOUWE</span>
                                <h2>{{ service.title }}</h2>
                            </div>
                            <p class="sdd-lead">{{ service.description }}</p>
                            <p class="mt-3">{{ service.description2 }}</p>
                        </div>

                        <!-- Deux images côte à côte -->
                        <div class="row g-4 sdd-block wow fadeInUp" data-wow-delay=".3s">
                            <div class="col-md-6">
                                <div class="sdd-sub-img"><img :src="service.image2" :alt="service.title"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="sdd-sub-img"><img :src="service.image3" :alt="service.title"></div>
                            </div>
                        </div>

                        <!-- Timeline / Processus -->
                        <div class="sdd-block wow fadeInUp" data-wow-delay=".35s">
                            <h3 class="sdd-section-h">Notre Processus</h3>
                            <div class="sdd-timeline">
                                <div
                                    v-for="step in service.steps"
                                    :key="step.num"
                                    class="sdd-timeline-item"
                                >
                                    <div class="sdd-tl-dot">
                                        <span>{{ step.num }}</span>
                                    </div>
                                    <div class="sdd-tl-content">
                                        <h5>{{ step.title }}</h5>
                                        <p>{{ step.text }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Avantages -->
                        <div class="sdd-block wow fadeInUp" data-wow-delay=".4s">
                            <h3 class="sdd-section-h">Nos Avantages</h3>
                            <div class="sdd-benefits-grid">
                                <div
                                    v-for="(b, i) in service.benefits"
                                    :key="i"
                                    class="sdd-benefit"
                                >
                                    <i class="far fa-check-circle"></i>
                                    <span>{{ b }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Chiffres clés -->
                        <div class="sdd-facts wow fadeInUp" data-wow-delay=".45s">
                            <div
                                v-for="fact in service.facts"
                                :key="fact.label"
                                class="sdd-fact"
                            >
                                <strong>{{ fact.value }}</strong>
                                <span>{{ fact.label }}</span>
                            </div>
                        </div>

                        <!-- CTA bas de contenu -->
                        <div class="sdd-block sdd-cta-row wow fadeInUp" data-wow-delay=".5s">
                            <Link href="/contact" class="theme-btn">
                                Nous Contacter <i class="far fa-arrow-right"></i>
                            </Link>
                            <Link href="/shop" class="sdd-btn-sec">
                                Voir nos Produits <i class="far fa-arrow-right"></i>
                            </Link>
                            <div class="sdd-phone">
                                <i class="fas fa-phone-alt"></i>
                                <div>
                                    <small>Appelez-nous</small>
                                    <a href="tel:+22870679448">+228 70 67 94 48</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ─── SIDEBAR ─── -->
                    <div class="col-lg-4">

                        <!-- Navigation tous les services -->
                        <div class="sdd-widget wow fadeInUp" data-wow-delay=".2s">
                            <div class="sdd-widget-head">
                                <i class="flaticon-leaf"></i>
                                <h5>Tous nos Services</h5>
                            </div>
                            <nav class="sdd-service-nav">
                                <Link
                                    v-for="s in allServices"
                                    :key="s.slug"
                                    :href="'/service-details/' + s.slug"
                                    class="sdd-nav-item"
                                    :class="{ active: s.slug === service.slug }"
                                >
                                    <span class="sdd-nav-icon"><i :class="s.icon"></i></span>
                                    <span class="sdd-nav-label">{{ s.title }}</span>
                                    <i class="far fa-chevron-right sdd-nav-arrow"></i>
                                </Link>
                            </nav>
                        </div>

                        <!-- Widget contact -->
                        <div class="sdd-widget sdd-contact-widget wow fadeInUp" data-wow-delay=".35s">
                            <div class="sdd-contact-bg bg-cover"
                                 style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
                                <div class="sdd-contact-mask">
                                    <div class="sdd-contact-icon"><i class="fas fa-headset"></i></div>
                                    <h4>Besoin d'aide ?</h4>
                                    <p>Notre équipe est disponible pour répondre à toutes vos demandes.</p>
                                    <a href="tel:+22870679448" class="sdd-contact-num">
                                        <i class="fas fa-phone-alt"></i> +228 70 67 94 48
                                    </a>
                                    <a href="tel:+22890452773" class="sdd-contact-num">
                                        <i class="fas fa-phone-alt"></i> +228 90 45 27 73
                                    </a>
                                    <Link href="/contact" class="theme-btn d-block text-center mt-3">
                                        Nous Contacter <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Chiffres clés sidebar -->
                        <div class="sdd-widget wow fadeInUp" data-wow-delay=".5s">
                            <div class="sdd-widget-head">
                                <i class="flaticon-like"></i>
                                <h5>Chiffres Clés</h5>
                            </div>
                            <div class="sdd-facts-sidebar">
                                <div v-for="fact in service.facts" :key="fact.label" class="sdd-fact-sb">
                                    <strong>{{ fact.value }}</strong>
                                    <span>{{ fact.label }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Badge certification -->
                        <div class="sdd-widget sdd-cert-widget wow fadeInUp" data-wow-delay=".6s">
                            <div class="sdd-cert-inner">
                                <div class="sdd-cert-seal">
                                    <i class="flaticon-broccoli"></i>
                                </div>
                                <div>
                                    <h6>Certifié ITRA</h6>
                                    <p>Tous nos services et produits répondent aux normes ITRA pour une qualité garantie.</p>
                                    <Link href="/service-details/certification" class="link-btn">
                                        En savoir plus <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             AUTRES SERVICES
        ══════════════════════════════════════════ -->
        <section class="section-padding pt-0 fix">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="">Découvrir aussi</span>
                    <h2 class="text-anim">Nos Autres Services</h2>
                </div>
                <div class="row g-4">
                    <div
                        v-for="(s, i) in otherServices"
                        :key="s.slug"
                        class="col-lg-3 col-md-6 wow fadeInUp"
                        :data-wow-delay="`${i * 0.15 + 0.2}s`"
                    >
                        <div class="sdd-other-card">
                            <div class="sdd-other-img">
                                <img :src="s.image" :alt="s.title">
                                <div class="sdd-other-overlay">
                                    <Link :href="'/service-details/' + s.slug" class="sdd-other-link">
                                        <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                            <div class="sdd-other-body">
                                <div class="sdd-other-icon"><i :class="s.icon"></i></div>
                                <h5><Link :href="'/service-details/' + s.slug">{{ s.title }}</Link></h5>
                                <p>{{ s.short }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════════════════════════════
             CTA + GALERIE
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
                            <h2 class="text-white text-anim">Profitez de Réductions<br>Jusqu'à 30% sur Nos Produits!</h2>
                        </div>
                    </div>
                    <Link href="/shop" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Découvrir Nos Produits <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>

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
import { computed, onMounted } from 'vue';

const props = defineProps({
    service:     { type: Object, required: true },
    allServices: { type: Array,  required: true },
});

const otherServices = computed(() =>
    props.allServices.filter(s => s.slug !== props.service.slug).slice(0, 4)
);

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
/* ════════════════════════════════
   HERO IMAGE
════════════════════════════════ */
.sdd-hero { position: relative; border-radius: 16px; overflow: hidden; margin-bottom: 40px; }
.sdd-hero img { width: 100%; height: 460px; object-fit: cover; display: block; }
.sdd-hero-ribbon {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 20px 28px;
    background: linear-gradient(0deg, rgba(0,40,0,.85) 0%, transparent 100%);
    display: flex; align-items: center; gap: 14px;
    color: #fff;
}
.sdd-hero-ribbon i { font-size: 1.8rem; color: #9de89d; }
.sdd-hero-ribbon span { font-size: 1.3rem; font-weight: 700; }

/* ════════════════════════════════
   BLOCKS CONTENUS
════════════════════════════════ */
.sdd-block { margin-bottom: 40px; }
.sdd-section-h {
    font-size: 1.25rem; font-weight: 700;
    margin-bottom: 24px; padding-bottom: 12px;
    border-bottom: 2px solid #e8f5e8; color: #1a3a1a;
}
.sdd-lead { font-size: 1.05rem; line-height: 1.8; color: #333; font-weight: 500; }

/* ════════════════════════════════
   IMAGES SECONDAIRES
════════════════════════════════ */
.sdd-sub-img { border-radius: 12px; overflow: hidden; }
.sdd-sub-img img { width: 100%; height: 230px; object-fit: cover; display: block;
    transition: transform .4s; }
.sdd-sub-img:hover img { transform: scale(1.04); }

/* ════════════════════════════════
   TIMELINE PROCESSUS
════════════════════════════════ */
.sdd-timeline { display: flex; flex-direction: column; gap: 0; }
.sdd-timeline-item {
    display: flex; gap: 20px; align-items: flex-start;
    padding-bottom: 28px; position: relative;
}
.sdd-timeline-item:not(:last-child)::before {
    content: ''; position: absolute;
    left: 23px; top: 52px; bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, #5cb85c 0%, #c8e6c8 100%);
}
.sdd-tl-dot {
    width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #2d7a2d, #5cb85c);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .85rem; font-weight: 800; z-index: 1;
    box-shadow: 0 4px 14px rgba(92,184,92,.35);
}
.sdd-tl-content {
    background: #f9fdf9; border: 1px solid #e8f5e8;
    border-radius: 12px; padding: 18px 20px; flex: 1;
    transition: box-shadow .25s;
}
.sdd-tl-content:hover { box-shadow: 0 4px 16px rgba(92,184,92,.15); }
.sdd-tl-content h5 { font-size: .95rem; font-weight: 700; margin-bottom: 6px; color: #1a3a1a; }
.sdd-tl-content p  { font-size: .875rem; color: #666; margin: 0; line-height: 1.6; }

/* ════════════════════════════════
   AVANTAGES
════════════════════════════════ */
.sdd-benefits-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
}
.sdd-benefit {
    display: flex; align-items: center; gap: 10px;
    background: #fff; border: 1px solid #e8f5e8;
    border-radius: 8px; padding: 12px 16px;
    font-size: .875rem; color: #444;
    transition: background .2s, border-color .2s;
}
.sdd-benefit:hover { background: #f0faf0; border-color: #aaddaa; }
.sdd-benefit i { color: #5cb85c; font-size: 1rem; flex-shrink: 0; }

/* ════════════════════════════════
   CHIFFRES CLÉS (bande)
════════════════════════════════ */
.sdd-facts {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    margin-bottom: 40px;
}
.sdd-fact {
    text-align: center; padding: 24px 12px;
    background: linear-gradient(135deg, #f0faf0, #e0f2e0);
    border: 1px solid #c8e6c8; border-radius: 12px;
}
.sdd-fact strong {
    display: block; font-size: 1.75rem; font-weight: 800;
    color: #2d7a2d; line-height: 1; margin-bottom: 6px;
}
.sdd-fact span { font-size: .75rem; color: #666; text-transform: uppercase; letter-spacing: .04em; }

/* ════════════════════════════════
   CTA BAS
════════════════════════════════ */
.sdd-cta-row {
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    border-top: 1px solid #e8f5e8; padding-top: 32px;
}
.sdd-btn-sec {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px; border-radius: 6px;
    border: 2px solid #5cb85c; color: #2d7a2d; font-weight: 700;
    text-decoration: none; font-size: .9rem;
    transition: background .25s, color .25s;
}
.sdd-btn-sec:hover { background: #5cb85c; color: #fff; }
.sdd-phone { display: flex; align-items: center; gap: 10px; margin-left: auto; }
.sdd-phone i {
    width: 38px; height: 38px; border-radius: 50%;
    background: #5cb85c; color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: .8rem;
}
.sdd-phone small { display: block; font-size: .7rem; color: #888; }
.sdd-phone a { font-weight: 700; font-size: .9rem; color: #222; text-decoration: none; }

/* ════════════════════════════════
   SIDEBAR WIDGETS
════════════════════════════════ */
.sdd-widget {
    background: #fff; border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    margin-bottom: 28px;
}
.sdd-widget-head {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 22px;
    background: linear-gradient(135deg, #1a3a1a, #2d7a2d);
    color: #fff;
}
.sdd-widget-head i  { font-size: 1.3rem; color: #9de89d; }
.sdd-widget-head h5 { margin: 0; font-size: .95rem; font-weight: 700; color: #fff; }

/* Navigation services */
.sdd-service-nav { display: flex; flex-direction: column; }
.sdd-nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 22px; border-bottom: 1px solid #f0f0f0;
    text-decoration: none; color: #444;
    transition: background .2s, padding-left .2s, color .2s;
}
.sdd-nav-item:last-child { border-bottom: none; }
.sdd-nav-item:hover, .sdd-nav-item.active {
    background: #f0faf0; padding-left: 28px;
    color: #2d7a2d;
}
.sdd-nav-item.active { font-weight: 700; }
.sdd-nav-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: #e8f5e8; display: flex; align-items: center;
    justify-content: center; font-size: .9rem; color: #5cb85c; flex-shrink: 0;
}
.sdd-nav-item.active .sdd-nav-icon { background: #5cb85c; color: #fff; }
.sdd-nav-label { flex: 1; font-size: .875rem; }
.sdd-nav-arrow { font-size: .65rem; color: #bbb; }
.sdd-nav-item.active .sdd-nav-arrow { color: #5cb85c; }

/* Widget contact */
.sdd-contact-widget { overflow: hidden; }
.sdd-contact-bg { position: relative; min-height: 360px; }
.sdd-contact-mask {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,50,0,.75) 0%, rgba(0,30,0,.92) 100%);
    padding: 32px 24px; display: flex; flex-direction: column; align-items: center;
    text-align: center;
}
.sdd-contact-icon {
    width: 62px; height: 62px; border-radius: 50%;
    background: rgba(255,255,255,.15); display: flex; align-items: center;
    justify-content: center; font-size: 24px; color: #fff; margin-bottom: 16px;
}
.sdd-contact-mask h4 { color: #fff; font-size: 1.2rem; margin-bottom: 10px; }
.sdd-contact-mask p  { color: rgba(255,255,255,.75); font-size: .85rem; margin-bottom: 18px; }
.sdd-contact-num {
    display: flex; align-items: center; gap: 8px;
    color: #fff; font-weight: 600; font-size: .9rem;
    text-decoration: none; margin-bottom: 8px;
    transition: opacity .2s;
}
.sdd-contact-num:hover { opacity: .8; color: #fff; }
.sdd-contact-num i { color: #9de89d; }

/* Chiffres sidebar */
.sdd-facts-sidebar { padding: 16px 22px; display: flex; flex-direction: column; gap: 14px; }
.sdd-fact-sb {
    display: flex; align-items: center; justify-content: space-between;
    padding-bottom: 14px; border-bottom: 1px solid #f0f0f0;
}
.sdd-fact-sb:last-child { border-bottom: none; padding-bottom: 0; }
.sdd-fact-sb strong { font-size: 1.25rem; font-weight: 800; color: #2d7a2d; }
.sdd-fact-sb span   { font-size: .8rem; color: #666; text-align: right; max-width: 60%; }

/* Badge certification */
.sdd-cert-widget {
    background: linear-gradient(135deg, #f0faf0, #e0f2e0);
    border: 1px solid #c8e6c8;
}
.sdd-cert-inner { display: flex; gap: 14px; align-items: flex-start; padding: 22px; }
.sdd-cert-seal {
    width: 52px; height: 52px; border-radius: 50%; flex-shrink: 0;
    background: #5cb85c; display: flex; align-items: center;
    justify-content: center; font-size: 22px; color: #fff;
}
.sdd-cert-inner h6 { font-size: .95rem; font-weight: 700; margin-bottom: 6px; color: #1a3a1a; }
.sdd-cert-inner p  { font-size: .825rem; color: #555; line-height: 1.6; margin-bottom: 10px; }

/* ════════════════════════════════
   AUTRES SERVICES (cards bas)
════════════════════════════════ */
.sdd-other-card {
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.08); background: #fff;
    transition: transform .3s, box-shadow .3s; height: 100%;
    display: flex; flex-direction: column;
}
.sdd-other-card:hover { transform: translateY(-6px); box-shadow: 0 12px 36px rgba(92,184,92,.18); }
.sdd-other-img { position: relative; height: 200px; overflow: hidden; }
.sdd-other-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.sdd-other-card:hover .sdd-other-img img { transform: scale(1.07); }
.sdd-other-overlay {
    position: absolute; inset: 0;
    background: rgba(0,50,0,.5);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .3s;
}
.sdd-other-card:hover .sdd-other-overlay { opacity: 1; }
.sdd-other-link {
    width: 48px; height: 48px; border-radius: 50%;
    background: #5cb85c; color: #fff; text-decoration: none;
    display: flex; align-items: center; justify-content: center;
    transform: scale(.7); transition: transform .3s;
}
.sdd-other-card:hover .sdd-other-link { transform: scale(1); }
.sdd-other-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.sdd-other-icon {
    width: 44px; height: 44px; border-radius: 10px;
    background: #f0faf0; display: flex; align-items: center;
    justify-content: center; font-size: 18px; color: #5cb85c;
    margin-bottom: 12px;
}
.sdd-other-body h5 { font-size: .9rem; font-weight: 700; margin-bottom: 8px; }
.sdd-other-body h5 a { color: inherit; text-decoration: none; transition: color .2s; }
.sdd-other-body h5 a:hover { color: #5cb85c; }
.sdd-other-body p {
    font-size: .825rem; color: #666; margin: 0; line-height: 1.6;
    display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}

/* ════════════════════════════════
   RESPONSIVE
════════════════════════════════ */
@media (max-width: 767px) {
    .sdd-hero img { height: 260px; }
    .sdd-facts   { grid-template-columns: 1fr 1fr; }
    .sdd-benefits-grid { grid-template-columns: 1fr; }
    .sdd-cta-row { flex-direction: column; align-items: flex-start; }
    .sdd-phone   { margin-left: 0; }
}
</style>
