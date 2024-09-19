$(document).ready(function () {
    // Cargar experiencia educativa
    $.ajax({
        url: "../controlador/ExperienceController.php?op=mostrarEducacion",
        type: "GET",
        success: function (response) {
            let jsonResponse = JSON.parse(response);
            if (jsonResponse.length > 0) {
                jsonResponse.forEach(function (item) {
                    let fila = `
                    <tr>
                        <td>${item.institution}</td>
                        <td>${item.education_type}</td>
                        <td>${item.start_date}</td>
                        <td>${item.end_date}</td>
                        <td>${item.duration}</td>
                    </tr>`;
                    $("#tablaExperienciaEducativa tbody").append(fila);
                });
            } else {
                $("#tablaExperienciaEducativa tbody").append('<tr><td colspan="5">No hay experiencia educativa registrada.</td></tr>');
            }
        }
    });

    // Cargar experiencia laboral
    $.ajax({
        url: "../controlador/ExperienceController.php?op=mostrarTrabajo",
        type: "GET",
        success: function (response) {
            let jsonResponse = JSON.parse(response);
            if (jsonResponse.length > 0) {
                jsonResponse.forEach(function (item) {
                    let fila = `
                    <tr>
                        <td>${item.company}</td>
                        <td>${item.position}</td>
                        <td>${item.start_date}</td>
                        <td>${item.end_date}</td>
                    </tr>`;
                    $("#tablaExperienciaLaboral tbody").append(fila);
                });
            } else {
                $("#tablaExperienciaLaboral tbody").append('<tr><td colspan="4">No hay experiencia laboral registrada.</td></tr>');
            }
        }
    });
});
