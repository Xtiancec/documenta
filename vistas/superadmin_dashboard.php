<?php
// superadmin_dashboard.php

session_start();

// Verificar si el usuario ha iniciado sesión y es un superadministrador
if (
    !isset($_SESSION['user_type']) ||
    $_SESSION['user_type'] !== 'user' ||
    $_SESSION['user_role'] !== 'superadmin'
) {
    header("Location: ../login.php"); // Asegúrate de que esta sea la URL correcta de login
    exit();
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<!-- Contenido del Dashboard del Super Administrador -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-chart-bar"></i> Dashboard Superadmin</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="escritorio.php">Inicio</a></li>
            <li class="breadcrumb-item">Super Administrador</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Contenido específico del dashboard del superadministrador -->
                <h4>Bienvenido al Dashboard de Super Administrador</h4>
                <!-- Agrega aquí tus widgets, gráficos, etc. -->
            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>
