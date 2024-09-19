<?php
// superadmin_dashboard.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user' || $_SESSION['user_role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Gestionar Usuarios</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Configuración</li>
            <li class="breadcrumb-item active">Usuarios</li>
        </ol>
    </div>
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10">
            <i class="ti-settings text-white"></i>
        </button>
    </div>  
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="accordionBasic" class="widget-header">
                    <div class="text-left">
                        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#formularioregistros">
                            <i class="fa fa-plus"></i> Agregar Usuario
                        </button>
                    </div>
                </div>
                <!-- Tabla para listar usuarios -->
                <div class="table-responsive mb-4 mt-4">
                    <table id="tbllistado" class="table table-striped table-bordered" style="width:100%">
                        <thead style="background-color: #2A3E52; color: white;">
                            <tr>
                                <th width="5%">ID</th>                                
                                <th width="10%">Empresa</th>
                                <th width="10%">Puesto de Trabajo</th>
                                <th width="20%">DNI</th>                                
                                <th width="20%">Nombre Completo</th>
                                <th width="10%">Email</th>
                                <th width="10%">Rol</th>
                                <th width="5%">Estado</th>
                                <th width="10%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal para guardar usuario -->
                <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-material m-t-40" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="company_id">Empresa</label>
                                            <select class="form-control" id="company_id" name="company_id" required>
                                                <!-- Las opciones se cargarán dinámicamente aquí -->
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="job_id">Puesto de Trabajo</label>
                                            <select class="form-control" id="job_id" name="job_id" required>
                                                <!-- Las opciones se cargarán dinámicamente aquí -->
                                            </select>
                                        </div>


                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="nacionality">Nacionalidad</label>
                                            <select class="form-control" id="nacionality" name="nacionality" required>
                                                
                                                <option value="Peruana">Peruana</option>
                                                <option value="Venezolana">Venezolana</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Boliviana">Boliviana</option>
                                                <option value="Brasileña">Brasileña</option>
                                                <option value="Chilena">Chilena</option>
                                                <option value="Colombiana">Colombiana</option>
                                                <option value="Cubana">Cubana</option>
                                                <option value="Ecuatoriana">Ecuatoriana</option>
                                                <option value="Guatemalteca">Guatemalteca</option>
                                                <option value="Haitiana">Haitiana</option>
                                                <option value="Hondureña">Hondureña</option>
                                                <option value="Jamaicana">Jamaicana</option>
                                                <option value="Mexicana">Mexicana</option>
                                                <option value="Nicaragüense">Nicaragüense</option>
                                                <option value="Panameña">Panameña</option>
                                                <option value="Paraguaya">Paraguaya</option>
                                                <option value="Puertorriqueña">Puertorriqueña</option>
                                                <option value="Salvadoreña">Salvadoreña</option>
                                                <option value="Uruguaya">Uruguaya</option>
                                                <option value="Dominicana">Dominicana</option>
                                                <option value="Costarricense">Costarricense</option>
                                                <option value="Trinitense">Trinitense</option>
                                                <option value="Beliceña">Beliceña</option>
                                                <option value="Canadiense">Canadiense</option>
                                                <option value="Estadounidense">Estadounidense</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                            <label for="username">DNI</label>
                                            <input class="form-control" type="hidden" id="id" name="id">
                                            <input class="form-control" type="text" id="username" name="username" maxlength="8" placeholder="DNI" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="lastname">Apellido Paterno</label>
                                            <input class="form-control" type="text" id="lastname" name="lastname" maxlength="100" placeholder="Apellido Paterno" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="surname">Apellido Materno</label>
                                            <input class="form-control" type="text" id="surname" name="surname" maxlength="100" placeholder="Apellido Materno" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for="names">Nombres</label>
                                            <input class="form-control" type="text" id="names" name="names" maxlength="100" placeholder="Nombres" required>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="email">Email</label>
                                            <input class="form-control" type="email" id="email" name="email" maxlength="100" placeholder="Email" required>
                                        </div>


                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="role">Rol</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="user">Usuario</option>
                                                <option value="superadmin">Super Administrador</option>
                                                <option value="adminrh">Administrador RRHH</option>
                                                <option value="adminpr">Administrador Procura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Guardar
                                    </button>
                                    <button class="btn btn-secondary" data-dismiss="modal">
                                        <i class="flaticon-cancel-12"></i>Cancelar
                                    </button>
                                </form>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal para actualizar usuario -->
                <div class="modal fade" id="formularioActualizar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form  class="form-material m-t-40" id="formActualizar" method="POST">
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
                                            <label for="nacionalityUpdate">Nacionalidad</label>
                                            <select class="form-control" id="nacionalityUpdate" name="nacionalityUpdate" required > 
                                                <!-- Opciones de nacionalidad -->
                                                <option value="Peruana">Peruana</option>
                                                <option value="Venezolana">Venezolana</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Boliviana">Boliviana</option>
                                                <option value="Brasileña">Brasileña</option>
                                                <option value="Chilena">Chilena</option>
                                                <option value="Colombiana">Colombiana</option>
                                                <option value="Cubana">Cubana</option>
                                                <option value="Ecuatoriana">Ecuatoriana</option>
                                                <option value="Guatemalteca">Guatemalteca</option>
                                                <option value="Haitiana">Haitiana</option>
                                                <option value="Hondureña">Hondureña</option>
                                                <option value="Jamaicana">Jamaicana</option>
                                                <option value="Mexicana">Mexicana</option>
                                                <option value="Nicaragüense">Nicaragüense</option>
                                                <option value="Panameña">Panameña</option>
                                                <option value="Paraguaya">Paraguaya</option>
                                                <option value="Puertorriqueña">Puertorriqueña</option>
                                                <option value="Salvadoreña">Salvadoreña</option>
                                                <option value="Uruguaya">Uruguaya</option>
                                                <option value="Dominicana">Dominicana</option>
                                                <option value="Costarricense">Costarricense</option>
                                                <option value="Trinitense">Trinitense</option>
                                                <option value="Beliceña">Beliceña</option>
                                                <option value="Canadiense">Canadiense</option>
                                                <option value="Estadounidense">Estadounidense</option>
                                                <option value="Otros">Otros</option>
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
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="roleUpdate">Rol</label>
                                            <select class="form-control" id="roleUpdate" name="roleUpdate" required>
                                            <option value="user">Usuario</option>
                                                <option value="superadmin">Super Administrador</option>
                                                <option value="adminrh">Administrador RRHH</option>
                                                <option value="adminpr">Administrador Procura</option>
                                            </select>
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
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>


                <!-- Modal para ver el historial de accesos -->
                <div class="modal fade" id="modalHistorial" role="dialog" aria-labelledby="modalHistorialLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHistorialLabel">Historial de Acceso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="tblHistorial" class="table table-striped table-bordered" style="width:100%">
                                    <thead style="background-color: #2A3E52; color: white;">
                                        <tr>
                                            <th width="50%">Hora de Acceso</th>
                                            <th width="50%">Hora de Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Carga de scripts -->
<?php
require 'layout/footer.php';
?>
<script src="scripts/user.js"></script>