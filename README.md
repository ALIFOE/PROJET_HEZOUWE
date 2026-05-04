# COOP CA HEZOUWE - Site Web Laravel

Site web de la coopérative COOP CA HEZOUWE pour la transformation et commercialisation du riz local du TOGO.

## À Propos du Projet

Ce projet est une conversion du site HTML original en application Laravel avec:
- **Framework**: Laravel 9 avec Inertia.js et Vue.js
- **Authentification**: Laravel Breeze
- **Paiements en ligne**: Stripe
- **Design**: Identique au site original HTML

## Caractéristiques

- Header unique (composant Vue réutilisable)
- Footer unique (composant Vue réutilisable)
- Système d'authentification complet (inscription, connexion, réinitialisation mot de passe)
- Boutique en ligne avec panier et checkout
- Intégration Stripe pour les paiements
- Design préservé du site original

## Installation

### Prérequis

- PHP 8.0+
- Composer
- Node.js & NPM
- MySQL

### Étapes d'installation

1. Cloner le projet
```bash
git clone <repository-url>
cd hezou-laravel
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Installer les dépendances Node
```bash
npm install
```

4. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurer la base de données dans `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hezouwe
DB_USERNAME=root
DB_PASSWORD=
```

6. Exécuter les migrations
```bash
php artisan migrate
```

7. Configurer Stripe dans `.env`
```
STRIPE_KEY=pk_test_your_stripe_key
STRIPE_SECRET=sk_test_your_stripe_secret
```

8. Compiler les assets
```bash
npm run build
```

9. Démarrer le serveur de développement
```bash
php artisan serve
```

## Structure du Projet

- `resources/js/Components/` - Composants Vue réutilisables (Header, Footer)
- `resources/js/Layouts/` - Layouts Vue (AppLayout, AuthenticatedLayout)
- `resources/js/Pages/` - Pages Vue (Home, About, Shop, Contact, etc.)
- `app/Http/Controllers/` - Contrôleurs Laravel (PaymentController)
- `routes/web.php` - Routes Laravel
- `public/assets/` - Assets statiques (CSS, JS, images)

## Pages Disponibles

- `/` - Accueil
- `/about` - À Propos
- `/shop` - Boutique
- `/shop-details` - Détails Produit
- `/shop-cart` - Panier
- `/checkout` - Checkout
- `/contact` - Contact
- `/service` - Services
- `/project` - Projets
- `/news` - Actualités
- `/team` - Équipe
- `/gallery` - Galerie
- `/faq` - FAQ
- `/testimonial` - Témoignages
- `/history` - Histoire
- `/pricing` - Tarifs

## Authentification

- `/login` - Connexion
- `/register` - Inscription
- `/forgot-password` - Mot de passe oublié
- `/dashboard` - Tableau de bord utilisateur

## Paiement Stripe

Le système de paiement utilise Stripe Checkout. Les routes de paiement sont:
- `/checkout` - Page de checkout
- `/payment/create-session` - Création session Stripe
- `/payment/success` - Page de succès
- `/payment/cancel` - Page d'annulation

## Développement

Pour le développement en mode hot-reload:
```bash
npm run dev
```

Pour compiler pour la production:
```bash
npm run build
```

## Licence

Ce projet est la propriété de COOP CA HEZOUWE.
