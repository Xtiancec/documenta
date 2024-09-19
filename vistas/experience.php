<?php
session_start(); // Iniciar sesión

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
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Registrar Experiencia Laboral y Educacional</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item active">Registrar Experiencia</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Formulario para registrar experiencia educativa -->
                <h3>Registrar Experiencia Educativa</h3>
                <form class="form-material m-t-40" id="formEducation" method="POST">
                    <table class="table table-bordered table-striped table-hover" id="tablaExperienciaEducativa">
                        <thead class="thead-light">
                            <tr>
                                <th>Institución</th>
                                <th>Tipo de Educación</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Duración</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Las filas se agregarán dinámicamente -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="btnAddEducacion"><i class="fa fa-plus-square"></i> Agregar Fila</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Experiencia Educativa</button>
                </form>

                <!-- Formulario para registrar experiencia laboral -->
                <h3 class="mt-5">Registrar Experiencia Laboral</h3>
                <form class="form-material m-t-40" id="formWork" method="POST">
                    <table class="table table-bordered table-striped table-hover" id="tablaExperienciaLaboral">
                        <thead class="thead-light">
                            <tr>
                                <th>Empresa</th>
                                <th>Puesto</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Acción</th>
                            </tr>
                        </theaad>
                        <tbody>
                            <!-- Las filas se agregarán dinámicamente -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="btnAddTrabajo"><i class="fa  fa-plus-square"></i> Agregar Fila</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Experiencia Laboral</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout/footer.php';
?>


<script src="scripts/experience.js"></script>