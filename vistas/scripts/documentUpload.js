$(document).ready(function () {
    cargarPuestos();

    function cargarPuestos() {
        $.ajax({
            url: '../controlador/DocumentUploadController.php?op=listarPuestosActivos',
            method: 'GET',
            success: function (data) {
                var options = '<option value="">Seleccione un puesto</option>';
                data = JSON.parse(data);
                $.each(data, function (index, value) {
                    options += '<option value="' + value.id + '">' + value.position_name + '</option>';
                });
                $('#position_id').html(options);
                cargarPuestoSeleccionado(); // Cargar el puesto seleccionado desde la sesión
            },
            error: function (error) {
                console.error("Error al cargar los puestos:", error);
            }
        });
    }

    function cargarPuestoSeleccionado() {
        $.ajax({
            url: '../controlador/DocumentUploadController.php?op=obtenerPuestoSeleccionado',
            method: 'GET',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.position_id) {
                    $('#position_id').val(data.position_id);
                    $('#position_id').trigger('change'); // Simular el cambio para cargar documentos
                }
            },
            error: function (error) {
                console.error("Error al obtener el puesto seleccionado:", error);
            }
        });
    }

    $('#position_id').on('change', function () {
        var position_id = $(this).val();
        if (position_id) {
            cargarDocumentos(position_id);
        } else {
            $('#document-list-obligatorios').empty();
            $('#document-list-opcionales').empty();
        }
    });

    function cargarDocumentos(position_id) {
        $('#document-list-obligatorios').empty();
        $('#document-list-opcionales').empty();

        $.ajax({
            url: '../controlador/DocumentUploadController.php?op=listarDocumentosPorPuesto',
            method: 'POST',
            data: { position_id: position_id },
            success: function (response) {
                var documentos = JSON.parse(response);
                renderizarDocumentos(documentos);
            },
            error: function (error) {
                console.error("Error al cargar los documentos:", error);
            }
        });
    }

    function renderizarDocumentos(documentos) {
        var obligatoriosHtml = '<div id="accordionObligatorios" class="accordion" role="tablist" aria-multiselectable="true">';
        var opcionalesHtml = '<div id="accordionOpcionales" class="accordion" role="tablist" aria-multiselectable="true">';

        documentos.forEach(function (doc, index) {
            var accordionItem = `
                <div class="card">
                    <div class="card-header clickable" role="tab" id="heading${doc.document_id}" data-toggle="collapse" data-parent="#accordion${doc.document_type}" href="#collapse${doc.document_id}" aria-expanded="${index === 0}" aria-controls="collapse${doc.document_id}">
                        <h5 class="mb-0">
                            ${doc.documentName} (${doc.document_type})
                        </h5>
                    </div>
                    <div id="collapse${doc.document_id}" class="collapse ${index === 0 ? 'show' : ''}" role="tabpanel" aria-labelledby="heading${doc.document_id}">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="file" class="dropify" 
                                        name="document_${doc.document_id}"
                                        data-id="${doc.document_id}" 
                                        data-type="${doc.document_type}" 
                                        data-category-id="${doc.document_id}" 
                                        data-max-file-size="2M" 
                                        data-show-remove="false"
                                        data-messages='{"default": "Arrastra y suelta un archivo aquí o haz clic", "replace": "Arrastra y suelta o haz clic para reemplazar", "remove": "Eliminar", "error": "El archivo es demasiado grande o de un tipo no permitido"}'
                                    />
                                </div>
                                <div class="col-sm-6">
                                    <textarea name="comment_${doc.document_id}" class="form-control" placeholder="Agregar comentario para este documento..." rows="4"></textarea>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <button type="button" class="btn btn-success btn-upload" data-id="${doc.document_id}">Subir</button>
                                    <button type="button" class="btn btn-danger btn-cancel">Cancelar</button>
                                </div>
                            </div>
                            <div class="document-history" id="history_${doc.document_id}">
                                <!-- Aquí se cargará el historial de documentos -->
                            </div>
                        </div>
                    </div>
                </div>
            `;

            if (doc.document_type === 'obligatorio') {
                obligatoriosHtml += accordionItem;
            } else {
                opcionalesHtml += accordionItem;
            }

            // Cargar el historial de documentos subidos
            cargarHistorialDocumentos(doc.document_id);
        });

        obligatoriosHtml += '</div>';
        opcionalesHtml += '</div>';

        $('#document-list-obligatorios').html(obligatoriosHtml);
        $('#document-list-opcionales').html(opcionalesHtml);

        $('.dropify').dropify(); // Inicializa Dropify para los nuevos elementos añadidos
    }

    function cargarHistorialDocumentos(document_id) {
        $.ajax({
            url: '../controlador/DocumentUploadController.php?op=listarHistorialDocumentos',
            method: 'POST',
            data: { document_id: document_id },
            success: function (response) {
                var history = JSON.parse(response);
                renderizarHistorialDocumentos(document_id, history);
            },
            error: function (error) {
                console.error("Error al cargar el historial de documentos:", error);
            }
        });
    }

    function renderizarHistorialDocumentos(document_id, history) {
        var historyHtml = '<h5>Historial de Documentos:</h5>';
        history.forEach(function (doc) {
            historyHtml += `
                <div class="document-uploaded">
                    <p><strong>Nombre:</strong> ${doc.document_name}</p>
                    <p><strong>Comentario:</strong> ${doc.user_observation}</p>
                    <p><strong>Subido en:</strong> ${doc.changed_at}</p>
                    <a href="${doc.document_path}" target="_blank">Ver documento</a>
                </div>
            `;
        });

        $(`#history_${document_id}`).html(historyHtml);
    }

    $(document).on('click', '.btn-upload', function () {
        var documentId = $(this).data('id');
        var formData = new FormData();
        var fileInput = $(`input[name=document_${documentId}]`)[0].files[0];
        var comment = $(`textarea[name=comment_${documentId}]`).val();
        var position_id = $('#position_id').val();
        var document_type = 'obligatorio'; // o 'opcional', según la lógica que necesites

        if (!fileInput) {
            alert("Por favor, selecciona un archivo para subir.");
            return;
        }

        formData.append('document_file', fileInput);
        formData.append('document_id', documentId);
        formData.append('comment', comment);
        formData.append('position_id', position_id);
        formData.append('document_type', document_type);

        $.ajax({
            url: '../controlador/DocumentUploadController.php?op=subirDocumento',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Toastify({
                    text: response,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#4caf50",
                    },
                }).showToast();
                cargarHistorialDocumentos(documentId); // Recargar historial después de la subida
            },
            error: function (error) {
                Toastify({
                    text: "Error al subir el documento.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#f44336",
                    },
                }).showToast();
            }
        });
    });
});
