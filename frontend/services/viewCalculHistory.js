document.addEventListener('DOMContentLoaded', () => {
    const historyCalculContainer = document.getElementById('historyCalculContainer');
    const showHistoryModal = new bootstrap.Modal(document.getElementById('showCalculHistory'));

    // Vérifie si l'élément existe avant de continuer
    if (!historyCalculContainer) {
        console.error("Le conteneur pour l'historique n'a pas été trouvé.");
        return;
    }

    // Vérifier si l'utilisateur est hors ligne
    if (!navigator.onLine) {
        showOfflineMessage();
    }

    function saveDataLocally(data) {
        localStorage.setItem('historyData', JSON.stringify(data));
    }
    
    function getLocalData() {
        const savedData = localStorage.getItem('historyData');
        return savedData ? JSON.parse(savedData) : null;
    }

    // Fonction pour déterminer la couleur de la pastille
    function getStatusClass(status) {
        if (status === 'en cours de calcul') {
            return 'bg-success';  // Vert
        } else if (status === 'calcul ralenti') {
            return 'bg-warning';  // Orange
        } else if (status === 'calcul interrompu') {
            return 'bg-danger';  // Rouge
        }
        return '';  // Si aucun état ne correspond
    }

    // Fonction pour charger l'historique
    async function openCalculHistory(moduleId) {
        const localData = getLocalData();  // Vérifier les données locales

        try {
            const response = await fetch(`frontend/services/viewCalculHistory.php?module_id=${moduleId}`);
            const history = await response.json();


            // Vérification des erreurs retournées par PHP
            if (history.error) {
                historyCalculContainer.innerHTML = `<tr><td colspan="10" class="text-center text-danger">${history.error}</td></tr>`;
                return;
            }

            saveDataLocally(history);  // Sauvegarder les données en local
            displayHistory(history);  // Afficher les données

            // Ouvrir le modal après avoir chargé l'historique
            showHistoryModal.show();

        } catch (err) {
            console.error('Erreur lors du chargement de l\'historique', err);
            historyCalculContainer.innerHTML = `<tr><td colspan="10" class="text-center text-danger">Impossible de charger les données</td></tr>`;
        }
        // if (localData) {
        //     console.log('Données locales utilisées');
        //     console.log(localData)
        //     displayHistory(localData);  // Afficher les données locales
        //     return;  // Arrêter ici si des données locales sont disponibles
        // }
    }

    // Fonction pour afficher l'historique
    function displayHistory(history) {
        historyCalculContainer.innerHTML = '';  // Vider l'affichage

        history.forEach(h => {
            const statusClass = getStatusClass(h.status);
            const historyRow = `
                <tr>
                    <td>${new Date(h.created_at).toLocaleDateString()}</td>
                    <td>
                        <span class="badge ${statusClass}">${h.status}</span>
                    </td>
                    <td>${h.message}</td>
                </tr>
            `;
            historyCalculContainer.innerHTML += historyRow;
        });
    }

    // Ajout d'un écouteur sur tous les boutons "Historique"
    document.addEventListener('click', (event) => {
        // Vérifier si l'élément cliqué est un bouton "Historique"
        if (event.target.classList.contains('historique-calcul-btn')) {
            event.preventDefault();

            const moduleId = event.target.getAttribute('data-module-id');

            if (moduleId) {
                openCalculHistory(moduleId);
            } else {
                console.error("Aucun module ID trouvé !");
            }
        }
    });

    // Gestion de la fermeture du modal (si besoin)
    const modalCloseButton = document.querySelector('[data-bs-dismiss="modal"]');
    if (modalCloseButton) {
        modalCloseButton.addEventListener('click', () => {
            console.log('Le modal est fermé');
        });
    } else {
        console.error("Le bouton de fermeture du modal n'a pas été trouvé.");
    }
});
