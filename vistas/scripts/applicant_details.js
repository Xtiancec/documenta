$(document).ready(function () {
    // Cargar los datos personales si ya existen
    cargarDatosPersonales();

    // Formulario para registrar datos
    $("#formApplicantDetailsRegister").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($("#formApplicantDetailsRegister")[0]);

        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=guardar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status) {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#28a745"
                    }).showToast();
                    cargarDatosPersonales();
                } else {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc3545"
                        
                    }).showToast();
                }
            }
        });
    });

    // Mostrar formulario de actualización al hacer clic en "Editar Perfil"
    $("#btnEditarPerfil").on("click", function () {
        $("#datosRegistrados").hide();
        $("#formApplicantDetailsUpdate").show();
        
        // Llenar el formulario de actualización con los datos actuales
        cargarDatosEnFormularioDeActualizacion();
    });

    // Formulario para actualizar datos
    $("#formApplicantDetailsUpdate").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($("#formApplicantDetailsUpdate")[0]);

        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=actualizar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status) {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#28a745"
                    }).showToast();
                    cargarDatosPersonales();
                } else {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc3545"
                    }).showToast();
                }
            }
        });
    });

    // Función para cargar datos del usuario en el panel de detalles
    function cargarDatosPersonales() {
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=mostrar",
            type: "POST",
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === false) {
                    // Mostrar el formulario de registro si no hay datos
                    $("#formApplicantDetailsRegister").fadeIn();
                    $("#formApplicantDetailsUpdate").hide();
                    $("#datosRegistrados").hide();
                } else {
                    // Mostrar los datos y el botón de editar si ya existen datos
                    $("#formApplicantDetailsRegister").hide();
                    $("#formApplicantDetailsUpdate").hide();
                    $("#datosRegistrados").fadeIn();

                    // Llenar los datos registrados
                    $("#verPhone").text(data.phone);
                    $("#verEmergencyPhone").text(data.emergency_contact_phone);
                    $("#verGender").text(data.gender);
                    $("#verBirthDate").text(data.birth_date);
                    $("#verMaritalStatus").text(data.marital_status);
                    $("#verChildrenCount").text(data.children_count);
                    $("#verBirthplace").text(data.birthplace);
                    $("#verEducationLevel").text(data.education_level);
                }
            },
            error: function () {
                alert("Error al cargar los datos personales.");
            }
        });
    }

    // Función para cargar los datos en el formulario de actualización
    function cargarDatosEnFormularioDeActualizacion() {
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=mostrar",
            type: "POST",
            success: function (response) {
                var data = JSON.parse(response);
                if (data) {
                    // Llenar los campos con los datos obtenidos
                    $("#phoneUpdate").val(data.phone);
                    $("#emergency_contact_phoneUpdate").val(data.emergency_contact_phone);
                    $("#genderUpdate").val(data.gender);
                    $("#birth_dateUpdate").val(data.birth_date);
                    $("#marital_statusUpdate").val(data.marital_status);
                    $("#children_countUpdate").val(data.children_count);
                    $("#birthplaceUpdate").val(data.birthplace);
                    $("#education_levelUpdate").val(data.education_level);
                }
            },
            error: function () {
                alert("Error al cargar los datos para actualización.");
            }
        });
    }

    $(document).ready(function () {
        // Mostrar el perfil cuando se hace clic en "Regresar a Mi Perfil"
        $("#btnBackToProfile").on("click", function () {
            $("#formApplicantDetailsUpdate").hide();
            $("#datosRegistrados").fadeIn();
        });
    });
});
