// Déclaration globale du graphique radar
let radarChart = null;
let currentModuleId = null;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function() {
            const moduleId = this.getAttribute('data-id');  // Récupérer l'id du module
            currentModuleId = moduleId;
            fetchRadarData(moduleId);;  // Récupérer les données spécifiques au module
        });
    });
});

export async function fetchRadarData(currentModuleId) {
    try {
        const response = await fetch(`frontend/services/getStatsWin.php?module_id=${currentModuleId}`);
        const data = await response.json();

        // Vérifier s'il y a une erreur ou si les données sont vides
        if (data.error) {
            console.error(data.error);
            return;
        }

        // Extraire les labels (module_id) et les valeurs (victoires)
        const fuel = data.map(item => item.fuel_consumption);  
        const victories = data.map(item => item.victories);
        
        const ctx = document.getElementById(`radarChart-${currentModuleId}`).getContext('2d');

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
                    label: 'Litres / 100 km',
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
    } catch (error) {
        console.error('Erreur lors de la récupération des données radar:', error);
    }
}
