<?php
require_once 'vendor/autoload.php'; // Charger automatiquement les dépendances Composer

use Dotenv\Dotenv;

// Charge les variables depuis le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// db.php : Configuration de la connexion à PostgreSQL
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$port = $_ENV['DB_PORT'];

try {
    // Connexion avec PDO
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [
        // Gestion des erreurs
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Désactiver l'émulation des requêtes
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "Connexion réussie à PostgreSQL.\n";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
