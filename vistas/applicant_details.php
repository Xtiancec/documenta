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
        <h3 class="text-themecolor">Registrar/Actualizar Datos Personales</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Postulantes</li>
            <li class="breadcrumb-item active">Registrar/Actualizar Datos</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form  class="form-material m-t-40" id="formApplicantDetailsRegister" method="POST" style="display:none;">
                    <div class="card shadow-sm border rounded-lg" style="border-color: #17a2b8; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h4 class="text-info mb-4 font-weight-bold text-center"><i class="fa fa-user-plus"></i> Registrar Datos Personales</h4>

                            <!-- Fila 1: Nivel Educativo y Género -->
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="education_level" class="font-weight-bold"><i class="fa fa-graduation-cap"></i> Nivel Educativo</label>
                                    <input type="text" class="form-control rounded-lg" id="education_level" name="education_level" maxlength="255" placeholder="Ej: Superior">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="gender" class="font-weight-bold"><i class="fa fa-venus-mars"></i> Género</label>
                                    <select class="form-control rounded-lg" id="gender" name="gender" required>
                                        <option value="" disabled selected>Selecciona tu género</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Fila 2: Teléfono y Teléfono de Emergencia -->
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="phone" class="font-weight-bold"><i class="fa fa-phone"></i> Teléfono</label>
                                    <input type="text" class="form-control rounded-lg" id="phone" name="phone" maxlength="15" placeholder="Ingresa tu teléfono" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="emergency_contact_phone" class="font-weight-bold"><i class="fa fa-phone-square"></i> Teléfono de Emergencia</label>
                                    <input type="text" class="form-control rounded-lg" id="emergency_contact_phone" name="emergency_contact_phone" maxlength="15" placeholder="Teléfono de emergencia">
                                </div>
                            </div>

                            <!-- Fila 3: Estado Civil y Cantidad de Hijos -->
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="marital_status" class="font-weight-bold"><i class="fa fa-life-ring"></i> Estado Civil</label>
                                    <select class="form-control rounded-lg" id="marital_status" name="marital_status" required>
                                        <option value="" disabled selected>Selecciona tu estado civil</option>
                                        <option value="Soltero">Soltero</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viudo">Viudo</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="children_count" class="font-weight-bold"><i class="fa fa-child"></i> Cantidad de Hijos</label>
                                    <input type="number" class="form-control rounded-lg" id="children_count" name="children_count" min="0" placeholder="Cantidad de hijos">
                                </div>
                            </div>

                            <!-- Fila 4: Lugar de Nacimiento y Fecha de Nacimiento -->
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="birthplace" class="font-weight-bold"><i class="fa fa-map-marker"></i> Lugar de Nacimiento</label>
                                    <input type="text" class="form-control rounded-lg" id="birthplace" name="birthplace" maxlength="255" placeholder="Lugar de nacimiento" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="birth_date" class="font-weight-bold"><i class="fa fa-birthday-cake"></i> Fecha de Nacimiento</label>
                                    <input type="date" class="form-control rounded-lg" id="birth_date" name="birth_date" required>
                                </div>
                            </div>

                            <!-- Botón de Envío -->
                            <button type="submit" class="btn btn-primary btn-block rounded-lg font-weight-bold">
                                <i class="fa fa-save"></i> Guardar Datos
                            </button>

                        </div>
                    </div>
                </form>






                <div class="row justify-content-center">
                    <div class="col-6 ">
                        <div id="datosRegistrados" style="display:none;">
                            <div class="card shadow-sm border rounded-lg" style="border-color: #17a2b8; border-radius: 15px;">
                                <div class="card-body p-4">
                                    <h2 class="text-info mb-4 font-weight-bold text-center">
                                        <i class="fa fa-user-check "></i> Mis Datos Personales Registrados
                                    </h2>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-phone fa-lg text-info mr-3"></i>
                                                <span><strong>Teléfono:</strong></span>
                                            </div>
                                            <span id="verPhone" class="text-muted">999999999</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-phone-square fa-lg text-info mr-3"></i>
                                                <span><strong>Teléfono de Emergencia:</strong></span>
                                            </div>
                                            <span id="verEmergencyPhone" class="text-muted">3333</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-venus-mars fa-lg text-info mr-3"></i>
                                                <span><strong>Género:</strong></span>
                                            </div>
                                            <span id="verGender" class="text-muted">Masculino</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-birthday-cake fa-lg text-info mr-3"></i>
                                                <span><strong>Fecha de Nacimiento:</strong></span>
                                            </div>
                                            <span id="verBirthDate" class="text-muted">1992-07-03</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-life-ring fa-lg text-info mr-3"></i>
                                                <span><strong>Estado Civil:</strong></span>
                                            </div>
                                            <span id="verMaritalStatus" class="text-muted">Soltero</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-child fa-lg text-info mr-3"></i>
                                                <span><strong>Cantidad de Hijos:</strong></span>
                                            </div>
                                            <span id="verChildrenCount" class="text-muted">1</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-map-marker fa-lg text-info mr-3"></i>
                                                <span><strong>Lugar de Nacimiento:</strong></span>
                                            </div>
                                            <span id="verBirthplace" class="text-muted">Lima</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-graduation-cap fa-lg text-info mr-3"></i>
                                                <span><strong>Nivel Educativo:</strong></span>
                                            </div>
                                            <span id="verEducationLevel" class="text-muted">Superior</span>
                                        </li>
                                    </ul>
                                    <button id="btnEditarPerfil" class="btn btn-info btn-lg btn-block rounded-lg font-weight-bold" style="border: none; padding: 12px 0;">
                                        <i class="fa fa-edit"></i> Editar Perfil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





                <!-- Formulario para actualizar datos -->

                <form class="form-material m-t-40" id="formApplicantDetailsUpdate" method="POST" style="display:none;">
                    <div class="card shadow-sm border rounded-lg" style="border-color: #17a2b8; border-radius: 15px;">
                        <div class="card-body p-4">
                            <h2 class="text-info mb-4 font-weight-bold text-center"><i class="fa fa-user-edit"></i> Actualizar Datos Personales</h2>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="education_levelUpdate" class="font-weight-bold"><i class="fa fa-graduation-cap"></i> Nivel Educativo</label>
                                    <input type="text" class="form-control rounded-lg" id="education_levelUpdate" name="education_levelUpdate" maxlength="255">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="genderUpdate" class="font-weight-bold"><i class="fa fa-venus-mars"></i> Género</label>
                                    <select class="form-control rounded-lg" id="genderUpdate" name="genderUpdate" required>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="phoneUpdate" class="font-weight-bold"><i class="fa fa-phone"></i> Teléfono</label>
                                    <input type="text" class="form-control rounded-lg" id="phoneUpdate" name="phoneUpdate" maxlength="15" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="emergency_contact_phoneUpdate" class="font-weight-bold"><i class="fa fa-phone-square"></i> Teléfono de Emergencia</label>
                                    <input type="text" class="form-control rounded-lg" id="emergency_contact_phoneUpdate" name="emergency_contact_phoneUpdate" maxlength="15">
                                </div>

                            </div>



                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="marital_statusUpdate" class="font-weight-bold"><i class="fa fa-life-ring"></i> Estado Civil</label>
                                    <select class="form-control rounded-lg" id="marital_statusUpdate" name="marital_statusUpdate" required>
                                        <option value="Soltero">Soltero</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viudo">Viudo</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="children_countUpdate" class="font-weight-bold"><i class="fa fa-child"></i> Cantidad de Hijos</label>
                                    <input type="number" class="form-control rounded-lg" id="children_countUpdate" name="children_countUpdate" min="0">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="birthplaceUpdate" class="font-weight-bold"><i class="fa fa-map-marker"></i> Lugar de Nacimiento</label>
                                    <input type="text" class="form-control rounded-lg" id="birthplaceUpdate" name="birthplaceUpdate" maxlength="255" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                    <label for="birth_dateUpdate" class="font-weight-bold"><i class="fa fa-birthday-cake"></i> Fecha de Nacimiento</label>
                                    <input type="date" class="form-control rounded-lg" id="birth_dateUpdate" name="birth_dateUpdate" required>
                                </div>

                            </div>


                            <div class="row justify-content-center">
                                <!-- Botón de actualización -->
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded-lg font-weight-bold">
                                        <i class="fas fa-sync-alt"></i> Actualizar Datos
                                    </button>
                                </div>

                                <!-- Botón de regresar al perfil -->
                                <div class="col-md-2">
                                    <button type="button" id="btnBackToProfile" class="btn btn-secondary btn-lg btn-block rounded-lg font-weight-bold">
                                        <i class="fa fa-arrow-left"></i> Regresar a Mi Perfil
                                    </button>
                                </div>
                            </div>

                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>

<?php
require 'layout/footer.php';
?>

<script src="scripts/applicant_details.js"></script>