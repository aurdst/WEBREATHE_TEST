<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once './database/db.php';
require_once __DIR__ . '/config/setup.php';
// require_once __DIR__ . '/config/clearTables.php'; // Nettoie les tables inutilisés
require_once __DIR__ . '/config/generateTableByModule/create_module_tables.php';

use Models\Module;

// A inséré ici => Voir dans config/set_models.php pour la l'initiation manuelle d'un module
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php include 'frontend/composants/navbar.php'; ?>

<?php echo $alerts; ?>

<div class="container">
    <?php
            // Tester une requête simple
            try {
                $query = $pdo->query("SELECT 'Connexion OK' AS message;");
                $result = $query->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erreur lors de l'exécution : " . $e->getMessage();
            }

            try {
                // Récupérer les modules
                $query = "SELECT * FROM modules";
                $result = $pdo->query($query);
            } catch (PDOException $e) {
                die("Erreur de connexion ou d'exécution : " . $e->getMessage());
            }
    ?>
</div>

<div class="container w-100">
    <h1 class="text-center mb-4">Listes des véhicules.</h1>
    <?php include 'frontend/composants/bouton/boutonAdd.php'; ?>
    <?php include 'frontend/composants/formulaire/formulaire.php'; ?>
    <?php include 'frontend/composants/tables/tablesHistory.php'; ?>

    <div class="row">
    <?php while ($module = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-6 mb-3"> <!-- Ajout d'une colonne pour aligner les cartes -->
            <div class="card shadow-sm my-1 mx-1" data-id="<?php echo htmlspecialchars($module['module_id']); ?>">
                <?php include 'frontend/composants/graphic/graphic.php'; ?>
                
                <i class="fa-solid fa-chart-line fw-bold text-warning p-3 position-relative align-self-end"></i>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
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

                    <!-- Image alignée à droite -->
                    <img src="frontend/services/<?php echo htmlspecialchars($module['image_url']); ?>" alt="Image du module" class="img-fluid rounded" style="max-width: 150px; height: auto;">
                </div>
                <div class="m-3">
                    <?php 
                        $moduleId = htmlspecialchars($module['module_id']); 
                        include 'frontend/composants/bouton/historyButton.php';
                    ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

    
<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="frontend/services/addModuleForm.js"></script>
<script src="frontend/services/viewHistory.js"></script>
<script src="frontend/composants/graphic/graphicToggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    import { fetchData } from './frontend/services/getStats.js';
    import { fetchRadarData } from './frontend/services/statsJs/getStatsWinRadar.js';
    import { fetchTiresData } from './frontend/services/statsJs/tiresStatus.js'

    // Appeler la fonction pour récupérer les données et créer le graphique
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
        fetchRadarData();
        fetchTiresData();
    });
</script>

</body>
</html>