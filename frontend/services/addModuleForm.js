document.addEventListener('DOMContentLoaded', () => {
  const addModuleForm = document.getElementById('addModuleForm');
  const modulesContainer = document.querySelector('.row');

  // Fonction pour charger les modules depuis la BDD dynamiquement
  async function loadModules() {
    try {
      const response = await fetch('frontend/services/getModules.php');
      const modules = await response.json();

      // Vider l'affichage actuel
      modulesContainer.innerHTML = '';

      // Générer le contenu
      modules.forEach(module => {
        const moduleCard = `
        <div class="col-md-6 mb-3"> <!-- Ajout d'une colonne pour aligner les cartes -->
          <div class="card shadow-sm my-1 mx-1" data-id="${module.module_id}">
            <div class="card-header">
              <canvas id="chart-${module.module_id}" width="400" height="200"></canvas>
            </div>
            <i class="fa-solid fa-chart-line fw-bold text-warning p-3 position-relative align-self-end"></i>
            
            <div class="card-body">
              <h5 class="card-title">${module.title}</h5>
      
              <div class="d-flex flex-wrap">
                <span class="badge bg-primary me-2">${module.category}</span>
              </div>
      
              <p class="card-text mt-3">
                <strong>Type de carburant :</strong> ${module.fuel_type}<br>
                <strong>Pilote :</strong> ${module.driver_name}<br>
                <strong>Dernière mise à jour :</strong> ${new Date(module.updated_at).toLocaleDateString()}
              </p>
            </div>
          </div>
        </div>
      `;
        modulesContainer.innerHTML += moduleCard;
      });
    } catch (error) {
      console.error('Erreur lors du chargement des modules', error);
    }
  }

  if (addModuleForm) {
    addModuleForm.addEventListener('submit', async (event) => {
      event.preventDefault(); // Empêche le rechargement de la page

      // Récupérer les données du formulaire
      const formData = new FormData(addModuleForm);

      try {
        const response = await fetch('frontend/services/addModule.php', {
          method: 'POST',
          body: formData,
        });

        if (response.ok) {
          const result = await response.json();
          console.log(result); // Affiche la réponse JSON pour débug

          // Exécuter le script pour créer la table dynamique du module
          fetch('../../config/create_module_tables.php')
            .then(() => {
              console.log('Tables modules vérifiées/créées.');
              loadModules(); // Rafraîchit les modules après ajout
              location.reload();
            })
            .catch(error => console.error('Erreur lors de la vérification des tables modules:', error));

          // Optionnel : Réinitialiser le formulaire après l'envoi
          addModuleForm.reset();
          location.reload();
        } else {
          alert('Erreur lors de l’ajout du module.');
          console.error('Erreur serveur :', response.statusText);
        }
      } catch (error) {
        console.error('Erreur réseau ou JS :', error);
      }
    });
  }
});
