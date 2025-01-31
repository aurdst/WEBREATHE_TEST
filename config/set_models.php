<?php
    // Création d'un objet Module
    $module = new Module($pdo);

    // Remplir les propriétés avec les données à insérer
    $module->title = "Module F1";
    $module->description = "Module de voiture de Formule 1.";
    $module->category = "Voiture";
    $module->name = "Mercedes";
    $module->avg_speed = 250.50;
    $module->brakes_installed = 4;
    $module->brakes_status = "Neufs";
    $module->tires_installed = 4;
    $module->tires_status = "Neufs";
    $module->fuel_type = "Essence";
    $module->fuel_per_lap = 2.5;
    $module->driver_name = "Lewis Hamilton";
    $module->victories = 5;

    // Appeler la méthode pour ajouter le module
    if ($module->create()) {
        echo "Module ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du module.";
    }
?>