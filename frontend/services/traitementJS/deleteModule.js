// Fonction globale pour ouvrir la pop-up de confirmation
window.openDeleteModal = function(moduleId, moduleName) {
    const moduleIdInput = document.getElementById('module_id_to_delete');
    const moduleNameSpan = document.getElementById('moduleName');
    const popUpDelete = new bootstrap.Modal(document.getElementById('popUpDelete'));
    
    moduleIdInput.value = moduleId;
    moduleNameSpan.textContent = moduleName;
    popUpDelete.show();
};

// Fonction pour forcer la fermeture de la modale et du backdrop
function forceCloseModal() {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
        document.body.classList.remove('modal-open');
        document.body.style.overflow = 'auto'; // Réactive le scroll de la page
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const deleteModuleForm = document.getElementById('deleteModuleForm');
        if (deleteModuleForm) {
            deleteModuleForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                const formData = new FormData();
                formData.append('module_id', document.getElementById('module_id_to_delete').value);

                try {
                    const response = await fetch('frontend/services/traitementPhp/deleteModule.php', {
                        method: 'POST',
                        body: formData,
                    });

                    if (response.ok) {
                        const result = await response.json();
                        console.log(result.message);

                        // Fermeture de la modale
                        const popUpDelete = bootstrap.Modal.getInstance(document.getElementById('popUpDelete'));
                        popUpDelete.hide();
                        
                        // Forcer la suppression du backdrop
                        forceCloseModal();
                        
                        // Recharger la page
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression du module.');
                    }
                    
                } catch (error) {
                    console.error('Erreur réseau ou JS :', error);
                }
            });
        } else {
            console.error('Le formulaire de suppression n\'a pas été trouvé.');
        }
    }, 500); // Attendre 500ms pour être sûr que le DOM est prêt
});

document.getElementById('popUpDelete').addEventListener('hidden.bs.modal', () => {
    forceCloseModal();
});
