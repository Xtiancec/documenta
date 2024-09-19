<?php

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card" style="max-height: 80vh; overflow-y: auto;">
            <div class="card-body">
                <h2>Subir Documentos</h2>
                <p>Sube tus documentos obligatorios y opcionales según tu puesto de trabajo.</p>

                <!-- Select para la selección de puestos -->
                <div class="form-group">
                    <label for="position_id">Selecciona tu puesto:</label>
                    <select name="position_id" id="position_id" class="form-control" required></select>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#obligatorios" role="tab">Documentos Obligatorios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#opcionales" role="tab">Documentos Opcionales</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="obligatorios" role="tabpanel">
                        <div class="p-20" id="document-list-obligatorios">
                            <!-- Aquí se cargarán los documentos obligatorios dinámicamente -->
                        </div>
                    </div>

                    <div class="tab-pane" id="opcionales" role="tabpanel">
                        <div class="p-20" id="document-list-opcionales">
                            <!-- Aquí se cargarán los documentos opcionales dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Contenedor para el historial de documentos -->
                <div id="document-history-container" class="mt-4">
                    <!-- Aquí se cargará el historial de documentos subidos -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/documentUpload.js"></script>

<?php
require 'layout/footer.php';
?>
