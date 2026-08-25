<template>
    <AppLayout
        title="Détails Projet"
        description="En savoir plus sur un projet de COOP CA HEZOUWE pour la transformation et la commercialisation du riz local au Togo."
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
                        <li><Link href="/project">Projets</Link></li>
                        <li>//</li>
                        <li>Modernisation des Équipements</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Modernisation des Équipements</h1>
                </div>
            </div>
        </section>

        <!-- Project content -->
        <section class="pjd-section">
            <div class="container">
                <div class="row g-5">
                    <!-- Main content -->
                    <div class="col-lg-8 wow fadeInLeft">
                        <!-- Hero image -->
                        <div class="pjd-hero-img">
                            <img src="/assets/img/riz3.jpeg" alt="Modernisation équipements HEZOUWE">
                            <div class="pjd-status-badge active">En cours</div>
                        </div>

                        <!-- Progress bar -->
                        <div class="pjd-progress-block">
                            <div class="pjd-progress-header">
                                <span>Avancement du projet</span>
                                <strong>85%</strong>
                            </div>
                            <div class="pjd-progress-bar">
                                <div class="pjd-progress-fill" style="width: 85%"></div>
                            </div>
                            <p>Phase 3/4 — Installation de la calibreuse industrielle en cours</p>
                        </div>

                        <!-- Description -->
                        <div class="pjd-content">
                            <h3 class="pjd-section-title">Vue d'ensemble du Projet</h3>
                            <p>Le projet de modernisation des équipements de transformation de la COOP CA HEZOUWE vise à tripler la capacité de traitement du riz et à améliorer significativement la qualité des produits finis. Financé en partie par Compassion Internationale Togo, ce projet a démarré en 2023 avec l'installation des premières décortiqueuses.</p>
                            <p>Aujourd'hui, en 2025, la phase 3 du projet est en cours avec l'installation d'une calibreuse industrielle qui permettra de trier automatiquement les grains selon leur taille, réduisant ainsi le taux de brisure à moins de 3%.</p>

                            <div class="pjd-dual-img">
                                <img src="/assets/img/riz5.jpeg" alt="Transformation 1">
                                <img src="/assets/img/riz2.jpeg" alt="Transformation 2">
                            </div>

                            <h3 class="pjd-section-title">Objectifs du Projet</h3>
                            <div class="pjd-objectives">
                                <div v-for="obj in objectives" :key="obj.title" class="pjd-objective">
                                    <div class="pjd-obj-icon"><i :class="obj.icon"></i></div>
                                    <div>
                                        <h6>{{ obj.title }}</h6>
                                        <p>{{ obj.text }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <h3 class="pjd-section-title">Phases du Projet</h3>
                            <div class="pjd-phases">
                                <div v-for="phase in phases" :key="phase.title" class="pjd-phase" :class="phase.status">
                                    <div class="pjd-phase-dot">
                                        <i :class="phase.status === 'done' ? 'fas fa-check' : phase.status === 'active' ? 'far fa-spinner' : 'far fa-clock'"></i>
                                    </div>
                                    <div class="pjd-phase-content">
                                        <div class="pjd-phase-header">
                                            <h6>{{ phase.title }}</h6>
                                            <span class="pjd-phase-date">{{ phase.period }}</span>
                                        </div>
                                        <p>{{ phase.text }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Results -->
                            <h3 class="pjd-section-title">Résultats Attendus</h3>
                            <div class="pjd-results">
                                <div v-for="r in results" :key="r" class="pjd-result-item">
                                    <i class="far fa-check-circle"></i>
                                    <span>{{ r }}</span>
                                </div>
                            </div>

                            <!-- Quote -->
                            <blockquote class="pjd-quote">
                                <i class="flaticon-quote"></i>
                                <p>"Ce projet va transformer notre coopérative. Avec ces équipements modernes, nous allons produire un riz de qualité internationale tout en maintenant nos valeurs de riz local et traçable."</p>
                                <footer>— Directeur de la COOP CA HEZOUWE</footer>
                            </blockquote>
                        </div>

                        <!-- Navigation -->
                        <div class="pjd-nav">
                            <Link href="/project" class="pjd-nav-btn prev">
                                <i class="far fa-arrow-left"></i> Retour aux Projets
                            </Link>
                            <Link href="/contact" class="pjd-nav-btn next">
                                Nous Soutenir <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 wow fadeInRight">
                        <!-- Project info -->
                        <div class="pjd-widget">
                            <h4 class="pjd-widget-title">Informations Projet</h4>
                            <div class="pjd-info-list">
                                <div v-for="info in projectInfo" :key="info.label" class="pjd-info-item">
                                    <span class="pjd-info-label">{{ info.label }}</span>
                                    <span class="pjd-info-val">{{ info.value }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats widget -->
                        <div class="pjd-widget pjd-stats-widget">
                            <h4 class="pjd-widget-title">Impact Chiffré</h4>
                            <div class="pjd-stats-grid">
                                <div v-for="s in projectStats" :key="s.label" class="pjd-stat-box">
                                    <strong>{{ s.value }}</strong>
                                    <span>{{ s.label }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact widget -->
                        <div class="pjd-widget pjd-contact-widget">
                            <i class="flaticon-farmer pjd-contact-ico"></i>
                            <h4>Soutenir ce Projet</h4>
                            <p>Vous êtes une ONG, une entreprise ou un particulier souhaitant soutenir notre mission ? Contactez-nous pour discuter des modalités.</p>
                            <Link href="/contact" class="pjd-contact-btn">
                                Nous Contacter <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>

                        <!-- Other projects -->
                        <div class="pjd-widget">
                            <h4 class="pjd-widget-title">Autres Projets</h4>
                            <div class="pjd-other-projects">
                                <div v-for="p in otherProjects" :key="p.title" class="pjd-other-item">
                                    <div class="pjd-other-img bg-cover" :style="`background-image: url('${p.image}')`"></div>
                                    <div>
                                        <h6><Link href="/project-details">{{ p.title }}</Link></h6>
                                        <span :class="['pjd-other-status', p.statusClass]">{{ p.status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const objectives = [
    { icon:'flaticon-organic',     title:'Tripler la Capacité',         text:'Passer de 5 à 15 tonnes de riz transformé par jour grâce aux nouveaux équipements.' },
    { icon:'flaticon-food-safety', title:'Améliorer la Qualité',        text:'Réduire le taux de brisure de 5% à moins de 3% avec la calibreuse industrielle.' },
    { icon:'flaticon-farmer',      title:'Créer des Emplois',           text:'Générer 6 emplois supplémentaires directs liés à la nouvelle ligne de production.' },
    { icon:'flaticon-delivery',    title:'Augmenter les Revenus',       text:'Augmenter le chiffre d\'affaires de la coopérative de 40% en 2 ans.' },
];

const phases = [
    { title:'Phase 1 — Décortiqueuses', period:'2023', status:'done',    text:'Installation de 2 décortiqueuses industrielles. Capacité : 5 tonnes/jour. Opérationnelles depuis septembre 2023.' },
    { title:'Phase 2 — Conditionnement', period:'2024', status:'done',   text:'Acquisition d\'emballeuses automatiques et de sacs hermétiques HEZOUWE. Lancement de la gamme 5kg et 25kg.' },
    { title:'Phase 3 — Calibreuse',      period:'2025', status:'active', text:'Installation de la calibreuse industrielle en cours. Livraison prévue Q2 2025. Réduira le taux de brisure à < 3%.' },
    { title:'Phase 4 — Centre Étendu',   period:'2026', status:'planned',text:'Construction d\'une extension du centre de transformation avec chambre froide et capacité de stockage accrue.' },
];

const results = [
    'Capacité de transformation portée à 15 tonnes/jour',
    'Taux de brisure réduit à moins de 3%',
    '6 nouveaux emplois directs créés',
    'Chiffre d\'affaires augmenté de 40% en 2026',
    'Obtention de nouvelles certifications qualité',
    'Réduction des pertes post-récolte de 30%',
];

const projectInfo = [
    { label:'Catégorie',       value:'Transformation' },
    { label:'Statut',          value:'En cours (85%)' },
    { label:'Durée',           value:'2023 – 2026' },
    { label:'Budget',          value:'Confidentiel' },
    { label:'Financement',     value:'Compassion Int. + HEZOUWE' },
    { label:'Bénéficiaires',   value:'30 producteurs membres' },
    { label:'Localisation',    value:'Tagbega, Région Plateaux' },
];

const projectStats = [
    { value:'15T',    label:'Tonnes/jour (objectif)' },
    { value:'3%',     label:'Taux brisure cible' },
    { value:'6',      label:'Emplois supplémentaires' },
    { value:'+40%',   label:'CA additionnel' },
];

const otherProjects = [
    { title:'Certification ITRA',           image:'/assets/img/riz5.jpeg', status:'Terminé',  statusClass:'done'    },
    { title:'Formation Agronomique',         image:'/assets/img/image6.jpg', status:'En cours', statusClass:'active'  },
    { title:'Réseau de Distribution Togo',  image:'/assets/img/image10.jpg', status:'En cours', statusClass:'active'  },
];
</script>

<style scoped>
.pjd-section { padding: 80px 0 90px; }

/* Hero image */
.pjd-hero-img { position: relative; border-radius: 16px; overflow: hidden; margin-bottom: 28px; }
.pjd-hero-img img { width: 100%; height: 380px; object-fit: cover; display: block; }
.pjd-status-badge { position: absolute; top: 16px; left: 16px; padding: 5px 16px; border-radius: 20px; font-size: .78rem; font-weight: 700; }
.pjd-status-badge.active { background: #e8f5e9; color: #2d7a2d; }

/* Progress */
.pjd-progress-block { background: #f8fdf8; border-radius: 12px; padding: 20px; margin-bottom: 32px; border: 1px solid #e0f0e0; }
.pjd-progress-header { display: flex; justify-content: space-between; font-size: .9rem; margin-bottom: 10px; color: #555; }
.pjd-progress-header strong { color: #2d7a2d; }
.pjd-progress-bar { height: 10px; background: #e0e0e0; border-radius: 5px; overflow: hidden; margin-bottom: 10px; }
.pjd-progress-fill { height: 100%; background: linear-gradient(90deg, #5cb85c, #8bc34a); border-radius: 5px; }
.pjd-progress-block p { font-size: .82rem; color: #888; margin: 0; }

/* Content */
.pjd-content { display: flex; flex-direction: column; gap: 20px; }
.pjd-section-title { font-size: 1.2rem; font-weight: 800; color: #1a3a1a; padding-left: 14px; border-left: 4px solid #5cb85c; margin-bottom: 4px; margin-top: 8px; }
.pjd-content p { color: #555; font-size: .95rem; line-height: 1.8; margin: 0; }
.pjd-dual-img { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pjd-dual-img img { width: 100%; height: 200px; object-fit: cover; border-radius: 12px; }

/* Objectives */
.pjd-objectives { display: flex; flex-direction: column; gap: 16px; }
.pjd-objective { display: flex; gap: 16px; align-items: flex-start; padding: 16px; background: #fafafa; border-radius: 10px; border: 1px solid #f0f0f0; }
.pjd-obj-icon { width: 44px; height: 44px; background: #e8f5e9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #5cb85c; flex-shrink: 0; }
.pjd-objective h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin-bottom: 4px; }
.pjd-objective p { font-size: .85rem; color: #666; margin: 0; line-height: 1.6; }

/* Phases */
.pjd-phases { display: flex; flex-direction: column; gap: 20px; }
.pjd-phase { display: flex; gap: 16px; align-items: flex-start; }
.pjd-phase-dot { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .75rem; flex-shrink: 0; }
.pjd-phase.done .pjd-phase-dot    { background: #5cb85c; color: #fff; }
.pjd-phase.active .pjd-phase-dot  { background: #ff9800; color: #fff; }
.pjd-phase.planned .pjd-phase-dot { background: #e0e0e0; color: #999; }
.pjd-phase-content { flex: 1; }
.pjd-phase-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
.pjd-phase-header h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin: 0; }
.pjd-phase-date { font-size: .75rem; color: #aaa; }
.pjd-phase-content p { font-size: .85rem; color: #666; margin: 0; line-height: 1.6; }

/* Results */
.pjd-results { display: flex; flex-direction: column; gap: 10px; }
.pjd-result-item { display: flex; align-items: flex-start; gap: 10px; font-size: .9rem; color: #555; }
.pjd-result-item i { color: #5cb85c; font-size: .85rem; margin-top: 2px; flex-shrink: 0; }

/* Quote */
.pjd-quote { background: linear-gradient(135deg, #1a3a1a, #2d7a2d); border-radius: 14px; padding: 28px; position: relative; margin-top: 8px; }
.pjd-quote i { font-size: 2rem; color: rgba(255,255,255,.3); display: block; margin-bottom: 12px; }
.pjd-quote p { color: #fff; font-size: 1rem; line-height: 1.8; margin-bottom: 12px; font-style: italic; }
.pjd-quote footer { color: #8bc34a; font-size: .85rem; font-weight: 600; }

/* Nav */
.pjd-nav { display: flex; justify-content: space-between; margin-top: 16px; flex-wrap: wrap; gap: 12px; }
.pjd-nav-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; transition: all .3s; }
.pjd-nav-btn.prev { background: #f5f5f5; color: #1a3a1a; border: 1.5px solid #e0e0e0; }
.pjd-nav-btn.prev:hover { background: #1a3a1a; color: #fff; }
.pjd-nav-btn.next { background: #5cb85c; color: #fff; }
.pjd-nav-btn.next:hover { background: #2d7a2d; }

/* Sidebar widgets */
.pjd-widget { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,.07); margin-bottom: 24px; }
.pjd-widget-title { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin: 0 0 16px; padding-bottom: 10px; border-bottom: 2px solid #e8f5e9; position: relative; }
.pjd-widget-title::after { content:''; position:absolute; bottom:-2px; left:0; width:40px; height:2px; background:#5cb85c; }

.pjd-info-list { display: flex; flex-direction: column; gap: 10px; }
.pjd-info-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f5f5f5; font-size: .88rem; }
.pjd-info-item:last-child { border-bottom: none; }
.pjd-info-label { color: #888; }
.pjd-info-val { font-weight: 600; color: #1a3a1a; text-align: right; }

.pjd-stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pjd-stat-box { background: #f8fdf8; border-radius: 10px; padding: 14px; text-align: center; border: 1px solid #e0f0e0; }
.pjd-stat-box strong { display: block; font-size: 1.3rem; font-weight: 800; color: #2d7a2d; }
.pjd-stat-box span { font-size: .72rem; color: #777; }

.pjd-contact-widget { background: linear-gradient(135deg, #1a3a1a, #2d7a2d); text-align: center; }
.pjd-contact-ico { font-size: 2.2rem; color: #8bc34a; display: block; margin-bottom: 12px; }
.pjd-contact-widget h4 { color: #fff; margin-bottom: 10px; font-size: 1rem; }
.pjd-contact-widget p { color: #c8e6c9; font-size: .85rem; line-height: 1.7; margin-bottom: 16px; }
.pjd-contact-btn { display: flex; justify-content: center; align-items: center; gap: 8px; padding: 12px; background: #5cb85c; color: #fff; border-radius: 8px; text-decoration: none; font-size: .9rem; font-weight: 700; transition: background .3s; }
.pjd-contact-btn:hover { background: #8bc34a; color: #fff; }

.pjd-other-projects { display: flex; flex-direction: column; gap: 14px; }
.pjd-other-item { display: flex; gap: 12px; align-items: center; }
.pjd-other-img { width: 56px; height: 56px; border-radius: 8px; flex-shrink: 0; background-size: cover; background-position: center; }
.pjd-other-item h6 { font-size: .85rem; font-weight: 700; color: #1a3a1a; margin: 0 0 4px; }
.pjd-other-item h6 a { color: inherit; text-decoration: none; }
.pjd-other-item h6 a:hover { color: #5cb85c; }
.pjd-other-status { font-size: .7rem; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
.pjd-other-status.done   { background: #e3f2fd; color: #1565c0; }
.pjd-other-status.active { background: #e8f5e9; color: #2d7a2d; }
</style>
