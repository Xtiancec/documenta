var tabla;

$(document).ready(function () {
    init();
});

function init() {
    listar();
    cargarSelectEmpresas();
}

// Función para cargar las empresas en los select
function cargarSelectEmpresas() {
    $.post("../controlador/JobPositionsController.php?op=selectCompany", function (r) {
        $("#company_id").html(r).select2();
        $("#company_id").append('<option disabled selected value="">Selecciona o escribe una Empresa</option>');
        $("#company_id").select2('refresh');
    });

    $.post("../controlador/JobPositionsController.php?op=selectCompany", function (r) {
        $("#company_idUpdate").html(r).select2();
        $("#company_idUpdate").append('<option disabled selected value="">Selecciona o escribe una Empresa</option>');
        $("#company_idUpdate").select2('refresh');
    });
}

// Función para listar los puestos
function listar() {
    tabla = $('#tbllistado').dataTable({
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f>>>><"col-md-12"rt><"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>>',
        buttons: [
            { extend: 'copy', className: 'btn' },
            { extend: 'csv', className: 'btn' },
            { extend: 'excel', className: 'btn' },
            { extend: 'print', className: 'btn' }
        ],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<i class="fas fa-arrow-left"></i>', "sNext": '<i class="fas fa-arrow-right"></i>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<i class="fas fa-search"></i>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 10, 20, 50],
        "pageLength": 10,
        "ajax": {
            url: '../controlador/JobPositionsController.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "order": [[0, "desc"]]
    }).DataTable();
}

// Función para mostrar un puesto
function mostrar(id) {
    $.post('../controlador/JobPositionsController.php?op=mostrar', { id: id }, function (data) {
        data = JSON.parse(data);
        $('#idUpdate').val(data.id);
        $('#company_idUpdate').val(data.company_id).trigger('change');
        $('#position_nameUpdate').val(data.position_name);
        $('#formularioActualizar').modal('show');
    });
}

// Función para guardar un nuevo puesto
function guardar() {
    var position_name = $('#position_name').val();
    var company_id = $('#company_id').val();

    if (position_name.trim() === "" || company_id === "") {
        Toastify({
            text: "Complete todos los campos requeridos",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#ffc107",
            className: "toast-progress",
        }).showToast();
        return;
    }

    $.post('../controlador/JobPositionsController.php?op=guardar', { position_name: position_name, company_id: company_id }, function (response) {
        if (response.includes("correctamente")) {
            $('#formularioregistros').modal('hide');
            Toastify({
                text: "Datos registrados correctamente",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
                className: "toast-progress",
            }).showToast();
            tabla.ajax.reload();
        } else {
            Toastify({
                text: "Error: " + response,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }
    });
}

// Función para actualizar un puesto
function actualizar() {
    var id = $('#idUpdate').val();
    var company_id = $('#company_idUpdate').val();
    var position_name = $('#position_nameUpdate').val();

    if (position_name.trim() === "" || company_id === "") {
        Toastify({
            text: "Complete todos los campos requeridos",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#ffc107",
        }).showToast();
        return;
    }

    $.post('../controlador/JobPositionsController.php?op=editar', { id: id, company_id: company_id, position_name: position_name }, function (response) {
        if (response.includes("correctamente")) {
            $('#formularioActualizar').modal('hide');
            Toastify({
                text: "Datos actualizados correctamente",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
            }).showToast();
            tabla.ajax.reload();
        } else {
            Toastify({
                text: "Error: " + response,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }
    });
}

// Funciones para desactivar y activar un puesto
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar el registro?',
        text: "¡Este registro se dará de baja hasta que se vuelva a activar!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡elimínalo!',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            desactivar(id);
            tabla.ajax.reload();
        }
    });
}

function desactivar(id) {
    $.post('../controlador/JobPositionsController.php?op=desactivar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Eliminado', 'El registro fue eliminado', 'success');
        } else {
            Swal.fire('Error', 'No se pudo desactivar el registro.', 'error');
        }
    }).fail(function () {
        Swal.fire('Error', 'Hubo un problema en el servidor.', 'error');
    });
}

function confirmarActivacion(id) {
    Swal.fire({
        title: '¿Está seguro de activar el registro?',
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
            tabla.ajax.reload();
        }
    });
}

function activar(id) {
    $.post('../controlador/JobPositionsController.php?op=activar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Activado', 'El registro fue activado correctamente', 'success');
        } else {
            Swal.fire('Error', 'No se pudo activar el registro.', 'error');
        }
    }).fail(function () {
        Swal.fire('Error', 'Hubo un problema en el servidor.', 'error');
    });
}
