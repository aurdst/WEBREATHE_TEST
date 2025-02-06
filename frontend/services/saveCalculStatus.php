<?php

// Inclure la connexion à la base de données
require_once '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées
    $moduleId = $_POST['module_id'] ?? null;
    $status = $_POST['status'] ?? null;
    $message = $_POST['message'] ?? null;

    // Affichage des valeurs reçues dans les logs pour vérification
    error_log("Module ID: $moduleId");
    error_log("Status: $status");
    error_log("Message: $message");

    // if ($moduleId && $status && $message) {
    //     try {
    //         // Préparer la requête d'insertion
    //         $query = "INSERT INTO calculs (module_id, status, message, created_at) VALUES (:module_id, :status, :message, NOW())";
    //         $stmt = $pdo->prepare($query);

    //         // Lier les paramètres
    //         $stmt->bindParam(':module_id', $moduleId);
    //         $stmt->bindParam(':status', $status);
    //         $stmt->bindParam(':message', $message);

    //         // Exécuter la requête
    //         if ($stmt->execute()) {
    //             echo "Statut du module enregistré avec succès.";
    //         } else {
    //             // Si l'exécution échoue, afficher un message d'erreur
    //             error_log("Erreur d'exécution de la requête : " . implode(", ", $stmt->errorInfo()));
    //             echo "Erreur lors de l'enregistrement du statut.";
    //         }
    //     } catch (PDOException $e) {
    //         error_log("Erreur PDO : " . $e->getMessage());
    //         echo "Erreur de connexion à la base de données.";
    //     }
    // } else {
    //     error_log("Paramètres manquants dans la requête : module_id=$moduleId, status=$status, message=$message");
    //     echo "Paramètres manquants dans la requête.";
    // }
}
?>
