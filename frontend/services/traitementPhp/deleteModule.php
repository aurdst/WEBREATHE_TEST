<?php

require_once '../../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer l'ID du module à supprimer
        $moduleId = $_POST['module_id'] ?? '';

        // Vérification de l'ID
        if (empty($moduleId)) {
            http_response_code(400); // Mauvaise requête
            echo json_encode(['message' => 'ID du module requis.']);
            exit;
        }

        // Vérifier si le module existe
        $checkQuery = "SELECT image_url FROM modules WHERE module_id = :module_id";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([':module_id' => $moduleId]);
        $module = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if (!$module) {
            http_response_code(404); // Module non trouvé
            echo json_encode(['message' => 'Module introuvable.']);
            exit;
        }

        // Si le module a une image associée, on la supprime du dossier
        if (!empty($module['image_url']) && file_exists($module['image_url'])) {
            unlink($module['image_url']);
        }

        // Suppression du module
        $query = "DELETE FROM modules WHERE module_id = :module_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':module_id' => $moduleId]);

        // Réponse JSON en cas de succès
        echo json_encode(['message' => 'Module supprimé avec succès.']);
    } catch (Exception $e) {
        http_response_code(500); // Erreur serveur
        echo json_encode(['message' => 'Erreur serveur.', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
