<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

// Vérifier si le module_id est passé
if (isset($_GET['module_id'])) {

    if (!isset($_GET['module_id']) || empty($_GET['module_id'])) {
        echo json_encode(["error" => "Module ID invalide ou manquant."]);
        exit;
    }
    
    $moduleId = $_GET['module_id']; // Récupération sécurisée

    // Générer le nom de la table à partir du module_id
    $tableName = 'module_' . $moduleId;

    // Script PostGresql pour check les tables
    $checkTableQuery = "SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_name = :tableName
    ) AS table_exists";
    
    $stmt = $pdo->prepare($checkTableQuery);
    $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
    $stmt->execute();
    $tableExists = $stmt->fetch(PDO::FETCH_ASSOC)['table_exists'];
    
    if ($tableExists) {
        // Requête SQL pour récupérer les données spécifiques au module_id
        $query = "SELECT * FROM \"$tableName\" ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        // Récupérer les données
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Vérifier si des données ont été trouvées
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(["error" => "Aucune donnée trouvée pour ce module."]);
        }
    } else {
        echo json_encode(["error" => "La table pour ce module n'existe pas."]);
    }
}
?>