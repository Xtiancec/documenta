var tabla;

$(document).ready(function () {
    Init();
});

function Init() {
    listar();
}

// Función listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f>>>><"col-md-12"rt><"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>>',
        buttons: [
            { extend: 'copy', className: 'btn' },
            { extend: 'pdf', className: 'btn' },
            { extend: 'excel', className: 'btn' },
            { extend: 'print', className: 'btn' },
            { extend: 'csv', className: 'btn' }
        ],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg...></svg>', "sNext": '<svg...></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg...></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "displayLength": 10,
        "lengthMenu": [10, 10, 20, 50],
       
        "ajax": {
            url: '../controlador/DocumentNameController.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "order": [[0, "desc"]] // Ordenar (columna, orden)
    }).DataTable();
}





function mostrar(id) {
    $.post('../controlador/DocumentNameController.php?op=mostrar', { id: id }, function (data) {
        data = JSON.parse(data);
        $('#idUpdate').val(data.id);
        $('#documentNameUpdate').val(data.documentName);
        $('#formularioActualizar').modal('show'); // Mostrar el modal de actualización
    });
}

function guardar() {
    var documentName = $('#documentName').val();

    if (documentName.trim() === "") {
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

    $.post('../controlador/DocumentNameController.php?op=guardar', { documentName: documentName }, function (response) {
        if (response === "Datos registrados correctamente") {
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
            $('#tbllistado').DataTable().ajax.reload(); // Recargar la tabla
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
    });
}

function actualizar() {
    var id = $('#idUpdate').val();
    var documentName = $('#documentNameUpdate').val();

    $.post('../controlador/DocumentNameController.php?op=editar', { id: id, documentName: documentName }, function (response) {
        if (response === "Datos actualizados correctamente") {
            $('#formularioActualizar').modal('hide');
            Toastify({
                text: response,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
                className: "toast-progress",
            }).showToast();
            $('#tbllistado').DataTable().ajax.reload(); // Recargar la tabla
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
    });
}

$(document).on('click', '.btn-edit', function () {
    var id = $(this).data('id');
    mostrar(id);
});

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

// Función para confirmar eliminación usando SweetAlert2
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
            Swal.fire('Eliminado', 'El registro fue eliminado', 'success');
            $('#tbllistado').DataTable().ajax.reload();
        }
    });
}

function desactivar(id) {
    $.post('../controlador/DocumentNameController.php?op=desactivar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Desactivado', 'El registro fue desactivado correctamente.', 'success');
            tabla.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
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
            Swal.fire('Activado', 'El registro fue activado', 'success');
            $('#tbllistado').DataTable().ajax.reload();
        }
    });
}

function activar(id) {
    $.post('../controlador/DocumentNameController.php?op=activar', { id: id }, function (response) {
        if (response.includes("correctamente")) {
            Swal.fire('Activado', 'El registro fue activado correctamente.', 'success');
            tabla.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
        } else {
            Swal.fire('Error', 'No se pudo activar el registro.', 'error');
        }
    }).fail(function () {
        Swal.fire('Error', 'Hubo un problema en el servidor.', 'error');
    });
}
