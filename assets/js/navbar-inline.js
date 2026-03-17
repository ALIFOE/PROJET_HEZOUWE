/**
 * Gestionnaire centralisé de la barre de navigation - Version Inline
 * Ce script injecte la barre de navigation directement sans charger un fichier externe
 */

(function() {
    'use strict';

    // Navhbar HTML content
    const NAVBAR_CONTENT = `<div class="header-top-4">
        <div class="container">
            <div class="header-top-wrapper3">
                <p>
                    <img src="assets/img/fi.png" alt="img">
                    Riz Local Premium du TOGO - Qualité Certifiée ITRA
                </p>
                <div class="top-line"></div>
                <div class="header-info">
                    <div class="list-item">
                        <img src="assets/img/icon/icon11.svg" alt="img">
                        <span>Tagbega, Wahala, Région Plateaux</span>
                    </div>
                     <div class="top-line"></div>
                     <div class="list-item">
                        <img src="assets/img/icon/icon22.svg" alt="img">
                        <a href="mailto:contact@hezouwe.tg">contact@hezouwe.tg</a>
                    </div>
                     <div class="top-line"></div>
                    <div class="list-item">
                        <img src="assets/img/icon/icon33.svg" alt="img">
                        <a href="tel:+22870679448">+228 70 67 94 48</a>
                    </div>
                     <div class="top-line"></div>
                      <div class="list-item">
                        <img src="assets/img/icon/icon44.svg" alt="img">
                        <span>Lun - Sam: 08.00 to 18.00</span>
                    </div>
                </div>
                <div class="head-right">
                    <div class="flag-wrap">
                        <div class="flag">
                            <img src="assets/img/flag.png" alt="flag">
                        </div>
                        <select class="single-select w-100">
                            <option>FR</option>
                            <option>EN</option>
                        </select>
                    </div>
                    <div class="line-shape"></div>
                    <div class="social-icon">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="header-sticky" class="header-4">
       <div class="container">
         <div class="mega-menu-wrapper">
            <div class="header-main">
                 <a href="index.html" class="header-logo">
                    <img src="assets/img/logo/logo_hezouwe.jpeg" alt="img">
                </a>
                <div class="header-right d-flex justify-content-end align-items-center">
                    <div class="mean__menu-wrapper">
                    <div class="main-menu">
                         <nav id="mobile-menu">
                            <ul>
                                <li><a href="index.html">Accueil</a></li>
                                <li><a href="about.html">À Propos</a></li>
                                <li><a href="shop.html">Nos Produits</a></li>
                                <li><a href="service.html">Services</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                    <div class="header-right-icon">
                        <button id="openButton" class="cart-icon"><i class="far fa-shopping-bag"></i>
                            <span id="cart-count">2</span>
                        </button>
                    </div>
                    <a href="contact.html" class="theme-btn">Nous Contacter
                        <i class="far fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
       </div>
    </div>`;

    // Charger la navbar au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔍 DOMContentLoaded - Injection de la navbar...');
        loadNavbar();
    });

    /**
     * Fonction pour injecter la barre de navigation
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

        // Injecter le contenu navbar
        injectNavbar(navbarContainer);
    }

    /**
     * Injecter le contenu navbar dans le DOM
     */
    function injectNavbar(container) {
        try {
            if (container) {
                container.innerHTML = NAVBAR_CONTENT;
                console.log('✅ Navbar injectée avec succès dans le conteneur');
            } else {
                console.error('❌ Conteneur navbar non trouvé');
                return;
            }
            
            // Réinitialiser les scripts après l'injection
            reinitializeScripts();
        } catch (e) {
            console.error('❌ Erreur lors de l\'injection:', e);
        }
    }

    /**
     * Réinitialiser les scripts côté client après l'injection de la navbar
     */
    function reinitializeScripts() {
        console.log('⚙️ Initialisation des fonctionnalités du menu...');
        
        // Initialiser le hamburger menu
        initHamburgerMenu();
        
        // Initialiser la page active
        setActiveNavigationItem();
        
        // Initialiser les événements du panier
        initCartEvents();
        
        // Réappliquer les scripts main.js si présents
        if (typeof initMenuToggle === 'function') {
            try {
                initMenuToggle();
                console.log('✅ initMenuToggle exécuté');
            } catch (e) {
                console.warn('⚠️ initMenuToggle non disponible');
            }
        }

        if (typeof handleStickyHeader === 'function') {
            try {
                handleStickyHeader();
                console.log('✅ handleStickyHeader exécuté');
            } catch (e) {
                console.warn('⚠️ handleStickyHeader non disponible');
            }
        }

        if (typeof initCart === 'function') {
            try {
                initCart();
                console.log('✅ initCart exécuté');
            } catch (e) {
                console.warn('⚠️ initCart non disponible');
            }
        }

        console.log('✅ Tous les scripts sont initialisés');
    }

    /**
     * Initialiser le hamburger menu
     */
    function initHamburgerMenu() {
        const toggleButton = document.querySelector('.sidebar__toggle');
        const offcanvasOverlay = document.querySelector('.offcanvas__overlay');
        const offcanvasClose = document.querySelector('.offcanvas__close button');
        const sideBar = document.getElementById('targetElement');

        if (!toggleButton || !sideBar) {
            console.warn('⚠️ Éléments du hamburger menu non trouvés');
            return;
        }

        // Toggle menu au clic
        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            sideBar.classList.toggle('side_bar_hidden');
            console.log('🍔 Hamburger menu basculé');
        });

        // Fermer au clic sur l'overlay
        if (offcanvasOverlay) {
            offcanvasOverlay.addEventListener('click', function() {
                sideBar.classList.add('side_bar_hidden');
                console.log('🍔 Menu fermé (overlay)');
            });
        }

        // Fermer au clic sur le bouton X
        if (offcanvasClose) {
            offcanvasClose.addEventListener('click', function() {
                sideBar.classList.add('side_bar_hidden');
                console.log('🍔 Menu fermé (bouton)');
            });
        }

        // Fermer quand on clique sur un lien du menu
        const menuLinks = document.querySelectorAll('nav#mobile-menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                sideBar.classList.add('side_bar_hidden');
                console.log('🍔 Menu fermé (lien cliqué)');
            });
        });

        console.log('✅ Hamburger menu initialisé');
    }

    /**
     * Marquer la page active dans la navigation
     */
    function setActiveNavigationItem() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navLinks = document.querySelectorAll('nav#mobile-menu a');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            link.parentElement.classList.remove('active');
            
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.parentElement.classList.add('active');
                console.log('📍 Page active détectée:', currentPage);
            }
        });
    }

    /**
     * Initialiser les événements du panier
     */
    function initCartEvents() {
        const openButton = document.getElementById('openButton');
        const closeButton = document.getElementById('closeButton');
        const sideBar = document.getElementById('targetElement');
        
        if (openButton && sideBar) {
            openButton.addEventListener('click', function(e) {
                e.preventDefault();
                sideBar.classList.remove('side_bar_hidden');
                console.log('🛒 Panier ouvert');
            });
        }

        if (closeButton && sideBar) {
            closeButton.addEventListener('click', function(e) {
                e.preventDefault();
                sideBar.classList.add('side_bar_hidden');
                console.log('🛒 Panier fermé');
            });
        }

        console.log('✅ Événements du panier initialisés');
    }

    /**
     * Mettre à jour dynamiquement la navigation
     * Utile si vous voulez ajouter/supprimer des éléments de menu
     */
    window.updateNavbar = function(menuItems) {
        const mobileMenu = document.querySelector('nav#mobile-menu ul');
        
        if (!mobileMenu) {
            console.error('❌ Menu mobile non trouvé');
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
            if (item.class) a.className = item.class;
            li.appendChild(a);
            mobileMenu.appendChild(li);
        });

        // Réinitialiser les événements après la mise à jour
        setActiveNavigationItem();
        initHamburgerMenu();
        
        console.log('✅ Menu mis à jour avec', menuItems.length, 'éléments');
    };

    /**
     * Fonction pour mettre à jour les informations de contact
     */
    window.updateContactInfo = function(config) {
        const phone = document.querySelector('a[href^="tel:"]');
        const email = document.querySelector('a[href^="mailto:"]');
        const location = document.querySelectorAll('.list-item span')[0];

        if (config.phone && phone) {
            phone.href = 'tel:' + config.phone;
            phone.textContent = config.phone;
            console.log('📞 Téléphone mis à jour:', config.phone);
        }

        if (config.email && email) {
            email.href = 'mailto:' + config.email;
            email.textContent = config.email;
            console.log('📧 Email mis à jour:', config.email);
        }

        if (config.location && location) {
            location.textContent = config.location;
            console.log('📍 Localisation mise à jour');
        }
    };

    /**
     * Fonction pour activer la page actuelle dans le menu
     */
    window.setActiveNavItem = setActiveNavigationItem;

    /**
     * Fonction pour mettre à jour le nombre d'articles du panier
     */
    window.updateCartCount = function(count) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
            console.log('🛒 Compte du panier mis à jour:', count);
        }
    };

    /**
     * Fonction pour basculer le panier
     */
    window.toggleCart = function(show) {
        const sideBar = document.getElementById('targetElement');
        if (!sideBar) {
            console.warn('⚠️ Élément panier non trouvé');
            return;
        }
        if (show === undefined) {
            sideBar.classList.toggle('side_bar_hidden');
        } else if (show) {
            sideBar.classList.remove('side_bar_hidden');
        } else {
            sideBar.classList.add('side_bar_hidden');
        }
    };

    /**
     * Fonction pour basculer le menu mobile
     */
    window.toggleMobileMenu = function(show) {
        const sideBar = document.getElementById('targetElement');
        if (!sideBar) {
            console.warn('⚠️ Élément menu mobile non trouvé');
            return;
        }
        if (show === undefined) {
            sideBar.classList.toggle('side_bar_hidden');
        } else if (show) {
            sideBar.classList.remove('side_bar_hidden');
        } else {
            sideBar.classList.add('side_bar_hidden');
        }
    };

    /**
     * Initialisation automatique de la navbar
     * S'exécute au chargement du document
     */
    function initializeNavbar() {
        console.log('🚀 Initialisation de la navbar...');
        
        try {
            loadNavbar();
            console.log('✅ Navbar initialisée avec succès');
        } catch (error) {
            console.error('❌ Erreur lors de l\'initialisation de la navbar:', error);
        }
    }

    // Exposer la fonction d'initialisation globalement si nécessaire
    window.initializeNavbar = initializeNavbar;

})();

// Initialiser la navbar quand le DOM est prêt
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.initializeNavbar);
} else {
    window.initializeNavbar();
}
