<template>
    <AppLayout :title="product.title">
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y"><img src="/assets/img/inner-page/shape-1.png" alt="img"></div>
            <div class="shape-2 float-bob-x"><img src="/assets/img/inner-page/shape-2.png" alt="img"></div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/shop">Nos Produits</Link></li>
                        <li>//</li>
                        <li>{{ product.title }}</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">{{ product.title }}</h1>
                </div>
            </div>
        </section>

        <!-- Product Detail -->
        <section class="spd-section">
            <div class="container">
                <div class="row g-5">
                    <!-- Image gallery -->
                    <div class="col-lg-6 wow fadeInLeft">
                        <div class="spd-gallery">
                            <div class="spd-main-img">
                                <img :src="activeImage" :alt="product.title">
                                <span v-if="product.badge" class="spd-badge">{{ product.badge }}</span>
                                <span v-if="product.discount" class="spd-discount">-{{ product.discount }}%</span>
                            </div>
                            <div class="spd-thumbs">
                                <div v-for="(img, i) in product.images" :key="i"
                                     class="spd-thumb"
                                     :class="{ active: activeImage === img }"
                                     @click="activeImage = img">
                                    <img :src="img" :alt="`vue ${i+1}`">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product info -->
                    <div class="col-lg-6 wow fadeInRight">
                        <div class="spd-info">
                            <div class="spd-cat">{{ product.category }}</div>
                            <h2 class="spd-title">{{ product.title }}</h2>

                            <div class="spd-stars">
                                <i v-for="s in product.stars" :key="s" class="fas fa-star"></i>
                                <span>({{ product.reviews }} avis)</span>
                            </div>

                            <div class="spd-prices">
                                <span class="spd-price">{{ formatPrice(product.price) }} FCFA</span>
                                <span v-if="product.price_promo" class="spd-price-old">
                                    <del>{{ formatPrice(product.price_promo) }} FCFA</del>
                                </span>
                                <span v-if="product.discount" class="spd-saving">
                                    Économie: {{ formatPrice(product.price_promo - product.price) }} FCFA
                                </span>
                            </div>

                            <p class="spd-short">{{ product.short }}</p>

                            <div class="spd-stock" :class="product.in_stock ? 'in' : 'out'">
                                <i :class="product.in_stock ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                {{ product.in_stock ? 'En stock — Livraison sous 24–48h' : 'Rupture de stock' }}
                            </div>

                            <!-- Features badges -->
                            <div class="spd-features">
                                <span v-for="f in product.features" :key="f" class="spd-feat">{{ f }}</span>
                            </div>

                            <!-- Quantity + add -->
                            <div class="spd-actions">
                                <div class="spd-qty">
                                    <button @click="qty > 1 && qty--" class="spd-qty-btn">−</button>
                                    <span class="spd-qty-val">{{ qty }}</span>
                                    <button @click="qty++" class="spd-qty-btn">+</button>
                                </div>
                                <button type="button" @click="addToCart" class="spd-btn-cart">
                                    <i class="far fa-shopping-cart"></i> Ajouter au Panier
                                </button>
                                <button type="button" @click="buyNow" class="spd-btn-buy">
                                    Acheter <i class="far fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Trust badges -->
                            <div class="spd-trust">
                                <div class="spd-trust-item">
                                    <i class="flaticon-leaf"></i>
                                    <span>100% Naturel</span>
                                </div>
                                <div class="spd-trust-item">
                                    <i class="flaticon-delivery"></i>
                                    <span>Livraison rapide</span>
                                </div>
                                <div class="spd-trust-item">
                                    <i class="flaticon-organic"></i>
                                    <span>Certifié ITRA</span>
                                </div>
                                <div class="spd-trust-item">
                                    <i class="flaticon-customer-service"></i>
                                    <span>SAV disponible</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="spd-tabs wow fadeInUp" data-wow-delay=".2s">
                    <div class="spd-tab-nav">
                        <button v-for="tab in tabs" :key="tab.key"
                                class="spd-tab-btn"
                                :class="{ active: activeTab === tab.key }"
                                @click="activeTab = tab.key">
                            {{ tab.label }}
                        </button>
                    </div>

                    <!-- Description -->
                    <div v-show="activeTab === 'description'" class="spd-tab-content">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7">
                                <h4>À propos de ce produit</h4>
                                <p>{{ product.description }}</p>
                                <p class="mt-3">Cultivé dans la région des Plateaux au TOGO, ce riz est le fruit d'un partenariat durable entre la COOP CA HEZOUWE et ses 30 producteurs membres de Tagbega. Chaque étape — semis, récolte, transformation, conditionnement — est contrôlée pour vous garantir la meilleure qualité.</p>
                            </div>
                            <div class="col-lg-5">
                                <img :src="product.images[1] || product.image" :alt="product.title" class="spd-tab-img">
                            </div>
                        </div>
                    </div>

                    <!-- Caractéristiques -->
                    <div v-show="activeTab === 'details'" class="spd-tab-content">
                        <h4>Fiche Technique</h4>
                        <div class="spd-details-table">
                            <div v-for="d in product.details" :key="d.label" class="spd-detail-row">
                                <span class="spd-detail-label">{{ d.label }}</span>
                                <span class="spd-detail-val">{{ d.value }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Avis -->
                    <div v-show="activeTab === 'reviews'" class="spd-tab-content">
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="spd-review-score">
                                    <div class="spd-score-big">{{ product.stars }}.0</div>
                                    <div class="spd-score-stars">
                                        <i v-for="s in product.stars" :key="s" class="fas fa-star"></i>
                                    </div>
                                    <p>Basé sur {{ product.reviews }} avis</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="spd-reviews-list">
                                    <div v-for="review in sampleReviews" :key="review.name" class="spd-review-item">
                                        <div class="spd-rev-header">
                                            <div class="spd-rev-avatar">{{ review.name[0] }}</div>
                                            <div>
                                                <strong>{{ review.name }}</strong>
                                                <div class="spd-rev-stars">
                                                    <i v-for="s in review.stars" :key="s" class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <span class="spd-rev-date">{{ review.date }}</span>
                                        </div>
                                        <p class="spd-rev-text">{{ review.text }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related products -->
                <div v-if="related.length" class="spd-related wow fadeInUp" data-wow-delay=".3s">
                    <div class="spd-related-header">
                        <h3>Produits Similaires</h3>
                        <Link href="/shop" class="spd-see-all">Voir tous <i class="far fa-arrow-right"></i></Link>
                    </div>
                    <div class="row g-4">
                        <div v-for="(p, i) in related" :key="p.slug" class="col-lg-3 col-md-6">
                            <div class="spd-rel-card">
                                <div class="spd-rel-img">
                                    <img :src="p.image" :alt="p.title">
                                    <span v-if="p.badge" class="spd-rel-badge">{{ p.badge }}</span>
                                </div>
                                <div class="spd-rel-body">
                                    <div class="spd-rel-cat">{{ p.category }}</div>
                                    <h6><Link :href="`/shop-details/${p.slug}`">{{ p.title }}</Link></h6>
                                    <div class="spd-rel-stars">
                                        <i v-for="s in p.stars" :key="s" class="fas fa-star"></i>
                                    </div>
                                    <div class="spd-rel-price">{{ formatPrice(p.price) }} FCFA</div>
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
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    product: Object,
    allProducts: Array,
    related: Array,
});

const activeImage = ref(props.product.images?.[0] || props.product.image);
const qty = ref(1);
const activeTab = ref('description');

const tabs = [
    { key: 'description', label: 'Description' },
    { key: 'details', label: 'Caractéristiques' },
    { key: 'reviews', label: `Avis (${props.product.reviews})` },
];

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const addToCart = () => {
    router.post(route('cart.store'), {
        product_slug: props.product.slug,
        quantity: qty.value,
        redirect_to: '/shop-cart',
    });
};

const buyNow = () => {
    router.post(route('cart.store'), {
        product_slug: props.product.slug,
        quantity: qty.value,
        redirect_to: '/checkout',
    });
};

const sampleReviews = [
    { name: 'Ama Koffi', stars: 5, date: 'Avril 2025', text: 'Riz d\'une qualité exceptionnelle. Grains entiers, très bon goût. Je recommande vivement !' },
    { name: 'Kossi Agbéko', stars: 5, date: 'Mars 2025', text: 'Livraison rapide, emballage soigné. Le riz est exactement comme décrit. Ma famille est ravie.' },
    { name: 'Adjoua M.', stars: 4, date: 'Février 2025', text: 'Très bon produit local. Content de soutenir les producteurs de Tagbega. Continuez comme ça !' },
];
</script>

<style scoped>
.spd-section { padding: 90px 0; }

/* Gallery */
.spd-gallery { display: flex; flex-direction: column; gap: 16px; }
.spd-main-img { position: relative; border-radius: 16px; overflow: hidden; height: 420px; box-shadow: 0 8px 30px rgba(0,0,0,.1); }
.spd-main-img img { width: 100%; height: 100%; object-fit: cover; }
.spd-badge { position: absolute; top: 16px; left: 16px; background: #5cb85c; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: .75rem; font-weight: 700; }
.spd-discount { position: absolute; top: 16px; right: 16px; background: #ff5722; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: .75rem; font-weight: 700; }
.spd-thumbs { display: flex; gap: 12px; }
.spd-thumb { width: 80px; height: 80px; border-radius: 10px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: border-color .25s; flex-shrink: 0; }
.spd-thumb.active { border-color: #5cb85c; }
.spd-thumb img { width: 100%; height: 100%; object-fit: cover; }

/* Info */
.spd-info { display: flex; flex-direction: column; gap: 18px; }
.spd-cat { font-size: .75rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
.spd-title { font-size: 1.9rem; font-weight: 800; color: #1a3a1a; margin: 0; line-height: 1.2; }
.spd-stars { color: #ffc107; font-size: .9rem; }
.spd-stars span { color: #999; font-size: .85rem; margin-left: 6px; }
.spd-prices { display: flex; align-items: baseline; gap: 14px; flex-wrap: wrap; }
.spd-price { font-size: 1.8rem; font-weight: 800; color: #2d7a2d; }
.spd-price-old { font-size: 1rem; color: #aaa; }
.spd-saving { font-size: .8rem; background: #fff3e0; color: #ff6f00; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
.spd-short { color: #555; font-size: .95rem; line-height: 1.7; margin: 0; }
.spd-stock { font-size: .85rem; font-weight: 600; display: flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; }
.spd-stock.in { color: #2d7a2d; background: #e8f5e9; }
.spd-stock.out { color: #c62828; background: #ffebee; }

.spd-features { display: flex; flex-wrap: wrap; gap: 8px; }
.spd-feat { padding: 4px 14px; background: #e8f5e9; color: #2d7a2d; border-radius: 20px; font-size: .8rem; font-weight: 600; }

.spd-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.spd-qty { display: flex; align-items: center; gap: 0; border: 2px solid #e0e0e0; border-radius: 10px; overflow: hidden; }
.spd-qty-btn { width: 40px; height: 44px; background: #f5f5f5; border: none; font-size: 1.2rem; cursor: pointer; transition: background .25s; }
.spd-qty-btn:hover { background: #5cb85c; color: #fff; }
.spd-qty-val { padding: 0 18px; font-weight: 700; font-size: 1rem; color: #1a3a1a; }
.spd-btn-cart { display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; background: #1a3a1a; color: #fff; border: none; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; cursor: pointer; transition: background .3s; }
.spd-btn-cart:hover { background: #5cb85c; color: #fff; }
.spd-btn-buy { display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; background: #5cb85c; color: #fff; border: none; border-radius: 10px; text-decoration: none; font-size: .9rem; font-weight: 600; cursor: pointer; transition: background .3s; }
.spd-btn-buy:hover { background: #2d7a2d; color: #fff; }

.spd-trust { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; padding: 16px; background: #f8fdf8; border-radius: 12px; border: 1px solid #e8f0e8; }
.spd-trust-item { display: flex; flex-direction: column; align-items: center; gap: 6px; text-align: center; }
.spd-trust-item i { font-size: 1.4rem; color: #5cb85c; }
.spd-trust-item span { font-size: .7rem; color: #555; font-weight: 600; }

/* Tabs */
.spd-tabs { margin-top: 70px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.07); }
.spd-tab-nav { display: flex; background: #1a3a1a; }
.spd-tab-btn { flex: 1; padding: 16px; background: none; border: none; color: #aaa; font-size: .95rem; font-weight: 600; cursor: pointer; transition: all .3s; border-bottom: 3px solid transparent; }
.spd-tab-btn:hover { color: #fff; }
.spd-tab-btn.active { color: #fff; border-bottom-color: #5cb85c; }
.spd-tab-content { padding: 40px; background: #fff; }
.spd-tab-content h4 { font-size: 1.2rem; color: #1a3a1a; margin-bottom: 16px; }
.spd-tab-content p { color: #555; line-height: 1.8; font-size: .95rem; }
.spd-tab-img { width: 100%; border-radius: 12px; object-fit: cover; height: 260px; }

.spd-details-table { display: flex; flex-direction: column; }
.spd-detail-row { display: flex; align-items: center; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
.spd-detail-row:last-child { border-bottom: none; }
.spd-detail-label { width: 220px; font-weight: 700; color: #1a3a1a; font-size: .9rem; flex-shrink: 0; }
.spd-detail-val { color: #555; font-size: .9rem; }

/* Reviews */
.spd-review-score { text-align: center; padding: 30px; background: #f8fdf8; border-radius: 12px; border: 1px solid #e0f0e0; }
.spd-score-big { font-size: 4rem; font-weight: 900; color: #2d7a2d; line-height: 1; }
.spd-score-stars { color: #ffc107; font-size: 1.2rem; margin: 8px 0; }
.spd-review-score p { color: #777; font-size: .85rem; margin: 0; }
.spd-reviews-list { display: flex; flex-direction: column; gap: 20px; }
.spd-review-item { padding: 20px; background: #fafafa; border-radius: 12px; border: 1px solid #f0f0f0; }
.spd-rev-header { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
.spd-rev-avatar { width: 40px; height: 40px; border-radius: 50%; background: #5cb85c; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
.spd-rev-stars { color: #ffc107; font-size: .75rem; }
.spd-rev-date { margin-left: auto; font-size: .78rem; color: #aaa; }
.spd-rev-text { color: #555; font-size: .9rem; line-height: 1.7; margin: 0; }

/* Related */
.spd-related { margin-top: 70px; }
.spd-related-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.spd-related-header h3 { font-size: 1.5rem; font-weight: 800; color: #1a3a1a; margin: 0; }
.spd-see-all { color: #5cb85c; text-decoration: none; font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: 6px; }
.spd-see-all:hover { color: #2d7a2d; }

.spd-rel-card { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s; background: #fff; }
.spd-rel-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,.13); }
.spd-rel-img { position: relative; height: 180px; overflow: hidden; }
.spd-rel-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.spd-rel-card:hover .spd-rel-img img { transform: scale(1.06); }
.spd-rel-badge { position: absolute; top: 10px; left: 10px; background: #5cb85c; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; }
.spd-rel-body { padding: 14px; }
.spd-rel-cat { font-size: .7rem; color: #5cb85c; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
.spd-rel-body h6 { font-size: .9rem; font-weight: 700; color: #1a3a1a; margin: 0 0 6px; line-height: 1.3; }
.spd-rel-body h6 a { color: inherit; text-decoration: none; }
.spd-rel-body h6 a:hover { color: #5cb85c; }
.spd-rel-stars { color: #ffc107; font-size: .7rem; margin-bottom: 6px; }
.spd-rel-price { font-size: 1rem; font-weight: 800; color: #2d7a2d; }
</style>
