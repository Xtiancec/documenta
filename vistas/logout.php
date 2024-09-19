<?php
session_start();
require_once "../modelos/User.php";

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    $user = new User();
    $user->registrarLogout($userId);
}

// Destruir sesión y redirigir al login
session_destroy();
header("Location: ../vistas/login.html");
exit();
?>
