// scripts/applicant_details.js

$(document).ready(function () {
    // Inicializar validación de formularios usando Bootstrap
    inicializarValidacionFormularios();

    // Cargar los datos personales si ya existen
    cargarDatosPersonales();

    // Manejar la selección del país en el formulario de registro y actualización
    $("#pais").on("change", function () {
        var pais = $(this).val();
        manejarCambioPais(pais, "register");
    });

    $("#paisUpdate").on("change", function () {
        var pais = $(this).val();
        manejarCambioPais(pais, "update");
    });

    // Manejar la selección de archivo en el formulario de registro
    document.getElementById('photo').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ninguna foto';
        document.getElementById('file-name').textContent = fileName;

        // Previsualizar la foto seleccionada
        var file = this.files[0];
        var preview = document.getElementById('previewPhoto');
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });

    // Manejar la selección de archivo en el formulario de actualización
    document.getElementById('photoUpdate').addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ninguna foto';
        document.getElementById('file-name-update').textContent = fileName;

        // Previsualizar la foto seleccionada
        var file = this.files[0];
        var preview = document.getElementById('previewPhotoUpdate');
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });


    // Formulario para registrar datos
    $("#formApplicantDetailsRegister").on("submit", function (e) {
        e.preventDefault();
        var form = this;
        if (!validarFormulario(form)) return;
        var formData = new FormData(form);

        enviarFormulario("../controlador/ApplicantDetailsController.php?op=guardar", formData, function (jsonResponse) {
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
        });
    });

    // Mostrar formulario de actualización al hacer clic en "Editar Perfil"
    $("#btnEditarPerfil").on("click", function () {
        $("#datosRegistrados").fadeOut(function () {
            $("#formApplicantDetailsUpdate").fadeIn();
            cargarDatosEnFormularioDeActualizacion();
        });
    });

    // Formulario para actualizar datos
    $("#formApplicantDetailsUpdate").on("submit", function (e) {
        e.preventDefault();
        var form = this;
        if (!validarFormulario(form)) return;
        var formData = new FormData(form);

        enviarFormulario("../controlador/ApplicantDetailsController.php?op=actualizar", formData, function (jsonResponse) {
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
        });
    });

    // Regresar al perfil
    $("#btnBackToProfile").on("click", function () {
        $("#formApplicantDetailsUpdate").fadeOut(function () {
            $("#datosRegistrados").fadeIn();
        });
    });

    // Función para manejar cambios en la selección de país
    function manejarCambioPais(pais, formType) {
        if (pais === "Perú") {
            // Cargar departamentos de Perú
            cargarDepartamentos(formType);
        } else {
            // Establecer "Otro" en departamento y provincia, y mostrar campo de dirección
            establecerOtro(formType);
        }
    }

    // Función para cargar departamentos de Perú
    function cargarDepartamentos(formType) {
        // Realizar una solicitud AJAX para obtener los departamentos de Perú
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=obtenerDepartamentos",
            type: "GET",
            dataType: "json",
            success: function (data) {
                var selectId = (formType === "register") ? "#departamento" : "#departamentoUpdate";
                $(selectId).empty().append('<option value="" disabled selected>Selecciona tu departamento</option>');
                $.each(data.departamentos, function (index, departamento) {
                    $(selectId).append('<option value="' + departamento + '">' + departamento + '</option>');
                });
                // Limpiar y deshabilitar el select de provincia hasta que se seleccione un departamento
                var provinciaId = (formType === "register") ? "#provincia" : "#provinciaUpdate";
                $(provinciaId).empty().append('<option value="" disabled selected>Selecciona tu provincia</option>').prop("disabled", true);

                // Ocultar previsualizaciones de fotos si se cambia el país
                if (formType === "register") {
                    $("#previewPhoto").attr("src", '').hide();
                } else {
                    $("#previewPhotoUpdate").attr("src", '').hide();
                }
            },
            error: function () {
                Toastify({
                    text: "Error al cargar los departamentos.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        });

        // Manejar cambio en el select de departamento
        var departamentoId = (formType === "register") ? "#departamento" : "#departamentoUpdate";
        $(departamentoId).off("change").on("change", function () {
            var departamento = $(this).val();
            if (departamento) {
                cargarProvincias(departamento, formType);
            }
        });
    }

    // Función para cargar provincias basadas en el departamento seleccionado
    function cargarProvincias(departamento, formType) {
        // Realizar una solicitud AJAX para obtener las provincias de Perú basadas en el departamento
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=obtenerProvincias&departamento=" + encodeURIComponent(departamento),
            type: "GET",
            dataType: "json",
            success: function (data) {
                var selectId = (formType === "register") ? "#provincia" : "#provinciaUpdate";
                $(selectId).empty().append('<option value="" disabled selected>Selecciona tu provincia</option>');
                $.each(data.provincias, function (index, provincia) {
                    $(selectId).append('<option value="' + provincia + '">' + provincia + '</option>');
                });
                // Habilitar el select de provincia
                $(selectId).prop("disabled", false);
            },
            error: function () {
                Toastify({
                    text: "Error al cargar las provincias.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        });

        // Manejar cambio en el select de provincia
        var provinciaId = (formType === "register") ? "#provincia" : "#provinciaUpdate";
        $(provinciaId).off("change").on("change", function () {
            var provincia = $(this).val();
            if (provincia) {
                cargarDireccion(provincia, formType); // Habilitar el campo de dirección
            }
        });
    }

    // Función para habilitar el campo de dirección basado en la provincia seleccionada
    function cargarDireccion(provincia, formType) {
        var direccionId = (formType === "register") ? "#direccion" : "#direccionUpdate";
        $(direccionId).prop("disabled", false);
    }

    // Función para establecer "Otro" en departamento y provincia, y habilitar el campo de dirección
    function establecerOtro(formType) {
        var departamentoId = (formType === "register") ? "#departamento" : "#departamentoUpdate";
        var provinciaId = (formType === "register") ? "#provincia" : "#provinciaUpdate";
        var direccionId = (formType === "register") ? "#direccion" : "#direccionUpdate";

        $(departamentoId).empty().append('<option value="Otro" selected>Otro</option>').prop("disabled", false);
        $(provinciaId).empty().append('<option value="Otro" selected>Otro</option>').prop("disabled", false);
        $(direccionId).val('').prop("disabled", false); // Habilitar el campo de dirección para que el usuario lo ingrese

        // Ocultar previsualizaciones de fotos si se cambia el país
        if (formType === "register") {
            $("#previewPhoto").attr("src", '').hide();
        } else {
            $("#previewPhotoUpdate").attr("src", '').hide();
        }
    }

    function cargarDatosPersonales() {
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=mostrar",
            type: "POST",
            dataType: "json",
            success: function (data) {
                console.log("Respuesta del servidor:", data);
        
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
    
                    // Mostrar la foto del postulante
                    if (data.data.photo) {
                        $("#verPhoto").attr("src", data.data.photo).show();
                    } else {
                        $("#verPhoto").attr("src", "../app/template/images/default_photo.png").show(); // Ruta web correcta
                    }
    
                    // Llenar los datos registrados
                    const fullName = data.data.nombre_completo || "Nombre Completo";
                    $("#verNombre").text(fullName);
                    $("#verPuesto").text(data.data.titulo_profesional || "Título Profesional");
                    $("#verPhone").text(data.data.phone);
                    $("#verEmergencyPhone").text(data.data.emergency_contact_phone || "No registrado");
                    $("#verContactoEmergencia").text(data.data.contacto_emergencia || "No registrado");
                    $("#verPais").text(data.data.pais);
                    $("#verDepartamento").text(data.data.departamento);
                    $("#verProvincia").text(data.data.provincia);
                    $("#verDireccion").text(data.data.direccion || "No registrada");
                    $("#verGender").text(data.data.gender);
                    $("#verBirthDate").text(data.data.birth_date);
                    $("#verMaritalStatus").text(data.data.marital_status);
                    $("#verChildrenCount").text(data.data.children_count);
                    $("#verNivelEstudio").text(data.data.education_level);
                }
            },
            error: function () {
                Toastify({
                    text: "Error al cargar los datos personales.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        });
    }
    
    // Función para cargar los datos en el formulario de actualización
    function cargarDatosPersonales() {
        $.ajax({
            url: "../controlador/ApplicantDetailsController.php?op=mostrar",
            type: "POST",
            dataType: "json",
            success: function (data) {
                console.log("Respuesta del servidor:", data);
    
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
    
                    // Mostrar la foto del postulante
                    if (data.data.photo) {
                        $("#verPhoto").attr("src", data.data.photo).show();
                    } else {
                        $("#verPhoto").attr("src", "../app/template/images/default_photo.png").show();
                    }
    
                    // Llenar los datos registrados
                    const fullName = data.data.nombre_completo || "Nombre Completo";
                    $("#verNombre").text(fullName);
    
                    // Mostrar el puesto de trabajo
                    const jobPosition = data.data.position_name || "Puesto no asignado";
                    $("#verPuesto").text(jobPosition);
    
                    $("#verPhone").text(data.data.phone);
                    $("#verEmergencyPhone").text(data.data.emergency_contact_phone || "No registrado");
                    $("#verContactoEmergencia").text(data.data.contacto_emergencia || "No registrado");
                    $("#verPais").text(data.data.pais);
                    $("#verDepartamento").text(data.data.departamento);
                    $("#verProvincia").text(data.data.provincia);
                    $("#verDireccion").text(data.data.direccion || "No registrada");
                    $("#verGender").text(data.data.gender);
                    $("#verBirthDate").text(data.data.birth_date);
                    $("#verMaritalStatus").text(data.data.marital_status);
                    $("#verChildrenCount").text(data.data.children_count);
                    $("#verNivelEstudio").text(data.data.education_level);
                }
            },
            error: function () {
                Toastify({
                    text: "Error al cargar los datos personales.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        });
    }
    
    // Inicializar validación de formularios usando Bootstrap
    function inicializarValidacionFormularios() {
        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    }

    // Función para validar formulario
    function validarFormulario(form) {
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return false;
        }
        return true;
    }

    // Función genérica para enviar formularios
    function enviarFormulario(url, formData, onSuccess) {
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    onSuccess(jsonResponse);
                } catch (e) {
                    Toastify({
                        text: "Respuesta inválida del servidor.",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc3545"
                    }).showToast();
                }
            },
            error: function () {
                Toastify({
                    text: "Error al procesar la solicitud.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        });
    }
});
