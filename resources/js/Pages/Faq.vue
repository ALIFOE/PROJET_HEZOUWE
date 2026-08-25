<template>
    <AppLayout title="FAQ">
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt="img"></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt="img"></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Questions Fréquentes</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">FAQ — Questions Fréquentes</h1>
                </div>
            </div>
        </section>

        <!-- Intro stats -->
        <div class="faq-intro">
            <div class="container">
                <div class="faq-intro-inner">
                    <div class="faq-intro-stat"><i class="flaticon-leaf"></i><div><strong>{{ faqs.length }}</strong><span>Questions répondues</span></div></div>
                    <div class="faq-intro-stat"><i class="flaticon-farmer"></i><div><strong>30+</strong><span>Producteurs membres</span></div></div>
                    <div class="faq-intro-stat"><i class="flaticon-food-safety"></i><div><strong>5 000+</strong><span>Clients satisfaits</span></div></div>
                    <div class="faq-intro-stat"><i class="flaticon-delivery"></i><div><strong>24–48h</strong><span>Délai de livraison</span></div></div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <!-- Category filter -->
                        <div class="faq-cats wow fadeInUp">
                            <button v-for="cat in faqCategories" :key="cat"
                                    class="faq-cat-btn"
                                    :class="{ active: activeCategory === cat }"
                                    @click="activeCategory = cat">
                                {{ cat }}
                            </button>
                        </div>

                        <!-- Accordion -->
                        <div class="faq-accordion wow fadeInUp" data-wow-delay=".2s">
                            <div v-for="(faq, i) in filteredFaqs" :key="faq.id"
                                 class="faq-item"
                                 :class="{ open: openIndex === faq.id }">
                                <div class="faq-question" @click="toggle(faq.id)">
                                    <div class="faq-q-left">
                                        <span class="faq-num">{{ String(i + 1).padStart(2, '0') }}</span>
                                        <h5>{{ faq.q }}</h5>
                                    </div>
                                    <div class="faq-icon">
                                        <i :class="openIndex === faq.id ? 'far fa-minus' : 'far fa-plus'"></i>
                                    </div>
                                </div>
                                <div class="faq-answer" v-show="openIndex === faq.id">
                                    <p>{{ faq.a }}</p>
                                </div>
                            </div>
                        </div>

                        <div v-if="filteredFaqs.length === 0" class="faq-empty">
                            <i class="far fa-question-circle"></i>
                            <p>Aucune question dans cette catégorie.</p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 wow fadeInRight" data-wow-delay=".3s">
                        <!-- Search in FAQ -->
                        <div class="faq-widget">
                            <h4 class="faq-widget-title">Rechercher</h4>
                            <div class="faq-search">
                                <input v-model="searchQuery" type="text" placeholder="Chercher une question...">
                                <i class="fal fa-search"></i>
                            </div>
                        </div>

                        <!-- Contact widget -->
                        <div class="faq-widget faq-contact-widget">
                            <div class="faq-contact-icon"><i class="flaticon-customer-service"></i></div>
                            <h4>Vous n'avez pas trouvé votre réponse?</h4>
                            <p>Notre équipe est disponible pour répondre à toutes vos questions sur nos produits et services.</p>
                            <div class="faq-contact-items">
                                <a href="tel:+22870679448" class="faq-contact-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span>+228 70 67 94 48</span>
                                </a>
                                <a href="mailto:contact@hezouwe.com" class="faq-contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>contact@hezouwe.com</span>
                                </a>
                            </div>
                            <Link href="/contact" class="faq-cta-btn">
                                Nous Contacter <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>

                        <!-- Quick links -->
                        <div class="faq-widget">
                            <h4 class="faq-widget-title">Liens Utiles</h4>
                            <ul class="faq-links">
                                <li><Link href="/shop"><i class="far fa-arrow-right"></i> Nos Produits</Link></li>
                                <li><Link href="/service"><i class="far fa-arrow-right"></i> Nos Services</Link></li>
                                <li><Link href="/about"><i class="far fa-arrow-right"></i> À Propos de Nous</Link></li>
                                <li><Link href="/news"><i class="far fa-arrow-right"></i> Actualités</Link></li>
                                <li><Link href="/pricing"><i class="far fa-arrow-right"></i> Nos Tarifs</Link></li>
                            </ul>
                        </div>

                        <!-- ITRA Badge -->
                        <div class="faq-widget faq-badge-widget">
                            <i class="flaticon-leaf faq-badge-icon"></i>
                            <h5>Certifié ITRA</h5>
                            <p>Institut Togolais de Recherche Agronomique — Qualité garantie et traçabilité assurée sur tous nos produits.</p>
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
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Riz Premium</span>
                            <h2 class="text-white text-anim">Prêt à Commander? <br> Découvrez Nos Produits!</h2>
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
import { ref, computed } from 'vue';

const openIndex = ref(1);
const activeCategory = ref('Tous');
const searchQuery = ref('');

const faqs = [
    { id:1,  cat:'Produits',   q:"Quelle est la différence entre le riz blanc et le riz étuvé HEZOUWE?",            a:"Le riz blanc est décortiqué et poli, offrant une texture légère et un goût délicat. Le riz étuvé est précuit à la vapeur avant décorticage, ce qui emprisonne les nutriments dans le grain, le rend plus ferme à la cuisson et plus riche en vitamines B1 et B3. Les deux sont certifiés ITRA et cultivés à Tagbega." },
    { id:2,  cat:'Produits',   q:"Qu'est-ce que la certification ITRA?",                                            a:"L'ITRA (Institut Togolais de Recherche Agronomique) est l'organisme officiel qui certifie la qualité, la variété et la traçabilité des semences et productions agricoles au Togo. Cette certification garantit que notre riz est produit selon les standards agronomiques les plus stricts." },
    { id:3,  cat:'Produits',   q:"Vos produits contiennent-ils des additifs ou conservateurs?",                     a:"Non. Tous nos produits sont 100% naturels, sans OGM, sans colorants ni conservateurs. Notre riz est transformé mécaniquement dans nos installations à Tagbega et conditionné hermétiquement pour conserver sa fraîcheur." },
    { id:4,  cat:'Produits',   q:"Quelle est la durée de conservation de votre riz?",                              a:"Nos produits se conservent 6 à 12 mois selon le type : 6 mois pour le riz blanc, 12 mois pour le riz étuvé. Conservez dans un endroit frais, sec et à l'abri de la lumière. Une fois ouvert, fermez hermétiquement le sac." },
    { id:5,  cat:'Commandes',  q:"Comment puis-je passer une commande?",                                           a:"Vous pouvez commander directement sur notre site dans la section 'Nos Produits', par téléphone au +228 70 67 94 48, par email à contact@hezouwe.com, ou en visitant notre siège à Tagbega, Région des Plateaux, TOGO. Pour les commandes groupées (>50kg), contactez-nous pour un devis personnalisé." },
    { id:6,  cat:'Commandes',  q:"Y a-t-il un minimum de commande?",                                               a:"Il n'y a pas de minimum pour les particuliers. Pour les commandes groupées professionnelles (restaurants, revendeurs, ONG), un minimum de 25kg est requis pour bénéficier des tarifs Pro. Contactez-nous pour les conditions." },
    { id:7,  cat:'Commandes',  q:"Acceptez-vous les commandes groupées pour les entreprises?",                      a:"Oui, nous avons une offre spéciale pour les entreprises, restaurants, cantines, épiceries et ONG. Nous proposons des tarifs dégressifs selon le volume, ainsi qu'un service de livraison dédié. Contactez notre équipe commerciale pour un devis." },
    { id:8,  cat:'Livraison',  q:"Quelle est la zone de livraison et les délais?",                                 a:"Nous livrons dans tout le TOGO sous 24 à 48h. Pour les livraisons à Lomé et environs : 24h. Pour les régions éloignées : 48h. La livraison est gratuite pour toute commande supérieure à 10 000 FCFA. Un suivi par SMS vous est envoyé." },
    { id:9,  cat:'Livraison',  q:"Combien coûte la livraison?",                                                    a:"La livraison est gratuite pour toute commande dépassant 10 000 FCFA. En dessous de ce seuil, des frais de 1 500 FCFA s'appliquent en zone Lomé. Pour les régions et commandes en gros, contactez-nous pour un devis de transport adapté." },
    { id:10, cat:'Paiement',   q:"Quels modes de paiement acceptez-vous?",                                         a:"Nous acceptons : Mobile Money (Flooz, T-Money), virement bancaire, espèces à la livraison ou en agence. Pour les commandes en ligne, le paiement par carte Stripe est également disponible. Tous les paiements sont sécurisés." },
    { id:11, cat:'Paiement',   q:"Les prix affichés incluent-ils la TVA?",                                         a:"Oui, tous nos prix sont affichés TTC (Toutes Taxes Comprises). Pour les achats en gros avec facturation professionnelle, une facture détaillée avec TVA applicable au TOGO vous sera fournie." },
    { id:12, cat:'Coopérative',q:"Comment rejoindre la coopérative HEZOUWE en tant que producteur?",               a:"Nous accueillons les riziculteurs de la région des Plateaux qui souhaitent rejoindre notre réseau. Conditions : posséder ou exploiter des parcelles de riz, s'engager à respecter nos standards de qualité, et résider dans notre zone d'intervention. Contactez-nous pour une visite de terrain." },
    { id:13, cat:'Coopérative',q:"Qui soutient HEZOUWE?",                                                          a:"La COOP CA HEZOUWE est soutenue par Compassion Internationale Togo pour son volet développement communautaire. Nous travaillons également avec l'ITRA pour la certification et avec des partenaires techniques locaux pour moderniser nos équipements." },
    { id:14, cat:'Coopérative',q:"Combien de producteurs font partie de la coopérative?",                          a:"Actuellement, 30 producteurs membres cultivent le riz dans la zone de Tagbega, Région des Plateaux. Ensemble, ils exploitent plusieurs dizaines d'hectares de rizières certifiées. La coopérative a été fondée en 2023 et compte déjà 13 emplois directs et indirects créés." },
];

const faqCategories = computed(() => ['Tous', ...new Set(faqs.map(f => f.cat))]);

const filteredFaqs = computed(() => {
    return faqs.filter(f => {
        const matchCat = activeCategory.value === 'Tous' || f.cat === activeCategory.value;
        const matchSearch = !searchQuery.value || f.q.toLowerCase().includes(searchQuery.value.toLowerCase()) || f.a.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchCat && matchSearch;
    });
});

const toggle = (id) => { openIndex.value = openIndex.value === id ? null : id; };
</script>

<style scoped>
/* Intro bar */
.faq-intro { background: #1a3a1a; padding: 20px 0; }
.faq-intro-inner { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 16px; }
.faq-intro-stat { display: flex; align-items: center; gap: 14px; color: #fff; }
.faq-intro-stat i { font-size: 1.8rem; color: #8bc34a; }
.faq-intro-stat strong { display: block; font-size: 1.3rem; font-weight: 800; color: #8bc34a; }
.faq-intro-stat span { font-size: .75rem; color: #ccc; }

/* Section */
.faq-section { padding: 80px 0 90px; }

/* Category filter */
.faq-cats { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
.faq-cat-btn { padding: 8px 20px; border: 2px solid #e0e0e0; background: none; border-radius: 30px; font-size: .85rem; cursor: pointer; transition: all .25s; color: #555; font-weight: 600; }
.faq-cat-btn:hover, .faq-cat-btn.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }

/* Accordion */
.faq-accordion { display: flex; flex-direction: column; gap: 12px; }
.faq-item { border: 1.5px solid #e8f0e8; border-radius: 12px; overflow: hidden; transition: border-color .3s, box-shadow .3s; }
.faq-item.open { border-color: #5cb85c; box-shadow: 0 4px 20px rgba(92,184,92,.15); }
.faq-question { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; cursor: pointer; gap: 16px; transition: background .25s; }
.faq-item.open .faq-question { background: #f0fff0; }
.faq-q-left { display: flex; align-items: center; gap: 16px; flex: 1; }
.faq-num { font-size: .75rem; font-weight: 800; color: #5cb85c; background: #e8f5e9; padding: 4px 10px; border-radius: 20px; flex-shrink: 0; }
.faq-question h5 { font-size: .95rem; font-weight: 700; color: #1a3a1a; margin: 0; line-height: 1.4; }
.faq-icon { width: 32px; height: 32px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: .8rem; color: #5cb85c; flex-shrink: 0; transition: all .3s; }
.faq-item.open .faq-icon { background: #5cb85c; color: #fff; }
.faq-answer { padding: 0 24px 20px 70px; }
.faq-answer p { color: #555; font-size: .9rem; line-height: 1.8; margin: 0; }

.faq-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.faq-empty i { font-size: 2.5rem; display: block; margin-bottom: 12px; }

/* Sidebar widgets */
.faq-widget { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,.07); margin-bottom: 24px; }
.faq-widget-title { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin: 0 0 16px; padding-bottom: 10px; border-bottom: 2px solid #e8f5e9; position: relative; }
.faq-widget-title::after { content:''; position:absolute; bottom:-2px; left:0; width:40px; height:2px; background:#5cb85c; }

.faq-search { position: relative; }
.faq-search input { width: 100%; border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px 40px 10px 14px; font-size: .9rem; outline: none; transition: border-color .3s; }
.faq-search input:focus { border-color: #5cb85c; }
.faq-search i { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #aaa; }

.faq-contact-widget { background: linear-gradient(135deg, #1a3a1a 0%, #2d7a2d 100%); color: #fff; text-align: center; }
.faq-contact-icon { font-size: 2.5rem; color: #8bc34a; margin-bottom: 14px; }
.faq-contact-widget h4 { color: #fff; font-size: 1rem; margin-bottom: 10px; }
.faq-contact-widget p { color: #c8e6c9; font-size: .85rem; line-height: 1.7; margin-bottom: 16px; }
.faq-contact-items { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
.faq-contact-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: rgba(255,255,255,.1); border-radius: 8px; color: #fff; text-decoration: none; font-size: .85rem; transition: background .25s; }
.faq-contact-item:hover { background: rgba(255,255,255,.2); }
.faq-contact-item i { color: #8bc34a; }
.faq-cta-btn { display: flex; justify-content: center; align-items: center; gap: 8px; padding: 12px; background: #5cb85c; color: #fff; border-radius: 8px; text-decoration: none; font-size: .9rem; font-weight: 700; transition: background .3s; }
.faq-cta-btn:hover { background: #8bc34a; color: #fff; }

.faq-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
.faq-links li a { display: flex; align-items: center; gap: 10px; color: #555; font-size: .9rem; text-decoration: none; transition: color .25s; }
.faq-links li a:hover { color: #5cb85c; }
.faq-links li a i { font-size: .7rem; color: #5cb85c; }

.faq-badge-widget { background: #e8f5e9; border: 2px solid #c8e6c9; text-align: center; }
.faq-badge-icon { font-size: 2rem; color: #5cb85c; display: block; margin-bottom: 10px; }
.faq-badge-widget h5 { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin-bottom: 8px; }
.faq-badge-widget p { font-size: .82rem; color: #555; margin: 0; line-height: 1.6; }
</style>
