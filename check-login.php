<?php
session_start();
include 'Connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $mysql = new Connection();
    $cnn = $mysql->getConnection();

    $query = $cnn->prepare("CALL proc_VerificarUsuario(?, ?)");
    $query->bind_param("ss", $usuario, $contrasenia);
    $query->execute();
    $query->store_result();
    $query->bind_result($idusuario, $is_valid);

    if ($query->num_rows > 0) {
        $query->fetch();
        if ($is_valid == 1) {
            $_SESSION['idusuario'] = $idusuario;
            $_SESSION['usuario'] = $usuario;
            header("Location: ./inicio/inicio.php");
            exit();
        } else {
            header("Location: login.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: login.php?error=Usuario no encontrado o inactivo");
        exit();
    }
    $query->close();
    $cnn->close();
} else {
    header("Location: login.php");
    exit();
}
?>