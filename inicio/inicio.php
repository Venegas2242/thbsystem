<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$idusuario = $_SESSION['idusuario'];
$section_name = "Inicio";
?>

<!DOCTYPE html>
<html ng-app="appReportes">
<head>
    <meta charset="UTF-8">
    <title><?php echo $section_name; ?></title>
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css"/>
</head>
<body style="padding-top: 4rem;">

    <?php include '../menu.php'; ?>

    <div class="container content-wrapper">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Bienvenido <?php echo $usuario; ?> con id <?php echo $idusuario; ?></h1>
            </div>
        </div>

    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js" type="text/javascript"></script>
</body>
</html>
