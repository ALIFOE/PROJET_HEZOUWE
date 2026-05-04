<template>
    <div class="error-404-section fix section-padding">
        <div class="container">
            <div class="error-404-wrapper text-center">
                <div class="error-image wow fadeInUp" data-wow-delay=".2s">
                    <img src="/assets/img/inner-page/404.png" alt="404">
                </div>
                <h1 class="wow fadeInUp" data-wow-delay=".4s">404</h1>
                <h2 class="wow fadeInUp" data-wow-delay=".6s">Page Non Trouvée</h2>
                <p class="wow fadeInUp" data-wow-delay=".8s">
                    Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                </p>
                <Link href="/" class="theme-btn wow fadeInUp" data-wow-delay="1s">
                    Retour à l'Accueil <i class="far fa-arrow-right"></i>
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
