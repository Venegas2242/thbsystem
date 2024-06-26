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
        <a href="formulario-abc.php">Proveedores</a>
        <a href="clientes.php">Clientes</a>
        <a href="productos.php">Productos</a>
    </div>

    <script src="scripts/menu-script.js"></script>
</body>
</html>
