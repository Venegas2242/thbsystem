<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: login.php");
    exit();
}

$section_name = "Proveedores/Clientes";
?>

<!DOCTYPE html>
<html ng-app="appReportes">
<head>
    <meta charset="UTF-8">
    <title><?php echo $section_name; ?></title>
    <!-- Referencias CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="./styles/entidades-style.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <style>
        .table-responsive::-webkit-scrollbar {
            width: 12px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,.3); 
            border-radius: 10px;
            border: 3px solid rgba(255,255,255,.5);
        }
        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }
        .table {
            margin-bottom: 0;
            background-color: #fff;
        }
        .table th, .table td {
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
        .content-wrapper {
            margin-bottom: 20px;
        }
        .filter-label {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .filter-label i {
            margin-right: 8px;
        }
    </style>
</head>
<body ng-controller="cReportes">

    <?php include 'menu.php'; ?>

    <div class="container fade-in content-wrapper">
        <div class="main-content">
            <div class="card">
                <div class="card-body">
                    <label for="tabla" class="filter-label"><i class="fas fa-filter"></i>Filtros:</label>
                    <form>
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label>País:</label>
                                <select id="cmbPais" ng-model="ubicacion.idpais" ng-change="cambiarPais()" class="form-control">
                                    <option value="">Todos</option>
                                    <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Estado:</label>
                                <select id="cmbEstado" ng-model="ubicacion.idestado" ng-change="cambiarEstado()" class="form-control">
                                    <option value="">Todos</option>
                                    <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Ciudad:</label>
                                <select id="cmbCiudad" ng-model="ubicacion.idciudad" class="form-control">
                                    <option value="">Todas</option>
                                    <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo:</label>
                                <select id="cmbTipo" ng-model="ubicacion.tipo" class="form-control">
                                    <option value="">Proveedores</option>
                                    <option value="Cliente">Clientes</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" ng-click="generarReporte()">Generar Reporte</button>
                        <button type="button" class="btn btn-secondary" ng-click="descargarPDF(this.ubicacion)" ng-disabled="!detalles_entidad.length">
                        <i class="fa-solid fa-file-pdf"></i> Descargar PDF
                        </button>
                    </form>
                </div>
            </div>
            <div id="tablaReporte" class="table-responsive" ng-show="true">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre Comercial</th>
                            <th>Nombre Común</th>
                            <th>Dirección</th>
                            <th>RFC</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Web</th>
                            <th>Crédito</th>
                            <th>Saldo</th>
                            <th>Días de Crédito</th>
                            <th>Banco</th>
                            <th>Cuenta</th>
                            <th>CLABE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="detalles_entidad.length == 0">
                            <td colspan="13" class="text-center">No hay entidades que coincidan</td>
                        </tr>
                        <tr ng-repeat="entidad in detalles_entidad">
                            <td>{{entidad.nombrecomercial}}</td>
                            <td>{{entidad.nombrecomun}}</td>
                            <td>{{entidad.direccion}}</td>
                            <td>{{entidad.rfc}}</td>
                            <td>{{entidad.telefono}}</td>
                            <td>{{entidad.correo}}</td>
                            <td>{{entidad.web}}</td>
                            <td>{{entidad.credito}}</td>
                            <td>{{entidad.saldo}}</td>
                            <td>{{entidad.diascredito}}</td>
                            <td>{{entidad.banco}}</td>
                            <td>{{entidad.cuenta}}</td>
                            <td>{{entidad.clabe}}</td>
                        </tr>
                    </tbody>
                </table>
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
    <script src="scripts/reportes-script.js"></script>
</body>
</html>
