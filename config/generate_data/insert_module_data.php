<?php

$path = realpath('C:/Users/Brocolis/Desktop/PROJET/WEBREATHE_TEST/database/db.php');
require_once $path;

try {
    if (!$pdo) {
        error_log("Connexion à la base de données échouée.");
        exit;
    }

    // Récupérer tous les modules
    $modulesQuery = "SELECT module_id FROM modules";
    $modulesStmt = $pdo->query($modulesQuery);
    $modules = $modulesStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($modules as $module) {
        $moduleId = $module['module_id'];
        $tableName = "module_" . $moduleId;

        // Vérifier si la table existe
        $checkTableQuery = "SELECT 1 FROM information_schema.tables WHERE table_name = '$tableName'";
        $tableExists = $pdo->query($checkTableQuery)->fetch();

        if (!$tableExists) {
            // Créer la table si elle n'existe pas
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
            $pdo->exec($createTableQuery);
            echo "Table $tableName créée.\n";
        } else {
            echo "La table pour le module $moduleId existe déjà.\n";
        }

        // Générer des valeurs aléatoires
        $avrg_speed = rand(100, 350);
        $kilometres = rand(1000, 50000);
        $tires_status = ['Neuf', 'Usé', 'Endommagé'][rand(0, 2)];
        $tires_changed = rand(0, 5);
        $fuel_status = rand(10, 100);
        $fuel_consumption = rand(2, 15);
        $brakes_changed = rand(0, 1);
        $brakes_status = ['Bon', 'Moyen', 'Mauvais'][rand(0, 2)];
        $victories = rand(0, 20);
        $image_url = 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.nicepng.com%2Fmaxp%2Fu2y3q8q8q8i1o0w7%2F&psig=AOvVaw3bz9SlHwzREmYGjU6oPV8k&ust=1738855058527000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCICXhIbqrIsDFQAAAAAdAAAAABAn';

        // Insérer les données dans la table correspondante
        $insertQuery = "INSERT INTO $tableName (
            module_id, avrg_speed, kilometres, tires_status, tires_changed, 
            fuel_status, fuel_consumption, brakes_changed, brakes_status, victories, updated_at
        ) VALUES (
            :module_id, :avrg_speed, :kilometres, :tires_status, :tires_changed, 
            :fuel_status, :fuel_consumption, :brakes_changed, :brakes_status, :victories, NOW()
        )";

        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([
            ':module_id' => $moduleId,
            ':avrg_speed' => $avrg_speed,
            ':kilometres' => $kilometres,
            ':tires_status' => $tires_status,
            ':tires_changed' => $tires_changed,
            ':fuel_status' => $fuel_status,
            ':fuel_consumption' => $fuel_consumption,
            ':brakes_changed' => $brakes_changed,
            ':brakes_status' => $brakes_status,
            ':victories' => $victories,
        ]);

        echo "Données insérées pour $tableName\n";
    }
} catch (PDOException $e) {
    error_log("Erreur SQL : " . $e->getMessage());
    echo "Script PB !";
}

sleep(100000);
?>
