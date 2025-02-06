<div class="modal fade" id="showCalculHistory" tabindex="-1" aria-labelledby="historyCalculModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyCalculModalLabel">Historique des Calcul</h5>
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
          <tbody id="historyCalculContainer">
            <!-- Données injectées ici dynamiquement -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
.bg-success {
  background-color: #28a745 !important; /* Vert */
}

.bg-warning {
  background-color: #fd7e14 !important; /* Orange */
}

.bg-danger {
  background-color: #dc3545 !important; /* Rouge */
}
.badge {
  padding: 5px 10px;
  font-size: 12px;
  border-radius: 10px;
}
</style>