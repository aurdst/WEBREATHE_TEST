<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once './database/db.php';
require_once __DIR__ . '/config/setup.php';
// require_once __DIR__ . '/config/clearTables.php'; // Nettoie les tables inutilisés
require_once __DIR__ . '/config/generateTableByModule/create_module_tables.php';

use Models\Module;

// A inséré ici => Voir dans config/set_models.php pour la l'initiation manuelle d'un module

// Tester une requête simple
try {
    $query = $pdo->query("SELECT 'Connexion OK' AS message;");
    $result = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution : " . $e->getMessage();
}
?>

<?php

try {
    // Récupérer les modules
    $query = "SELECT * FROM modules";
    $result = $pdo->query($query);
} catch (PDOException $e) {
    die("Erreur de connexion ou d'exécution : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard F1</title>
    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container my-2">
    <h1 class="text-center mb-4">Listes des véhicules.</h1>
    <?php include 'frontend/composants/bouton/boutonAdd.php'; ?>
    <?php include 'frontend/composants/formulaire/formulaire.php'; ?>

    <!-- GRAPHIQUE -->
    <div class="container my-2">
        <h1 class="text-center mb-4">Dashboard F1 - Vitesse moyenne du véhicule</h1>
        <canvas id="myChart" width="200" height="100"></canvas>
    </div>

    <!-- GRAPHIQUE RADAR -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Dashboard F1 - Nombre de victoires par module</h1>
        <canvas id="radarChart" width="200" height="200"></canvas>
    </div>


    <div class="row">
        <?php while ($module = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($module['title']); ?></h5>

                        <div class="d-flex flex-wrap">
                            <span class="badge bg-primary me-2"><?php echo htmlspecialchars($module['category']); ?></span>
                        </div>

                        <p class="card-text mt-3">
                            <strong>Type de carburant :</strong> <?php echo htmlspecialchars($module['fuel_type']); ?><br>
                            <strong>Pilote :</strong> <?php echo htmlspecialchars($module['driver_name']); ?><br>
                            <strong>Dernière mise à jour :</strong> <?php echo date('d M Y', strtotime($module['updated_at'])); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="frontend/services/addModuleForm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    import { fetchData } from './frontend/services/getStats.js';
    import { fetchRadarData } from './frontend/services/statsJs/getStatsWinRadar.js';

    // Appeler la fonction pour récupérer les données et créer le graphique
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
        fetchRadarData();
    });
</script>

</body>
</html>