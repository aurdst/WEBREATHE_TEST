<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $query = "SELECT victories, module_id, fuel_consumption FROM module_40 LIMIT 30";
    $stmt = $pdo->query($query);

    // Vérifier si la requête a réussi
    if (!$stmt) {
        echo json_encode(["error" => "Erreur lors de l'exécution de la requête."]);
        exit;
    }

    // Tableau pour stocker les données
    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

?>
