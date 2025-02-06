<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

// Vérifier si le module_id est passé
if (isset($_GET['module_id']) && !empty($_GET['module_id'])) {

    $moduleId = $_GET['module_id']; // Récupération sécurisée

    // Vérification de l'existence de la table dans la base de données (calculs)
    $checkTableQuery = "SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_name = 'calculs'
    ) AS table_exists";
    
    $stmt = $pdo->prepare($checkTableQuery);
    $stmt->execute();
    $tableExists = $stmt->fetch(PDO::FETCH_ASSOC)['table_exists'];
    
    if ($tableExists) {
        // Requête SQL pour récupérer les données du module dans la table 'calculs'
        $query = "SELECT * FROM calculs WHERE module_id = :module_id ORDER BY created_at DESC LIMIT 500";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':module_id', $moduleId, PDO::PARAM_INT);
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
        echo json_encode(["error" => "La table 'calculs' n'existe pas."]);
    }
} else {
    echo json_encode(["error" => "Module ID invalide ou manquant."]);
}
?>
