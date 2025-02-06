<!-- Modal -->
<div class="modal fade" id="showHistory" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">Historique du véhicule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date de création</th>
              <th>Statut</th>
              <th>Message</th>
            </tr>
          </thead>
          <tbody id="historyContainer">
            <!-- Données injectées ici dynamiquement -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
