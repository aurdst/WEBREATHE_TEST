<!-- Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModuleModalLabel">Ajouter un nouveau module</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addModuleForm">
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
            <input type="text" class="form-control" id="category" name="category" required>
          </div>
          <div class="mb-3">
            <label for="fuelType" class="form-label">Type de carburant</label>
            <input type="text" class="form-control" id="fuelType" name="fuel_type" required>
          </div>
          <div class="mb-3">
            <label for="driverName" class="form-label">Nom du pilote</label>
            <input type="text" class="form-control" id="driverName" name="driver_name" required>
          </div>
          <div class="mb-3">
              <label for="description" class="form-label">Description :</label>
              <textarea class="form-control" id="description" name="description" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
</div>
