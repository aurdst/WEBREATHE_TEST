<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

// Récupérer les données des modules
$query = "SELECT avrg_speed, module_id FROM module_40";
$stmt = $pdo->query($query);

// Tableau pour stocker les données
$data = [];

// Récupérer chaque ligne et ajouter au tableau
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Retourner les données sous forme de JSON
echo json_encode($data);
?>
