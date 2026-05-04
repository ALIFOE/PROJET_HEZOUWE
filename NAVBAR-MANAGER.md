# Gestionnaire Centralisé de la Barre de Navigation

## 📋 Description
Ce système permet de gérer la barre de navigation de votre site à partir d'un **seul fichier centralisé**. Plus besoin de mettre à jour la navbar sur chaque page!

---

## 📁 Fichiers Créés

### 1. **`assets/components/navbar.html`**
- Contient la structure complète de la barre de navigation
- C'est le **fichier unique** à modifier si vous voulez changer le menu
- Inclut: header top, menu principal, icônes de recherche/panier, etc.

### 2. **`assets/js/navbar.js`**
- Script qui charge automatiquement `navbar.html` et l'injecte dans le DOM
- Gère les chemins relatifs réels (même si la page est dans un sous-dossier)
- Fournit des fonctions utilitaires pour mettre à jour le menu dynamiquement

---

## 🚀 Comment Utiliser

### Étape 1: Inclure le script dans toutes vos pages

Avant la fermeture de la balise `</body>`, ajoutez cette ligne dans chaque fichier HTML:

```html
<script src="assets/js/navbar.js"></script>
```

**Exemple dans `index.html`:**
```html
    </footer>
    <!-- ... -->
    <script src="assets/js/navbar.js"></script>
</body>
</html>
```

### Étape 2: Ajouter un conteneur pour la navbar (si nécessaire)

Vous pouvez garder votre `<header>` existant comme conteneur. Le script remplacera son contenu:

```html
<header class="header-section-4"></header>
```

---

## 💡 Avantages

✅ **Manutention facile** - Modifiez la navbar une seule fois  
✅ **Pas de duplication** - Une seule source de vérité  
✅ **Chemins automatiques** - Fonctionne sur toutes les pages  
✅ **Dynamique** - Mettez à jour le menu avec JavaScript  
✅ **Performant** - Chargement en cache du navigateur  

---

## 🔧 Fonctions Avancées

### 1. Mettre à jour les éléments de menu dynamiquement

```javascript
updateNavbar([
    { href: 'index.html', label: 'Accueil' },
    { href: 'about.html', label: 'À Propos' },
    { href: 'shop.html', label: 'Nos Produits' },
    { href: 'service.html', label: 'Services' },
    { href: 'contact.html', label: 'Contact' }
]);
```

### 2. Mettre à jour les informations de contact

```javascript
updateContactInfo({
    phone: '+228 70 67 94 48',
    email: 'contact@hezouwe.tg',
    location: 'Tagbega, Wahala, Région Plateaux'
});
```

### 3. Marquer la page actuelle comme active

```javascript
document.addEventListener('DOMContentLoaded', function() {
    setActiveNavItem();
});
```

---

## 📝 Structure du Fichier `navbar.html`

```html
<!-- includes:
1. Header top (infos de contact, réseau sociaux)
2. Header sticky (logo, menu, panier, CTA)
3. Offcanvas (menu mobile)
-->
```

---

## ⚙️ Configuration Personnalisée

### Modifier les liens du menu

Éditez `assets/components/navbar.html`:
```html
<nav id="mobile-menu">
    <ul>
        <li><a href="index.html">Accueil</a></li>
        <!-- Modifiez ici -->
    </ul>
</nav>
```

### Modifier les infos de contact

Dans `navbar.html`, cherchez:
```html
<a href="tel:+22870679448">+228 70 67 94 48</a>
<a href="mailto:contact@hezouwe.tg">contact@hezouwe.tg</a>
```

### Ajouter du CSS personnalisé

Les styles restent dans votre `assets/css/main.css` comme avant!

---

## ⚠️ Notes Importantes

1. Le script fonctionne avec AJAX - assurez-vous que votre serveur local ou hosting supporte les requêtes AJAX
2. Chaque page doit avoir un `<header class="header-section-4"></header>` ou un conteneur existant
3. Le script détecte automatiquement le chemin (pages racine ou sous-dossiers)
4. Les scripts jQuery/Bootstrap doivent être chargés APRÈS `navbar.js`

---

## 🐛 Dépannage

### "Erreur lors du chargement de la barre de navigation"
- Vérifiez que `assets/components/navbar.html` existe
- Vérifiez les chemins relatifs
- Vérifiez que votre navigateur permet les requêtes AJAX locales

### Les styles ne s'appliquent pas
- Assurez-vous que `main.css` et les autres CSS sont encore chargés
- Les chemins CSS sont relatifs au fichier HTML, pas au fichier navbar

### Le menu mobile ne fonctionne pas
- Assurez-vous que `main.js` est chargé APRÈS `navbar.js`
- Vérifiez la console du navigateur (F12) pour les erreurs

---

## 📞 Besoin d'aide?

Pour toute modification ou ajout à la structure de la navbar, éditez simplement:
- **Menu**: `assets/components/navbar.html`
- **Comportement**: `assets/js/navbar.js`
- **Styles**: `assets/css/main.css`

C'est tout! 🎉
