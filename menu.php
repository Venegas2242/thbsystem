<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Lateral Desplegable</title>
    <link rel="stylesheet" href="styles/menu-style.css">
</head>
<body>
    <div class="menu-bg"></div>
    <div class="menu-btn" onclick="toggleNav()">
        <span>&#9776; Menú</span>
    </div>
    
    <div id="mySidenav" class="sidenav">
        <a href="proveedores.php"><i class="fas fa-truck me-2"></i>  Proveedores</a>
        <a href="clientes.php"><i class="fas fa-user me-2"></i> Clientes</a>
        <a href="productos.php"><i class="fas fa-box me-2"></i>     Productos</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>       Salir</a>
    </div>

    <script src="scripts/menu-script.js"></script>
</body>
</html>
