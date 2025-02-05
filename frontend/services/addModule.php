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
        $image_url = $_POST['image_url'] ?? '';

        $module = new stdClass();

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            // Définir le chemin de destination
            $uploadDir = 'uploads/';
            $imagePath = $uploadDir . basename($_FILES['image_url']['name']);
            
            // Déplacer l'image téléchargée vers le dossier de destination
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
                echo "Image téléchargée avec succès.";
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }

            if ($_FILES['image_url']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['message' => 'Erreur lors de l\'upload de l\'image.', 'error_code' => $_FILES['image_url']['error']]);
                exit;
            }
        
            // Affecter le chemin de l'image à la propriété image_url
            $module->image_url = $imagePath;
        }

        // Validation basique
        if (empty($title) || empty($category) || empty($fuel_type) || empty($driver_name)) {
            http_response_code(400);
            echo json_encode(['message' => 'Tous les champs sont requis.']);
            exit;
        }

        // Préparation et exécution
        $query = "INSERT INTO modules (title, name, category, fuel_type, driver_name, description, image_url)
             VALUES (:title, :name, :category, :fuel_type, :driver_name, :description, :image_url)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':name' => $name,
            ':category' => $category,
            ':fuel_type' => $fuel_type,
            ':driver_name' => $driver_name,
            ':description' => $description,
            ':image_url' => $module->image_url ?? $image_url,
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
