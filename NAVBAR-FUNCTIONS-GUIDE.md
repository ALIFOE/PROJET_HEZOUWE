# Guide des Fonctions Globales de la Navbar

## 📌 Introduction

Le fichier `assets/js/navbar-inline.js` expose plusieurs fonctions globales pour contrôler et personnaliser la navbar dynamiquement.

---

## 🎯 Fonctions Disponibles

### 1. **updateCartCount(count)**
Met à jour le nombre d'articles dans le panier.

```javascript
// Définir le nombre à 5
window.updateCartCount(5);

// Ou utiliser directement
updateCartCount(10);
```

**Paramètres:**
- `count` (number) - Le nombre d'articles à afficher

**Résultat:** Met à jour le badge du panier avec le nombre spécifié

---

### 2. **toggleCart(show)**
Bascule l'affichage du panier (cart sidebar).

```javascript
// Toggle le panier (on/off)
window.toggleCart();

// Afficher le panier
window.toggleCart(true);

// Fermer le panier
window.toggleCart(false);
```

**Paramètres:**
- `show` (boolean, optionnel) - true pour afficher, false pour fermer, undefined pour basculer

---

### 3. **toggleMobileMenu(show)**
Bascule l'affichage du menu mobile (hamburger).

```javascript
// Toggle le menu
window.toggleMobileMenu();

// Afficher le menu
window.toggleMobileMenu(true);

// Fermer le menu
window.toggleMobileMenu(false);
```

**Paramètres:**
- `show` (boolean, optionnel) - true pour afficher, false pour fermer, undefined pour basculer

---

### 4. **updateNavbar(menuItems)**
Met à jour complètement le contenu du menu avec plusieurs éléments.

```javascript
const newMenu = [
    { href: 'index.html', label: 'Accueil' },
    { href: 'about.html', label: 'À Propos' },
    { href: 'shop.html', label: 'Boutique' },
    { href: 'contact.html', label: 'Contact', class: 'active' }
];

window.updateNavbar(newMenu);
```

**Paramètres:**
- `menuItems` (array) - Tableau d'objets avec:
  - `href` (string) - L'URL du lien
  - `label` (string) - Le texte affiché
  - `class` (string, optionnel) - La classe CSS à appliquer

**Résultat:** Remplace complètement les éléments du menu et réinitialise les événements

---

### 5. **updateContactInfo(config)**
Met à jour les informations de contact dans la navbar.

```javascript
window.updateContactInfo({
    phone: '+33 1 23 45 67 89',
    email: 'contact@exemple.com',
    location: 'Paris, France'
});
```

**Paramètres:**
- `config` (object) - Configuration avec:
  - `phone` (string, optionnel) - Le numéro de téléphone
  - `email` (string, optionnel) - L'adresse email
  - `location` (string, optionnel) - La localisation

**Résultat:** Met à jour les informations affichées dans la navbar

---

### 6. **setActiveNavItem()**
Marque la page actuelle dans le menu de navigation.

```javascript
// Appel automatique au chargement, mais peut être rappelé manuellement
window.setActiveNavItem();
```

**Paramètres:** Aucun

**Résultat:** Ajoute la classe 'active' au lien correspondant à la page actuelle

---

### 7. **initializeNavbar()**
Initialise complètement la navbar (appelée automatiquement au chargement).

```javascript
// Appel automatique, mais peut être rappelé si nécessaire
window.initializeNavbar();
```

**Paramètres:** Aucun

**Résultat:** Charge et initialise toute la navbar

---

## 💡 Exemples Pratiques

### Exemple 1: Mettre à jour le panier après une commande

```javascript
// L'utilisateur ajoute un article
function addItemToCart(item) {
    // ... code pour ajouter l'article ...
    
    // Mettre à jour le badge du panier
    const currentCount = parseInt(document.getElementById('cart-count').textContent) || 0;
    updateCartCount(currentCount + 1);
    
    // Afficher le panier
    toggleCart(true);
    
    console.log('✅ Article ajouté au panier!');
}
```

### Exemple 2: Personnaliser le menu dynamiquement

```javascript
// Personnes connectées vs visiteurs
function updateMenuForUser(isLoggedIn) {
    const baseMenu = [
        { href: 'index.html', label: 'Accueil' },
        { href: 'shop.html', label: 'Boutique' },
        { href: 'contact.html', label: 'Contact' }
    ];
    
    if (isLoggedIn) {
        baseMenu.push({ href: 'profile.html', label: 'Mon Profil' });
        baseMenu.push({ href: '#', label: 'Se Déconnecter' });
    } else {
        baseMenu.push({ href: 'login.html', label: 'Se Connecter' });
    }
    
    updateNavbar(baseMenu);
}

// Utilisation
updateMenuForUser(true);
```

### Exemple 3: Mettre à jour les coordonnées de contact

```javascript
// Charger les coordonnées depuis une API
fetch('/api/contact-info')
    .then(response => response.json())
    .then(data => {
        updateContactInfo({
            phone: data.phone,
            email: data.email,
            location: data.address
        });
    });
```

### Exemple 4: Contrôler le menu depuis JavaScript

```javascript
// Ouvrir le menu automatiquement après 2 secondes
setTimeout(() => {
    toggleMobileMenu(true);
    console.log('Menu ouvert automatiquement');
}, 2000);

// Fermer après 5 secondes
setTimeout(() => {
    toggleMobileMenu(false);
}, 5000);
```

---

## 🔍 Console Debugging

Le script navbar affiche des messages de débogage dans la console. Vous pouvez les voir en appuyant sur F12:

```
🚀 Initialisation de la navbar...
✅ Navbar injectée avec succès
✅ Hamburger menu initialisé
📍 Page active détectée: index.html
✅ Événements du panier initialisés
✅ Navbar initialisée avec succès
```

**Problèmes à vérifier:**
- ❌ Aucun message = Le script n'est peut-être pas chargé
- ⚠️ Erreurs = Vérifier que les IDs des éléments existent dans le HTML

---

## 📋 Checklist d'Intégration

- [x] Navbar injectée automatiquement au chargement
- [x] Menu mobile bascule avec le hamburger
- [x] Page active soulignée automatiquement
- [x] Panier ouvert/fermé avec les boutons
- [x] Barre de recherche supprimée
- [x] Fonctions globales accessibles via `window`
- [ ] Tester sur toutes les pages
- [ ] Vérifier la console pour les erreurs
- [ ] Adapter le CSS si nécessaire

---

## 🜜 Ressources

- **Fichier principal:** `assets/js/navbar-inline.js`
- **Composant HTML:** `assets/components/navbar.html` (référence)
- **Documentation:** `NAVBAR-MANAGER.md`
- **Configuration:** `assets/config/navbar-config.json`

---

**Dernière mise à jour:** Session en cours
**Version:** 2.0 (avec initialisation automatique et fonctions globales)
