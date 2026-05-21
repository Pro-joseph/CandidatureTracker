# CandidatureTracker

Application web de suivi de candidatures professionnelles. Permet de centraliser, organiser et suivre l'évolution de vos recherches d'emploi.

## Fonctionnalités

- **Gestion des candidatures** — Ajout, modification, consultation et suppression des candidatures avec suivi du statut et priorité
- **Suivi des entretiens** — Planification et suivi des entretiens (téléphonique, technique, RH, final) avec résultat
- **Filtres et recherche** — Filtrage par statut et priorité pour retrouver rapidement une candidature
- **Archivage** — Archivage des candidatures avec possibilité de restauration ou suppression définitive
- **Tableau de bord** — Statistiques globales (candidatures actives, entretiens à venir, offres reçues) et liste des prochains entretiens

## Stack technique

- **Framework :** Laravel 13.x — PHP 8.3+
- **Base de données :** MySQL (par défaut)
- **Authentification :** Laravel Breeze (Blade)
- **Frontend :** Tailwind CSS, Alpine.js, Blade
- **Build :** Vite

## Installation

```bash
# Cloner le dépôt
git clone <https://github.com/Pro-joseph/CandidatureTracker>
cd candidaturetracker

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate

# Compiler les assets (développement)
npm run dev

# Lancer le serveur
php artisan serve
```

### Configuration minimale

| Variable | Valeur par défaut | Description |
|---|---|---|
| `APP_URL` | `http://localhost` | URL de l'application |
| `DB_CONNECTION` | `sqlite` | Base de données |
| `SESSION_DRIVER` | `database` | Stockage des sessions |
| `QUEUE_CONNECTION` | `database` | File d'attente |
| `CACHE_STORE` | `database` | Cache |
