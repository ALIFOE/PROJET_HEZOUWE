<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;
const initials = (user?.name || 'U').split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
</script>

<template>
    <Head title="Mon profil" />

    <AuthenticatedLayout>
        <!-- Banner -->
        <div class="profile-banner">
            <div class="banner-inner">
                <div class="avatar">{{ initials }}</div>
                <div class="banner-info">
                    <p class="banner-eyebrow">Mon compte</p>
                    <h1>{{ user?.name }}</h1>
                    <p class="banner-email">{{ user?.email }}</p>
                </div>
            </div>
        </div>

        <div class="profile-page">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
            <UpdatePasswordForm />
            <DeleteUserForm />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.profile-banner {
    background: linear-gradient(135deg, #1a3a1a 0%, #24562a 100%);
    padding: 48px 0 36px;
}

.banner-inner {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 28px;
}

.avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #d5a741;
    color: #1a3a1a;
    font-size: 1.8rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 3px solid rgba(255,255,255,0.2);
}

.banner-eyebrow {
    margin: 0 0 4px;
    color: #d5a741;
    font-size: 0.75rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.banner-info h1 {
    margin: 0 0 4px;
    color: #fff;
    font-size: 1.8rem;
    font-weight: 900;
}

.banner-email {
    margin: 0;
    color: rgba(255,255,255,0.6);
    font-size: 0.95rem;
}

.profile-page {
    max-width: 860px;
    margin: 0 auto;
    padding: 36px 24px 64px;
    display: flex;
    flex-direction: column;
    gap: 28px;
}

@media (max-width: 640px) {
    .banner-inner {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }

    .banner-info h1 {
        font-size: 1.4rem;
    }

    .profile-page {
        padding: 24px 16px 48px;
    }
}
</style>
