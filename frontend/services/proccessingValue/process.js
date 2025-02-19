document.addEventListener("DOMContentLoaded", function () {
    function updateModuleStatus(moduleId, status) {
        // Décommenter pour voir les status des calcul en cours
        // console.log(`Mise à jour du module ${moduleId} → ${status}`);

        const statusBadge = document.querySelector(`.module-status[data-id='${moduleId}']`);

        if (!statusBadge) {
            console.warn(`Module ID ${moduleId} non trouvé !`);
            return;
        }

        let message = "";
        switch (status) {
            case "en cours de calcul":
                statusBadge.textContent = "En cours de calcul";
                statusBadge.className = "badge bg-success module-status"; // Vert
                message = "En cours de calcul";
                break;
            case "calcul ralenti":
                statusBadge.textContent = "Calcul ralenti";
                statusBadge.className = "badge bg-warning module-status"; // Orange
                message = "Calcul ralenti";
                break;
            case "calcul interrompu":
                statusBadge.textContent = "Calcul interrompu";
                statusBadge.className = "badge bg-danger module-status"; // Rouge
                message = "Calcul interrompu";
                break;
            default:
                statusBadge.textContent = "En attente";
                statusBadge.className = "badge bg-secondary module-status"; // Gris
                message = "En attente";
        }
        // Envoi des informations au serveur via AJAX (Mis en pause pour evité la surcharge de données)
        // Décommenter pour simuler les calculs
        // sendModuleStatusToServer(moduleId, status, message);
    }

    function sendModuleStatusToServer(moduleId, status, message) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "frontend/services/saveCalculStatus.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(`Statut du module ${moduleId} enregistré avec succès.`);
            }
        };
        xhr.send(`module_id=${moduleId}&status=${status}&message=${encodeURIComponent(message)}`);
    }

    function getRandomDelay(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function cycleModuleStatus(moduleId) {
        setTimeout(() => {
            updateModuleStatus(moduleId, "en cours de calcul");
            setTimeout(() => {
                updateModuleStatus(moduleId, "calcul ralenti");
                setTimeout(() => {
                    updateModuleStatus(moduleId, "calcul interrompu");

                    // 🔁 Relance le cycle après un délai aléatoire (entre 5 et 10 sec avant le redémarrage)
                    setTimeout(() => cycleModuleStatus(moduleId), getRandomDelay(5000, 10000));

                }, getRandomDelay(3000, 15000)); // Durée avant "calcul interrompu"
            }, getRandomDelay(6000, 20000)); // Durée avant "calcul ralenti"
        }, getRandomDelay(2000, 15000)); // Durée avant "en cours de calcul"
    }

    document.querySelectorAll(".module-status").forEach((el) => {
        const moduleId = el.getAttribute("data-id");
        cycleModuleStatus(moduleId); // Démarre le cycle en boucle pour chaque module
    });
});
