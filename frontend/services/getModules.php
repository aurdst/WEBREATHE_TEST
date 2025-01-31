<?php 
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    if (!$pdo) {
        error_log("Connexion à la base de données échouée.");
        echo json_encode(["error" => "Connexion à la base de données échouée."]);
        exit;
    }

    $query = "SELECT * FROM modules ORDER BY updated_at DESC";
    $stmt = $pdo->query($query);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("getModules.php exécuté, modules récupérés: " . json_encode($modules));

    echo json_encode($modules);
} catch (PDOException $e) {
    error_log("Erreur SQL : " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de la récupération des modules : " . $e->getMessage()]);
}
