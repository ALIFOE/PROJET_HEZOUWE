<template>
    <AppLayout
        title="Notre Histoire"
        description="L'histoire de COOP CA HEZOUWE, de sa création à aujourd'hui : une coopérative togolaise au service de la filière riz local."
    >
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt="img"></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt="img"></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Notre Histoire</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">L'Histoire de HEZOUWE</h1>
                </div>
            </div>
        </section>

        <!-- Hero intro -->
        <section class="hist-hero">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft">
                        <div class="hist-hero-img">
                            <img src="/assets/img/riz3.jpeg" alt="HEZOUWE">
                            <div class="hist-hero-badge">
                                <div class="hist-badge-year">2023</div>
                                <div class="hist-badge-text">Fondée</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight">
                        <div class="section-title mb-0">
                            <span><img src="/assets/img/sub-title.svg" alt="img">Notre Histoire</span>
                            <h2 class="text-anim">De Tagbega au Marché Africain</h2>
                        </div>
                        <p class="hist-intro-text">
                            COOP CA HEZOUWE est née d'une vision simple mais puissante : transformer le riz local du TOGO en un produit de qualité premium, créer de la valeur ajoutée pour les producteurs locaux et nourrir des milliers de familles avec un riz sain, traçable et certifié.
                        </p>
                        <p class="hist-intro-text">
                            Fondée en 2023 à Tagbega, dans la Région des Plateaux du TOGO, la coopérative réunit aujourd'hui 30 producteurs passionnés. Avec le soutien de Compassion Internationale Togo et la certification ITRA, HEZOUWE s'impose comme un acteur clé de la transformation agricole locale.
                        </p>
                        <div class="hist-hero-stats">
                            <div v-for="s in heroStats" :key="s.label" class="hist-hero-stat">
                                <strong>{{ s.value }}</strong>
                                <span>{{ s.label }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section class="hist-timeline-section">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Chronologie</span>
                    <h2 class="text-anim">Nos Étapes Clés</h2>
                    <p class="wow fadeInUp" data-wow-delay=".2s">Du projet à la réalité — les grandes dates qui ont façonné HEZOUWE.</p>
                </div>
                <div class="hist-timeline">
                    <div class="hist-timeline-line"></div>
                    <div v-for="(event, i) in timeline" :key="event.year"
                         class="hist-tl-item wow fadeInUp"
                         :class="i % 2 === 0 ? 'left' : 'right'"
                         :data-wow-delay="`${0.1 + i * 0.15}s`">
                        <div class="hist-tl-dot">{{ event.year }}</div>
                        <div class="hist-tl-card">
                            <div class="hist-tl-card-icon"><i :class="event.icon"></i></div>
                            <h5>{{ event.title }}</h5>
                            <p>{{ event.text }}</p>
                            <div v-if="event.badge" class="hist-tl-badge">{{ event.badge }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values section -->
        <section class="hist-values-section section-bg">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Nos Valeurs</span>
                    <h2 class="text-anim">Ce Qui Nous Guide</h2>
                </div>
                <div class="row g-4">
                    <div v-for="(val, i) in values" :key="val.title"
                         class="col-lg-3 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + i * 0.15}s`">
                        <div class="hist-val-card">
                            <div class="hist-val-icon"><i :class="val.icon"></i></div>
                            <h5>{{ val.title }}</h5>
                            <p>{{ val.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partenaires -->
        <section class="hist-partners-section">
            <div class="container">
                <div class="section-title text-center mb-4">
                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Partenaires</span>
                    <h2 class="text-anim">Ils Nous Font Confiance</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <div v-for="p in partners" :key="p.name" class="col-lg-3 col-md-4 col-6 wow fadeInUp">
                        <div class="hist-partner-card">
                            <i :class="p.icon" class="hist-partner-icon"></i>
                            <h6>{{ p.name }}</h6>
                            <p>{{ p.role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-discount-section-4 section-padding pt-0">
            <div class="container">
                <div class="cta-wrapper-4 bg-cover" style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');">
                    <div class="cta-discount-area">
                        <div class="circle-bg-icon wow fadeInUp">
                            <img src="/assets/img/home-3/cta-discount/white-circle.png" alt="img" class="circle-icon">
                            <div class="icon"><i class="flaticon-leaf"></i></div>
                        </div>
                        <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Rejoignez-nous</span>
                            <h2 class="text-white text-anim">Participez à Notre Histoire<br>et Commandez Dès Aujourd'hui!</h2>
                        </div>
                    </div>
                    <Link href="/shop" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Voir Nos Produits <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const heroStats = [
    { value: '2023', label: 'Année de fondation' },
    { value: '30+',  label: 'Producteurs membres' },
    { value: '5K+',  label: 'Clients satisfaits' },
    { value: '13+',  label: 'Emplois créés' },
];

const timeline = [
    { year: '2021', icon: 'flaticon-farmer', title: 'Naissance de l\'Idée', badge: 'Genèse', text: 'Des producteurs de riz de Tagbega constatent le potentiel inexploité du riz local et entament des discussions pour créer une structure coopérative.' },
    { year: '2022', icon: 'flaticon-organic', title: 'Étude de Faisabilité', badge: 'Planification', text: 'Avec l\'appui de Compassion Internationale Togo, une étude de marché et de faisabilité technique est réalisée. Le potentiel est confirmé : la demande locale dépasse l\'offre.' },
    { year: '2023', icon: 'flaticon-leaf', title: 'Création Officielle de HEZOUWE', badge: 'Fondation', text: 'La COOP CA HEZOUWE est officiellement créée avec 30 producteurs membres fondateurs. Installation des premières décortiqueuses et équipements de transformation à Tagbega.' },
    { year: '2023', icon: 'flaticon-food-safety', title: 'Première Certification ITRA', badge: 'Certification', text: 'Notre riz blanc et notre riz étuvé obtiennent la certification de l\'Institut Togolais de Recherche Agronomique, garantissant la qualité et la traçabilité de nos produits.' },
    { year: '2024', icon: 'flaticon-delivery', title: 'Lancement Commercial', badge: 'Marché', text: 'Premiers partenariats avec des distributeurs au Togo. Lancement de la gamme de produits : riz blanc 5kg, riz étuvé 5kg, formats vrac 25kg pour les professionnels.' },
    { year: '2025', icon: 'flaticon-like', title: '5 000 Clients Satisfaits', badge: 'Croissance', text: 'HEZOUWE atteint le cap des 5 000 clients satisfaits au Togo et en Afrique de l\'Ouest. Ouverture d\'un centre de conditionnement modernisé à Tagbega.' },
    { year: '2026', icon: 'flaticon-farmer', title: 'Expansion Régionale', badge: 'Avenir', text: 'Objectif : doubler le réseau de producteurs, obtenir de nouvelles certifications internationales et exporter dans 3 pays d\'Afrique de l\'Ouest. Le riz togolais rayonne.' },
];

const values = [
    { icon: 'flaticon-leaf',            title: 'Qualité',        text: 'Chaque grain de riz HEZOUWE est soigneusement sélectionné et transformé selon les plus hauts standards de qualité agronomique.' },
    { icon: 'flaticon-farmer',          title: 'Solidarité',     text: 'Nous créons de la valeur pour toute la chaîne : producteurs, transformateurs, livreurs et clients. Ensemble, nous réussissons.' },
    { icon: 'flaticon-organic',         title: 'Durabilité',     text: 'Nos méthodes de culture respectent l\'environnement et préservent les sols pour les générations futures de riziculteurs togolais.' },
    { icon: 'flaticon-food-safety',     title: 'Traçabilité',    text: 'De la parcelle à votre table, chaque lot de riz est traçable et certifié par l\'ITRA pour vous garantir une confiance totale.' },
];

const partners = [
    { icon: 'flaticon-organic',      name: 'Compassion Internationale', role: 'Partenaire institutionnel & financement' },
    { icon: 'flaticon-food-safety',  name: 'ITRA',                      role: 'Certification qualité agricole' },
    { icon: 'flaticon-farmer',       name: 'Producteurs de Tagbega',    role: '30 producteurs membres partenaires' },
    { icon: 'flaticon-delivery',     name: 'Réseau de Distribution',    role: 'Livraison dans tout le Togo' },
];
</script>

<style scoped>
/* Hero */
.hist-hero { padding: 80px 0; }
.hist-hero-img { position: relative; border-radius: 20px; overflow: hidden; }
.hist-hero-img img { width: 100%; height: 420px; object-fit: cover; display: block; }
.hist-hero-badge { position: absolute; bottom: 24px; left: 24px; background: #5cb85c; color: #fff; border-radius: 12px; padding: 14px 20px; text-align: center; }
.hist-badge-year { font-size: 2rem; font-weight: 900; line-height: 1; }
.hist-badge-text { font-size: .75rem; text-transform: uppercase; letter-spacing: 1px; }
.hist-intro-text { color: #555; font-size: .95rem; line-height: 1.8; margin-bottom: 16px; }
.hist-hero-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 24px; }
.hist-hero-stat { text-align: center; padding: 14px 8px; background: #f8fdf8; border-radius: 10px; border: 1px solid #e0f0e0; }
.hist-hero-stat strong { display: block; font-size: 1.4rem; font-weight: 800; color: #2d7a2d; }
.hist-hero-stat span { font-size: .72rem; color: #777; }

/* Timeline */
.hist-timeline-section { padding: 80px 0; }
.hist-timeline { position: relative; padding: 20px 0; }
.hist-timeline-line { position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: #c8e6c9; transform: translateX(-50%); }
.hist-tl-item { display: flex; justify-content: flex-end; padding-right: calc(50% + 40px); margin-bottom: 50px; position: relative; }
.hist-tl-item.right { justify-content: flex-start; padding-right: 0; padding-left: calc(50% + 40px); }
.hist-tl-dot { position: absolute; left: 50%; top: 20px; transform: translateX(-50%); width: 60px; height: 60px; background: #5cb85c; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 800; text-align: center; border: 4px solid #fff; box-shadow: 0 4px 16px rgba(92,184,92,.3); z-index: 2; }
.hist-tl-card { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,.08); border: 1.5px solid #e8f0e8; max-width: 380px; width: 100%; }
.hist-tl-card:hover { border-color: #5cb85c; }
.hist-tl-card-icon { font-size: 1.6rem; color: #5cb85c; margin-bottom: 10px; }
.hist-tl-card h5 { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin-bottom: 8px; }
.hist-tl-card p { font-size: .88rem; color: #666; line-height: 1.7; margin: 0; }
.hist-tl-badge { display: inline-block; margin-top: 12px; background: #e8f5e9; color: #2d7a2d; padding: 3px 12px; border-radius: 20px; font-size: .72rem; font-weight: 700; }

@media (max-width: 768px) {
    .hist-timeline-line { left: 24px; }
    .hist-tl-item, .hist-tl-item.right { justify-content: flex-start; padding-left: 70px; padding-right: 0; }
    .hist-tl-dot { left: 24px; width: 48px; height: 48px; font-size: .65rem; }
}

/* Values */
.hist-values-section { padding: 80px 0; }
.hist-val-card { background: #fff; border-radius: 16px; padding: 30px 24px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s; height: 100%; }
.hist-val-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,.12); }
.hist-val-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-size: 1.6rem; color: #5cb85c; }
.hist-val-card h5 { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin-bottom: 10px; }
.hist-val-card p { font-size: .88rem; color: #666; line-height: 1.7; margin: 0; }

/* Partners */
.hist-partners-section { padding: 80px 0 90px; }
.hist-partner-card { background: #fff; border-radius: 14px; padding: 24px 20px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,.06); border: 1.5px solid #f0f0f0; transition: border-color .3s; }
.hist-partner-card:hover { border-color: #5cb85c; }
.hist-partner-icon { font-size: 2rem; color: #5cb85c; display: block; margin-bottom: 12px; }
.hist-partner-card h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin-bottom: 6px; }
.hist-partner-card p { font-size: .78rem; color: #888; margin: 0; }
</style>
