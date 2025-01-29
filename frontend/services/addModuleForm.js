// frontend/services/addModuleForm.js

document.addEventListener('DOMContentLoaded', () => {
    // Récupérer le formulaire via son ID
    const addModuleForm = document.getElementById('addModuleForm');
  
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
            console.log(result); // Affiche la réponse JSON pour déboguer
  
            // Optionnel : Réinitialiser le formulaire après l'envoi
            addModuleForm.reset();
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
  