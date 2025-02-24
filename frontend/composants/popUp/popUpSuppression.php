<!-- Modal -->
<div class="modal fade" id="popUpDelete" tabindex="-1" aria-labelledby="deleteModuleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModuleModalLabel">
          Êtes-vous sûr de vouloir supprimer le module "<span id='moduleName'></span>" ?
          Cette action est irréversible.
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="deleteModuleForm">
          <input type="hidden" id="module_id_to_delete" name="module_id">
          <button type="submit" class="btn btn-danger">Oui</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
        </form>
      </div>
    </div>
  </div>
</div>
