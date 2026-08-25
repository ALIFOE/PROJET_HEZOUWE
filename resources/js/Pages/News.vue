<template>
    <AppLayout
        title="Actualités"
        description="Suivez les actualités de COOP CA HEZOUWE : événements, avancées de la coopérative et actualités de la filière riz local au Togo."
    >
        <!-- Breadcrumb -->
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/inner-page/shape-1.png" alt="img">
            </div>
            <div class="shape-2 float-bob-x">
                <img src="/assets/img/inner-page/shape-2.png" alt="img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li>Actualités & Blog</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nos Actualités</h1>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="blog-wrapper section-padding">
            <div class="container">
                <div class="news-area">
                    <div class="row">

                        <!-- ===== Articles principaux ===== -->
                        <div class="col-12 col-lg-8">
                            <div class="blog-posts">

                                <div v-if="!allNews.length" class="no-news-message">
                                    <i class="fal fa-newspaper"></i>
                                    <h3>Aucun article pour le moment</h3>
                                    <p>Revenez bientôt pour découvrir nos prochaines actualités.</p>
                                </div>

                                <div
                                    v-for="(article, i) in allNews"
                                    :key="article.slug"
                                    class="single-blog-post"
                                >
                                    <div
                                        class="post-featured-thumb bg-cover wow fadeInUp"
                                        data-wow-delay=".3s"
                                        :style="`background-image: url('${article.image}');`"
                                    >
                                        <div class="nd-category-badge">{{ article.category }}</div>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta wow fadeInUp" data-wow-delay=".2s">
                                            <span><i class="far fa-user"></i>{{ article.author }}</span>
                                            <span><i class="fal fa-comments"></i>{{ article.comments }} Commentaire{{ article.comments > 1 ? 's' : '' }}</span>
                                            <span><i class="fal fa-clock"></i>{{ article.read }} de lecture</span>
                                            <span><i class="fal fa-calendar-alt"></i>{{ article.date }}</span>
                                        </div>
                                        <h3 class="wow fadeInUp" data-wow-delay=".4s">
                                            <Link :href="'/news-details/' + article.slug">
                                                {{ article.title }}
                                            </Link>
                                        </h3>
                                        <p class="wow fadeInUp" data-wow-delay=".6s">
                                            {{ article.excerpt }}
                                        </p>
                                        <div class="nd-tags-row wow fadeInUp" data-wow-delay=".7s">
                                            <span v-for="tag in article.tag.slice(0,3)" :key="tag" class="nd-tag">{{ tag }}</span>
                                        </div>
                                        <Link
                                            :href="'/news-details/' + article.slug"
                                            class="theme-btn mt-4 wow fadeInUp"
                                            data-wow-delay=".8s"
                                        >
                                            Lire la Suite <i class="far fa-arrow-right"></i>
                                        </Link>
                                    </div>
                                </div>

                                <!-- Citation encadrée -->
                                <div class="single-blog-post quote-post format-quote wow fadeInUp" data-wow-delay=".9s">
                                    <div class="post-content text-white bg-cover">
                                        <div class="quote-content">
                                            <div class="icon">
                                                <i class="fas fa-quote-left"></i>
                                            </div>
                                            <div class="quote-text">
                                                <h2>Le riz local togolais est un trésor que HEZOUWE s'engage à valoriser chaque jour pour les familles du TOGO et d'Afrique de l'Ouest.</h2>
                                                <div class="post-meta">
                                                    <span><i class="fal fa-comments"></i>{{ totalComments }} Commentaires</span>
                                                    <span><i class="fal fa-calendar-alt"></i>2026</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="page-nav-wrap text-center">
                                <ul>
                                    <li class="active"><a class="page-numbers" href="javascript:void(0)"><i class="fal fa-long-arrow-left"></i></a></li>
                                    <li class="active"><a class="page-numbers" href="javascript:void(0)">01</a></li>
                                    <li><a class="page-numbers" href="javascript:void(0)">02</a></li>
                                    <li><a class="page-numbers" href="javascript:void(0)"><i class="fal fa-long-arrow-right"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- ===== Sidebar ===== -->
                        <div class="col-12 col-lg-4 wow fadeInUp">
                            <div class="main-sidebar sticky-style">

                                <!-- Recherche -->
                                <div class="single-sidebar-widget">
                                    <div class="wid-title wow fadeInUp" data-wow-delay=".2s">
                                        <h3>Rechercher</h3>
                                    </div>
                                    <div class="search_widget wow fadeInUp">
                                        <form @submit.prevent>
                                            <input type="text" placeholder="Rechercher un article...">
                                            <button type="submit"><i class="fal fa-search"></i></button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Articles récents -->
                                <div class="single-sidebar-widget">
                                    <div class="wid-title wow fadeInUp" data-wow-delay=".4s">
                                        <h3>Articles Récents</h3>
                                    </div>
                                    <div class="popular-posts">
                                        <div
                                            v-for="(article, i) in allNews.slice(0,3)"
                                            :key="article.slug"
                                            class="single-post-item wow fadeInUp"
                                            :data-wow-delay="(i * 0.2 + 0.3) + 's'"
                                        >
                                            <div class="thumb bg-cover" :style="`background-image: url('${article.thumb}');`"></div>
                                            <div class="post-content">
                                                <h5>
                                                    <Link :href="'/news-details/' + article.slug">{{ article.title }}</Link>
                                                </h5>
                                                <div class="post-date">
                                                    <i class="far fa-calendar"></i>{{ article.date }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catégories -->
                                <div class="single-sidebar-widget">
                                    <div class="wid-title wow fadeInUp" data-wow-delay=".2s">
                                        <h3>Catégories</h3>
                                    </div>
                                    <div class="widget_categories wow fadeInUp" data-wow-delay=".4s">
                                        <ul>
                                            <li v-for="cat in categories" :key="cat.name">
                                                <Link href="/news">{{ cat.name }} <span>{{ cat.count.toString().padStart(2, '0') }}</span></Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="single-sidebar-widget wow fadeInUp" data-wow-delay=".6s">
                                    <div class="wid-title">
                                        <h3>Tags</h3>
                                    </div>
                                    <div class="tagcloud">
                                        <Link v-for="tag in allTags" :key="tag" href="/news">{{ tag }}</Link>
                                    </div>
                                </div>

                                <!-- À propos de HEZOUWE -->
                                <div class="single-sidebar-widget wow fadeInUp" data-wow-delay=".8s">
                                    <div class="nd-about-widget">
                                        <img src="/assets/img/logo/logo_hezouwe.jpeg" alt="HEZOUWE">
                                        <h5>COOP CA HEZOUWE</h5>
                                        <p>Coopérative de transformation et commercialisation du riz local togolais de qualité premium, certifiée ITRA depuis 2023.</p>
                                        <Link href="/about" class="link-btn">
                                            En savoir plus <i class="far fa-arrow-right"></i>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-discount-section-4 section-padding pt-0">
            <div class="container">
                <div class="cta-wrapper-4 bg-cover" style="background-image: url('/assets/img/home-4/cta-discount-bg.jpg');">
                    <div class="cta-discount-area">
                        <div class="circle-bg-icon wow fadeInUp">
                            <img src="/assets/img/home-3/cta-discount/white-circle.png" alt="img" class="circle-icon">
                            <div class="icon">
                                <i class="flaticon-leaf"></i>
                            </div>
                        </div>
                        <div class="section-title wow fadeInUp" data-wow-delay=".3s">
                            <span class="text-white"><img src="/assets/img/sub-title.svg" alt="img">Offre Spéciale</span>
                            <h2 class="text-white text-anim">Profitez de Réductions <br> Jusqu'à 30% sur Nos Produits!</h2>
                        </div>
                    </div>
                    <Link href="/shop" class="theme-btn wow fadeInUp" data-wow-delay=".7s">
                        Découvrir Nos Produits <i class="far fa-arrow-right"></i>
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
    allNews: { type: Array, required: true },
});

const totalComments = computed(() =>
    props.allNews.reduce((s, a) => s + a.comments, 0)
);

const categories = computed(() => {
    const map = {};
    props.allNews.forEach(a => {
        map[a.category] = (map[a.category] || 0) + 1;
    });
    return Object.entries(map).map(([name, count]) => ({ name, count }));
});

const allTags = computed(() => {
    const set = new Set();
    props.allNews.forEach(a => a.tag.forEach(t => set.add(t)));
    return [...set].slice(0, 10);
});
</script>

<style scoped>
/* Message quand aucun article visible */
.no-news-message {
    text-align: center;
    padding: 60px 20px;
    background: #f8faf7;
    border: 1px solid #e8eee3;
    border-radius: 12px;
}
.no-news-message i {
    font-size: 2.5rem;
    color: var(--theme-color, #5cb85c);
    margin-bottom: 16px;
    display: block;
}
.no-news-message h3 { font-size: 1.2rem; font-weight: 700; color: #17351a; margin-bottom: 8px; }
.no-news-message p { color: #68746a; margin: 0; }

/* Category badge sur l'image */
.post-featured-thumb { position: relative; }
.nd-category-badge {
    position: absolute; top: 16px; left: 16px;
    background: var(--theme-color, #5cb85c);
    color: #fff; font-size: .75rem; font-weight: 700;
    padding: 4px 14px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: .05em;
}

/* Tags dans la carte article */
.nd-tags-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
.nd-tag {
    font-size: .75rem; color: var(--theme-color, #5cb85c);
    border: 1px solid var(--theme-color, #5cb85c);
    padding: 2px 10px; border-radius: 20px;
}

/* Widget À propos sidebar */
.nd-about-widget {
    padding: 24px;
    background: #f0faf0;
    border-radius: 12px;
    border: 1px solid #c8e6c8;
    text-align: center;
}
.nd-about-widget img {
    width: 80px; height: 80px; border-radius: 50%;
    object-fit: cover; margin: 0 auto 14px; display: block;
    border: 3px solid var(--theme-color, #5cb85c);
}
.nd-about-widget h5 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
.nd-about-widget p  { font-size: .85rem; color: #555; margin-bottom: 14px; line-height: 1.6; }
</style>
