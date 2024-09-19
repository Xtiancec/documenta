$(document).ready(function () {
    // Agregar fila para nueva experiencia educativa
    $("#btnAddEducacion").on("click", function () {
        agregarFilaEducacion('', '', '', '', '', ''); // Fila vacía
    });

    // Agregar fila para nueva experiencia laboral
    $("#btnAddTrabajo").on("click", function () {
        agregarFilaTrabajo('', '', '', '', ''); // Fila vacía
    });

    // Función para agregar una fila vacía de experiencia educativa
    function agregarFilaEducacion(id, institution = '', education_type = '', start_date = '', end_date = '', duration = '') {
        let fila = `
        <tr>
            <td><input type="hidden" name="education_id[]" value="${id}"><input type="text" class="form-control" name="institution[]" value="${institution}" required></td>
            <td><input type="text" class="form-control" name="education_type[]" value="${education_type}" required></td>
            <td><input type="date" class="form-control" name="start_date_education[]" value="${start_date}" required></td>
            <td><input type="date" class="form-control" name="end_date_education[]" value="${end_date}" required></td>
            <td><input type="number" class="form-control" name="duration_education[]" value="${duration}" min="1" required></td>
            <td><button type="button" class="btn btn-danger btnRemoveRow"><i class="fa fa-trash-o"></i></button></td>
        </tr>`;
        $("#tablaExperienciaEducativa tbody").append(fila);
    }

    // Función para agregar una fila vacía de experiencia laboral
    function agregarFilaTrabajo(id, company = '', position = '', start_date = '', end_date = '') {
        let fila = `
        <tr>
            <td><input type="hidden" name="work_id[]" value="${id}"><input type="text" class="form-control" name="company[]" value="${company}" required></td>
            <td><input type="text" class="form-control" name="position[]" value="${position}" required></td>
            <td><input type="date" class="form-control" name="start_date_work[]" value="${start_date}" required></td>
            <td><input type="date" class="form-control" name="end_date_work[]" value="${end_date}" required></td>
            <td><button type="button" class="btn btn-danger btnRemoveRow"><i class="fa fa-trash-o"></i></button></td>
        </tr>`;
        $("#tablaExperienciaLaboral tbody").append(fila);
    }

    // Eliminar una fila de la tabla
    $(document).on('click', '.btnRemoveRow', function () {
        $(this).closest('tr').remove();
    });

    // Guardar experiencia educativa
    $("#formEducation").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "../controlador/ExperienceController.php?op=guardarEducacion",
            type: "POST",
            data: formData,
            success: function (response) {
                let jsonResponse = JSON.parse(response);
                if (jsonResponse.status) {
                    alert("Experiencia educativa registrada correctamente.");
                } else {
                    alert("Error al registrar: " + jsonResponse.message);
                }
            },
        });
    });

    // Guardar experiencia laboral
    $("#formWork").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "../controlador/ExperienceController.php?op=guardarTrabajo",
            type: "POST",
            data: formData,
            success: function (response) {
                let jsonResponse = JSON.parse(response);
                if (jsonResponse.status) {
                    alert("Experiencia laboral registrada correctamente.");
                } else {
                    alert("Error al registrar: " + jsonResponse.message);
                }
            },
        });
    });
});
