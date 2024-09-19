var tabla;

function init() {
    $('#formularioregistros').on('show.bs.modal', function (e) {
        $('#formulario')[0].reset(); // Limpia todos los campos del formulario
        cargarEmpresas("#company_id");
        cargarPuestos("#job_id");
    });

    $('#formularioActualizar').on('show.bs.modal', function (e) {
        $('#formActualizar')[0].reset(); // Limpia todos los campos del formulario
    });

    listar();

    $("#formulario").on("submit", function (e) {
        guardar(e);
    });

    $("#formActualizar").on("submit", function (e) {
        actualizar(e); // Asegura que este método se llame para la actualización
    });

    $("#username").on('change', function () {
        var dni = $(this).val();
        if (dni.length === 8) {
            consultarDNI(dni);
        }
    });

    $("#usernameUpdate").on('change', function () {
        var dni = $(this).val();
        if (dni.length === 8) {
            consultarDNIUpdate(dni);
        }
    });
}


// Función para obtener historial de accesos
function mostrarHistorial(userId) {
    $.ajax({
        url: '../controlador/UserController.php?op=obtenerHistorialAcceso',
        type: 'POST',
        data: { userId: userId },
        success: function (response) {
            const jsonResponse = JSON.parse(response);

            if (jsonResponse.success) {
                let historyHtml = "";
                jsonResponse.history.forEach(entry => {
                    historyHtml += `
                        <tr>
                            <td>${entry.access_time}</td>
                            <td>${entry.logout_time ? entry.logout_time : 'Aún no ha cerrado sesión'}</td>
                        </tr>
                    `;
                });
                $('#tblHistorial tbody').html(historyHtml);
                $('#modalHistorial').modal('show'); // Mostrar el modal de historial
            } else {
                Swal.fire('Error', 'No se pudo obtener el historial de accesos.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Error al obtener el historial de accesos.', 'error');
        }
    });
}

// Función para listar usuarios en la tabla
function listar() {
    tabla = $("#tbllistado").dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controlador/UserController.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log("Error en listar: ", e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    }).DataTable();
}

// Función para mostrar los datos de un usuario en el formulario de actualización
function mostrar(id) {
    $.post("../controlador/UserController.php?op=mostrar", { id: id }, function (data, status) {
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
        $("#nacionalityUpdate").val(data.nacionality);
        $("#roleUpdate").val(data.role);
    });
}

// Función para cargar las empresas en el select
function cargarEmpresas(selector, selectedId = null) {
    $.ajax({
        url: "../controlador/UserController.php?op=listarEmpresas",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log("Empresas cargadas: ", data); // Verificar los datos de empresas
            let options = "<option value=''>Seleccione una Empresa</option>";
            data.forEach(empresa => {
                options += `<option value="${empresa.id}" ${selectedId == empresa.id ? 'selected' : ''}>${empresa.company_name}</option>`;
            });
            $(selector).html(options);
            console.log(`Empresas cargadas en ${selector} con ID seleccionado: ${selectedId}`);
        },
        error: function (xhr, status, error) {
            console.error(`Error al cargar empresas: ${error}`);
        }
    });
}

// Función para cargar los puestos de trabajo en el select
function cargarPuestos(selector, selectedId = null) {
    $.ajax({
        url: "../controlador/UserController.php?op=listarPuestosActivos",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log("Puestos cargados: ", data); // Verificar los datos de puestos
            let options = "<option value=''>Seleccione un Puesto de Trabajo</option>";
            data.forEach(puesto => {
                options += `<option value="${puesto.id}" ${selectedId == puesto.id ? 'selected' : ''}>${puesto.position_name}</option>`;
            });
            $(selector).html(options);
            console.log(`Puestos de trabajo cargados en ${selector} con ID seleccionado: ${selectedId}`);
        },
        error: function (xhr, status, error) {
            console.error(`Error al cargar puestos de trabajo: ${error}`);
        }
    });
}


function guardar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/UserController.php?op=insertar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos.includes("correctamente")) {
                Toastify({
                    text: "Usuario registrado correctamente",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745"
                }).showToast();
                $("#formularioregistros").modal("hide");
                tabla.ajax.reload();
            } else {
                Toastify({
                    text: "Error al registrar el usuario",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        }
    });
}

// Función para actualizar usuario
function actualizar(e) {
    e.preventDefault();
    var formData = new FormData($("#formActualizar")[0]);

    $.ajax({
        url: "../controlador/UserController.php?op=actualizar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos.includes("correctamente")) {
                Toastify({
                    text: "Usuario actualizado correctamente",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745"
                }).showToast();
                $("#formularioActualizar").modal("hide");
                tabla.ajax.reload();
            } else {
                Toastify({
                    text: "Error al actualizar el usuario",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545"
                }).showToast();
            }
        }
    });
}


// Función para consultar DNI
function consultarDNI(dni) {
    console.log("Consultando DNI: " + dni); // Verificar el DNI que se está consultando
    $.ajax({
        url: 'proxy.php?dni=' + dni,
        method: 'GET',
        success: function (response) {
            console.log("Respuesta de consulta DNI: ", response); // Verificar la respuesta de la consulta
            if (response) {
                // Llenar los campos con la información obtenida
                $("#lastname").val(response.apellidoPaterno);
                $("#surname").val(response.apellidoMaterno);
                $("#names").val(response.nombres);
            } else {
                Toastify({
                    text: "No se encontraron datos para el DNI ingresado.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                    className: "toast-progress",
                }).showToast();
            }
        },
        error: function (error) {
            console.error("Error al consultar el DNI: ", error);
            Toastify({
                text: "Error al consultar el DNI.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
                className: "toast-progress",
            }).showToast();
        }
    });
}

// Función para consultar DNI en el formulario de actualización
function consultarDNIUpdate(dni) {
    console.log("Consultando DNI para actualización: " + dni); // Verificar el DNI que se está consultando
    $.ajax({
        url: 'proxy.php?dni=' + dni,
        method: 'GET',
        success: function (response) {
            console.log("Respuesta de consulta DNI en actualización: ", response); // Verificar la respuesta de la consulta
            if (response) {
                // Llenar los campos con la información obtenida
                $("#lastnameUpdate").val(response.apellidoPaterno);
                $("#surnameUpdate").val(response.apellidoMaterno);
                $("#namesUpdate").val(response.nombres);
            } else {
                Toastify({
                    text: "No se encontraron datos para el DNI ingresado.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                    className: "toast-progress",
                }).showToast();
            }
        },
        error: function (error) {
            console.error("Error al consultar el DNI en actualización: ", error);
            Toastify({
                text: "Error al consultar el DNI.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
                className: "toast-progress",
            }).showToast();
        }
    });
}


// Función para activar un usuario
function activar(id) {
    Swal.fire({
        title: '¿Estás seguro de activar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, activar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return new Promise((resolve) => {
                $.ajax({
                    url: '../controlador/UserController.php?op=activar',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        if (response.includes("Usuario activado correctamente")) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Activado',
                                text: 'El usuario ha sido activado.',
                            });
                            tabla.ajax.reload(); // Recargar la tabla
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo activar el usuario.', 'error');
                    }
                });
            });
        }
    });
}

// Función para desactivar un usuario
function desactivar(id) {
    Swal.fire({
        title: '¿Estás seguro de desactivar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return new Promise((resolve) => {
                $.ajax({
                    url: '../controlador/UserController.php?op=desactivar',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        if (response.includes("Usuario desactivado correctamente")) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Desactivado',
                                text: 'El usuario ha sido desactivado.',
                            });
                            tabla.ajax.reload(); // Recargar la tabla
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo desactivar el usuario.', 'error');
                    }
                });
            });
        }
    });
}

// Inicializar el script
init();
