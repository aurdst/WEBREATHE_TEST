let charts = {}; // Stocke tous les graphiques par moduleId

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function() {
            const moduleId = this.getAttribute('data-id');  
            fetchTiresData(moduleId);  // Récupérer les données spécifiques au module
        });
    });
});

export async function fetchTiresData(currentModuleId) {
    try {
        const response = await fetch(`frontend/services/statsJs/getTiresStats.php?module_id=${currentModuleId}`);
        const data = await response.json();

        // Extraction des données
        const tireTypes = ['Neufs', 'Usés', 'Dégradés'];
        const tireStatus = ['Bon état', 'À remplacer'];

        const tireCounts = [
            data.map(nt => nt.new_tires),
            data.map(ut => ut.used_tires),
            data.map(dt => dt.damaged_tires),
        ];

        const statusCounts = [
            data.map(gc => gc.good_condition),
            data.map(nr => nr.need_replacement),
        ];

        // Sélection des contextes canvas
        const doughnutCtx = document.getElementById(`doughnutChart-${currentModuleId}`).getContext('2d');
        const pieCtx = document.getElementById(`pieChart-${currentModuleId}`).getContext('2d');

        charts[`doughnut-${currentModuleId}`] = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: tireTypes,
                datasets: [{
                    label: 'Répartition des pneus',
                    data: tireCounts,
                    backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        charts[`pie-${currentModuleId}`] = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: tireStatus,
                datasets: [{
                    label: 'État des pneus',
                    data: statusCounts,
                    backgroundColor: ['#2E86C1', '#E74C3C'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    } catch (error) {
        console.error('Erreur lors de la récupération des données pneus:', error);
    }
}
