<?php
// Asegúrate de iniciar la sesión al comienzo del archivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inicializar variables
$name = 'Usuario';
$user_role = '';
$user_type = '';

// Verificar el tipo de usuario y asignar el nombre y rol adecuados
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

    switch ($user_type) {
        case 'user':
            $name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Usuario';
            break;
        case 'applicant':
            $name = isset($_SESSION['names']) ? $_SESSION['names'] : 'Postulante';
            break;
        case 'supplier':
            $name = isset($_SESSION['companyName']) ? $_SESSION['companyName'] : 'Empresa';
            break;
        default:
            $name = 'Usuario';
    }
}
?>

<nav class="navbar top-navbar navbar-expand-md navbar-light">
    <div class="navbar-header">
        <a class="navbar-brand" href="escritorio.php">
            <b><img src="../app/template/images/icono-andina.png" width="50" height="50" alt="homepage" class="dark-logo" /></b>
            <span><img src="../app/template/images/texto-andina.png" width="150" height="50" alt="homepage" class="dark-logo" /></span>
        </a>
    </div>
    
    <div class="navbar-collapse">
        <ul class="navbar-nav my-lg-0">
            <li class="nav-item dropdown">
                <?php if (!empty($user_type)): ?>
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Bienvenido, <?php echo htmlspecialchars($name); ?> (<?php echo ucfirst(htmlspecialchars($user_role)); ?>)
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <a href="logout.php" class="dropdown-item">Cerrar Sesión</a>
                    </div>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Iniciar Sesión</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>

</header>
