// frontend/services/addModuleForm.js

document.addEventListener('DOMContentLoaded', () => {
    // Récupérer le formulaire via son ID
    const addModuleForm = document.getElementById('addModuleForm');
    const modulesContainer = document.querySelector('.row');

    // Fonction pour charger les modules depuis la bdd dynamiquement
    async function loadModules() {
      try {
        const response = await fetch('frontend/services/getModules.php');
        const modules = await response.json();

        // Vider l'affichage actuel
        modulesContainer.innerHTML = '';

        // Générer le contenu
        modules.forEach(module => {
          const moduleCard = `
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
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
          `
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

            fetch('./frontend/services/addModule.php', {
                  method: 'POST',
                  body: formData
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Exécuter le script pour créer la table dynamique du module
                      fetch('../../config/create_module_tables.php')
                          .then(() => {
                              console.log('Tables modules vérifiées/créées.');
                              loadModules();
                          })
                          .catch(error => console.error('Erreur lors de la vérification des tables modules:', error));
                  } else {
                      console.error('Erreur:', data.error);
                  }
              });
            
            // Optionnel : Réinitialiser le formulaire après l'envoi
            addModuleForm.reset();

            // Refresh les données
            console.log("Chargement des modules après ajout...");
            loadModules();
          } else {
            alert('Erreur lors de l’ajout du module.');
            console.error('Erreur serveur :', response.statusText);
          }
        } catch (error) {
          console.error('Erreur réseau ou JS :', error);
        }
      });
    }
  });
  