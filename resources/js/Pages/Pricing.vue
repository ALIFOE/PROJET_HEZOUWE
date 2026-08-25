<template>
    <AppLayout
        title="Nos Tarifs"
        description="Consultez les tarifs des produits et services de COOP CA HEZOUWE : riz local togolais de qualité à prix juste."
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
                        <li>Nos Tarifs</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Tarifs</h1>
                </div>
            </div>
        </section>

        <!-- Intro -->
        <section class="prc-intro">
            <div class="container">
                <div class="section-title text-center wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Tarification Transparente</span>
                    <h2 class="text-anim">Des Prix Justes pour un Riz de Qualité</h2>
                    <p class="wow fadeInUp" data-wow-delay=".2s">Tous nos prix sont en FCFA, TTC. Des remises sont disponibles pour les commandes groupées et les abonnements professionnels.</p>
                </div>

                <!-- Toggle -->
                <div class="prc-toggle wow fadeInUp" data-wow-delay=".3s">
                    <span :class="{ active: !isAnnuel }">Particuliers</span>
                    <div class="prc-switch" @click="isAnnuel = !isAnnuel" :class="{ on: isAnnuel }">
                        <div class="prc-switch-ball"></div>
                    </div>
                    <span :class="{ active: isAnnuel }">Professionnels <span class="prc-save-badge">-20%</span></span>
                </div>
            </div>
        </section>

        <!-- Produits pricing -->
        <section class="prc-products-section">
            <div class="container">
                <h3 class="prc-section-title wow fadeInUp">Produits Riz</h3>
                <div class="row g-4">
                    <div v-for="(p, i) in productPricing" :key="p.name"
                         class="col-lg-4 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + i * 0.15}s`">
                        <div class="prc-product-card" :class="{ featured: p.featured }">
                            <div v-if="p.featured" class="prc-featured-label">Bestseller</div>
                            <div class="prc-product-img">
                                <img :src="p.image" :alt="p.name">
                            </div>
                            <div class="prc-product-body">
                                <div class="prc-cat">{{ p.category }}</div>
                                <h5>{{ p.name }}</h5>
                                <div class="prc-price-row">
                                    <div class="prc-price-main">
                                        <span class="prc-amount">{{ formatPrice(isAnnuel ? p.proPriceUnit : p.priceUnit) }}</span>
                                        <span class="prc-currency">FCFA/kg</span>
                                    </div>
                                    <div class="prc-price-total">
                                        {{ formatPrice(isAnnuel ? p.proPrice : p.price) }} FCFA <small>/ {{ p.pack }}</small>
                                    </div>
                                </div>
                                <div v-if="isAnnuel" class="prc-saving-info">
                                    <i class="fas fa-tag"></i> Économie : {{ formatPrice(p.price - p.proPrice) }} FCFA
                                </div>
                                <ul class="prc-features">
                                    <li v-for="f in p.features" :key="f"><i class="far fa-check-circle"></i> {{ f }}</li>
                                </ul>
                                <Link :href="`/shop-details/${p.slug}`" class="prc-buy-btn">
                                    Commander <i class="far fa-arrow-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services pricing -->
        <section class="prc-services-section section-bg">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Services</span>
                    <h2 class="text-anim">Tarifs des Services HEZOUWE</h2>
                </div>
                <div class="row g-4">
                    <div v-for="(plan, i) in servicePlans" :key="plan.name"
                         class="col-lg-4 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + i * 0.2}s`">
                        <div class="prc-plan-card" :class="{ 'prc-plan-featured': plan.featured }">
                            <div class="prc-plan-header">
                                <div class="prc-plan-icon"><i :class="plan.icon"></i></div>
                                <h4>{{ plan.name }}</h4>
                                <p>{{ plan.subtitle }}</p>
                            </div>
                            <div class="prc-plan-price">
                                <span class="prc-plan-amount">{{ plan.price }}</span>
                                <span class="prc-plan-period">{{ plan.period }}</span>
                            </div>
                            <ul class="prc-plan-features">
                                <li v-for="f in plan.features" :key="f" :class="{ disabled: f.startsWith('✗') }">
                                    <i :class="f.startsWith('✗') ? 'far fa-times-circle' : 'far fa-check-circle'"></i>
                                    {{ f.replace('✗ ', '') }}
                                </li>
                            </ul>
                            <Link href="/contact" class="prc-plan-btn">
                                Nous Contacter <i class="far fa-arrow-right"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Delivery pricing -->
        <section class="prc-delivery-section">
            <div class="container">
                <div class="section-title text-center mb-5 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Livraison</span>
                    <h2 class="text-anim">Tarifs de Livraison</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <div v-for="(zone, i) in deliveryZones" :key="zone.zone"
                         class="col-lg-3 col-md-6 wow fadeInUp"
                         :data-wow-delay="`${0.1 + i * 0.15}s`">
                        <div class="prc-delivery-card">
                            <div class="prc-del-icon"><i :class="zone.icon"></i></div>
                            <h5>{{ zone.zone }}</h5>
                            <div class="prc-del-price">{{ zone.price }}</div>
                            <p>{{ zone.delay }}</p>
                            <div v-if="zone.free" class="prc-del-free">Gratuit > 10 000 FCFA</div>
                        </div>
                    </div>
                </div>
                <div class="prc-delivery-note wow fadeInUp">
                    <i class="flaticon-leaf"></i>
                    <p>Livraison <strong>gratuite</strong> pour toute commande supérieure à <strong>10 000 FCFA</strong> en zone Lomé et Région des Plateaux. Pour les commandes en gros (>100kg), contactez-nous pour un devis de transport dédié.</p>
                </div>
            </div>
        </section>

        <!-- FAQ Tarifs -->
        <section class="prc-faq-section section-bg">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5 wow fadeInLeft">
                        <div class="section-title">
                            <span><img src="/assets/img/sub-title.svg" alt="img">Questions Tarifs</span>
                            <h2 class="text-anim">Besoin d'un Devis Personnalisé?</h2>
                        </div>
                        <p class="prc-faq-intro">Pour les commandes institutionnelles, les ONG, les restaurants et les revendeurs, nous proposons des tarifs sur mesure selon le volume et la régularité des commandes.</p>
                        <Link href="/contact" class="theme-btn wow fadeInUp">
                            Demander un Devis <i class="far fa-arrow-right"></i>
                        </Link>
                    </div>
                    <div class="col-lg-7 wow fadeInRight">
                        <div class="prc-faq-list">
                            <div v-for="(faq, i) in pricingFaqs" :key="i"
                                 class="prc-faq-item"
                                 :class="{ open: openFaq === i }"
                                 @click="openFaq = openFaq === i ? null : i">
                                <div class="prc-faq-q">
                                    <span>{{ faq.q }}</span>
                                    <i :class="openFaq === i ? 'far fa-minus' : 'far fa-plus'"></i>
                                </div>
                                <div class="prc-faq-a" v-show="openFaq === i">{{ faq.a }}</div>
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
import { ref } from 'vue';

const isAnnuel = ref(false);
const openFaq = ref(null);

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const productPricing = [
    { slug:'riz-blanc-premium-5kg',   name:'Riz Blanc Premium 5kg',  category:'Riz Blanc',    image:'/assets/img/riz2.jpeg',  price:5000,  proPrice:4000,  priceUnit:1000, proPriceUnit:800,  pack:'sac 5kg',  featured:false, features:['Certifié ITRA','Taux brisure < 5%','Sac hermétique','Livraison 24h'] },
    { slug:'riz-itra-certifie-10kg',  name:'Riz ITRA Certifié 10kg', category:'Riz Certifié', image:'/assets/img/riz5.jpeg',  price:7000,  proPrice:5600,  priceUnit:700,  proPriceUnit:560,  pack:'sac 10kg', featured:true,  features:['Certification ITRA','Qualité supérieure','Traçabilité complète','Prix unitaire optimal'] },
    { slug:'riz-blanc-bulk-25kg',     name:'Riz Blanc Bulk 25kg',    category:'Pro / Vrac',   image:'/assets/img/riz6.jpeg',  price:10000, proPrice:8000,  priceUnit:400,  proPriceUnit:320,  pack:'sac 25kg', featured:false, features:['Idéal restauration','Tarif vrac','Facturation pro','Livraison dédiée'] },
];

const servicePlans = [
    {
        name:'Particulier', subtitle:'Pour les ménages', icon:'flaticon-organic', featured:false, price:'0 FCFA', period:'frais de service',
        features:['Commande en ligne','Livraison à domicile','Suivi SMS','Service client 6j/7','✗ Tarifs dégressifs','✗ Facturation pro'],
    },
    {
        name:'Pro / Revendeur', subtitle:'Épiceries, marchés', icon:'flaticon-leaf', featured:true, price:'Sur devis', period:'selon volume',
        features:['Tarifs dégressifs 10–25%','Livraison dédiée','Facturation professionnelle','Crédit 30 jours','Priorité stock','Support dédié'],
    },
    {
        name:'Institution / ONG', subtitle:'Cantines, hôpitaux, ONG', icon:'flaticon-farmer', featured:false, price:'Sur devis', period:'contrat annuel',
        features:['Tarifs institutionnels','Livraison programmée','Contrat annuel','Rapport traçabilité','Visite site possible','✗ Vente au détail'],
    },
];

const deliveryZones = [
    { icon:'flaticon-delivery', zone:'Lomé & environs',         price:'1 500 FCFA',   delay:'Sous 24h',  free:true  },
    { icon:'flaticon-delivery', zone:'Région des Plateaux',     price:'2 000 FCFA',   delay:'Sous 24h',  free:true  },
    { icon:'flaticon-delivery', zone:'Autres régions TOGO',     price:'3 000 FCFA',   delay:'Sous 48h',  free:false },
    { icon:'flaticon-delivery', zone:'Commande > 100kg',        price:'Sur devis',    delay:'Programmé', free:false },
];

const pricingFaqs = [
    { q:'Y a-t-il un minimum de commande pour les tarifs Pro?',      a:'Oui, les tarifs professionnels s\'appliquent à partir de 25kg par commande. Pour les contrats annuels, un volume minimum de 200kg/mois est requis.' },
    { q:'Comment obtenir un devis pour une commande groupée?',        a:'Contactez-nous par téléphone (+228 70 67 94 48) ou par email (contact@hezouwe.com) en précisant les quantités, la fréquence et la zone de livraison.' },
    { q:'Les prix incluent-ils les frais de livraison?',              a:'Non, les prix affichés sont hors livraison. La livraison est gratuite pour toute commande supérieure à 10 000 FCFA en zone Lomé et Plateaux.' },
    { q:'Proposez-vous des abonnements mensuels?',                    a:'Oui, pour les professionnels et institutions qui commandent régulièrement, nous proposons des contrats d\'approvisionnement mensuel avec des tarifs préférentiels.' },
];
</script>

<style scoped>
/* Intro */
.prc-intro { padding: 70px 0 30px; }
.prc-toggle { display: flex; align-items: center; justify-content: center; gap: 16px; margin-top: 30px; font-size: .95rem; font-weight: 600; }
.prc-toggle span { color: #aaa; transition: color .3s; }
.prc-toggle span.active { color: #1a3a1a; }
.prc-switch { width: 52px; height: 28px; background: #e0e0e0; border-radius: 14px; cursor: pointer; position: relative; transition: background .3s; }
.prc-switch.on { background: #5cb85c; }
.prc-switch-ball { width: 22px; height: 22px; background: #fff; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: left .3s; box-shadow: 0 2px 6px rgba(0,0,0,.2); }
.prc-switch.on .prc-switch-ball { left: 27px; }
.prc-save-badge { background: #ff5722; color: #fff; padding: 1px 8px; border-radius: 20px; font-size: .72rem; margin-left: 6px; }

/* Products section */
.prc-products-section { padding: 60px 0 80px; }
.prc-section-title { font-size: 1.4rem; font-weight: 800; color: #1a3a1a; margin-bottom: 30px; padding-left: 16px; border-left: 4px solid #5cb85c; }

.prc-product-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); border: 2px solid transparent; transition: all .3s; position: relative; }
.prc-product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,.12); border-color: #c8e6c9; }
.prc-product-card.featured { border-color: #5cb85c; }
.prc-featured-label { position: absolute; top: 16px; right: 16px; background: #5cb85c; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: .72rem; font-weight: 700; z-index: 2; }
.prc-product-img { height: 200px; overflow: hidden; }
.prc-product-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.prc-product-card:hover .prc-product-img img { transform: scale(1.06); }
.prc-product-body { padding: 22px; }
.prc-cat { font-size: .72rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.prc-product-body h5 { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin-bottom: 14px; }
.prc-price-row { margin-bottom: 8px; }
.prc-price-main { display: flex; align-items: baseline; gap: 4px; }
.prc-amount { font-size: 1.8rem; font-weight: 900; color: #2d7a2d; }
.prc-currency { font-size: .85rem; color: #777; }
.prc-price-total { font-size: .85rem; color: #555; margin-top: 2px; }
.prc-price-total small { color: #aaa; }
.prc-saving-info { display: flex; align-items: center; gap: 6px; background: #fff3e0; color: #e65100; padding: 6px 12px; border-radius: 8px; font-size: .8rem; font-weight: 600; margin-bottom: 14px; }
.prc-features { list-style: none; padding: 0; margin: 12px 0 18px; display: flex; flex-direction: column; gap: 8px; }
.prc-features li { display: flex; align-items: center; gap: 8px; font-size: .85rem; color: #555; }
.prc-features li i { color: #5cb85c; font-size: .8rem; }
.prc-buy-btn { display: flex; justify-content: center; align-items: center; gap: 8px; padding: 12px; background: #1a3a1a; color: #fff; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; transition: background .3s; }
.prc-buy-btn:hover { background: #5cb85c; color: #fff; }

/* Service plans */
.prc-services-section { padding: 80px 0; }
.prc-plan-card { background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,.07); border: 2px solid #f0f0f0; transition: all .3s; height: 100%; display: flex; flex-direction: column; }
.prc-plan-card:hover { border-color: #c8e6c9; transform: translateY(-5px); }
.prc-plan-featured { border-color: #5cb85c; background: linear-gradient(to bottom, #f0fff0, #fff); }
.prc-plan-header { text-align: center; margin-bottom: 20px; }
.prc-plan-icon { font-size: 2.2rem; color: #5cb85c; margin-bottom: 12px; }
.prc-plan-header h4 { font-size: 1.2rem; font-weight: 800; color: #1a3a1a; margin-bottom: 4px; }
.prc-plan-header p { font-size: .85rem; color: #888; margin: 0; }
.prc-plan-price { text-align: center; margin-bottom: 24px; padding: 16px; background: #f8f8f8; border-radius: 12px; }
.prc-plan-amount { font-size: 1.8rem; font-weight: 900; color: #2d7a2d; display: block; }
.prc-plan-period { font-size: .8rem; color: #aaa; }
.prc-plan-features { list-style: none; padding: 0; margin: 0 0 24px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
.prc-plan-features li { display: flex; align-items: center; gap: 8px; font-size: .88rem; color: #555; }
.prc-plan-features li i { font-size: .8rem; }
.prc-plan-features li i.fa-check-circle { color: #5cb85c; }
.prc-plan-features li.disabled { color: #ccc; }
.prc-plan-features li.disabled i { color: #ddd; }
.prc-plan-btn { display: flex; justify-content: center; align-items: center; gap: 8px; padding: 12px; background: #5cb85c; color: #fff; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; transition: background .3s; }
.prc-plan-btn:hover { background: #2d7a2d; color: #fff; }

/* Delivery */
.prc-delivery-section { padding: 80px 0; }
.prc-delivery-card { background: #fff; border-radius: 14px; padding: 28px 20px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,.06); border: 1.5px solid #f0f0f0; transition: border-color .3s; }
.prc-delivery-card:hover { border-color: #5cb85c; }
.prc-del-icon { font-size: 2rem; color: #5cb85c; margin-bottom: 12px; }
.prc-delivery-card h5 { font-size: .95rem; font-weight: 700; color: #1a3a1a; margin-bottom: 10px; }
.prc-del-price { font-size: 1.4rem; font-weight: 800; color: #2d7a2d; margin-bottom: 6px; }
.prc-delivery-card p { font-size: .82rem; color: #888; margin-bottom: 10px; }
.prc-del-free { background: #e8f5e9; color: #2d7a2d; padding: 4px 12px; border-radius: 20px; font-size: .72rem; font-weight: 700; display: inline-block; }
.prc-delivery-note { display: flex; align-items: flex-start; gap: 14px; margin-top: 30px; background: #e8f5e9; border-radius: 12px; padding: 18px 22px; border: 1px solid #c8e6c9; }
.prc-delivery-note i { font-size: 1.4rem; color: #5cb85c; flex-shrink: 0; }
.prc-delivery-note p { font-size: .88rem; color: #555; margin: 0; line-height: 1.7; }

/* FAQ pricing */
.prc-faq-section { padding: 80px 0; }
.prc-faq-intro { color: #555; line-height: 1.8; margin-bottom: 24px; }
.prc-faq-list { display: flex; flex-direction: column; gap: 12px; }
.prc-faq-item { background: #fff; border-radius: 10px; border: 1.5px solid #e0e0e0; overflow: hidden; cursor: pointer; }
.prc-faq-item.open { border-color: #5cb85c; }
.prc-faq-q { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; gap: 12px; font-size: .9rem; font-weight: 600; color: #1a3a1a; }
.prc-faq-q i { color: #5cb85c; flex-shrink: 0; }
.prc-faq-a { padding: 0 20px 16px; font-size: .88rem; color: #666; line-height: 1.7; }
</style>
