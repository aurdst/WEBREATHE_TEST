<?php

$path = realpath('C:/Users/Brocolis/Desktop/PROJET/WEBREATHE_TEST/database/db.php');
require_once $path;

try {
    if (!$pdo) {
        error_log("Connexion à la base de données échouée.");
        exit;
    }

    // Récupérer tous les module_id existants dans la table modules
    $modulesQuery = "SELECT module_id FROM modules";
    $modulesStmt = $pdo->query($modulesQuery);
    $existingModules = $modulesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Extraire les module_id dans un tableau pour comparaison
    $existingModuleIds = array_map(function($module) {
        return "modules_" . $module['module_id'];
    }, $existingModules);

    // Récupérer toutes les tables existantes
    $tablesQuery = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'";
    $tablesStmt = $pdo->query($tablesQuery);
    $existingTables = $tablesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Comparer les tables existantes avec les modules en base
    foreach ($existingTables as $table) {
        $tableName = $table['table_name'];
        // Si la table n'existe pas dans les modules, on la supprime
        if (strpos($tableName, 'modules_') === 0 && !in_array($tableName, $existingModuleIds)) {
            // Table à supprimer
            $dropTableQuery = "DROP TABLE IF EXISTS $tableName";
            $pdo->exec($dropTableQuery);
            echo "Table $tableName supprimée.\n";
        }
    }

    // Ajouter ici ta logique de création et insertion si nécessaire.

} catch (PDOException $e) {
    error_log("Erreur SQL : " . $e->getMessage());
    echo "Script PB !";
}

sleep(100000);
?>
