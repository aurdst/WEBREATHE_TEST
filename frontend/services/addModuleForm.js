// frontend/services/addModuleForm.js

document.addEventListener('DOMContentLoaded', () => {
    // Récupérer le formulaire via son ID
    const addModuleForm = document.getElementById('addModuleForm');
    const modulesContainer = document.querySelector('.row');

    // Fonction pour charger les modules depuis la bdd dynamiquement
    async function loadModules() {
      try {
        console.log("Appel de getModules.php...");
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

    // Appel de la function
    loadModules();
  
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
            alert('Module ajouté avec succès !');
            console.log(result); // Affiche la réponse JSON pour débug
            
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
  