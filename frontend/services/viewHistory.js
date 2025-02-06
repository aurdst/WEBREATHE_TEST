document.addEventListener('DOMContentLoaded', () => {
    const historyContainer = document.getElementById('historyContainer');

    async function openHistory(moduleId) {
        try {
            const response = await fetch(`frontend/services/viewHistory.php?module_id=${moduleId}`);
            const history = await response.json();

            console.log(history)

            // Vérification des erreurs retournées par PHP
            if (history.error) {
                historyContainer.innerHTML = `<tr><td colspan="10" class="text-center text-danger">${history.error}</td></tr>`;
                return;
            }

            // Vider l'affichage actuel
            historyContainer.innerHTML = '';

            // Générer les lignes du tableau
            history.forEach(h => {
                const historyRow = `
                    <tr>
                        <td>${new Date(h.created_at).toLocaleDateString()}</td>
                        <td>${h.avrg_speed} km/h</td>
                        <td>${h.kilometres} km</td>
                        <td>${h.tires_status}</td>
                        <td>${h.tires_changed ? 'Oui' : 'Non'}</td>
                        <td>${h.fuel_status} %</td>
                        <td>${h.fuel_consumption} L</td>
                        <td>${h.brakes_changed ? 'Oui' : 'Non'}</td>
                        <td>${h.brakes_status}</td>
                        <td>${h.victories}</td>
                    </tr>
                `;
                historyContainer.innerHTML += historyRow;
            });

        } catch (err) {
            console.error('Erreur lors du chargement de l\'historique', err);
            historyContainer.innerHTML = `<tr><td colspan="10" class="text-center text-danger">Impossible de charger les données</td></tr>`;
        }
    }
    // Ajout d'un écouteur sur tous les boutons "Historique"
    document.addEventListener('click', (event) => {
    // Vérifier si l'élément cliqué est un bouton "Historique"
        if (event.target.classList.contains('historique-btn')) {
            event.preventDefault();

            const moduleId = event.target.getAttribute('data-module-id');
            console.log("Bouton cliqué, Module ID :", moduleId);

            if (moduleId) {
                openHistory(moduleId);
            } else {
                console.error("Aucun module ID trouvé !");
            }
        }
    });
});
