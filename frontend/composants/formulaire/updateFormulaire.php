<!-- Modal -->
<div class="modal fade" id="updateModuleModal"
  tabindex="-1"
  aria-labelledby="updateModuleModalLabel"
  enctype="multipart/form-data"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModuleModalLabel">Mettre à jour le module</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateModuleForm" method="post">
        <input type="hidden" id="module_id" name="module_id" value="" required>
          <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select class="form-control" id="category" name="category" required>
              <option value="" disabled selected>Choisir une catégorie</option>
              <option value="F1">F1</option>
              <option value="Rallye">Rallye</option>
              <option value="Endurance">Endurance</option>
              <option value="MotoGP">MotoGP</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fuelType" class="form-label">Type de carburant</label>
            <select class="form-control" id="fuelType" name="fuel_type" required>
              <option value="" disabled selected>Choisir un type de carburant</option>
              <option value="Essence">Essence</option>
              <option value="Diesel">Diesel</option>
              <option value="Électrique">Électrique</option>
              <option value="Hybride">Hybride</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="driverName" class="form-label">Nom du pilote</label>
            <input type="text" class="form-control" id="driverName" name="driver_name" required>
          </div>
          <div class="mb-3">
              <label for="description" class="form-label">Description :</label>
              <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
          </div>
          <label for="image_url">Image du module:</label>
          <input type="file" name="image_url" id="image_url" required>
          <button type="submit" class="btn btn-success">Mettre à jour</button>
        </form>
      </div>
    </div>
  </div>
</div>
