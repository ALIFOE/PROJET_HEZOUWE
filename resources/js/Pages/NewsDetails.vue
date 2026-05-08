<template>
    <AppLayout :title="article.title">
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
                        <li><Link href="/news">Actualités</Link></li>
                        <li>//</li>
                        <li>{{ article.category }}</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Détail Actualité</h1>
                </div>
            </div>
        </section>

        <!-- Article Section -->
        <section class="blog-wrapper section-padding">
            <div class="container">
                <div class="row">

                    <!-- ===== Contenu Article ===== -->
                    <div class="col-12 col-lg-8">
                        <div class="blog-posts">
                            <div class="single-blog-post details-post">

                                <!-- Image héro -->
                                <div class="nd-hero-image wow fadeInUp">
                                    <img :src="article.image" :alt="article.title" class="w-100">
                                    <div class="nd-hero-category">{{ article.category }}</div>
                                </div>

                                <div class="post-content">
                                    <!-- Meta -->
                                    <div class="post-meta wow fadeInUp" data-wow-delay=".2s">
                                        <span><i class="far fa-user"></i>{{ article.author }}</span>
                                        <span><i class="fal fa-comments"></i>{{ article.comments }} Commentaire{{ article.comments > 1 ? 's' : '' }}</span>
                                        <span><i class="fal fa-clock"></i>{{ article.read }} de lecture</span>
                                        <span><i class="fal fa-calendar-alt"></i>{{ article.date }}</span>
                                    </div>

                                    <!-- Titre -->
                                    <h2 class="nd-article-title wow fadeInUp" data-wow-delay=".3s">
                                        {{ article.title }}
                                    </h2>

                                    <!-- Tags -->
                                    <div class="nd-tags-row mb-4 wow fadeInUp" data-wow-delay=".35s">
                                        <span v-for="tag in article.tag" :key="tag" class="nd-tag">{{ tag }}</span>
                                    </div>

                                    <!-- Intro -->
                                    <p class="nd-intro wow fadeInUp" data-wow-delay=".4s">{{ article.intro }}</p>

                                    <!-- Corps paragraphe 1 -->
                                    <p class="wow fadeInUp" data-wow-delay=".45s">{{ article.body[0] }}</p>

                                    <!-- Images secondaires -->
                                    <div class="row g-4 my-4 wow fadeInUp" data-wow-delay=".5s">
                                        <div class="col-md-6">
                                            <div class="nd-sub-image">
                                                <img :src="article.image2" :alt="article.title" class="w-100">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="nd-sub-image">
                                                <img :src="article.image3" :alt="article.title" class="w-100">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Corps paragraphes 2 et 3 -->
                                    <p class="wow fadeInUp" data-wow-delay=".55s">{{ article.body[1] }}</p>

                                    <!-- Citation -->
                                    <blockquote class="nd-blockquote wow fadeInUp" data-wow-delay=".6s">
                                        <i class="fas fa-quote-left nd-quote-icon"></i>
                                        <p>{{ article.quote }}</p>
                                    </blockquote>

                                    <p class="wow fadeInUp" data-wow-delay=".65s">{{ article.body[2] }}</p>

                                    <!-- Conclusion -->
                                    <div class="nd-conclusion wow fadeInUp" data-wow-delay=".7s">
                                        <i class="far fa-check-circle nd-conclusion-icon"></i>
                                        <p>{{ article.conclusion }}</p>
                                    </div>

                                    <!-- Tags + Partage -->
                                    <div class="nd-footer-row wow fadeInUp" data-wow-delay=".75s">
                                        <div class="nd-tags-footer">
                                            <strong>Tags :</strong>
                                            <span v-for="tag in article.tag" :key="tag" class="nd-tag">{{ tag }}</span>
                                        </div>
                                        <div class="nd-share">
                                            <strong>Partager :</strong>
                                            <a href="#" class="nd-share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#" class="nd-share-btn twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="#" class="nd-share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                                        </div>
                                    </div>

                                    <!-- Navigation article précédent / suivant -->
                                    <div class="nd-nav-articles wow fadeInUp" data-wow-delay=".8s">
                                        <Link
                                            v-if="prevArticle"
                                            :href="'/news-details/' + prevArticle.slug"
                                            class="nd-nav-btn nd-nav-prev"
                                        >
                                            <i class="far fa-arrow-left"></i>
                                            <div>
                                                <small>Article précédent</small>
                                                <p>{{ prevArticle.title }}</p>
                                            </div>
                                        </Link>
                                        <div v-else></div>
                                        <Link
                                            v-if="nextArticle"
                                            :href="'/news-details/' + nextArticle.slug"
                                            class="nd-nav-btn nd-nav-next"
                                        >
                                            <div>
                                                <small>Article suivant</small>
                                                <p>{{ nextArticle.title }}</p>
                                            </div>
                                            <i class="far fa-arrow-right"></i>
                                        </Link>
                                        <div v-else></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== Sidebar ===== -->
                    <div class="col-12 col-lg-4 wow fadeInUp">
                        <div class="main-sidebar sticky-style">

                            <!-- Recherche -->
                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3>Rechercher</h3>
                                </div>
                                <div class="search_widget">
                                    <form @submit.prevent>
                                        <input type="text" placeholder="Rechercher un article...">
                                        <button type="submit"><i class="fal fa-search"></i></button>
                                    </form>
                                </div>
                            </div>

                            <!-- Articles récents -->
                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3>Articles Récents</h3>
                                </div>
                                <div class="popular-posts">
                                    <div
                                        v-for="(a, i) in recent"
                                        :key="a.slug"
                                        class="single-post-item"
                                    >
                                        <div class="thumb bg-cover" :style="`background-image: url('${a.thumb}');`"></div>
                                        <div class="post-content">
                                            <h5>
                                                <Link :href="'/news-details/' + a.slug">{{ a.title }}</Link>
                                            </h5>
                                            <div class="post-date">
                                                <i class="far fa-calendar"></i>{{ a.date }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catégories -->
                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3>Catégories</h3>
                                </div>
                                <div class="widget_categories">
                                    <ul>
                                        <li v-for="cat in categories" :key="cat.name">
                                            <Link href="/news">{{ cat.name }} <span>{{ cat.count.toString().padStart(2,'0') }}</span></Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3>Tags</h3>
                                </div>
                                <div class="tagcloud">
                                    <Link v-for="tag in allTags" :key="tag" href="/news">{{ tag }}</Link>
                                </div>
                            </div>

                            <!-- CTA sidebar -->
                            <div class="single-sidebar-widget">
                                <div class="nd-cta-widget">
                                    <div class="nd-cta-overlay">
                                        <i class="flaticon-leaf nd-cta-icon"></i>
                                        <h5>Riz HEZOUWE</h5>
                                        <p>Découvrez notre gamme de riz local certifié ITRA, disponible en plusieurs formats.</p>
                                        <Link href="/shop" class="theme-btn w-100 text-center d-block">
                                            Voir nos Produits <i class="far fa-arrow-right"></i>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Articles liés -->
        <section class="section-padding pt-0 fix">
            <div class="container">
                <div class="section-title text-center mb-4 wow fadeInUp">
                    <span><img src="/assets/img/sub-title.svg" alt="img">Lire aussi</span>
                    <h2 class="text-anim">Articles Similaires</h2>
                </div>
                <div class="row g-4">
                    <div
                        v-for="(a, i) in recent"
                        :key="a.slug"
                        class="col-lg-4 col-md-6 wow fadeInUp"
                        :data-wow-delay="(i * 0.2 + 0.2) + 's'"
                    >
                        <div class="nd-related-card">
                            <div class="nd-related-img">
                                <img :src="a.image" :alt="a.title">
                                <div class="nd-related-cat">{{ a.category }}</div>
                                <div class="nd-related-overlay">
                                    <Link :href="'/news-details/' + a.slug" class="nd-related-btn">
                                        <i class="far fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                            <div class="nd-related-content">
                                <div class="nd-related-meta">
                                    <span><i class="fal fa-calendar-alt"></i>{{ a.date }}</span>
                                    <span><i class="fal fa-clock"></i>{{ a.read }}</span>
                                </div>
                                <h5>
                                    <Link :href="'/news-details/' + a.slug">{{ a.title }}</Link>
                                </h5>
                                <p>{{ a.excerpt.slice(0, 100) }}…</p>
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
    article: { type: Object, required: true },
    allNews: { type: Array,  required: true },
    recent:  { type: Array,  required: true },
});

const currentIndex = computed(() =>
    props.allNews.findIndex(a => a.slug === props.article.slug)
);
const prevArticle = computed(() =>
    currentIndex.value > 0 ? props.allNews[currentIndex.value - 1] : null
);
const nextArticle = computed(() =>
    currentIndex.value < props.allNews.length - 1 ? props.allNews[currentIndex.value + 1] : null
);

const categories = computed(() => {
    const map = {};
    props.allNews.forEach(a => { map[a.category] = (map[a.category] || 0) + 1; });
    return Object.entries(map).map(([name, count]) => ({ name, count }));
});

const allTags = computed(() => {
    const set = new Set();
    props.allNews.forEach(a => a.tag.forEach(t => set.add(t)));
    return [...set].slice(0, 10);
});
</script>

<style scoped>
/* ── Hero image ── */
.nd-hero-image { position: relative; overflow: hidden; border-radius: 12px; margin-bottom: 30px; }
.nd-hero-image img { max-height: 480px; object-fit: cover; }
.nd-hero-category {
    position: absolute; top: 20px; left: 20px;
    background: var(--theme-color, #5cb85c); color: #fff;
    font-size: .75rem; font-weight: 700; padding: 5px 16px;
    border-radius: 20px; text-transform: uppercase;
}

/* ── Article titre ── */
.nd-article-title { font-size: 1.75rem; line-height: 1.35; margin-bottom: 16px; }

/* ── Tags ── */
.nd-tags-row, .nd-tags-footer { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.nd-tag {
    font-size: .75rem; color: var(--theme-color, #5cb85c);
    border: 1px solid var(--theme-color, #5cb85c);
    padding: 3px 12px; border-radius: 20px;
}
.nd-tags-footer strong { margin-right: 4px; font-size: .875rem; color: #444; }

/* ── Intro ── */
.nd-intro { font-size: 1.05rem; line-height: 1.8; color: #333; font-weight: 500; margin-bottom: 20px; }

/* ── Sub images ── */
.nd-sub-image { border-radius: 10px; overflow: hidden; }
.nd-sub-image img { height: 220px; object-fit: cover; }

/* ── Blockquote ── */
.nd-blockquote {
    position: relative;
    border-left: 4px solid var(--theme-color, #5cb85c);
    background: linear-gradient(135deg, #f0faf0 0%, #e8f5e8 100%);
    padding: 28px 28px 28px 56px;
    border-radius: 0 12px 12px 0;
    margin: 28px 0;
}
.nd-blockquote p { font-size: 1.05rem; font-style: italic; color: #333; margin: 0; line-height: 1.7; }
.nd-quote-icon {
    position: absolute; top: 24px; left: 18px;
    font-size: 1.5rem; color: var(--theme-color, #5cb85c);
}

/* ── Conclusion ── */
.nd-conclusion {
    display: flex; gap: 16px; align-items: flex-start;
    background: #fff; border: 1px solid #c8e6c8;
    border-radius: 10px; padding: 20px; margin: 24px 0;
}
.nd-conclusion-icon { color: var(--theme-color, #5cb85c); font-size: 1.3rem; flex-shrink: 0; margin-top: 2px; }
.nd-conclusion p { margin: 0; color: #444; line-height: 1.7; }

/* ── Footer row (tags + share) ── */
.nd-footer-row {
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 16px;
    border-top: 1px solid #e0e0e0; padding-top: 20px; margin-top: 20px;
}
.nd-share { display: flex; align-items: center; gap: 10px; }
.nd-share strong { font-size: .875rem; color: #444; }
.nd-share-btn {
    width: 34px; height: 34px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-size: .85rem; text-decoration: none;
    transition: transform .2s, opacity .2s;
}
.nd-share-btn:hover { transform: scale(1.1); opacity: .9; color: #fff; }
.nd-share-btn.facebook  { background: #1877f2; }
.nd-share-btn.twitter   { background: #1da1f2; }
.nd-share-btn.whatsapp  { background: #25d366; }

/* ── Navigation articles ── */
.nd-nav-articles {
    display: flex; justify-content: space-between; gap: 16px;
    border-top: 1px solid #e0e0e0; padding-top: 24px; margin-top: 24px;
}
.nd-nav-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px; border-radius: 10px;
    border: 1px solid #e8f5e8; background: #f9fdf9;
    text-decoration: none; color: #333; max-width: 48%;
    transition: background .25s, border-color .25s;
}
.nd-nav-btn:hover { background: #e8f5e8; border-color: var(--theme-color, #5cb85c); color: #333; }
.nd-nav-btn small { display: block; font-size: .75rem; color: var(--theme-color, #5cb85c); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
.nd-nav-btn p { margin: 0; font-size: .85rem; font-weight: 600; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.nd-nav-btn i { font-size: 1rem; color: var(--theme-color, #5cb85c); flex-shrink: 0; }
.nd-nav-next { flex-direction: row-reverse; text-align: right; }

/* ── CTA sidebar ── */
.nd-cta-widget {
    border-radius: 12px; overflow: hidden;
    background: linear-gradient(135deg, #1a4a1a 0%, #2d7a2d 100%);
}
.nd-cta-overlay {
    padding: 32px 24px; text-align: center;
}
.nd-cta-icon { font-size: 2.5rem; color: rgba(255,255,255,.6); margin-bottom: 14px; display: block; }
.nd-cta-overlay h5 { color: #fff; font-size: 1.1rem; margin-bottom: 10px; }
.nd-cta-overlay p  { color: rgba(255,255,255,.8); font-size: .875rem; margin-bottom: 20px; line-height: 1.6; }

/* ── Related cards ── */
.nd-related-card {
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.08); background: #fff;
    transition: transform .3s, box-shadow .3s;
}
.nd-related-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,.13); }
.nd-related-img { position: relative; height: 200px; overflow: hidden; }
.nd-related-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.nd-related-card:hover .nd-related-img img { transform: scale(1.07); }
.nd-related-cat {
    position: absolute; top: 12px; left: 12px;
    background: var(--theme-color, #5cb85c); color: #fff;
    font-size: .7rem; font-weight: 700; padding: 3px 12px;
    border-radius: 20px; text-transform: uppercase;
}
.nd-related-overlay {
    position: absolute; inset: 0;
    background: rgba(0, 60, 0, .45);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .3s;
}
.nd-related-card:hover .nd-related-overlay { opacity: 1; }
.nd-related-btn {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--theme-color, #5cb85c);
    display: flex; align-items: center; justify-content: center;
    color: #fff; text-decoration: none; font-size: .9rem;
}
.nd-related-content { padding: 20px; }
.nd-related-meta { display: flex; gap: 14px; margin-bottom: 10px; }
.nd-related-meta span { font-size: .78rem; color: #888; }
.nd-related-meta i { margin-right: 4px; color: var(--theme-color, #5cb85c); }
.nd-related-content h5 { font-size: .95rem; font-weight: 700; margin-bottom: 8px; }
.nd-related-content h5 a { color: inherit; text-decoration: none; transition: color .2s; }
.nd-related-content h5 a:hover { color: var(--theme-color, #5cb85c); }
.nd-related-content p { font-size: .83rem; color: #666; margin: 0; line-height: 1.6; }
</style>
