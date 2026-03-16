/**
 * Gestionnaire centralisé de la barre de navigation
 * Ce script charge et injecte la barre de navigation dans toutes les pages
 */

(function() {
    'use strict';

    // Charger la navbar au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔍 DOMContentLoaded - Chargement de la navbar...');
        loadNavbar();
    });

    /**
     * Fonction pour charger la barre de navigation via AJAX
     */
    function loadNavbar() {
        console.log('📍 Fonction loadNavbar appelée');
        
        // Trouver l'élément qui accueillera la navbar
        const navbarContainer = document.querySelector('header.header-section-4');
        console.log('🔎 Conteneur trouvé:', navbarContainer ? 'OUI' : 'NON');
        
        // Si la navbar existe déjà, ne pas la charger à nouveau
        if (navbarContainer && navbarContainer.querySelector('.header-top-4')) {
            console.log('✅ Navbar déjà chargée');
            return;
        }

        // Déterminer le chemin correct pour les fichiers
        const navbarPath = getNavbarPath();
        console.log('📂 Chemin navbar:', navbarPath);

        // Charger le fichier navbar.html
        loadNavbarContent(navbarPath, navbarContainer);
    }

    /**
     * Charger le contenu navbar
     */
    function loadNavbarContent(navbarPath, container) {
        const xhr = new XMLHttpRequest();
        
        xhr.onload = function() {
            console.log('📥 Réponse reçue, status:', xhr.status);
            if (xhr.status === 200 || xhr.status === 0) { // 0 pour fichiers locaux
                console.log('✅ Contenu reçu, injection en cours...');
                injectNavbar(xhr.responseText, container);
            } else {
                console.error('❌ Erreur HTTP:', xhr.status);
            }
        };
        
        xhr.onerror = function() {
            console.error('❌ Erreur réseau lors du chargement de la navbar');
            console.error('Statut:', xhr.status, 'Réponse:', xhr.responseText);
            showErrorMessage();
        };
        
        xhr.onprogress = function(event) {
            console.log('📥 Progression:', event.loaded, 'bytes');
        };
        
        console.log('🚀 Envoi requête XHR vers:', navbarPath);
        xhr.open('GET', navbarPath, true);
        xhr.send();
    }

    /**
     * Injecter le contenu navbar dans le DOM
     */
    function injectNavbar(html, container) {
        try {
            if (container) {
                container.innerHTML = html;
                console.log('✅ Navbar injectée avec succès dans le conteneur');
            } else {
                const body = document.body;
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                body.insertBefore(tempDiv.firstElementChild, body.firstChild);
                console.log('✅ Navbar injectée (nouveau conteneur créé)');
            }
            
            // Réinitialiser les scripts après l'injection
            reinitializeScripts();
        } catch (e) {
            console.error('❌ Erreur lors de l\'injection:', e);
        }
    }

    /**
     * Afficher un message d'erreur
     */
    function showErrorMessage() {
        console.error('⚠️ La barre de navigation n\'a pas pu être chargée');
        console.error('Vérifiez:');
        console.error('1. Que le fichier assets/components/navbar.html existe');
        console.error('2. Le chemin relatif depuis la page actuelle');
        console.error('3. Ouvrez les outils de développement (F12) pour plus de détails');
        console.error('4. Si vous ouvrez le fichier en local (file://), utilisez un serveur local');
    }

    /**
     * Déterminer le chemin du fichier navbar.html
     */
    function getNavbarPath() {
        // Chemin relatif qui fonctionne pour les fichiers locaux et serveurs
        // Fonctionne depuis la racine du projet
        return 'assets/components/navbar.html';
    }

    /**
     * Réinitialiser les scripts côté client après l'injection de la navbar
     */
    function reinitializeScripts() {
        // Réappliquer les événements de menu mobile
        if (typeof initMenuToggle === 'function') {
            initMenuToggle();
        }

        // Réappliquer les effets sticky du header
        if (typeof handleStickyHeader === 'function') {
            handleStickyHeader();
        }

        // Réappliquer les événements du panier
        if (typeof initCart === 'function') {
            initCart();
        }

        // Log pour debug
        console.log('Barre de navigation chargée et scripts réinitialisés');
    }

    /**
     * Mettre à jour dynamiquement la navigation
     * Utile si vous voulez ajouter/supprimer des éléments de menu
     */
    window.updateNavbar = function(menuItems) {
        const mobileMenu = document.querySelector('nav#mobile-menu ul');
        
        if (!mobileMenu) {
            console.error('Menu mobile non trouvé');
            return;
        }

        // Vider le menu actuel
        mobileMenu.innerHTML = '';

        // Ajouter les nouveaux éléments
        menuItems.forEach(item => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = item.href;
            a.textContent = item.label;
            li.appendChild(a);
            mobileMenu.appendChild(li);
        });

        console.log('Menu mise à jour');
    };

    /**
     * Fonction pour mettre à jour les informations de contact
     */
    window.updateContactInfo = function(config) {
        const phone = document.querySelector('a[href^="tel:"]');
        const email = document.querySelector('a[href^="mailto:"]');
        const location = document.querySelector('.list-item span:first-child');

        if (config.phone && phone) {
            phone.href = 'tel:' + config.phone;
            phone.textContent = config.phone;
        }

        if (config.email && email) {
            email.href = 'mailto:' + config.email;
            email.textContent = config.email;
        }

        if (config.location && location) {
            location.textContent = config.location;
        }
    };

    /**
     * Fonction pour activer la page actuelle dans le menu
     */
    window.setActiveNavItem = function() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navLinks = document.querySelectorAll('nav#mobile-menu a');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.parentElement.classList.add('active');
            } else {
                link.parentElement.classList.remove('active');
            }
        });
    };

})();
