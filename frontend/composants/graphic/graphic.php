<div class="graphics-container" style="display: none;">
    <div class="container mb-4">
        <div class="row">
            <!-- Graphique Barres -->
            <div class="col-md-6 d-flex flex-column align-items-center">
                <p class="text-center my-2">Vitesse moyenne du véhicule</p>
                <div class="bg-light rounded p-3 shadow-sm w-100">
                    <canvas id="myChart-<?php echo $module['module_id']; ?>"></canvas>
                </div>
            </div>

            <!-- Graphique Radar -->
            <div class="col-md-6 d-flex flex-column align-items-center">
                <p class="text-center my-2">Nombre de victoires</p>
                <div class="bg-light rounded p-3 shadow-sm w-100">
                    <canvas id="radarChart-<?php echo $module['module_id']; ?>"></canvas>
                </div>
            </div>

            <!-- Graphique Doughnut (Répartition des types de pneus) -->
            <div class="col-md-6 d-flex flex-column align-items-center">
                <p class="text-center my-2">Répartition des types de pneus</p>
                <div class="bg-light rounded p-3 shadow-sm w-100">
                    <canvas id="doughnutChart-<?php echo $module['module_id']; ?>"></canvas>
                </div>
            </div>

            <!-- Graphique Pie (État global des pneus) -->
            <div class="col-md-6 d-flex flex-column align-items-center">
                <p class="text-center my-2">État global des pneus</p>
                <div class="bg-light rounded p-3 shadow-sm w-100">
                    <canvas id="pieChart-<?php echo $module['module_id']; ?>"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>