<template>
    <AppLayout title="Nos Projets">
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt="img"></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt="img"></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Nos Projets</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Projets & Initiatives</h1>
                </div>
            </div>
        </section>

        <!-- Intro stats -->
        <div class="proj-stats-bar">
            <div class="container">
                <div class="proj-stats-inner">
                    <div v-for="s in stats" :key="s.label" class="proj-stat">
                        <i :class="s.icon"></i>
                        <div><strong>{{ s.value }}</strong><span>{{ s.label }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects -->
        <section class="proj-section">
            <div class="container">
                <div class="section-title text-center wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Initiatives HEZOUWE</span>
                    <h2 class="text-anim">Ce Que Nous Bâtissons</h2>
                    <p class="wow fadeInUp" data-wow-delay=".2s">Les projets qui transforment la filière riz locale et créent de la valeur durable pour notre communauté.</p>
                </div>

                <!-- Filter -->
                <div class="proj-filters wow fadeInUp" data-wow-delay=".3s">
                    <button v-for="cat in categories" :key="cat"
                            class="proj-filter-btn"
                            :class="{ active: activeFilter === cat }"
                            @click="activeFilter = cat">
                        {{ cat }}
                    </button>
                </div>

                <div class="row g-4">
                    <div v-for="(proj, i) in filteredProjects" :key="proj.id"
                         class="col-lg-4 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + (i % 3) * 0.15}s`">
                        <div class="proj-card" :class="{ 'proj-featured': proj.featured }">
                            <div class="proj-card-img">
                                <img :src="proj.image" :alt="proj.title">
                                <div class="proj-status" :class="proj.statusClass">{{ proj.status }}</div>
                                <div class="proj-card-overlay">
                                    <Link href="/project-details" class="proj-view-btn">
                                        Voir le Projet <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                            <div class="proj-card-body">
                                <div class="proj-card-cat"><i :class="proj.icon"></i> {{ proj.category }}</div>
                                <h5><Link href="/project-details">{{ proj.title }}</Link></h5>
                                <p>{{ proj.excerpt }}</p>
                                <div class="proj-progress">
                                    <div class="proj-progress-header">
                                        <span>Avancement</span>
                                        <span>{{ proj.progress }}%</span>
                                    </div>
                                    <div class="proj-progress-bar">
                                        <div class="proj-progress-fill" :style="`width: ${proj.progress}%`"></div>
                                    </div>
                                </div>
                                <div class="proj-card-meta">
                                    <span><i class="far fa-calendar"></i> {{ proj.year }}</span>
                                    <span><i class="far fa-users"></i> {{ proj.beneficiaries }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact section -->
        <section class="proj-impact section-bg">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Impact</span>
                    <h2 class="text-anim">Notre Impact en Chiffres</h2>
                </div>
                <div class="row g-4">
                    <div v-for="(impact, i) in impacts" :key="impact.title"
                         class="col-lg-3 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + i * 0.15}s`">
                        <div class="proj-impact-card">
                            <div class="proj-impact-icon"><i :class="impact.icon"></i></div>
                            <div class="proj-impact-value">{{ impact.value }}</div>
                            <h6>{{ impact.title }}</h6>
                            <p>{{ impact.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners -->
        <section class="proj-partners">
            <div class="container">
                <div class="section-title text-center mb-4 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Partenaires</span>
                    <h2 class="text-anim">Ils Soutiennent Nos Projets</h2>
                </div>
                <div class="row g-3 justify-content-center">
                    <div v-for="p in partners" :key="p" class="col-lg-2 col-md-3 col-4 wow fadeInUp">
                        <div class="proj-partner-box">{{ p }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-discount-section-4 section-padding">
            <div class="container">
                <div class="cta-wrapper-4 bg-cover" style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');">
                    <div class="cta-discount-area">
                        <div class="circle-bg-icon wow fadeInUp">
                            <img src="/assets/img/home-3/cta-discount/white-circle.png" alt="img" class="circle-icon">
                            <div class="icon"><i class="flaticon-leaf"></i></div>
                        </div>
                        <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Engagement</span>
                            <h2 class="text-white text-anim">Participez à Notre Mission<br>et Soutenez le Riz Local!</h2>
                        </div>
                    </div>
                    <Link href="/contact" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Nous Rejoindre <i class="far fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const activeFilter = ref('Tous');

const stats = [
    { icon:'flaticon-farmer',      value:'6',       label:'Projets actifs' },
    { icon:'flaticon-organic',     value:'30+',     label:'Producteurs bénéficiaires' },
    { icon:'flaticon-like',        value:'5K+',     label:'Ménages impactés' },
    { icon:'flaticon-delivery',    value:'13+',     label:'Emplois créés' },
];

const projects = [
    { id:1, category:'Transformation', statusClass:'active', status:'En cours',  progress:85, year:'2023–2025', beneficiaries:'30 producteurs', featured:true,  icon:'flaticon-organic',      image:'/assets/img/riz3.jpeg',   title:'Modernisation des Équipements de Transformation',          excerpt:'Installation de nouvelles décortiqueuses, calibreuses et emballeuses pour améliorer la qualité et la capacité de transformation à Tagbega.' },
    { id:2, category:'Certification',  statusClass:'done',   status:'Terminé',   progress:100, year:'2023',      beneficiaries:'Tous les membres', featured:false, icon:'flaticon-food-safety',  image:'/assets/img/riz5.jpeg',   title:'Certification ITRA des Produits HEZOUWE',                  excerpt:'Obtention de la certification officielle de l\'Institut Togolais de Recherche Agronomique pour notre gamme complète de riz.' },
    { id:3, category:'Formation',      statusClass:'active', status:'En cours',  progress:60, year:'2024–2026', beneficiaries:'30 producteurs', featured:false, icon:'flaticon-farmer',       image:'/assets/img/image6.jpg',  title:'Programme de Formation Agronomique des Producteurs',       excerpt:'Sessions de formation sur les bonnes pratiques agricoles, la gestion de l\'eau, la fertilisation et la gestion post-récolte du riz.' },
    { id:4, category:'Commercial',     statusClass:'active', status:'En cours',  progress:70, year:'2024–2026', beneficiaries:'5 000+ clients',  featured:false, icon:'flaticon-delivery',     image:'/assets/img/image10.jpg', title:'Développement du Réseau de Distribution au Togo',          excerpt:'Expansion du réseau de distribution dans toutes les régions du Togo avec des partenariats avec épiceries, supermarchés et marchés.' },
    { id:5, category:'Social',         statusClass:'active', status:'En cours',  progress:50, year:'2025–2027', beneficiaries:'Communauté Tagbega', featured:false, icon:'flaticon-leaf',       image:'/assets/img/image7.jpg',  title:'Projet d\'Autonomisation des Femmes Productrices',          excerpt:'Programme spécifique pour intégrer et former les femmes dans la filière riz : cultivation, transformation et gestion des coopératives.' },
    { id:6, category:'Infrastructure', statusClass:'planned',status:'Planifié', progress:15, year:'2026–2028', beneficiaries:'Toute la coopérative', featured:false, icon:'flaticon-organic',  image:'/assets/img/image11.jpg', title:'Construction d\'un Nouveau Centre de Conditionnement',      excerpt:'Projet de construction d\'un centre moderne de conditionnement et de stockage pour tripler la capacité de traitement annuel.' },
];

const categories = computed(() => ['Tous', ...new Set(projects.map(p => p.category))]);
const filteredProjects = computed(() =>
    activeFilter.value === 'Tous' ? projects : projects.filter(p => p.category === activeFilter.value)
);

const impacts = [
    { icon:'flaticon-farmer',     value:'30+',    title:'Producteurs Membres',   text:'Riziculteurs de Tagbega directement bénéficiaires des projets de modernisation.' },
    { icon:'flaticon-like',       value:'5 000+', title:'Clients Satisfaits',    text:'Ménages et professionnels qui consomment le riz HEZOUWE chaque mois.' },
    { icon:'flaticon-delivery',   value:'13+',    title:'Emplois Créés',         text:'Emplois directs et indirects générés par les activités de la coopérative.' },
    { icon:'flaticon-organic',    value:'2',      title:'Certifications',        text:'Certifications ITRA obtenues pour garantir qualité et traçabilité.' },
];

const partners = ['Compassion Int.', 'ITRA', 'Producteurs Tagbega', 'MAEP Togo', 'FAOJ', 'Partenaires Locaux'];
</script>

<style scoped>
/* Stats bar */
.proj-stats-bar { background: #1a3a1a; padding: 18px 0; }
.proj-stats-inner { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 16px; }
.proj-stat { display: flex; align-items: center; gap: 14px; color: #fff; }
.proj-stat i { font-size: 1.8rem; color: #8bc34a; }
.proj-stat strong { display: block; font-size: 1.3rem; font-weight: 800; color: #8bc34a; }
.proj-stat span { font-size: .75rem; color: #ccc; }

/* Section */
.proj-section { padding: 80px 0; }

/* Filters */
.proj-filters { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
.proj-filter-btn { padding: 9px 22px; border: 2px solid #e0e0e0; background: none; border-radius: 30px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .25s; color: #555; }
.proj-filter-btn:hover, .proj-filter-btn.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }

/* Project card */
.proj-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s; border: 2px solid transparent; height: 100%; display: flex; flex-direction: column; }
.proj-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,.13); }
.proj-featured { border-color: #5cb85c; }

.proj-card-img { position: relative; height: 220px; overflow: hidden; }
.proj-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.proj-card:hover .proj-card-img img { transform: scale(1.06); }
.proj-status { position: absolute; top: 12px; left: 12px; padding: 3px 12px; border-radius: 20px; font-size: .72rem; font-weight: 700; }
.proj-status.active  { background: #e8f5e9; color: #2d7a2d; }
.proj-status.done    { background: #e3f2fd; color: #1565c0; }
.proj-status.planned { background: #fff3e0; color: #e65100; }
.proj-card-overlay { position: absolute; inset: 0; background: rgba(26,58,26,.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .3s; }
.proj-card:hover .proj-card-overlay { opacity: 1; }
.proj-view-btn { display: flex; align-items: center; gap: 8px; padding: 12px 22px; background: #5cb85c; color: #fff; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; }

.proj-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
.proj-card-cat { font-size: .75rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
.proj-card-cat i { font-size: .9rem; }
.proj-card-body h5 { font-size: .95rem; font-weight: 700; color: #1a3a1a; margin: 0; }
.proj-card-body h5 a { color: inherit; text-decoration: none; }
.proj-card-body h5 a:hover { color: #5cb85c; }
.proj-card-body p { font-size: .85rem; color: #666; line-height: 1.7; margin: 0; flex: 1; }

.proj-progress { margin-top: 4px; }
.proj-progress-header { display: flex; justify-content: space-between; font-size: .78rem; color: #777; margin-bottom: 6px; }
.proj-progress-bar { height: 6px; background: #f0f0f0; border-radius: 3px; overflow: hidden; }
.proj-progress-fill { height: 100%; background: linear-gradient(90deg, #5cb85c, #8bc34a); border-radius: 3px; transition: width 1s ease; }

.proj-card-meta { display: flex; gap: 16px; font-size: .78rem; color: #999; }
.proj-card-meta span { display: flex; align-items: center; gap: 5px; }

/* Impact */
.proj-impact { padding: 80px 0; }
.proj-impact-card { background: #fff; border-radius: 16px; padding: 28px 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,.07); transition: transform .3s; }
.proj-impact-card:hover { transform: translateY(-5px); }
.proj-impact-icon { width: 60px; height: 60px; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 1.5rem; color: #5cb85c; }
.proj-impact-value { font-size: 2rem; font-weight: 900; color: #2d7a2d; margin-bottom: 6px; }
.proj-impact-card h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin-bottom: 8px; }
.proj-impact-card p { font-size: .82rem; color: #777; margin: 0; line-height: 1.6; }

/* Partners */
.proj-partners { padding: 70px 0 80px; }
.proj-partner-box { background: #fff; border-radius: 10px; padding: 14px 8px; text-align: center; font-size: .82rem; font-weight: 700; color: #1a3a1a; box-shadow: 0 3px 12px rgba(0,0,0,.06); border: 1.5px solid #f0f0f0; transition: border-color .25s; }
.proj-partner-box:hover { border-color: #5cb85c; color: #5cb85c; }
</style>
