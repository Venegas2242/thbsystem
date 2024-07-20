<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$section_name = "Usuarios";
?>

<!DOCTYPE html>
<html ng-app="appUsuarios">

<head>
    <meta charset="UTF-8">
    <title><?php echo $section_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="./styles/usuarios-style.css"> -->
     <link rel="stylesheet" href="../assets/styles/footer.css">
    <style>
        .content-wrapper {
            padding-top: 5rem;
            /* Ajusta este valor según la altura de tu menú */
            padding-bottom: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
            background-color: #fff;
        }

        .table th,
        .table td {
            white-space: nowrap;
            padding: 12px 15px;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .add-user-btn {
            font-size: 1.5rem;
            background-color: rgb(253, 97, 17);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .add-user-btn:hover {
            background-color: #d5560d;
        }

        .add-user-btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(253, 97, 17, 0.5);
        }

        .btn-primary-custom {
            background-color: rgb(253, 97, 17);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #d5560d;
        }

        .btn-warning,
        .btn-danger {
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .modal-content {
            border-radius: 10px;
        }

        .form-control {
            border-radius: 5px;
        }
    </style>
</head>

<body ng-controller="cUsuarios">

    <?php include '../menu.php'; ?>

    <div class="container fade-in content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Usuarios Registrados</h3>
            <button class="add-user-btn" ng-click="abrirRegistroUsuarioModal()">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre de Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="usuario in usuarios">
                                <td>{{usuario.nombre}}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" ng-click="editarUsuario(usuario)">Editar Contraseña</button>
                                    <button class="btn btn-danger btn-sm" ng-click="eliminarUsuario(usuario.id)">Eliminar</button>
                                </td>
                            </tr>
                            <tr ng-if="usuarios.length == 0">
                                <td colspan="2" class="text-center">No hay usuarios registrados</td>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para registrar usuario -->
    <div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Registro de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form ng-submit="registrarUsuario()">
                        <div class="form-group">
                            <label for="usuario">Nombre de Usuario:</label>
                            <input type="text" class="form-control" id="usuario" ng-model="nuevoUsuario.usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" ng-model="nuevoUsuario.contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form ng-submit="actualizarContrasena()">
                        <div class="form-group">
                            <label for="nuevaContrasena">Nueva Contraseña:</label>
                            <input type="password" class="form-control" id="nuevaContrasena" ng-model="editarUsuarioData.contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <small><a href="http://www.tehiba.com">www.tehiba.com</a></small>
        </div>
    </div>

    <!-- Referencias Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js" type="text/javascript"></script>
    <script src="./scripts/usuarios-script.js"></script>
</body>

</html>