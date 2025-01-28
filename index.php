<?php
require_once './database/db.php';

// Tester une requête simple
try {
    $query = $pdo->query("SELECT 'Connexion OK' AS message;");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    echo $result['message']; // Affichera "Connexion OK"
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution : " . $e->getMessage();
}
