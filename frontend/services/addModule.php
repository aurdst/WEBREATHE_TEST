<?php

require_once '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer les données envoyées
        $title = $_POST['title'] ?? '';
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $fuel_type = $_POST['fuel_type'] ?? '';
        $driver_name = $_POST['driver_name'] ?? '';
        $description = $_POST['description'] ?? '';

        // Validation basique
        if (empty($title) || empty($category) || empty($fuel_type) || empty($driver_name)) {
            http_response_code(400);
            echo json_encode(['message' => 'Tous les champs sont requis.']);
            exit;
        }

        // Préparation et exécution
        $query = "INSERT INTO modules (title, name, category, fuel_type, driver_name, description) VALUES (:title, :name, :category, :fuel_type, :driver_name, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':name' => $name,
            ':category' => $category,
            ':fuel_type' => $fuel_type,
            ':driver_name' => $driver_name,
            ':description' => $description,
        ]);

        // Réponse JSON en cas de succès
        echo json_encode(['message' => 'Module ajouté avec succès.']);
    } catch (Exception $e) {
        http_response_code(500); // Erreur serveur
        echo json_encode(['message' => 'Erreur serveur.', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
