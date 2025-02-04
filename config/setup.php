<?php

// Inclure la connexion PDO (assurez-vous que votre fichier db.php est correct)
require_once 'database/db.php'; 

// Inclure Bootstrap pour l'affichage
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">';

try {
    // Vérifier si la base de données existe déjà
    $dbName = $_ENV['DB_NAME'];
    
    // Vérifier l'existence de la base de données dans PostgreSQL
    $result = $pdo->query("SELECT 1 FROM pg_catalog.pg_database WHERE datname = '$dbName'");
    if (!$result->fetch()) {
        // Si la base de données n'existe pas, créer la base de données
        $pdo->exec("CREATE DATABASE $dbName");
        $alerts .= '<div class="container mt-3">
        <div class="card border-warning" id="alert-card-bdd">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-3"></i>
                <div>
                    <h5 class="card-title text-warning">Information</h5>
                    <p class="card-text">Base de données créée avec succès.</p>
                </div>
            </div>
        </div>
      </div>';
    } else {
        $alerts .= '<div class="container mt-3 p-3">
                <div class="card border-warning" id="alert-card-bdd">
                <button type="button" class="btn-close ms-auto m-2 position-absolute" data-bs-dismiss="alert" aria-label="Close" id="close-alert-bdd"></button>
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-3"></i>
                        <div>
                            <h5 class="card-title text-warning">Information</h5>
                            <p class="card-text">La base de données existe déjà.</p>
                        </div>
                    </div>
                </div>
              </div>';
    }

    // Se connecter à la base de données créée
    $pdo = new PDO("pgsql:host={$_ENV['DB_HOST']};dbname=$dbName", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

    // Création de la table modules si elle n'existe pas
    $createTableQuery = "
    CREATE TABLE IF NOT EXISTS modules (
        module_id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        category VARCHAR(100),
        name VARCHAR(255) NOT NULL,
        avg_speed NUMERIC(10, 2),
        brakes_installed INTEGER,
        brakes_status VARCHAR(50),
        tires_installed INTEGER,
        tires_status VARCHAR(50),
        fuel_type VARCHAR(50),
        fuel_per_lap NUMERIC(10, 2),
        driver_name VARCHAR(255),
        victories INTEGER DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    // Exécution de la requête pour créer la table
    $pdo->exec($createTableQuery);
    $alerts .= '<div class="container mt-3 p-3">
            <div class="card border-warning" id="alert-card-table">
            <button type="button" class="btn-close ms-auto position-absolute" data-bs-dismiss="alert" aria-label="Close" id="close-alert-table"></button>
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-3"></i>
                    <div>
                        <h5 class="card-title text-warning">Information</h5>
                        <p class="card-text">Table modules créée avec succès (si elle n\'existait pas).</p>
                    </div>
                </div>
            </div>
        </div>';
    
    // Ajouter les contraintes si elles n'existent pas
    // Vérification de l'existence de la contrainte valid_brakes_status
    $constraintExistsQuery = "
        SELECT 1 FROM pg_constraint WHERE conname = 'valid_brakes_status';
    ";
    // Exécution de la requête :
    $constraintResult = $pdo->query($constraintExistsQuery);
    // Vérification résultats : 
    if (!$constraintResult->fetch()) {
        // Ajout de la contrainte valid_brakes_status
        $addBrakesStatusConstraintQuery = "
        ALTER TABLE modules
        ADD CONSTRAINT valid_brakes_status CHECK (brakes_status IN ('Neufs', 'Usés', 'À remplacer'));
        ";
        // Execution de requete
        $pdo->exec($addBrakesStatusConstraintQuery);
        echo "Contrainte valid_brakes_status ajoutée.\n";
    }
    // Même chose pour les pneus
    $constraintExistsQuery = "
    SELECT 1 FROM pg_constraint WHERE conname = 'valid_tires_status';
    ";
    $constraintResult = $pdo->query($constraintExistsQuery);
    if (!$constraintResult->fetch()) {
        $addTiresStatusConstraintQuery = "
        ALTER TABLE modules
        ADD CONSTRAINT valid_tires_status CHECK (tires_status IN ('Neufs', 'Usés', 'À remplacer'));
        ";
        $pdo->exec($addTiresStatusConstraintQuery);
        echo "Contrainte valid_tires_status ajoutée.\n";
    }

} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution des requêtes
    die("Erreur de connexion ou d'exécution : " . $e->getMessage());
}
?>

<script>
    document.getElementById("close-alert-bdd").addEventListener("click", function() {
        var alertCard = document.getElementById("alert-card-bdd");
        alertCard.style.display = "none";
    });

    document.getElementById("close-alert-table").addEventListener("click", function() {
        var alertCard = document.getElementById("alert-card-table");
        alertCard.style.display = "none";
    });
</script>
