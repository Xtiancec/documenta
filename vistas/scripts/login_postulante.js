$(document).ready(function () {
    $("#frmAccesoPostulante").on("submit", function (e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        let username = $("#loginp").val();
        let password = $("#clavep").val();

        console.log("Formulario enviado");
        console.log("Username: " + username + ", Password: " + password);

        $.ajax({
            url: "../controlador/LoginPostulanteController.php?op=verificar",
            method: "POST",
            data: { username: username, password: password },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    window.location.href = "http://localhost/rh/vistas/applicant_details.php";
                } else {
                    $("#login-error-message").html(data.message || "Usuario o contraseña incorrectos.");
                }
            },
            error: function (xhr, status, error) {
                $("#login-error-message").html("Hubo un problema en el servidor. Por favor, inténtalo de nuevo.");
            }
        });
        
    });
});
