// Déclare myChart en dehors de la fonction pour un scope global
let myChart = null;

export async function fetchData() {
    try {
        const response = await fetch('frontend/services/getStats.php');  // Appel au fichier PHP qui retourne les données
        const data = await response.json();
        console.log('data dans le script js', data);

        // Préparer les données pour le graphique
        const speeds = data.map(module => module.avrg_speed); // Utiliser la vitesse moyenne pour les données du graphique
        console.log('Vitesse moyenne:', speeds);

        const labels = data.map(module => module.title);  // Ajouter les titres des modules comme labels

        const ctx = document.getElementById('myChart').getContext('2d');

        // Si un graphique existe déjà, le détruire avant de créer un nouveau
        if (myChart) {
            myChart.destroy();
        }

        // Créer un nouveau graphique
        myChart = new Chart(ctx, {
            type: 'line',  // Type de graphique
            data: {
                labels: speeds,  // Titres des modules
                datasets: [{
                    label: 'Vitesse moyenne',
                    data: speeds,  // Données (vitesse moyenne des modules)
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
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

        console.log('Graphique créé:', myChart);

    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
}
