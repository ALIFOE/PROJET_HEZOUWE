/**
 * Snippets de Code pour Gérer la Barre de Navigation
 * Copiez et collez ces exemples dans votre code
 */

// ============================================================================
// 1. MARQUER LA PAGE ACTIVE DANS LE MENU
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('nav#mobile-menu a');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
            link.parentElement.classList.add('active');
        }
    });
});

// ============================================================================
// 2. CHANGER DYNAMIQUEMENT LE MENU
// ============================================================================
// Exemple: Si vous voulez ajouter des sous-menus ou sélectionner des éléments
function highlightMenuByPath(path) {
    const navLink = document.querySelector(`nav#mobile-menu a[href="${path}"]`);
    if (navLink) {
        navLink.parentElement.classList.add('active');
    }
}

// Utilisation:
// highlightMenuByPath('shop.html');

// ============================================================================
// 3. METTRE À JOUR LES INFOS DE CONTACT EN MASSE
// ============================================================================
const companySocialLinks = {
    facebook: 'https://facebook.com/coop-ca-hezouwe',
    twitter: 'https://twitter.com/hezouwe',
    youtube: 'https://youtube.com/@hezouwe',
    linkedin: 'https://linkedin.com/company/hezouwe'
};

function updateSocialLinks(links) {
    const socialIcons = document.querySelectorAll('.social-icon a');
    const platforms = ['facebook', 'twitter', 'youtube', 'linkedin'];

    socialIcons.forEach((icon, index) => {
        if (platforms[index] && links[platforms[index]]) {
            icon.href = links[platforms[index]];
        }
    });

    console.log('Liens sociaux mis à jour');
}

// Utilisation:
// updateSocialLinks(companySocialLinks);

// ============================================================================
// 4. BASCULER L'AFFICHAGE DU MENU MOBILE
// ============================================================================
function toggleMobileMenu() {
    const menu = document.querySelector('nav#mobile-menu');
    if (menu) {
        menu.classList.toggle('show');
    }
}

// Utilisation dans un bouton:
// <button onclick="toggleMobileMenu()">Menu</button>

// ============================================================================
// 5. FERMER LE MENU AUTOMATIQUEMENT APRÈS CLIC
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('nav#mobile-menu a');
    const sideBar = document.getElementById('targetElement');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Fermer le sidebar après le clic
            if (sideBar) {
                sideBar.classList.add('side_bar_hidden');
            }
        });
    });
});

// ============================================================================
// 6. METTRE EN CACHE LE NOMBRE D'ARTICLES DU PANIER
// ============================================================================
function updateCartCount(count) {
    const cartBadge = document.querySelector('.cart-icon span');
    if (cartBadge) {
        cartBadge.textContent = count;
        // Sauvegarder en localStorage aussi
        localStorage.setItem('cartCount', count);
    }
}

// Utilisation:
// updateCartCount(5);

// ============================================================================
// 7. CHARGER LE NOMBRE D'ARTICLES DU PANIER AU DÉMARRAGE
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    const savedCount = localStorage.getItem('cartCount');
    if (savedCount) {
        updateCartCount(savedCount);
    }
});

// ============================================================================
// 8. RECHERCHE EN DIRECT DANS LE MENU
// ============================================================================
function filterMenuItems(searchText) {
    const navLinks = document.querySelectorAll('nav#mobile-menu a');
    
    navLinks.forEach(link => {
        const text = link.textContent.toLowerCase();
        if (text.includes(searchText.toLowerCase())) {
            link.parentElement.style.display = 'block';
        } else {
            link.parentElement.style.display = 'none';
        }
    });
}

// Utilisation (ex: après un input de recherche):
// filterMenuItems('produits');

// ============================================================================
// 9. AJOUTER UN ÉLÉMENT DE MENU DYNAMIQUEMENT
// ============================================================================
function addMenuItemDynamically(label, href, position = 'end') {
    const menu = document.querySelector('nav#mobile-menu ul');
    if (!menu) return;

    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = href;
    a.textContent = label;
    li.appendChild(a);

    if (position === 'end') {
        menu.appendChild(li);
    } else if (position === 'start') {
        menu.insertBefore(li, menu.firstChild);
    }

    console.log(`Élément ajouté: ${label}`);
}

// Utilisation:
// addMenuItemDynamically('Blog', 'blog.html', 'end');

// ============================================================================
// 10. SUPPRIMER UN ÉLÉMENT DE MENU
// ============================================================================
function removeMenuItemByHref(href) {
    const link = document.querySelector(`nav#mobile-menu a[href="${href}"]`);
    if (link) {
        link.parentElement.remove();
        console.log(`Élément supprimé: ${href}`);
    }
}

// Utilisation:
// removeMenuItemByHref('blog.html');

// ============================================================================
// 11. OBTENIR TOUS LES ÉLÉMENTS DE MENU
// ============================================================================
function getAllMenuItems() {
    const links = document.querySelectorAll('nav#mobile-menu a');
    const items = [];

    links.forEach(link => {
        items.push({
            label: link.textContent,
            href: link.getAttribute('href'),
            isActive: link.parentElement.classList.contains('active')
        });
    });

    return items;
}

// Utilisation:
// const menuItems = getAllMenuItems();
// console.log(menuItems);

// ============================================================================
// 12. SYNCHRONISER LE MENU AVEC UNE BASE DE DONNÉES (Advanced)
// ============================================================================
async function syncMenuFromAPI(apiUrl) {
    try {
        const response = await fetch(apiUrl);
        const menuData = await response.json();
        
        updateNavbar(menuData.menu);
        updateContactInfo(menuData.contact);
        
        console.log('Menu synchronisé depuis l\'API');
    } catch (error) {
        console.error('Erreur lors de la synchronisation:', error);
    }
}

// Utilisation (si vous avez une API):
// syncMenuFromAPI('/api/navbar');

// ============================================================================
// 13. ACTIVER/DÉSACTIVER UN ÉLÉMENT DE MENU
// ============================================================================
function toggleMenuItemByHref(href, enable = true) {
    const link = document.querySelector(`nav#mobile-menu a[href="${href}"]`);
    if (link) {
        if (enable) {
            link.parentElement.style.display = 'block';
            link.classList.remove('disabled');
        } else {
            link.parentElement.style.display = 'none';
            link.classList.add('disabled');
        }
    }
}

// Utilisation:
// toggleMenuItemByHref('admin.html', false); // Masquer le lien admin

// ============================================================================
// 14. EXPORTER LA CONFIGURATION ACTUELLE
// ============================================================================
function exportNavbarConfig() {
    const config = {
        menu: getAllMenuItems(),
        timestamp: new Date().toISOString()
    };
    
    console.log(JSON.stringify(config, null, 2));
    return config;
}

// Utilisation:
// const backup = exportNavbarConfig();

// ============================================================================
// 15. LISTENER POUR LES CHANGEMENTS DE PAGE (History API)
// ============================================================================
window.addEventListener('popstate', function() {
    // Réappliquer la mise en évidence de la page active
    setActiveNavItem();
});

// ============================================================================
// EXPORT POUR UTILISATION EXTERNE (si nécessaire)
// ============================================================================
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        highlightMenuByPath,
        updateSocialLinks,
        toggleMobileMenu,
        updateCartCount,
        filterMenuItems,
        addMenuItemDynamically,
        removeMenuItemByHref,
        getAllMenuItems,
        syncMenuFromAPI,
        toggleMenuItemByHref,
        exportNavbarConfig
    };
}
