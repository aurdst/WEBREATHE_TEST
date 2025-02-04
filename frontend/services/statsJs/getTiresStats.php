<?php
require_once '../../../database/db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_GET['module_id']) || empty($_GET['module_id'])) {
    echo json_encode(["error" => "Module ID invalide ou manquant."]);
    exit;
}

$moduleId = $_GET['module_id'];
$tableName = 'module_' . $moduleId;

// Vérifier l'existence de la table
$checkTableQuery = "SELECT EXISTS (
    SELECT FROM information_schema.tables WHERE table_name = :tableName
) AS table_exists";

$stmt = $pdo->prepare($checkTableQuery);
$stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
$stmt->execute();
$tableExists = $stmt->fetch(PDO::FETCH_ASSOC)['table_exists'] ?? false;

if (!$tableExists) {
    echo json_encode(["error" => "La table pour ce module n'existe pas."]);
    exit;
}

$query = "SELECT 
            SUM(CASE WHEN tires_status = 'Neuf' THEN 1 ELSE 0 END) AS new_tires,
            SUM(CASE WHEN tires_status = 'Usé' THEN 1 ELSE 0 END) AS used_tires,
            SUM(CASE WHEN tires_status = 'Endommagé' THEN 1 ELSE 0 END) AS damaged_tires,
            SUM(CASE WHEN tires_status IN ('Neuf', 'Usé') THEN 1 ELSE 0 END) AS good_condition,
            SUM(CASE WHEN tires_status = 'Endommagé' THEN 1 ELSE 0 END) AS need_replacement
            FROM \"$tableName\"
            LIMIT 10";

$stmt = $pdo->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_NAMED);

if (!empty($data)) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
} else {
    echo json_encode(["error" => "Aucune donnée trouvée pour ce module."]);
}
exit;
?>
