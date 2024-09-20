<?php
// superadmin_dashboard.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user' || $_SESSION['user_role'] !== 'adminrh') {
    header("Location: ../login.php");
    exit();
}


require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Crear Documentos</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Configuración</li>
            <li class="breadcrumb-item active">Creación de Documentos</li>
        </ol>
    </div>

    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="accordionBasic" class="widget-header">

                    <div class="text-left">
                        <button class="btn btn-outline-primary waves-effect waves-light" data-toggle="modal" data-target="#formularioregistros">
                            <span class="btn-label"><i class="fa fa-plus"></i>
                            </span>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Agregar Documento

                                </font>
                            </font>
                        </button>
                    </div>

                  
                </div>

                <div class="table-responsive mb-4 mt-4">
                    <table id="tbllistado" class="table full-color-table full-muted-table hover-table" style="width:100%">
                        <thead style="background-color: #2A3E52; color: white;">
                            <tr>
                                <th width="10%">ID</th>
                                <th width="30%">Documento</th>
                                <th width="15%">F. Creacion</th>
                                <th width="15%">F. Actualizacion</th>
                                <th width="15%">Estado</th>
                                <th width="15%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!-- Modal para Guardar -->
                <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form class="form-material m-t-40" name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for=""> Documento</label>
                                            <input class="form-control" type="hidden" id="id" name="id">
                                            <input class="form-control" type="text" id="documentName" name="documentName" maxlength="50" placeholder="Nombre del documento" required>
                                        </div>
                                    </div>
                                    <!-- Cambié el tipo de submit a button -->
                                    <button type="button" class="btn btn-success" onclick="guardar();"><i class="fa fa-check"></i>Guardar</button>
                                    <button class="btn btn-secondary" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para Actualizar -->
                <div class="modal fade" id="formularioActualizar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form class="form-material m-t-40" name="formActualizar" id="formActualizar" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for=""> Documento</label>
                                            <input class="form-control" type="hidden" id="idUpdate" name="idUpdate">
                                            <input class="form-control" type="text" id="documentNameUpdate" name="documentNameUpdate" maxlength="50" placeholder="Nombre del area" required autofocus>
                                        </div>
                                    </div>
                                    <!-- Cambié el tipo de submit a button -->
                                    <button type="button" class="btn btn-primary actualizar" onclick="actualizar();"><i class="fa fa-check"></i>Guardar Cambios</button>
                                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Scripts finales -->
<?php
require 'layout/footer.php';
?>

<script src="scripts/documentName.js"></script>