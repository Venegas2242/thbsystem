<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Desplegable</title>
    <link rel="stylesheet" href="styles/menu-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="menu-bg">
        <h1 class="section-name">
            <?php echo isset($section_name) ? $section_name : '' ?>
        </h1>
    </div>
    <div class="menu-btn" onclick="toggleNav()">
        <span>&#9776; sdas</span>
    </div>

    <div id="mySidenav" class="sidenav">
        <a class="dropdown-item" href="reportes-entidades.php"><i class="fa-solid fa-chart-pie"></i> Reportes</a>
        <a class="dropdown-btn" onclick="toggleDropdown()">
            <i class="fas fa-bars me-2"></i> Catálogos <i class="fa fa-caret-down"></i>
        </a>
        <div class="dropdown-container">
            <a class="dropdown-item" href="usuarios.php"><i class="fa-solid fa-user-plus"></i> Usuarios</a>
            <a class="dropdown-item" href="#"><i class="fa-solid fa-building"></i> Ciudades</a>
            <a class="dropdown-item" href="bancos.php"><i class="fa-solid fa-money-check-dollar"></i> Bancos</a>
            <a class="dropdown-item" href="entidades.php"><i class="fas fa-truck me-2"></i> Prov/Clien</a>
            <a class="dropdown-item" href="#"><i class="fas fa-box me-2"></i> Productos</a>
        </div>
        <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Salir</a>
    </div>

    <script src="scripts/menu-script.js"></script>
</body>

</html>
