document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button[data-module-id]'); // Sélectionne tous les boutons avec data-module-id

    buttons.forEach(button => {
        button.addEventListener('click', async () => {
            const moduleId = button.dataset.moduleId;

            // Attends que la modal soit affichée
            const updateModal = new bootstrap.Modal(document.getElementById('updateModuleModal'));
            updateModal.show();

            try {
                const response = await fetch(`/frontend/services/getModuleById.php?id=${moduleId}`);
                const module = await response.json();
      
                // Vérification et affichage des données dans le formulaire
                if (module) {
                    document.getElementById('module_id').value = module.module_id;
                    document.getElementById('title').value = module.title;
                    document.getElementById('name').value = module.name;
                    document.getElementById('category').value = module.category;
                    document.getElementById('fuelType').value = module.fuel_type;
                    document.getElementById('driverName').value = module.driver_name;
                    document.getElementById('description').value = module.description;
                } else {
                    console.error('Module non trouvé.');
                }
            } catch (error) {
                console.error('Erreur lors du chargement des modules', error);
            }
        });
    });

    // Gestion de la soumission du formulaire
    const updateModuleForm = document.getElementById('updateModuleForm');
    if (updateModuleForm) {
        updateModuleForm.addEventListener('submit', async (event) => {
            event.preventDefault();
    
            const formData = new FormData(updateModuleForm);
            try {
                const response = await fetch('/frontend/services/updateModule.php', {
                    method: 'POST',
                    body: formData,
                });
    
                if (response.ok) {
                    const result = await response.json();
                    console.log(result);
                    location.reload(); // Recharge la page après la mise à jour
                } else {
                    alert('Erreur lors de la mise à jour du module.');
                    console.error('Erreur serveur :', response.statusText);
                }
            } catch (error) {
                console.error('Erreur réseau ou JS :', error);
            }
        });
    }
});
