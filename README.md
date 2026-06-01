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

| Variable           | Valeur par défaut  | Description          |
| ------------------ | ------------------ | -------------------- |
| `APP_URL`          | `http://localhost` | URL de l'application |
| `DB_CONNECTION`    | `sqlite`           | Base de données      |
| `QUEUE_CONNECTION` | `database`         | File d'attente       |
| `CACHE_STORE`      | `database`         | Cache                |

### User Stories

- **US1** — Inscription / Connexion / Déconnexion En tant qu'utilisateur, je veux créer mon compte, me connecter et me déconnecter.
- **US2** — Liste de mes candidatures En tant qu'utilisateur connecté, je veux voir toutes mes candidatures actives avec les informations essentielles de chacune en un coup d'œil.
- **US3** — Créer une candidature En tant qu'utilisateur connecté, je veux enregistrer une nouvelle candidature avec : le nom de l'entreprise, le poste visé, l'URL de l'offre (optionnel), le statut, la priorité, des notes libres et la date de candidature.
- **US4** — Voir le détail d'une candidature En tant qu'utilisateur connecté, je veux consulter le détail complet d'une candidature ainsi que tous les entretiens qui lui sont associés.
- **US5** — Modifier une candidature En tant qu'utilisateur connecté, je veux modifier les informations d'une de mes candidatures.
- **US6** — Archiver une candidature En tant qu'utilisateur connecté, je veux archiver une candidature terminée pour la retirer de ma liste principale sans la supprimer définitivement.
- **US7** — Page Archives En tant qu'utilisateur connecté, je veux consulter mes candidatures archivées dans une page dédiée.
- **US8** — Restaurer une candidature En tant qu'utilisateur connecté, je veux restaurer une candidature archivée pour la remettre dans ma liste active.
- **US9** — Filtres : filtrer la liste des candidatures par statut et/ou priorité.
- **US10** — Ajouter un entretien En tant qu'utilisateur connecté, je veux ajouter un entretien à une candidature avec : le type, la date et l'heure planifiée, des notes de préparation (optionnel) et le résultat.
- **US11** — Modifier / Supprimer un entretien En tant qu'utilisateur connecté, je veux modifier les informations d'un entretien ou le supprimer.

### Agile Organization

Kanban board on Jira with Daily standups.
