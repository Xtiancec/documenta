$(document).ready(function () {
    $("#frmAcceso").on("submit", function (e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        let username = $("#logina").val();
        let password = $("#clavea").val();

        if (username === "" || password === "") {
            $("#login-error-message").html("Por favor, rellena todos los campos.");
            return;
        }

        $.ajax({
            url: "../controlador/LoginSupplierController.php?op=verificar",
            method: "POST",
            data: { username: username, password: password },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    // Redirigir al dashboard del proveedor
                    window.location.href = "http://localhost/rh/vistas/supplierDetails.php";
                } else {
                    // Mostrar mensaje de error
                    $("#login-error-message").html(data.message || "Usuario o contraseña incorrectos.");
                }
            },
            error: function (xhr, status, error) {
                // Manejo de errores en el servidor
                $("#login-error-message").html("Hubo un problema en el servidor. Por favor, inténtalo de nuevo.");
                console.error(xhr.responseText); // Para depuración
            }
        });
    });
});
