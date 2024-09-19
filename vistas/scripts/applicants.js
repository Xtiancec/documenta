var tabla;

function init() {
    // Cuando el modal de agregar postulante se muestra
    $('#formularioregistros').on('show.bs.modal', function (e) {
        $('#formulario')[0].reset(); // Limpia todos los campos del formulario
        cargarEmpresas("#company_id");
        cargarPuestos("#job_id");
    });


    // Cuando el modal de actualizar postulante se muestra
    $('#formularioActualizar').on('show.bs.modal', function (e) {
        $('#formActualizar')[0].reset(); // Limpia todos los campos del formulario
    });

    listar();

    // Guardar postulante al enviar el formulario
    $("#formulario").on("submit", function (e) {
        guardar(e);
    });

    $("#formActualizar").on("submit", function (e) {
        actualizar(e); // Asegura que este método se llame para la actualización
    });

    // Consultar DNI al cambiar el valor del campo DNI
    $("#username").on("change", function () {
        var dni = $(this).val();
        if (dni.length === 8) {
            consultarDNI(dni);
        }
    });

    // Consultar DNI al actualizar el campo DNI
    $("#usernameUpdate").on("change", function () {
        var dni = $(this).val();
        if (dni.length === 8) {
            consultarDNIUpdate(dni);
        }
    });
}

// Función para listar postulantes en la tabla
function listar() {
    tabla = $("#tbllistado").DataTable({
        "ajax": {
            url: "../controlador/ApplicantController.php?op=listar",
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10
    });
}

// Función para guardar postulante
function guardar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/ApplicantController.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.includes("registrado correctamente")) {
                $('#formularioregistros').modal('hide');
                Toastify({
                    text: response,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                    className: "toast-progress",
                }).showToast();
                $('#tbllistado').DataTable().ajax.reload();
            } else {
                Toastify({
                    text: response,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                    className: "toast-progress",
                }).showToast();
            }
        }
    });
}

// Función para actualizar un postulante
function actualizar(e) {
    e.preventDefault();
    var formData = new FormData($("#formActualizar")[0]);

    $.ajax({
        url: "../controlador/ApplicantController.php?op=editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.includes("actualizado correctamente")) {
                $('#formularioActualizar').modal('hide');
                Toastify({
                    text: response,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                }).showToast();
                $('#tbllistado').DataTable().ajax.reload();
            } else {
                Toastify({
                    text: "Error al actualizar el postulante",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
            }
        }
    });
}


// Función para confirmar eliminación con SweetAlert2
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Está seguro de desactivar el postulante?',
        text: "Este registro se desactivará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡desactívalo!',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            desactivar(id);
        }
    });
}

// Función para desactivar un postulante
function desactivar(id) {
    $.post('../controlador/ApplicantController.php?op=desactivar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Desactivado', 'El postulante fue desactivado correctamente.', 'success');
            tabla.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
        } else {
            Swal.fire('Error', 'No se pudo desactivar el postulante.', 'error');
        }
    });
}

// Función para confirmar activación con SweetAlert2
function confirmarActivacion(id) {
    Swal.fire({
        title: '¿Está seguro de activar el postulante?',
        text: "Este registro se activará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#002A52E',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡actívalo!',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            activar(id);
        }
    });
}

// Función para activar un postulante
function activar(id) {
    $.post('../controlador/ApplicantController.php?op=activar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Activado', 'El postulante fue activado correctamente.', 'success');
            tabla.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
        } else {
            Swal.fire('Error', 'No se pudo activar el postulante.', 'error');
        }
    });
}

// Configurar eventos para los botones
$(document).on('click', '.btn-edit', function () {
    var id = $(this).data('id');
    mostrar(id);
});
$(document).on('click', '.btn-desactivar', function () {
    var id = $(this).data('id');
    confirmarEliminacion(id);
});
$(document).on('click', '.btn-activar', function () {
    var id = $(this).data('id');
    confirmarActivacion(id);
});


// Función para cargar las empresas en el select
function cargarEmpresas(selector, selectedId = null) {
    $.ajax({
        url: "../controlador/ApplicantController.php?op=listarEmpresas",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let options = "<option value=''>Seleccione una Empresa</option>";
            data.forEach(empresa => {
                options += `<option value="${empresa.id}" ${selectedId == empresa.id ? 'selected' : ''}>${empresa.company_name}</option>`;
            });
            $(selector).html(options);
        },
        error: function (e) {
            console.error("Error cargando empresas: ", e.responseText);
        }
    });
}



// Función para cargar los puestos de trabajo en el select
function cargarPuestos(selector, selectedId = null) {
    $.ajax({
        url: "../controlador/ApplicantController.php?op=listarPuestosActivos",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let options = "<option value=''>Seleccione un Puesto de Trabajo</option>";
            data.forEach(puesto => {
                options += `<option value="${puesto.id}" ${selectedId == puesto.id ? 'selected' : ''}>${puesto.position_name}</option>`;
            });
            $(selector).html(options);
        },
        error: function (e) {
            console.error("Error cargando puestos de trabajo: ", e.responseText);
        }
    });
}

// Función para consultar DNI al agregar
function consultarDNI(dni) {
    $.ajax({
        url: 'proxy.php?dni=' + dni,
        method: 'GET',
        success: function (response) {
            if (response) {
                $("#lastname").val(response.apellidoPaterno);
                $("#surname").val(response.apellidoMaterno);
                $("#names").val(response.nombres);
            } else {
                alert("No se encontraron datos para el DNI ingresado.");
            }
        }
    });
}

// Función para consultar DNI al actualizar
function consultarDNIUpdate(dni) {
    $.ajax({
        url: 'proxy.php?dni=' + dni,
        method: 'GET',
        success: function (response) {
            if (response) {
                $("#lastnameUpdate").val(response.apellidoPaterno);
                $("#surnameUpdate").val(response.apellidoMaterno);
                $("#namesUpdate").val(response.nombres);
            } else {
                alert("No se encontraron datos para el DNI ingresado.");
            }
        }
    });
}
// Función para mostrar los datos de un postulante en el formulario de actualización
function mostrar(id) {
    $.post("../controlador/ApplicantController.php?op=mostrar", { id: id }, function (data, status) {
        console.log("Datos recibidos en mostrar: ", data); // Verificar los datos recibidos

        data = JSON.parse(data);

        // Mostrar el formulario de actualización
        $("#formularioActualizar").modal("show");

        cargarEmpresas("#company_idUpdate", data.company_id);
        cargarPuestos("#job_idUpdate", data.job_id);

        $("#idUpdate").val(data.id);
        $("#usernameUpdate").val(data.username);
        $("#emailUpdate").val(data.email);
        $("#lastnameUpdate").val(data.lastname);
        $("#surnameUpdate").val(data.surname);
        $("#namesUpdate").val(data.names);
    });
}


// Función para limpiar los campos del formulario
function limpiar() {
    $("#username").val('');
    $("#lastname").val('');
    $("#surname").val('');
    $("#names").val('');
    $("#email").val('');
    $("#company_id").val('');
    $("#job_id").val('');
}

// Inicializar las funciones
init();
