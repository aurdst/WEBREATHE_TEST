<?php 
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    if (!$pdo) {
        echo json_encode(["error" => "Connexion à la base de données échouée."]);
        exit;
    }

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "ID du module non fourni."]);
        exit;
    }

    $moduleId = htmlspecialchars($_GET['id']);
    $query = "SELECT * FROM modules WHERE module_id = :moduleId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':moduleId', $moduleId, PDO::PARAM_STR);
    $stmt->execute();

    $module = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($module) {
        echo json_encode($module);
    } else {
        echo json_encode(["error" => "Module non trouvé."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de la récupération du module : " . $e->getMessage()]);
}
