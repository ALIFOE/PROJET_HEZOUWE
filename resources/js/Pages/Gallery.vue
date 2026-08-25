<template>
    <AppLayout
        title="Galerie"
        description="Photos de la coopérative COOP CA HEZOUWE : collecte, transformation et commercialisation du riz local du Togo en images."
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
                        <li>Galerie</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Notre Galerie</h1>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="gal-section">
            <div class="container">
                <div class="section-title text-center wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Nos Images</span>
                    <h2 class="text-anim">Activités, Produits & Équipe</h2>
                    <p class="mt-3">Découvrez en images nos installations de Tagbega, nos producteurs partenaires et nos produits de riz de qualité ITRA.</p>
                </div>

                <!-- Filter buttons -->
                <div class="gal-filters wow fadeInUp" data-wow-delay=".2s">
                    <button v-for="cat in categories" :key="cat"
                            class="gal-filter-btn"
                            :class="{ active: activeFilter === cat }"
                            @click="activeFilter = cat">
                        {{ cat }}
                        <span>{{ cat === 'Tout' ? gallery.length : gallery.filter(g => g.cat === cat).length }}</span>
                    </button>
                </div>

                <!-- Grid -->
                <div class="gal-grid">
                    <div v-for="(item, i) in filteredGallery" :key="item.id"
                         class="gal-item wow fadeInUp"
                         :data-wow-delay="`${0.05 + (i % 4) * 0.1}s`"
                         :class="item.wide ? 'gal-wide' : ''"
                         @click="openModal(item)">
                        <div class="gal-img">
                            <img :src="item.src" :alt="item.title">
                            <div class="gal-overlay">
                                <div class="gal-overlay-content">
                                    <span class="gal-cat-badge">{{ item.cat }}</span>
                                    <h5>{{ item.title }}</h5>
                                    <div class="gal-zoom"><i class="far fa-expand"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="filteredGallery.length === 0" class="gal-empty">
                    <i class="far fa-images"></i>
                    <p>Aucune image dans cette catégorie.</p>
                </div>
            </div>
        </section>

        <!-- Lightbox Modal -->
        <div v-if="modalItem" class="gal-modal" @click.self="closeModal">
            <div class="gal-modal-box">
                <button class="gal-modal-close" @click="closeModal"><i class="far fa-times"></i></button>
                <div class="gal-modal-img">
                    <img :src="modalItem.src" :alt="modalItem.title">
                </div>
                <div class="gal-modal-info">
                    <span class="gal-cat-badge">{{ modalItem.cat }}</span>
                    <h4>{{ modalItem.title }}</h4>
                    <p>{{ modalItem.desc }}</p>
                </div>
                <div class="gal-modal-nav">
                    <button @click="prevModal" :disabled="currentModalIndex === 0"><i class="far fa-arrow-left"></i></button>
                    <span>{{ currentModalIndex + 1 }} / {{ filteredGallery.length }}</span>
                    <button @click="nextModal" :disabled="currentModalIndex === filteredGallery.length - 1"><i class="far fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Stats section -->
        <section class="gal-stats section-bg">
            <div class="container">
                <div class="gal-stats-inner">
                    <div v-for="s in stats" :key="s.label" class="gal-stat wow fadeInUp">
                        <i :class="s.icon"></i>
                        <div>
                            <strong>{{ s.value }}</strong>
                            <span>{{ s.label }}</span>
                        </div>
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
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Nos Produits</span>
                            <h2 class="text-white text-anim">Commandez Notre Riz<br>Premium Directement!</h2>
                        </div>
                    </div>
                    <Link href="/shop" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Voir la Boutique <i class="far fa-arrow-right"></i>
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

const activeFilter = ref('Tout');
const modalItem = ref(null);
const currentModalIndex = ref(0);

const gallery = [
    { id:1,  cat:'Riziculture', src:'/assets/img/riz1.jpeg',   title:'Parcelles de Riz à Tagbega',          desc:'Les rizières des membres de la coopérative dans la Région des Plateaux au Togo.',          wide:true  },
    { id:2,  cat:'Riziculture', src:'/assets/img/riz2.jpeg',   title:'Récolte du Riz Blanc',                 desc:'Producteurs membres récoltant le riz blanc certifié ITRA dans les parcelles de Tagbega.' },
    { id:3,  cat:'Transformation', src:'/assets/img/riz3.jpeg',title:'Décorticage Moderne',                  desc:'Nos équipements modernes de décorticage assurent un taux de brisure inférieur à 5%.' },
    { id:4,  cat:'Transformation', src:'/assets/img/riz5.jpeg',title:'Riz Étuvé — Précuisson Vapeur',       desc:'Processus d\'étuvage qui emprisonne les nutriments dans le grain avant décorticage.' },
    { id:5,  cat:'Produits',    src:'/assets/img/riz6.jpeg',   title:'Riz Blanc Premium 5kg',               desc:'Conditionnement soigné du riz blanc premium dans des sacs hermétiques refermables.' },
    { id:6,  cat:'Produits',    src:'/assets/img/riz7.jpeg',   title:'Gamme Riz Étuvé',                     desc:'Notre gamme de riz étuvé riche en vitamines B, certifiée ITRA, idéale pour tous les plats.' },
    { id:7,  cat:'Équipe',      src:'/assets/img/image6.jpg',  title:'Producteurs Partenaires',             desc:'Les 30 producteurs membres de la COOP CA HEZOUWE, piliers de notre coopérative.', wide:true },
    { id:8,  cat:'Riziculture', src:'/assets/img/riz8.jpeg',   title:'Variété IR841',                       desc:'Variété de riz IR841 adaptée aux conditions climatiques des Plateaux togolais.' },
    { id:9,  cat:'Équipe',      src:'/assets/img/image7.jpg',  title:'Formation des Producteurs',           desc:'Sessions de formation agronomique pour améliorer la qualité et les rendements.' },
    { id:10, cat:'Produits',    src:'/assets/img/image10.jpg', title:'Pack Découverte HEZOUWE',             desc:'Notre pack découverte permettant de déguster plusieurs variétés de riz HEZOUWE.' },
    { id:11, cat:'Transformation', src:'/assets/img/image11.jpg', title:'Centre de Conditionnement',       desc:'Nouvelles installations de conditionnement modernisées en 2025 à Tagbega.' },
    { id:12, cat:'Riziculture', src:'/assets/img/image12.jpg', title:'Irrigation des Rizières',            desc:'Système d\'irrigation permettant deux cycles de production par an à Tagbega.' },
];

const categories = computed(() => ['Tout', ...new Set(gallery.map(g => g.cat))]);
const filteredGallery = computed(() =>
    activeFilter.value === 'Tout' ? gallery : gallery.filter(g => g.cat === activeFilter.value)
);

const openModal = (item) => {
    currentModalIndex.value = filteredGallery.value.findIndex(g => g.id === item.id);
    modalItem.value = item;
};
const closeModal = () => { modalItem.value = null; };
const prevModal = () => {
    if (currentModalIndex.value > 0) {
        currentModalIndex.value--;
        modalItem.value = filteredGallery.value[currentModalIndex.value];
    }
};
const nextModal = () => {
    if (currentModalIndex.value < filteredGallery.value.length - 1) {
        currentModalIndex.value++;
        modalItem.value = filteredGallery.value[currentModalIndex.value];
    }
};

const stats = [
    { icon: 'flaticon-farmer',      value: '30+',   label: 'Producteurs membres' },
    { icon: 'flaticon-organic',     value: '50+ha', label: 'Hectares cultivés' },
    { icon: 'flaticon-like',        value: '5K+',   label: 'Clients satisfaits' },
    { icon: 'flaticon-food-safety', value: 'ITRA',  label: 'Certification qualité' },
];
</script>

<style scoped>
.gal-section { padding: 80px 0 60px; }

/* Filters */
.gal-filters { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
.gal-filter-btn { display: flex; align-items: center; gap: 8px; padding: 9px 22px; border: 2px solid #e0e0e0; background: none; border-radius: 30px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .25s; color: #555; }
.gal-filter-btn span { background: #f0f0f0; padding: 1px 8px; border-radius: 20px; font-size: .72rem; }
.gal-filter-btn:hover, .gal-filter-btn.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }
.gal-filter-btn.active span { background: rgba(255,255,255,.25); }

/* Grid */
.gal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.gal-item { cursor: pointer; border-radius: 12px; overflow: hidden; }
.gal-wide { grid-column: span 2; }
.gal-img { position: relative; overflow: hidden; height: 240px; }
.gal-wide .gal-img { height: 260px; }
.gal-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.gal-item:hover .gal-img img { transform: scale(1.08); }
.gal-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(26,58,26,.8) 0%, transparent 50%); opacity: 0; transition: opacity .3s; display: flex; align-items: flex-end; }
.gal-item:hover .gal-overlay { opacity: 1; }
.gal-overlay-content { padding: 20px; width: 100%; }
.gal-cat-badge { display: inline-block; background: #5cb85c; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; margin-bottom: 6px; }
.gal-overlay-content h5 { color: #fff; font-size: .9rem; margin: 0 0 8px; }
.gal-zoom { width: 36px; height: 36px; background: rgba(255,255,255,.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem; }

@media (max-width: 992px) { .gal-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) { .gal-grid { grid-template-columns: 1fr; } .gal-wide { grid-column: span 1; } }

.gal-empty { text-align: center; padding: 60px; color: #aaa; }
.gal-empty i { font-size: 3rem; display: block; margin-bottom: 12px; }

/* Modal */
.gal-modal { position: fixed; inset: 0; background: rgba(0,0,0,.85); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; }
.gal-modal-box { background: #fff; border-radius: 16px; overflow: hidden; max-width: 800px; width: 100%; position: relative; }
.gal-modal-close { position: absolute; top: 12px; right: 12px; z-index: 10; width: 36px; height: 36px; background: rgba(0,0,0,.5); color: #fff; border: none; border-radius: 50%; cursor: pointer; font-size: .9rem; }
.gal-modal-img img { width: 100%; height: 420px; object-fit: cover; display: block; }
.gal-modal-info { padding: 20px 24px; }
.gal-modal-info h4 { font-size: 1.1rem; color: #1a3a1a; margin: 8px 0 6px; }
.gal-modal-info p { font-size: .88rem; color: #666; margin: 0; }
.gal-modal-nav { display: flex; justify-content: center; align-items: center; gap: 20px; padding: 14px 24px; border-top: 1px solid #f0f0f0; }
.gal-modal-nav button { width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid #e0e0e0; background: none; cursor: pointer; transition: all .25s; }
.gal-modal-nav button:hover:not(:disabled) { background: #5cb85c; color: #fff; border-color: #5cb85c; }
.gal-modal-nav button:disabled { opacity: .3; cursor: not-allowed; }
.gal-modal-nav span { font-size: .85rem; color: #777; }

/* Stats */
.gal-stats { padding: 40px 0; }
.gal-stats-inner { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 20px; }
.gal-stat { display: flex; align-items: center; gap: 16px; }
.gal-stat i { font-size: 2rem; color: #5cb85c; }
.gal-stat strong { display: block; font-size: 1.4rem; font-weight: 800; color: #1a3a1a; }
.gal-stat span { font-size: .8rem; color: #777; }
</style>
