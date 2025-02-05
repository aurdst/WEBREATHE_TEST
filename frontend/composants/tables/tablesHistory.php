<!-- Modal -->
<div class="modal fade" id="showHistory" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">Historique du Véhicules</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date de création</th>
              <th>Vitesse Moyenne</th>
              <th>Km parcourus</th>
              <th>État des pneus</th>
              <th>Plaquettes changées</th>
              <th>État du carburant</th>
              <th>Consommation</th>
              <th>Freins changés</th>
              <th>État des freins</th>
              <th>Victoires</th>
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
