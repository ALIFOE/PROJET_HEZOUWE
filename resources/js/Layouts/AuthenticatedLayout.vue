<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <!-- Back To Top Start -->
        <button id="back-top" class="back-to-top">
            <i class="far fa-arrow-up"></i>
        </button>

        <!-- MouseCursor Start -->
        <div class="mouseCursor cursor-outer"></div>
        <div class="mouseCursor cursor-inner"></div>

        <Header />

        <!-- Page Content -->
        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>
