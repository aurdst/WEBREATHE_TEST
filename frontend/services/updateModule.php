<?php
require_once '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $moduleId = $_POST['module_id'] ?? '';
        $title = $_POST['title'] ?? '';
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $fuel_type = $_POST['fuel_type'] ?? '';
        $driver_name = $_POST['driver_name'] ?? '';
        $description = $_POST['description'] ?? '';
        $image_url = $_POST['image_url'] ?? '';

        if (empty($moduleId) || empty($title) || empty($category) || empty($fuel_type) || empty($driver_name)) {
            http_response_code(400);
            echo json_encode(['message' => 'Tous les champs sont requis.']);
            exit;
        }

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $imagePath = $uploadDir . basename($_FILES['image_url']['name']);
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
                $image_url = $imagePath;
            }
        }

        $query = "UPDATE modules SET 
                    title = :title,
                    name = :name,
                    category = :category,
                    fuel_type = :fuel_type,
                    driver_name = :driver_name,
                    description = :description,
                    image_url = :image_url,
                    updated_at = NOW()
                  WHERE module_id = :module_id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':name' => $name,
            ':category' => $category,
            ':fuel_type' => $fuel_type,
            ':driver_name' => $driver_name,
            ':description' => $description,
            ':image_url' => $image_url,
            ':module_id' => $moduleId,
        ]);

        echo json_encode(['message' => 'Module mis à jour avec succès.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur serveur.', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
