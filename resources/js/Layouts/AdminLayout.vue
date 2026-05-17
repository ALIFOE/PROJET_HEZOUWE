<template>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>HEZOUWE</h2>
                <span>Admin Panel</span>
            </div>
            <nav class="sidebar-nav">
                <Link href="/admin" class="nav-item" :class="{ active: $page.url === '/admin' }">
                    <i class="far fa-home"></i>
                    <span>Dashboard</span>
                </Link>
                <Link href="/admin/orders" class="nav-item" :class="{ active: $page.url.startsWith('/admin/orders') }">
                    <i class="far fa-receipt"></i>
                    <span>Commandes</span>
                </Link>
                <Link href="/admin/products" class="nav-item" :class="{ active: $page.url.startsWith('/admin/products') }">
                    <i class="far fa-box"></i>
                    <span>Produits</span>
                </Link>
                <Link href="/admin/services" class="nav-item" :class="{ active: $page.url.startsWith('/admin/services') }">
                    <i class="far fa-cog"></i>
                    <span>Services</span>
                </Link>
                <Link href="/admin/news" class="nav-item" :class="{ active: $page.url.startsWith('/admin/news') }">
                    <i class="far fa-newspaper"></i>
                    <span>Actualités</span>
                </Link>

                <div class="nav-separator"></div>

                <Link href="/admin/users" class="nav-item" :class="{ active: $page.url.startsWith('/admin/users') }">
                    <i class="far fa-users"></i>
                    <span>Utilisateurs</span>
                </Link>
            </nav>
            <div class="sidebar-footer">
                <Link href="/dashboard" class="nav-item">
                    <i class="far fa-arrow-left"></i>
                    <span>Retour Site</span>
                </Link>
            </div>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-left">
                    <h1>{{ title }}</h1>
                </div>
                <div class="header-right">
                    <span class="user-info">
                        <i class="far fa-user"></i>
                        {{ $page.props.auth.user?.name || 'Admin' }}
                    </span>
                    <Link href="/logout" method="post" class="logout-btn">
                        <i class="far fa-sign-out"></i>
                        Déconnexion
                    </Link>
                </div>
            </header>

            <div class="admin-content">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const title = computed(() => page.props.title || 'Dashboard');
</script>

<style scoped>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background: #f5f7f2;
}

.admin-sidebar {
    width: 260px;
    background: linear-gradient(180deg, #153717 0%, #1a3a1a 100%);
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    z-index: 1000;
}

.sidebar-header {
    padding: 28px 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-header h2 {
    margin: 0;
    color: #fff;
    font-size: 1.5rem;
    font-weight: 900;
    letter-spacing: 0.5px;
}

.sidebar-header span {
    display: block;
    color: #d5a741;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 4px;
}

.sidebar-nav {
    flex: 1;
    padding: 20px 16px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    font-weight: 600;
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.nav-item.active {
    background: #5cb85c;
    color: #fff;
}

.nav-item i {
    width: 20px;
    text-align: center;
    font-size: 1rem;
}

.nav-separator {
    height: 1px;
    background: rgba(255, 255, 255, 0.08);
    margin: 8px 0;
}

.sidebar-footer {
    padding: 20px 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.admin-main {
    flex: 1;
    margin-left: 260px;
    display: flex;
    flex-direction: column;
}

.admin-header {
    background: #fff;
    padding: 20px 32px;
    border-bottom: 1px solid #e8eee3;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
}

.admin-header h1 {
    margin: 0;
    color: #1a3a1a;
    font-size: 1.5rem;
    font-weight: 900;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6b7280;
    font-weight: 600;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: #fecaca;
}

.admin-content {
    flex: 1;
    padding: 32px;
}

@media (max-width: 1024px) {
    .admin-sidebar {
        width: 220px;
    }
    
    .admin-main {
        margin-left: 220px;
    }
    
    .admin-content {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    
    .admin-sidebar.open {
        transform: translateX(0);
    }
    
    .admin-main {
        margin-left: 0;
    }
    
    .admin-header {
        padding: 16px 20px;
    }
    
    .admin-content {
        padding: 16px;
    }
}
</style>
