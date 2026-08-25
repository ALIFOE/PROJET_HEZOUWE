<template>
    <AppLayout
        title="Nos Produits"
        description="Achetez du riz local togolais de qualité : riz blanc, riz étuvé et autres produits de la coopérative COOP CA HEZOUWE, directement des producteurs du Togo."
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
                        <li>Nos Produits</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Produits</h1>
                </div>
            </div>
        </section>

        <!-- Stats bar -->
        <div class="sh-stats-bar">
            <div class="container">
                <div class="sh-stats-inner">
                    <div class="sh-stat"><span class="sh-stat-val">{{ products.length }}</span><span class="sh-stat-lbl">Produits</span></div>
                    <div class="sh-stat"><span class="sh-stat-val">{{ categories.length }}</span><span class="sh-stat-lbl">Catégories</span></div>
                    <div class="sh-stat"><span class="sh-stat-val">{{ inStockCount }}</span><span class="sh-stat-lbl">En stock</span></div>
                    <div class="sh-stat"><span class="sh-stat-val">5 000+</span><span class="sh-stat-lbl">Clients</span></div>
                </div>
            </div>
        </div>

        <!-- Shop Section -->
        <section class="sh-section fix">
            <div class="container">
                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-4 order-2 order-xl-1">
                        <div class="sh-sidebar">
                            <!-- Search -->
                            <div class="sh-widget">
                                <h4 class="sh-widget-title">Recherche</h4>
                                <div class="sh-search">
                                    <input v-model="searchQuery" type="text" placeholder="Rechercher un produit...">
                                    <button><i class="fal fa-search"></i></button>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="sh-widget">
                                <h4 class="sh-widget-title">Catégories</h4>
                                <ul class="sh-cat-list">
                                    <li :class="{ active: activeCategory === '' }" @click="activeCategory = ''">
                                        <span>Tous les produits</span>
                                        <span class="sh-cat-count">{{ products.length }}</span>
                                    </li>
                                    <li v-for="cat in categories" :key="cat"
                                        :class="{ active: activeCategory === cat }"
                                        @click="activeCategory = cat">
                                        <span>{{ cat }}</span>
                                        <span class="sh-cat-count">{{ countByCategory(cat) }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Meilleures ventes -->
                            <div class="sh-widget">
                                <h4 class="sh-widget-title">Meilleures Ventes</h4>
                                <div class="sh-bestsellers">
                                    <div v-for="p in topSellers" :key="p.slug" class="sh-bs-item">
                                        <div class="sh-bs-img bg-cover" :style="`background-image:url('${p.image}')`"></div>
                                        <div class="sh-bs-info">
                                            <div class="sh-bs-stars">
                                                <i v-for="s in p.stars" :key="s" class="fas fa-star"></i>
                                            </div>
                                            <h6><Link :href="`/shop-details/${p.slug}`">{{ p.title }}</Link></h6>
                                            <p>{{ formatPrice(p.price) }} FCFA</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtrer par prix -->
                            <div class="sh-widget">
                                <h4 class="sh-widget-title">Filtrer par Prix</h4>
                                <div class="sh-price-filter">
                                    <div class="sh-price-range">
                                        <input type="range" v-model.number="maxPrice" min="1000" max="15000" step="500" class="sh-range">
                                    </div>
                                    <p class="sh-price-label">Prix max: <strong>{{ formatPrice(maxPrice) }} FCFA</strong></p>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="sh-widget">
                                <h4 class="sh-widget-title">Tags Populaires</h4>
                                <div class="sh-tags">
                                    <span v-for="tag in popularTags" :key="tag"
                                          class="sh-tag"
                                          :class="{ active: activeTag === tag }"
                                          @click="activeTag = activeTag === tag ? '' : tag">
                                        {{ tag }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="col-xl-9 col-lg-8 order-1 order-xl-2">
                        <!-- Sort bar -->
                        <div class="sh-sort-bar">
                            <p>{{ filteredProducts.length }} produit{{ filteredProducts.length > 1 ? 's' : '' }} trouvé{{ filteredProducts.length > 1 ? 's' : '' }}</p>
                            <select v-model="sortBy" class="sh-sort-select">
                                <option value="">Trier par défaut</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="discount">Meilleure remise</option>
                            </select>
                        </div>

                        <div v-if="filteredProducts.length === 0" class="sh-empty">
                            <i class="flaticon-wheat"></i>
                            <p>Aucun produit ne correspond à votre recherche.</p>
                            <button @click="resetFilters" class="sh-reset-btn">Réinitialiser les filtres</button>
                        </div>

                        <div class="row g-4">
                            <div v-for="(p, i) in filteredProducts" :key="p.slug"
                                 class="col-lg-4 col-md-6 wow fadeInUp"
                                 :data-wow-delay="`${0.1 + (i % 3) * 0.2}s`">
                                <div class="sh-card">
                                    <div class="sh-card-img">
                                        <img :src="p.image" :alt="p.title">
                                        <span v-if="p.badge" class="sh-badge">{{ p.badge }}</span>
                                        <span v-if="p.discount" class="sh-discount">-{{ p.discount }}%</span>
                                        <div class="sh-card-overlay">
                                            <button type="button" @click="addToCart(p)" class="sh-ov-btn" title="Ajouter au panier">
                                                <i class="far fa-shopping-cart"></i>
                                            </button>
                                            <Link :href="`/shop-details/${p.slug}`" class="sh-ov-btn" title="Voir détails">
                                                <i class="far fa-eye"></i>
                                            </Link>
                                            <Link href="/shop-cart" class="sh-ov-btn" title="Favoris">
                                                <i class="far fa-heart"></i>
                                            </Link>
                                        </div>
                                    </div>
                                    <div class="sh-card-body">
                                        <div class="sh-card-cat">{{ p.category }}</div>
                                        <h5 class="sh-card-title">
                                            <Link :href="`/shop-details/${p.slug}`">{{ p.title }}</Link>
                                        </h5>
                                        <div class="sh-card-stars">
                                            <i v-for="s in p.stars" :key="s" class="fas fa-star"></i>
                                            <span>({{ p.reviews }})</span>
                                        </div>
                                        <div class="sh-card-price">
                                            <span class="sh-price-main">{{ formatPrice(p.price) }} FCFA</span>
                                            <span v-if="p.price_promo" class="sh-price-old"><del>{{ formatPrice(p.price_promo) }} FCFA</del></span>
                                        </div>
                                        <div class="sh-card-stock" :class="p.in_stock ? 'in' : 'out'">
                                            <i :class="p.in_stock ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                            {{ p.in_stock ? 'En stock' : 'Rupture' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        <!-- Gallery Slider -->
        <div class="gallery-section-4 section-padding fix pt-0 section-bg">
            <div class="swiper gallery-slide">
                <div class="swiper-wrapper">
                    <div v-for="img in galleryImages" :key="img" class="swiper-slide">
                        <div class="gallery-image-4">
                            <img :src="img" alt="galerie">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({ products: Array });

const searchQuery = ref('');
const activeCategory = ref('');
const activeTag = ref('');
const maxPrice = ref(15000);
const sortBy = ref('');

const categories = computed(() => [...new Set(props.products.map(p => p.category))]);
const inStockCount = computed(() => props.products.filter(p => p.in_stock).length);
const topSellers = computed(() => props.products.slice(0, 3));
const popularTags = ['Riz Blanc', 'Riz Étuvé', 'ITRA', 'Premium', 'Bio', 'Bulk'];

const countByCategory = (cat) => props.products.filter(p => p.category === cat).length;

const filteredProducts = computed(() => {
    let list = props.products.filter(p => {
        const matchSearch = !searchQuery.value || p.title.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchCat = !activeCategory.value || p.category === activeCategory.value;
        const matchPrice = p.price <= maxPrice.value;
        const matchTag = !activeTag.value || p.features?.includes(activeTag.value) || p.category.includes(activeTag.value) || p.title.includes(activeTag.value);
        return matchSearch && matchCat && matchPrice && matchTag;
    });
    if (sortBy.value === 'price_asc') list = [...list].sort((a, b) => a.price - b.price);
    if (sortBy.value === 'price_desc') list = [...list].sort((a, b) => b.price - a.price);
    if (sortBy.value === 'discount') list = [...list].sort((a, b) => (b.discount || 0) - (a.discount || 0));
    return list;
});

const formatPrice = (n) => n.toLocaleString('fr-FR');
const resetFilters = () => { searchQuery.value = ''; activeCategory.value = ''; activeTag.value = ''; maxPrice.value = 15000; sortBy.value = ''; };

const addToCart = (product) => {
    router.post(route('cart.store'), {
        product_slug: product.slug,
        quantity: 1,
        redirect_to: '/shop-cart',
    }, { preserveScroll: true });
};

const galleryImages = [
    '/assets/img/image1.jpg', '/assets/img/image2.jpg', '/assets/img/image3.jpg',
    '/assets/img/image4.jpg', '/assets/img/image5.jpg',
];

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
        new Swiper('.gallery-slide', {
            loop: true, slidesPerView: 5, spaceBetween: 30,
            autoplay: { delay: 3000 },
            breakpoints: { 1200:{slidesPerView:5}, 992:{slidesPerView:4}, 768:{slidesPerView:3}, 576:{slidesPerView:2}, 0:{slidesPerView:1} },
        });
    }
});
</script>

<style scoped>
/* Stats bar */
.sh-stats-bar { background: #1a3a1a; padding: 18px 0; }
.sh-stats-inner { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 12px; }
.sh-stat { text-align: center; }
.sh-stat-val { display: block; font-size: 1.6rem; font-weight: 800; color: #8bc34a; line-height: 1; }
.sh-stat-lbl { font-size: .75rem; color: #ccc; text-transform: uppercase; letter-spacing: 1px; }

/* Section */
.sh-section { padding: 90px 0; }

/* Sidebar */
.sh-sidebar { display: flex; flex-direction: column; gap: 30px; }
.sh-widget { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
.sh-widget-title { font-size: 1rem; font-weight: 700; color: #1a3a1a; margin: 0 0 16px; padding-bottom: 10px; border-bottom: 2px solid #e8f5e9; position: relative; }
.sh-widget-title::after { content:''; position:absolute; bottom:-2px; left:0; width:40px; height:2px; background:#5cb85c; }

.sh-search { display: flex; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; transition: border-color .3s; }
.sh-search:focus-within { border-color: #5cb85c; }
.sh-search input { flex: 1; border: none; padding: 10px 14px; font-size: .9rem; outline: none; }
.sh-search button { background: #5cb85c; color: #fff; border: none; padding: 10px 16px; cursor: pointer; transition: background .3s; }
.sh-search button:hover { background: #2d7a2d; }

.sh-cat-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
.sh-cat-list li { display: flex; justify-content: space-between; align-items: center; padding: 9px 12px; border-radius: 8px; cursor: pointer; font-size: .9rem; color: #555; transition: all .25s; border: 1px solid transparent; }
.sh-cat-list li:hover, .sh-cat-list li.active { background: #e8f5e9; color: #2d7a2d; font-weight: 600; border-color: #c8e6c9; }
.sh-cat-count { background: #5cb85c; color: #fff; border-radius: 20px; padding: 1px 8px; font-size: .75rem; }

.sh-bestsellers { display: flex; flex-direction: column; gap: 16px; }
.sh-bs-item { display: flex; gap: 12px; align-items: center; }
.sh-bs-img { width: 60px; height: 60px; border-radius: 8px; flex-shrink: 0; background-size: cover; background-position: center; }
.sh-bs-info { flex: 1; }
.sh-bs-stars { color: #ffc107; font-size: .7rem; margin-bottom: 3px; }
.sh-bs-info h6 { font-size: .85rem; margin: 0 0 2px; line-height: 1.3; }
.sh-bs-info h6 a { color: #1a3a1a; text-decoration: none; }
.sh-bs-info h6 a:hover { color: #5cb85c; }
.sh-bs-info p { font-size: .8rem; color: #5cb85c; font-weight: 700; margin: 0; }

.sh-price-filter { display: flex; flex-direction: column; gap: 12px; }
.sh-range { width: 100%; accent-color: #5cb85c; }
.sh-price-label { font-size: .85rem; color: #555; margin: 0; }
.sh-price-label strong { color: #2d7a2d; }

.sh-tags { display: flex; flex-wrap: wrap; gap: 8px; }
.sh-tag { padding: 5px 12px; border: 1.5px solid #ddd; border-radius: 20px; font-size: .8rem; cursor: pointer; transition: all .25s; color: #555; }
.sh-tag:hover, .sh-tag.active { background: #5cb85c; color: #fff; border-color: #5cb85c; }

/* Sort bar */
.sh-sort-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding: 12px 16px; background: #f8fdf8; border-radius: 8px; border: 1px solid #e0f0e0; }
.sh-sort-bar p { margin: 0; font-size: .9rem; color: #666; }
.sh-sort-select { border: 1.5px solid #ddd; border-radius: 6px; padding: 7px 12px; font-size: .85rem; outline: none; cursor: pointer; }
.sh-sort-select:focus { border-color: #5cb85c; }

.sh-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.sh-empty i { font-size: 3rem; color: #c8e6c9; display: block; margin-bottom: 16px; }
.sh-empty p { font-size: 1rem; margin-bottom: 20px; }
.sh-reset-btn { background: #5cb85c; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; cursor: pointer; font-size: .9rem; }

/* Product card */
.sh-card { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s; background: #fff; height: 100%; display: flex; flex-direction: column; }
.sh-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,.13); }

.sh-card-img { position: relative; overflow: hidden; height: 220px; }
.sh-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.sh-card:hover .sh-card-img img { transform: scale(1.07); }

.sh-badge { position: absolute; top: 12px; left: 12px; background: #5cb85c; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; }
.sh-discount { position: absolute; top: 12px; right: 12px; background: #ff5722; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; }

.sh-card-overlay { position: absolute; bottom: -60px; left: 0; right: 0; display: flex; justify-content: center; gap: 10px; padding: 14px; background: linear-gradient(transparent, rgba(0,0,0,.5)); transition: bottom .3s; }
.sh-card:hover .sh-card-overlay { bottom: 0; }
.sh-ov-btn { width: 38px; height: 38px; background: #fff; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1a3a1a; text-decoration: none; font-size: .85rem; cursor: pointer; transition: all .25s; }
.sh-ov-btn:hover { background: #5cb85c; color: #fff; }

.sh-card-body { padding: 18px; flex: 1; display: flex; flex-direction: column; gap: 6px; }
.sh-card-cat { font-size: .72rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
.sh-card-title { font-size: .95rem; font-weight: 700; color: #1a3a1a; margin: 0; line-height: 1.3; }
.sh-card-title a { color: inherit; text-decoration: none; }
.sh-card-title a:hover { color: #5cb85c; }
.sh-card-stars { color: #ffc107; font-size: .75rem; }
.sh-card-stars span { color: #999; margin-left: 4px; font-size: .8rem; }
.sh-card-price { display: flex; align-items: baseline; gap: 10px; margin-top: 4px; }
.sh-price-main { font-size: 1.1rem; font-weight: 800; color: #2d7a2d; }
.sh-price-old { font-size: .85rem; color: #aaa; }
.sh-card-stock { font-size: .78rem; font-weight: 600; display: flex; align-items: center; gap: 5px; margin-top: 2px; }
.sh-card-stock.in { color: #5cb85c; }
.sh-card-stock.out { color: #f44336; }
</style>
