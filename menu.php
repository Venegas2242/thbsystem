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

    <script>
        let navToggleCount = 0;

        function toggleNav() {
            navToggleCount++;
            if (navToggleCount % 2 === 1) {
                document.getElementById("mySidenav").style.width = "15rem"; /* 250px to 15rem */
                document.querySelector('.content-wrapper').style.marginLeft = "15rem"; /* 250px to 15rem */
            } else {
                document.getElementById("mySidenav").style.width = "0";
                document.querySelector('.content-wrapper').style.marginLeft = "auto";
                document.querySelector('.content-wrapper').style.marginRight = "auto";
            }
        }
    </script>
</body>
</html>
