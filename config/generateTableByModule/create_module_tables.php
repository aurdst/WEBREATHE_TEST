<?php

require_once 'database/db.php';

try  {
    $dbName = $_ENV['DB_NAME'];

    $pdo = new PDO("pgsql:host={$_ENV['DB_HOST']};dbname=$dbName", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        
    // Récupérer les modules existants
    $query = "SELECT module_id FROM modules";
    $result = $pdo->query($query);

    // Pour chaque module, créer une table spécifique qui va recevoir
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $module_id = $row['module_id'];

        $tableName = "module_" . $module_id;

        $checkTableQuery = "SELECT 1 FROM information_schema.tables WHERE table_name = '$tableName'";
        $tableExists = $pdo->query($checkTableQuery)->fetch();

        if (!$tableExists) {
            // Créer la table pour ce module
            $createTableQuery = "
            CREATE TABLE $tableName (
                id SERIAL PRIMARY KEY,
                module_id INTEGER NOT NULL,
                avrg_speed INTEGER,
                kilometres INTEGER,
                tires_status VARCHAR(50),
                tires_changed INTEGER,
                fuel_status NUMERIC(10, 2),
                fuel_consumption NUMERIC(10, 2),
                brakes_changed BOOLEAN,
                brakes_status VARCHAR(50),
                victories INTEGER,
                image_url VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (module_id) REFERENCES modules(module_id) ON DELETE CASCADE
            );";
                // Exécution de la création de la table
                $pdo->exec($createTableQuery);
            } 
    }

} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution des requêtes
    die("Erreur de connexion ou d'exécution : " . $e->getMessage());
}

?>