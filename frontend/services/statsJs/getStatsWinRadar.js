// Déclaration globale du graphique radar
let radarChart = null;

export async function fetchRadarData() {
    try {
        const response = await fetch('frontend/services/getStatsWin.php'); // Appel AJAX au backend
        const data = await response.json();

        
        // Extraire les labels (module_id) et les valeurs (victoires)
        const fuel = data.map(module => module.fuel_consumption);
        const victories = data.map(module => module.victories);
        console.log('Données radar récupérées:', victories);

        const ctx = document.getElementById('radarChart').getContext('2d');

        // Si un graphique existe déjà, le détruire avant d'en créer un nouveau
        if (radarChart) {
            radarChart.destroy();
        }

        // Création du Radar Chart
        radarChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: victories,
                datasets: [{
                    label: 'Nombre de victoires',
                    data: victories, // Nombre de victoires par module
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgb(255, 159, 64)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(255, 159, 64)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 159, 64)'
                },
                {
                    label: 'Essence consomée',
                    data: fuel, // Nombre de victoires par module
                    backgroundColor: 'rgba(17, 0, 165, 0.2)',
                    borderColor: 'rgb(62, 0, 177)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(62, 0, 177)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(62, 0, 177)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    r: { // Axe radial (Radar)
                        beginAtZero: true
                    }
                }
            }
        });

        console.log('RadarChart créé:', radarChart);

    } catch (error) {
        console.error('Erreur lors de la récupération des données radar:', error);
    }
}
