<?php
session_start();

// Verificar si la sesión del postulante está activa
if (!isset($_SESSION['applicant_id'])) {
    // Redirigir al login si no está iniciada la sesión
    header("Location: login_postulantes.html");
    exit();
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-6 align-self-center">
        <h4 class="text-themecolor font-weight-bold">Experiencia Laboral y Educacional Registrada</h4>
    </div>
    <div class="col-md-6 align-self-center">
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item active">Ver Experiencia</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Experiencia Educativa -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 d-flex align-items-center">
                    <i class="fa fa-book mr-2"></i> Experiencia Educativa
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tablaExperienciaEducativa">
                        <thead class="thead-light">
                            <tr>
                                <th>Institución</th>
                                <th>Tipo de Educación</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Duración (meses)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas se agregarán dinámicamente desde el servidor -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Experiencia Laboral -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 d-flex align-items-center">
                    <i class="fa fa-briefcase mr-2"></i> Experiencia Laboral
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tablaExperienciaLaboral">
                        <thead class="thead-light">
                            <tr>
                                <th>Empresa</th>
                                <th>Puesto</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas se agregarán dinámicamente desde el servidor -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>

<script src="scripts/view_experience.js"></script>

<!-- Mejoras CSS -->
<style>
/* Ajuste del estilo general */
body {
    background-color: #f4f6f9;
}

/* Título de la página */
.page-titles {
    margin-bottom: 30px;
}

h4.text-themecolor {
    color: #007bff;
    font-size: 1.6rem;
}

/* Estilo de las tarjetas */
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #007bff;
    border-bottom: none;
    color: white;
    padding: 20px;
    font-weight: bold;
}

/* Mejora de tablas */
.table {
    margin-bottom: 0;
}

thead.thead-light th {
    background-color: #f8f9fa;
    color: #343a40;
    text-align: center;
}

tbody td {
    text-align: center;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

/* Breadcrumbs */
.breadcrumb {
    background: none;
    padding: 0;
}

/* Íconos */
.fa-home {
    color: #007bff;
}

/* Estilos de botones de acción */
.btn-action {
    margin-right: 5px;
    color: white;
    background-color: #007bff;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
}

.btn-action:hover {
    background-color: #0056b3;
}

/* Ajuste de márgenes y espaciado */
.mb-4 {
    margin-bottom: 1.5rem !important;
}
</style>
