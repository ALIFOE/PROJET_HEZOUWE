<template>
    <AppLayout title="Accueil">
        <section class="home-hero">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <span class="eyebrow">COOP CA HEZOUWE</span>
                        <h1>Riz local du Togo, transforme avec soin et livre avec confiance.</h1>
                        <p>
                            Decouvrez nos produits certifies, nos services de collecte, transformation, conditionnement et livraison pour les familles, revendeurs et institutions.
                        </p>
                        <div class="hero-actions">
                            <Link href="/shop" class="hz-btn primary">
                                Commander <i class="far fa-arrow-right"></i>
                            </Link>
                            <Link href="/service" class="hz-btn secondary">
                                Voir les services
                            </Link>
                        </div>
                    </div>

                    <div class="hero-product">
                        <img :src="featuredProducts[0]?.image || '/assets/img/riz2.jpeg'" :alt="featuredProducts[0]?.title || 'Riz HEZOUWE'">
                        <div class="hero-product-info">
                            <span>Produit phare</span>
                            <strong>{{ featuredProducts[0]?.title || 'Riz Blanc Premium' }}</strong>
                            <p>{{ formatPrice(featuredProducts[0]?.price || 0) }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="impact-strip">
            <div class="container">
                <div class="impact-grid">
                    <div>
                        <strong>30+</strong>
                        <span>Producteurs partenaires</span>
                    </div>
                    <div>
                        <strong>ITRA</strong>
                        <span>Qualite certifiee</span>
                    </div>
                    <div>
                        <strong>24-48h</strong>
                        <span>Livraison rapide</span>
                    </div>
                    <div>
                        <strong>100%</strong>
                        <span>Riz local togolais</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section section-light">
            <div class="container">
                <div class="section-head">
                    <span class="eyebrow">Nos produits</span>
                    <h2>Selection dynamique de la boutique</h2>
                    <p>Ces produits viennent directement de la meme source que la page Boutique.</p>
                    <Link href="/shop" class="section-link">Voir toute la boutique <i class="far fa-arrow-right"></i></Link>
                </div>

                <div class="product-grid">
                    <article v-for="product in featuredProducts" :key="product.slug" class="product-card">
                        <Link :href="`/shop-details/${product.slug}`" class="product-image">
                            <img :src="product.image" :alt="product.title">
                            <span v-if="product.badge" class="badge">{{ product.badge }}</span>
                        </Link>
                        <div class="product-body">
                            <span>{{ product.category }}</span>
                            <h3>
                                <Link :href="`/shop-details/${product.slug}`">{{ product.title }}</Link>
                            </h3>
                            <p>{{ product.short }}</p>
                            <div class="product-bottom">
                                <strong>{{ formatPrice(product.price) }} FCFA</strong>
                                <Link :href="`/shop-details/${product.slug}`" class="icon-link" aria-label="Voir le produit">
                                    <i class="far fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="home-section">
            <div class="container">
                <div class="split-grid">
                    <div class="story-media">
                        <img src="/assets/img/image10.jpg" alt="Production locale HEZOUWE">
                    </div>
                    <div class="story-copy">
                        <span class="eyebrow">Notre mission</span>
                        <h2>Une cooperative au service du riz local et des producteurs.</h2>
                        <p>
                            HEZOUWE collecte, transforme et commercialise le riz local togolais avec une attention forte portee a la qualite, a la tracabilite et a l'impact social.
                        </p>
                        <div class="story-list">
                            <div>
                                <i class="flaticon-farmer"></i>
                                <span>Partenariat direct avec les producteurs</span>
                            </div>
                            <div>
                                <i class="flaticon-quality"></i>
                                <span>Controle qualite sur chaque lot</span>
                            </div>
                            <div>
                                <i class="flaticon-delivery"></i>
                                <span>Distribution locale et commandes groupees</span>
                            </div>
                        </div>
                        <Link href="/about" class="hz-btn primary">Decouvrir HEZOUWE</Link>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section section-green">
            <div class="container">
                <div class="section-head inverse">
                    <span class="eyebrow">Nos services</span>
                    <h2>Les services affiches ici viennent de la page Services</h2>
                    <p>Modifiez un service dans la source commune, il sera mis a jour automatiquement ici.</p>
                    <Link href="/service" class="section-link">Voir tous les services <i class="far fa-arrow-right"></i></Link>
                </div>

                <div class="service-grid">
                    <article v-for="service in featuredServices" :key="service.slug" class="service-card">
                        <img :src="service.image" :alt="service.title">
                        <div class="service-body">
                            <i :class="service.icon"></i>
                            <h3>
                                <Link :href="`/service-details/${service.slug}`">{{ service.title }}</Link>
                            </h3>
                            <p>{{ service.short }}</p>
                            <Link :href="`/service-details/${service.slug}`" class="service-link">
                                Plus d'info <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="home-section section-light">
            <div class="container">
                <div class="cta-panel">
                    <div>
                        <span class="eyebrow">Commande en ligne</span>
                        <h2>Votre panier est lie a votre compte client.</h2>
                        <p>Connectez-vous, ajoutez vos produits et retrouvez vos commandes dans votre dashboard.</p>
                    </div>
                    <Link href="/shop" class="hz-btn primary">
                        Commencer une commande <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    services: {
        type: Array,
        default: () => [],
    },
});

const featuredProducts = computed(() => props.products.slice(0, 6));
const featuredServices = computed(() => props.services.slice(0, 4));

const formatPrice = (n) => Number(n || 0).toLocaleString('fr-FR');
</script>

<style scoped>
.home-hero {
    min-height: calc(100vh - 124px);
    display: flex;
    align-items: center;
    padding: 74px 0 64px;
    color: #fff;
    background:
        linear-gradient(90deg, rgba(21, 55, 23, .96), rgba(21, 55, 23, .72)),
        url('/assets/img/riz8.jpeg') center/cover;
}

.hero-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.12fr) minmax(320px, .88fr);
    align-items: center;
    gap: 46px;
}

.eyebrow {
    display: inline-flex;
    color: #c8902a;
    font-size: .78rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.hero-copy h1,
.section-head h2,
.story-copy h2,
.cta-panel h2 {
    margin: 10px 0 14px;
    color: #1a3a1a;
    font-weight: 900;
    line-height: 1.08;
}

.hero-copy h1 {
    max-width: 820px;
    color: #fff;
    font-size: clamp(2.4rem, 5vw, 5rem);
}

.hero-copy p {
    max-width: 660px;
    color: rgba(255,255,255,.84);
    font-size: 1.05rem;
    line-height: 1.75;
}

.hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 28px;
}

.hz-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    min-height: 46px;
    padding: 0 18px;
    border-radius: 8px;
    font-weight: 900;
    text-decoration: none;
    transition: transform .2s, background .2s, color .2s, border-color .2s;
}

.hz-btn.primary {
    color: #fff;
    background: #5cb85c;
}

.hz-btn.secondary {
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.4);
}

.hz-btn:hover {
    transform: translateY(-1px);
}

.hero-product {
    position: relative;
    min-height: 460px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 26px 80px rgba(0,0,0,.25);
}

.hero-product img {
    width: 100%;
    height: 100%;
    min-height: 460px;
    object-fit: cover;
}

.hero-product-info {
    position: absolute;
    left: 20px;
    right: 20px;
    bottom: 20px;
    padding: 18px;
    border-radius: 8px;
    background: rgba(255,255,255,.94);
}

.hero-product-info span,
.hero-product-info strong,
.hero-product-info p {
    display: block;
}

.hero-product-info span {
    color: #c8902a;
    font-size: .78rem;
    font-weight: 900;
    text-transform: uppercase;
}

.hero-product-info strong {
    margin-top: 4px;
    color: #1a3a1a;
    font-size: 1.25rem;
}

.hero-product-info p {
    margin: 4px 0 0;
    color: #2d7a2d;
    font-weight: 900;
}

.impact-strip {
    background: #1a3a1a;
    color: #fff;
    padding: 24px 0;
}

.impact-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.impact-grid div {
    padding: 10px 0;
}

.impact-grid strong,
.impact-grid span {
    display: block;
    text-align: center;
}

.impact-grid strong {
    color: #ffd66b;
    font-size: 1.4rem;
}

.impact-grid span {
    color: rgba(255,255,255,.78);
    font-size: .9rem;
}

.home-section {
    padding: 86px 0;
    background: #fff;
}

.section-light {
    background: #f5f7f2;
}

.section-green {
    background: #183919;
}

.section-head {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px 28px;
    align-items: end;
    margin-bottom: 30px;
}

.section-head .eyebrow,
.section-head h2,
.section-head p {
    grid-column: 1;
}

.section-head h2,
.story-copy h2,
.cta-panel h2 {
    font-size: clamp(1.8rem, 3vw, 3rem);
}

.section-head p,
.story-copy p,
.cta-panel p {
    margin: 0;
    color: #667266;
    line-height: 1.7;
}

.section-head.inverse h2,
.section-head.inverse p {
    color: #fff;
}

.section-head.inverse p {
    color: rgba(255,255,255,.76);
}

.section-link {
    grid-column: 2;
    grid-row: 1 / span 3;
    align-self: center;
    color: #2d7a2d;
    font-weight: 900;
    text-decoration: none;
}

.inverse .section-link {
    color: #ffd66b;
}

.product-grid,
.service-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.product-card,
.service-card,
.cta-panel {
    background: #fff;
    border: 1px solid #e7eee2;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(28, 57, 30, .08);
}

.product-image {
    position: relative;
    display: block;
    height: 230px;
    overflow: hidden;
}

.product-image img,
.service-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s;
}

.product-card:hover .product-image img,
.service-card:hover img {
    transform: scale(1.05);
}

.badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 4px 10px;
    border-radius: 999px;
    color: #fff;
    background: #5cb85c;
    font-size: .72rem;
    font-weight: 900;
}

.product-body,
.service-body {
    padding: 18px;
}

.product-body > span {
    color: #2d7a2d;
    font-size: .75rem;
    font-weight: 900;
    text-transform: uppercase;
}

.product-body h3,
.service-body h3 {
    margin: 6px 0 8px;
    color: #1a3a1a;
    font-size: 1.05rem;
    font-weight: 900;
    line-height: 1.35;
}

.product-body h3 a,
.service-body h3 a {
    color: inherit;
    text-decoration: none;
}

.product-body p,
.service-body p {
    display: -webkit-box;
    min-height: 52px;
    margin: 0;
    overflow: hidden;
    color: #6b7280;
    font-size: .9rem;
    line-height: 1.55;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-top: 18px;
}

.product-bottom strong {
    color: #1a3a1a;
    font-size: 1.02rem;
}

.icon-link {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: #1a3a1a;
    text-decoration: none;
}

.split-grid {
    display: grid;
    grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr);
    align-items: center;
    gap: 44px;
}

.story-media {
    height: 520px;
    border-radius: 8px;
    overflow: hidden;
}

.story-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.story-list {
    display: grid;
    gap: 12px;
    margin: 24px 0;
}

.story-list div {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 14px;
    border: 1px solid #e7eee2;
    border-radius: 8px;
    background: #f8fbf6;
}

.story-list i {
    color: #2d7a2d;
    font-size: 1.25rem;
}

.story-list span {
    color: #243524;
    font-weight: 800;
}

.service-grid {
    grid-template-columns: repeat(4, 1fr);
}

.service-card img {
    height: 170px;
}

.service-body i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 8px;
    color: #2d7a2d;
    background: #eaf7ea;
    font-size: 1.35rem;
}

.service-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 16px;
    color: #2d7a2d;
    font-weight: 900;
    text-decoration: none;
}

.cta-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding: 34px;
}

@media (max-width: 1199px) {
    .service-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 991px) {
    .hero-grid,
    .split-grid {
        grid-template-columns: 1fr;
    }

    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .section-head {
        grid-template-columns: 1fr;
    }

    .section-link {
        grid-column: 1;
        grid-row: auto;
    }
}

@media (max-width: 640px) {
    .home-hero {
        min-height: auto;
        padding: 56px 0;
    }

    .hero-product,
    .hero-product img,
    .story-media {
        min-height: 320px;
        height: 320px;
    }

    .impact-grid,
    .product-grid,
    .service-grid {
        grid-template-columns: 1fr;
    }

    .home-section {
        padding: 62px 0;
    }

    .cta-panel {
        align-items: flex-start;
        flex-direction: column;
        padding: 24px;
    }
}
</style>
