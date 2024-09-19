$(document).ready(function () {
    // Inicialización de Dropify
    $('.dropify').dropify({
        messages: {
            'default': 'Arrastra y suelta un archivo aquí o haz clic',
            'replace': 'Arrastra y suelta o haz clic para reemplazar',
            'remove': 'Eliminar',
            'error': 'Oops, algo salió mal.'
        },
        error: {
            'fileSize': 'El tamaño del archivo es demasiado grande (5MB max).',
            'fileExtension': 'Este tipo de archivo no está permitido.'
        }
    });

    var documentCounter = 1;

    // Preguntar si desea subir un CV o un documento diferente
    $('#uploadDocumentButton').on('click', function () {
        Swal.fire({
            title: '¿Qué tipo de documento deseas subir?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Subir CV',
            cancelButtonText: 'Subir Otro Documento',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#cvUploadModal').modal('show'); // Abrir modal para subir CV
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                $('#otherDocsUploadModal').modal('show'); // Abrir modal para subir otro documento
            }
        });
    });

    // Añadir nuevo campo de documento para "otros documentos"
    $('#addDocument').on('click', function () {
        var newRowId = `doc_row_${documentCounter}`;
        var newFileInput = `
            <div class="form-group" id="${newRowId}">
                <label for="other_file_${documentCounter}">Seleccionar Documento</label>
                <input type="file" id="other_file_${documentCounter}" name="other_files[]" class="dropify" data-max-file-size="5M" required />
                <div class="text-right">
                <button type="button" class="btn btn-danger btn-sm removeDocumentRow" data-row-id="${newRowId}"><i class="fa fa-trash"></i> Eliminar</button>
                </div>  
            </div>`;
        $('#otherDocsContainer').append(newFileInput);
        $(`#other_file_${documentCounter}`).dropify();
        documentCounter++;
    });

    // Eliminar la fila de documento añadida
    $(document).on('click', '.removeDocumentRow', function () {
        var rowId = $(this).data('row-id');
        $('#' + rowId).remove();
    });

    // Cargar documentos subidos al cargar la página
    cargarDocumentos();

    // Manejar la subida de CV
    $("#formCvUpload").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "../controlador/DocumentApplicantController.php?op=subirCv",
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
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#4CAF50",
                        className: "toast-progress",
                    }).showToast();
                    cargarDocumentos();
                    $('#formCvUpload')[0].reset();
                    $('.dropify').dropify(); // Reinicializar Dropify
                } else {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#F44336",
                        className: "toast-progress",
                    }).showToast();
                }
            },
            error: function () {
                Swal.fire('Error', 'Ocurrió un error al subir el CV.', 'error');
            }
        });
    });

    // Manejar la subida de otros documentos
    $("#formOtherDocsUpload").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "../controlador/DocumentApplicantController.php?op=subirOtrosDocumentos",
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
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#4CAF50",
                        className: "toast-progress",
                    }).showToast();
                    cargarDocumentos();
                    $('#formOtherDocsUpload')[0].reset();
                    $('.dropify').dropify(); // Reinicializar Dropify
                } else {
                    Toastify({
                        text: jsonResponse.message,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#F44336",
                        className: "toast-progress",
                    }).showToast();
                }
            },
            error: function () {
                Swal.fire('Error', 'Ocurrió un error al subir los documentos.', 'error');
            }
        });
    });

    // Función para cargar los documentos subidos en la tabla
    function cargarDocumentos() {
        $.ajax({
            url: "../controlador/DocumentApplicantController.php?op=listarDocumentos",
            type: "GET",
            success: function (response) {
                try {
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === false) {
                        Swal.fire('Información', jsonResponse.message, 'info');
                        $("#documentList").html('<tr><td colspan="3">No se encontraron documentos subidos.</td></tr>');
                    } else {
                        var tableBody = $("#documentList");
                        tableBody.empty();

                        // Recorrer los documentos y agregarlos a la tabla
                        jsonResponse.forEach(function (doc) {
                            var row = `<tr>
                                <td>${doc.original_file_name}</td>
                                <td>${doc.created_at}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm" onclick="eliminarDocumento(${doc.id})">Eliminar</button>
                                </td>
                            </tr>`;
                            tableBody.append(row);
                        });
                    }
                } catch (e) {
                    console.error("Error procesando respuesta JSON: ", e);
                    Swal.fire('Error', 'Error al procesar los documentos.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Error al cargar los documentos.', 'error');
            }
        });
    }

    // Función para eliminar un documento subido
    window.eliminarDocumento = function (id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../controlador/DocumentApplicantController.php?op=eliminarDocumento",
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status) {
                            Toastify({
                                text: jsonResponse.message,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4CAF50",
                                className: "toast-progress",
                            }).showToast();
                            cargarDocumentos();
                        } else {
                            Toastify({
                                text: jsonResponse.message,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#F44336",
                                className: "toast-progress",
                            }).showToast();
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Error al eliminar el documento.', 'error');
                    }
                });
            }
        });
    };

    // Subida de CV
    $(document).ready(function () {
        // Subida de CV
        $('#formCvUpload').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#cvUploadProgress').css('width', percentComplete + '%');
                            $('#cvUploadProgress').attr('aria-valuenow', percentComplete);
                            $('#cvUploadProgress span').text(Math.round(percentComplete) + '% Complete');
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: 'upload_cv.php',  // Cambia por tu archivo PHP que maneja la subida
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log('Subida completa');
                    $('#cvUploadProgress').css('width', '0%');
                    $('#cvUploadProgress span').text('0% Complete');
                },
                error: function (response) {
                    console.log('Error en la subida');
                }
            });
        });

        // Subida de otros documentos
        $('#formOtherDocsUpload').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#otherDocsUploadProgress').css('width', percentComplete + '%');
                            $('#otherDocsUploadProgress').attr('aria-valuenow', percentComplete);
                            $('#otherDocsUploadProgress span').text(Math.round(percentComplete) + '% Complete');
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: 'upload_documents.php',  // Cambia por tu archivo PHP que maneja la subida
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log('Subida completa');
                    $('#otherDocsUploadProgress').css('width', '0%');
                    $('#otherDocsUploadProgress span').text('0% Complete');
                },
                error: function (response) {
                    console.log('Error en la subida');
                }
            });
        });
    });

});
