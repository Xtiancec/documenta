$(document).ready(function () {
    $("#frmAcceso").on("submit", function (e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        let username = $("#username").val().trim();
        let password = $("#clavea").val().trim();

        console.log("Formulario enviado");
        console.log("Username: " + username + ", Password: " + password);

        $.ajax({
            url: "../controlador/LoginController.php?op=verificar",
            method: "POST",
            data: { username: username, password: password },
            dataType: "json",
            success: function (data) {
                console.log("Respuesta recibida: ", data);
                if (data.success) {
                    // Redireccionar según el rol y tipo
                    if (data.type === 'user') {
                        switch (data.role) {
                            case "superadmin":
                                window.location.href = "http://localhost/rh/vistas/superadmin_dashboard.php"; 
                                break;
                            case "adminrh":
                                window.location.href = "http://localhost/rh/vistas/adminrh_dashboard.php"; 
                                break;
                            case "adminpr":
                                window.location.href = "http://localhost/rh/vistas/adminpr_dashboard.php"; 
                                break;
                            case "user":
                                window.location.href = "http://localhost/rh/vistas/user_dashboard.php"; 
                                break;
                            default:
                                $("#login-error-message").html("Rol no reconocido.");
                        }
                    } else if (data.type === 'applicant') {
                        window.location.href = "http://localhost/rh/vistas/dashboardApplicant.php"; 
                    } else if (data.type === 'supplier') {
                        window.location.href = "http://localhost/rh/vistas/supplier_dashboard.php"; 
                    } else {
                        $("#login-error-message").html("Tipo de usuario no reconocido.");
                    }
                } else {
                    $("#login-error-message").html(data.message || "Usuario o contraseña incorrectos.");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX: ", status, error);
                console.log("Respuesta del servidor: ", xhr.responseText); // Muestra la respuesta completa del servidor
                $("#login-error-message").html("Hubo un problema en el servidor. Por favor, inténtalo de nuevo.");
            }
        });
    });
});
