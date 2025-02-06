<?php
namespace Models;

class Calcul {
    private $pdo;

    // Propriétés
    public $calcul_id;
    public $module_id; // Référence à la table `modules`
    public $status; // Statut de calcul (par exemple: "En cours", "Terminé", "Échec")
    public $result; // Résultat du calcul
    public $message; // Message d'état ou erreur
    public $created_at;
    public $updated_at;

    // Constructeur avec la connexion PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter un calcul
    public function create() {
        try {
            $query = "INSERT INTO calculs (module_id, status, result, message, created_at, updated_at)
                      VALUES (:module_id, :status, :result, :message, NOW(), NOW())";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':module_id', $this->module_id);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':result', $this->result);
            $stmt->bindParam(':message', $this->message);
    
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Erreur lors de l'exécution de la requête.");
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer tous les calculs
    public function getAll() {
        $query = "SELECT * FROM calculs";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un calcul par ID
    public function getById($calcul_id) {
        $query = "SELECT * FROM calculs WHERE calcul_id = :calcul_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':calcul_id', $calcul_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour un calcul
    public function update() {
        $query = "UPDATE calculs SET status = :status, result = :result, message = :message, updated_at = NOW() WHERE calcul_id = :calcul_id";
        
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(':calcul_id', $this->calcul_id);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':result', $this->result);
        $stmt->bindParam(':message', $this->message);

        return $stmt->execute();
    }

    // Méthode pour supprimer un calcul
    public function delete() {
        $query = "DELETE FROM calculs WHERE calcul_id = :calcul_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':calcul_id', $this->calcul_id);
        return $stmt->execute();
    }
}
?>