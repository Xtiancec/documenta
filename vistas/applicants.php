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
        <h3 class="text-themecolor">Gestionar Postulantes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Configuración</li>
            <li class="breadcrumb-item active">Postulantes</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="accordionBasic" class="widget-header">
                    <div class="text-left">
                        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#formularioregistros">
                            <i class="fa fa-plus"></i> Agregar Postulante
                        </button>
                    </div>
                </div>

                <!-- Tabla para listar postulantes -->
                <div class="table-responsive mb-4 mt-4">
                    <table id="tbllistado" class="table table-striped table-bordered" style="width:100%">
                        <thead style="background-color: #2A3E52; color: white;">
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Nombre Completo</th>
                                <th>Empresa</th>
                                <th>Puesto</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal para agregar postulante -->
                <div class="modal fade" id="formularioregistros" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Postulante</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para agregar postulante -->
                                <form class="form-material m-t-40" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="company_id">Empresa</label>
                                            <select class="form-control" id="company_id" name="company_id" required></select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="job_id">Puesto de Trabajo</label>
                                            <select class="form-control" id="job_id" name="job_id" required></select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="username">DNI</label>
                                            <input class="form-control" type="text" id="username" name="username" maxlength="8" placeholder="DNI" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="lastname">Apellido Paterno</label>
                                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Apellido Paterno" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="surname">Apellido Materno</label>
                                            <input class="form-control" type="text" id="surname" name="surname" placeholder="Apellido Materno" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="names">Nombres</label>
                                            <input class="form-control" type="text" id="names" name="names" placeholder="Nombres" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="email">Email</label>
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para actualizar postulante -->
                <div class="modal fade" id="formularioActualizar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Postulante</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-material m-t-40" id="formActualizar" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="company_idUpdate">Empresa</label>
                                            <select class="form-control" id="company_idUpdate" name="company_idUpdate" required>
                                                <!-- Las opciones se cargarán dinámicamente aquí -->
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="job_idUpdate">Puesto de Trabajo</label>
                                            <select class="form-control" id="job_idUpdate" name="job_idUpdate" required>
                                                <!-- Las opciones se cargarán dinámicamente aquí -->
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="usernameUpdate">DNI</label>
                                            <input class="form-control" type="hidden" id="idUpdate" name="idUpdate">
                                            <input class="form-control" type="text" id="usernameUpdate" name="usernameUpdate" maxlength="8" placeholder="DNI" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="lastnameUpdate">Apellido Paterno</label>
                                            <input class="form-control" type="text" id="lastnameUpdate" name="lastnameUpdate" maxlength="100" placeholder="Apellido Paterno" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="surnameUpdate">Apellido Materno</label>
                                            <input class="form-control" type="text" id="surnameUpdate" name="surnameUpdate" maxlength="100" placeholder="Apellido Materno" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="namesUpdate">Nombres</label>
                                            <input class="form-control" type="text" id="namesUpdate" name="namesUpdate" maxlength="100" placeholder="Nombres" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="emailUpdate">Email</label>
                                            <input class="form-control" type="email" id="emailUpdate" name="emailUpdate" maxlength="100" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Guardar Cambios
                                    </button>
                                    <button class="btn btn-secondary" data-dismiss="modal">
                                        <i class="flaticon-cancel-12"></i>Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>

<script src="scripts/applicants.js"></script>