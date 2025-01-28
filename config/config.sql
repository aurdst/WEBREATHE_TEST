-- Création de la base de données (facultatif si elle existe déjà)
CREATE DATABASE f1_dashboard;

-- Connexion à la base de données
\c f1_dashboard;

-- Création de la table des modules
CREATE TABLE modules (
    module_id SERIAL PRIMARY KEY, -- Identifiant unique
    title VARCHAR(255) NOT NULL, -- Titre du module
    description TEXT, -- Description détaillée
    category VARCHAR(100), -- Catégorie
    name VARCHAR(255) NOT NULL, -- Nom du module ou de la voiture
    avg_speed NUMERIC(10, 2), -- Vitesse moyenne (en km/h)
    brakes_installed INTEGER, -- Nombre de freins installés
    brakes_status VARCHAR(50), -- État des freins
    tires_installed INTEGER, -- Nombre de pneus installés
    tires_status VARCHAR(50), -- État des pneus
    fuel_type VARCHAR(50), -- Type de carburant
    fuel_per_lap NUMERIC(10, 2), -- Consommation de carburant par tour (en litres)
    driver_name VARCHAR(255), -- Nom du pilote
    victories INTEGER DEFAULT 0, -- Nombre de victoires
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Date de mise à jour
);

-- Ajout d'une contrainte pour valider l'état des freins et des pneus
ALTER TABLE modules
ADD CONSTRAINT valid_brakes_status CHECK (brakes_status IN ('Neufs', 'Usés', 'À remplacer'));

ALTER TABLE modules
ADD CONSTRAINT valid_tires_status CHECK (tires_status IN ('Neufs', 'Usés', 'À remplacer'));
