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
                <?php if (isset($_SESSION['username'])): ?>
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Bienvenido, <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Usuario'; ?> (<?php echo ucfirst(htmlspecialchars($_SESSION['role'])); ?>)
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