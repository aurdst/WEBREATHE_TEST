# WEBREATHE_TEST
Projet : Dashboard de gestion et de suivi des performances de modules de Formule 1

# Description du projet

Le projet vise à développer une application complète basée sur un backend en PHP et une interface utilisateur en HTML, CSS et Bootstrap. L'objectif principal est de créer un dashboard permettant de visualiser en temps réel les performances de modules de Formule 1, comme des voitures Mercedes ou Ferrari. Ce dashboard est destiné à fournir des informations clés sur les paramètres techniques et l'état des consommables pour aider les équipes techniques à optimiser leurs stratégies.

> [!IMPORTANT]
> Étape 1 : Installer et Configurer un Package pour .env
> Installer la bibliothèque Dotenv
> Utilisez Composer pour installer le package vlucas/phpdotenv, qui
> permet de gérer facilement les fichiers .env.

> Si vous n’avez pas encore installé Composer, vous pouvez le télécharger > ici : https://getcomposer.org/.

> Ensuite, exécutez la commande suivante dans le répertoire de votre projet PHP :

```composer require vlucas/phpdotenv```
>Une fois installé, le package est prêt à être utilisé.

> Étape 2 : Créer un fichier .env
Créez un fichier .env à la racine de votre projet. Ce fichier contiendra vos variables sensibles, comme ceci :

# Fichier .env

```
DB_HOST=localhost
DB_NAME=f1_dashboard
DB_USER=postgres
DB_PASSWORD=votre_mot_de_passe
DB_PORT=5432
```

> [!CAUTION]
Remarque : Ne partagez jamais ce fichier avec le reste du monde ! Ajoutez-le à votre fichier .gitignore pour éviter qu’il ne soit suivi par Git.

# Fonctionnalités principales

## Gestion des Modules

Chaque module représente un élément essentiel d’une Formule 1 et contient les informations suivantes :
```
Titre

Description

Catégorie (par exemple : "Performance", "Consommables")

Nom de la voiture ou du module

Date de création et de mise à jour

Pilote utilisé

Suivi des Performances

Données relatives à la voiture de Formule 1 :

Vitesse moyenne en km/h.

Nombre de tours par heure.

Type de carburant utilisé (essence, éthanol, etc.).

Litres de carburant consommés par tour.

État des Consommables

Détail des consommables clés :

Freins : Nombre de freins installés et leur état (exemple : "Neufs", "Usés").

Pneus : Nombre de pneus installés et leur état (exemple : "À remplacer", "Usés").
```
# Visualisation en temps réel

Dashboard dynamique et intuitif construit avec Bootstrap, affichant :

Des cartes pour chaque métrique (vitesse, tours, carburant, etc.).

Une vue synthétique des performances globales.

## Backend robuste

Construit en PHP avec une base de données PostgreSQL.

Gestion centralisée des entités « modules » via une API REST ou des formulaires PHP.

Fichier SQL préconfiguré pour créer la base de données et les tables.

### Structure de la Base de Données

```
Base de données PostgreSQL : f1_dashboard

Table : modules

module_id : Identifiant unique

title : Titre du module

description : Description détaillée

category : Catégorie

name : Nom de la voiture/module

avg_speed : Vitesse moyenne en km/h

brakes_installed : Nombre de freins installés

brakes_status : État des freins

tires_installed : Nombre de pneus installés

tires_status : État des pneus

fuel_type : Type de carburant

fuel_per_lap : Litres consommés par tour

driver_name : Nom du pilote utilisé

victories : Nombre de victoires

created_at : Date de création

updated_at : Date de mise à jour
```

### Technologies Utilisées

Backend : PHP

Gestion des requêtes et de la logique métier.

Connexion à PostgreSQL pour le stockage des données.

API REST ou formulaires PHP pour les opérations CRUD (Create, Read, Update, Delete).

Base de données : PostgreSQL

Performance élevée pour le traitement de données en temps réel.

Fichier SQL préconçu pour faciliter l'installation et la configuration.

Frontend : HTML, CSS, Bootstrap

Interface utilisateur responsive et attrayante.

Grille Bootstrap pour organiser les cartes et tableaux.

Animation pour un affichage fluide des données.

> [!NOTE]
> AJAX (optionnel)

> Recharge des données sans recharger la page pour une expérience utilisateur optimale.

## Livrables

### Dashboard fonctionnel :

Interface utilisateur prête à l'emploi pour visualiser les données des modules.

Données actualisées dynamiquement ou via soumission manuelle.

### Backend PHP :

Scripts PHP pour la gestion de la base de données et l'intégration frontend.

Endpoint API (si requis).

### Documentation :

Fichier SQL pour créer la base de données.

Guide d'installation et d'utilisation du projet.

## Objectif Client

Offrir une solution intuitive et performante pour le suivi des données clés de modules de Formule 1, en simplifiant la prise de décision pour les équipes techniques et stratégiques.

## Prochaine étape

Démarrer le développement en phase avec les besoins précis du client. Des itérations régulières avec feedback permettront de garantir que la solution correspond aux attentes.

