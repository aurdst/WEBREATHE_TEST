<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once './database/db.php';
require_once __DIR__ . '/config/setup.php';

use Models\Module;

// Création d'un objet Module
// $module = new Module($pdo);

// Remplir les propriétés avec les données à insérer
// $module->title = "Module F1";
// $module->description = "Module de voiture de Formule 1.";
// $module->category = "Voiture";
// $module->name = "Mercedes";
// $module->avg_speed = 250.50;
// $module->brakes_installed = 4;
// $module->brakes_status = "Neufs";
// $module->tires_installed = 4;
// $module->tires_status = "Neufs";
// $module->fuel_type = "Essence";
// $module->fuel_per_lap = 2.5;
// $module->driver_name = "Lewis Hamilton";
// $module->victories = 5;

// Appeler la méthode pour ajouter le module
// if ($module->create()) {
//     echo "Module ajouté avec succès.";
// } else {
//     echo "Erreur lors de l'ajout du module.";
// }

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
    <title>Modules Dashboard</title>
    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Dashboard</h1>
    <?php include 'frontend/composants/bouton/boutonAdd.php'; ?>
    <?php include 'frontend/composants/formulaire/formulaire.php'; ?>
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

</body>
</html>