let myChart = null;
let currentModuleId = null;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function() {
            const moduleId = this.getAttribute('data-id');  // Récupérer l'id du module
            currentModuleId = moduleId;
            fetchData(currentModuleId);  // Récupérer les données spécifiques au module
        });
    });
});

export async function fetchData(currentModuleId) {
    try {
        const response = await fetch(`frontend/services/getStats.php?module_id=${currentModuleId}`);  // Appel au fichier PHP qui retourne les données
        const data = await response.json();

        // Vérifier s'il y a une erreur ou si les données sont vides
        if (data.error) {
            console.error(data.error);
            return;
        }

        // Préparer les données pour le graphique
        const speeds = data.map (s => s.avrg_speed);  // Utiliser la vitesse moyenne pour les données du graphique
        const ctx = document.getElementById(`myChart-${currentModuleId}`).getContext('2d');

            // Créer un nouveau graphique
            myChart = new Chart(ctx, {
                type: 'line',  // Type de graphique
                data: {
                    labels: speeds,  // Utiliser l'ID du module comme label
                    datasets: [{
                        label: 'Vitesse moyenne',
                        data: speeds,  // Données (vitesse moyenne du module)
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                          ],
                          borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                          ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
}
