<template>
    <AppLayout
        title="Contact"
        description="Contactez COOP CA HEZOUWE : adresse, téléphone et email de la coopérative de riz local à Tagbega, Wahala, Région Plateaux, Togo. Une question ? Écrivez-nous."
    >
        <!-- Breadcrumb Section Start -->
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
                        <li>Nous Contacter</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Nous Contacter</h1>
                </div>
            </div>
        </section>

        <!-- Contact Section Start -->
        <section class="contact-info-section section-padding fix">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="contact-info-box">
                            <div class="shape-1">
                                <img src="/assets/img/inner-page/contact-shape.png" alt="img">
                            </div>
                            <div class="contact-top">
                                <div class="icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h3>Email 24/7</h3>
                            </div>
                            <p>
                                <a href="mailto:contact@hezouwe.com">contact@hezouwe.com</a>
                            </p>
                            <p>
                                <a href="mailto:info@hezouwe.tg">info@hezouwe.tg</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="contact-info-box">
                            <div class="shape-1">
                                <img src="/assets/img/inner-page/contact-shape.png" alt="img">
                            </div>
                            <div class="contact-top">
                                <div class="icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h3>Appelez-nous Anytime</h3>
                            </div>
                            <p>
                                <a href="tel:+22870679448">Téléphone: +228 70 67 94 48</a>
                            </p>
                            <p>
                                <a href="tel:+22890452773">Mobile: +228 90 45 27 73</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                        <div class="contact-info-box">
                            <div class="shape-1">
                                <img src="/assets/img/inner-page/contact-shape.png" alt="img">
                            </div>
                            <div class="contact-top">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h3>Notre Localisation</h3>
                            </div>
                            <p>
                                Tagbega, Wahala <br> Région Plateaux, TOGO
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section Start --> 
        <section class="contact-section section-bg fix">
            <div class="shape-1 float-bob-x">
                <img src="/assets/img/home-1/contact-shape.png" alt="img">
            </div>
            <div class="container">
                <div class="contact-wrapper">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-6">
                            <div class="contact-content">
                                <div class="section-title mb-0">
                                    <span class="wow fadeInUp"><img src="/assets/img/sub-title.svg" alt="img">Nous Contacter</span>
                                    <h2>Envoyez-nous un Message<br> Pour Vos Questions sur le Riz</h2>
                                </div>
                                <form class="contact-form-box" @submit.prevent="sendMessage">
                                    <div class="row g-4 align-items-center justify-content-center">
                                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                            <div class="form-clt">
                                                <input v-model="form.name" type="text" name="name" id="name" placeholder="Votre Nom Complet" required :disabled="status === 'loading'">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                                            <div class="form-clt">
                                                <input v-model="form.email" type="email" name="email" id="email2" placeholder="Votre Email" required :disabled="status === 'loading'">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                                            <div class="form-clt">
                                                <input v-model="form.phone" type="tel" name="phone" id="phone" placeholder="Votre Téléphone" :disabled="status === 'loading'">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                            <div class="form-clt">
                                                <input v-model="form.subject" type="text" name="subject" id="subject" placeholder="Sujet du Message" required :disabled="status === 'loading'">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".8s">
                                            <div class="form-clt">
                                                <select v-model="form.inquiryType" name="inquiry-type" id="inquiry-type" class="nice-select wide" required :disabled="status === 'loading'">
                                                    <option value="">Sélectionner le type de demande</option>
                                                    <option value="product-info">Information Produit</option>
                                                    <option value="bulk-order">Commande Groupée</option>
                                                    <option value="partnership">Partenariat</option>
                                                    <option value="feedback">Feedback/Avis</option>
                                                    <option value="support">Support Client</option>
                                                    <option value="other">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <div class="form-clt">
                                                <textarea v-model="form.message" name="message" id="message" placeholder="Votre Message..." required :disabled="status === 'loading'"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" class="theme-btn" :disabled="status === 'loading'">
                                                <span v-if="status === 'loading'">Envoi…</span>
                                                <span v-else>Envoyer le Message <i class="far fa-arrow-right"></i></span>
                                            </button>
                                            <p v-if="statusMsg" class="contact-feedback" :class="status">{{ statusMsg }}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-image">
                                <img src="/assets/img/riz3.jpeg" alt="Contact HEZOUWE">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Map Section Start -->
        <div class="map-section-contact">
            <div class="google-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.2857344482823!2d1.244156!3d6.120236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x101929a37f00001%3A0x5c5e5e5e5e5e5e5e!2sWahala%2C%20Plateaux%20Region%2C%20Togo!5e0!3m2!1sfr!2stg!4v1615900000000!5m2!1sfr!2stg" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Gallery Section Start -->
        <!-- <div class="gallery-section-4 section-padding fix pt-0 section-bg">
            <div class="swiper gallery-slide">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image1.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image2.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image3.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image4.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/image5.jpg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-image-4">
                            <img src="/assets/img/home-4/gallery/gallery-06.jpg" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';

const form = reactive({
    name: '',
    email: '',
    phone: '',
    subject: '',
    inquiryType: '',
    message: '',
});

const status    = ref(''); // 'loading' | 'success' | 'error'
const statusMsg = ref('');

const sendMessage = async () => {
    if (status.value === 'loading') return;
    status.value = 'loading';
    statusMsg.value = '';

    try {
        const res = await window.axios.post('/contact', {
            name:         form.name,
            email:        form.email,
            phone:        form.phone,
            subject:      form.subject,
            inquiry_type: form.inquiryType,
            message:      form.message,
        });
        status.value = 'success';
        statusMsg.value = res.data.message;
        form.name = '';
        form.email = '';
        form.phone = '';
        form.subject = '';
        form.inquiryType = '';
        form.message = '';
    } catch (err) {
        status.value = 'error';
        statusMsg.value = err?.response?.data?.message || 'Une erreur est survenue. Veuillez réessayer.';
    }
};

onMounted(() => {
    if (typeof Swiper !== 'undefined') {
        // Initialize gallery slider
        new Swiper('.gallery-slide', {
            loop: true,
            slidesPerView: 5,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }
});
</script>

<style scoped>
.contact-feedback {
    margin: 14px 0 0;
    font-size: 0.88rem;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 6px;
}

.contact-feedback.success { background: rgba(45,106,79,0.12); color: #1a3a1a; }
.contact-feedback.error   { background: rgba(180,35,35,0.1); color: #7a1010; }

.contact-form-box input:disabled,
.contact-form-box textarea:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.contact-form-box .theme-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
