<?php

namespace Models;

class Module {
    private $pdo;

    // Propriétés
    public $module_id;
    public $title;
    public $description;
    public $category;
    public $name;
    public $avg_speed;
    public $brakes_installed;
    public $brakes_status;
    public $tires_installed;
    public $tires_status;
    public $fuel_type;
    public $fuel_per_lap;
    public $driver_name;
    public $victories;
    public $created_at;
    public $updated_at;

    // Constructeur avec la connexion PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter un module
    public function create() {
        try {
            $query = "INSERT INTO modules (title, description, category, name, avg_speed, brakes_installed, brakes_status, tires_installed, tires_status, fuel_type, fuel_per_lap, driver_name, victories, created_at, updated_at)
                      VALUES (:title, :description, :category, :name, :avg_speed, :brakes_installed, :brakes_status, :tires_installed, :tires_status, :fuel_type, :fuel_per_lap, :driver_name, :victories, NOW(), NOW())";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':avg_speed', $this->avg_speed);
            $stmt->bindParam(':brakes_installed', $this->brakes_installed);
            $stmt->bindParam(':brakes_status', $this->brakes_status);
            $stmt->bindParam(':tires_installed', $this->tires_installed);
            $stmt->bindParam(':tires_status', $this->tires_status);
            $stmt->bindParam(':fuel_type', $this->fuel_type);
            $stmt->bindParam(':fuel_per_lap', $this->fuel_per_lap);
            $stmt->bindParam(':driver_name', $this->driver_name);
            $stmt->bindParam(':victories', $this->victories);
    
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Erreur lors de l'exécution de la requête.");
            }
        } catch (PDOException $e) {
            // Si une erreur PDO se produit
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        } catch (Exception $e) {
            // Si une autre erreur se produit
            die("Erreur : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer tous les modules
    public function getAll() {
        $query = "SELECT * FROM modules";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un module par ID
    public function getById($module_id) {
        $query = "SELECT * FROM modules WHERE module_id = :module_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour un module
    public function update() {
        $query = "UPDATE modules SET title = :title, description = :description, category = :category, name = :name, avg_speed = :avg_speed, brakes_installed = :brakes_installed, brakes_status = :brakes_status, tires_installed = :tires_installed, tires_status = :tires_status, fuel_type = :fuel_type, fuel_per_lap = :fuel_per_lap, driver_name = :driver_name, victories = :victories, updated_at = NOW() WHERE module_id = :module_id";
        
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(':module_id', $this->module_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':avg_speed', $this->avg_speed);
        $stmt->bindParam(':brakes_installed', $this->brakes_installed);
        $stmt->bindParam(':brakes_status', $this->brakes_status);
        $stmt->bindParam(':tires_installed', $this->tires_installed);
        $stmt->bindParam(':tires_status', $this->tires_status);
        $stmt->bindParam(':fuel_type', $this->fuel_type);
        $stmt->bindParam(':fuel_per_lap', $this->fuel_per_lap);
        $stmt->bindParam(':driver_name', $this->driver_name);
        $stmt->bindParam(':victories', $this->victories);

        return $stmt->execute();
    }

    // Méthode pour supprimer un module
    public function delete() {
        $query = "DELETE FROM modules WHERE module_id = :module_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':module_id', $this->module_id);
        return $stmt->execute();
    }
}
