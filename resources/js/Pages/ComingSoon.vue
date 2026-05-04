<template>
    <AppLayout title="Bientôt Disponible">
        <!-- Coming Soon Section Start -->
        <section class="coming-soon-section fix section-padding">
            <div class="container">
                <div class="coming-soon-wrapper">
                    <div class="coming-soon-content text-center">
                        <h1 class="wow fadeInUp" data-wow-delay=".2s">Bientôt Disponible</h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Nous travaillons sur quelque chose d'extraordinaire. Restez à l'écoute pour les dernières nouvelles de COOP CA HEZOUWE.
                        </p>
                        <div class="countdown-timer wow fadeInUp" data-wow-delay=".6s">
                            <div class="timer-item">
                                <span class="days">00</span>
                                <p>Jours</p>
                            </div>
                            <div class="timer-item">
                                <span class="hours">00</span>
                                <p>Heures</p>
                            </div>
                            <div class="timer-item">
                                <span class="minutes">00</span>
                                <p>Minutes</p>
                            </div>
                            <div class="timer-item">
                                <span class="seconds">00</span>
                                <p>Secondes</p>
                            </div>
                        </div>
                        <div class="newsletter-form wow fadeInUp" data-wow-delay=".8s">
                            <form action="#">
                                <input type="email" placeholder="Entrez votre email">
                                <button type="submit" class="theme-btn">S'inscrire <i class="far fa-arrow-right"></i></button>
                            </form>
                        </div>
                        <div class="social-links wow fadeInUp" data-wow-delay="1s">
                            <Link href="/"><i class="fab fa-facebook-f"></i></Link>
                            <Link href="/"><i class="fab fa-twitter"></i></Link>
                            <Link href="/"><i class="fab fa-instagram"></i></Link>
                            <Link href="/"><i class="fab fa-linkedin-in"></i></Link>
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
import { onMounted } from 'vue';

onMounted(() => {
    // Initialize countdown timer
    const countdownDate = new Date().getTime() + (30 * 24 * 60 * 60 * 1000); // 30 days from now
    
    const timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = countdownDate - now;
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const daysEl = document.querySelector('.days');
        const hoursEl = document.querySelector('.hours');
        const minutesEl = document.querySelector('.minutes');
        const secondsEl = document.querySelector('.seconds');
        
        if (daysEl) daysEl.textContent = days < 10 ? '0' + days : days;
        if (hoursEl) hoursEl.textContent = hours < 10 ? '0' + hours : hours;
        if (minutesEl) minutesEl.textContent = minutes < 10 ? '0' + minutes : minutes;
        if (secondsEl) secondsEl.textContent = seconds < 10 ? '0' + seconds : seconds;
        
        if (distance < 0) {
            clearInterval(timer);
        }
    }, 1000);
});
</script>
