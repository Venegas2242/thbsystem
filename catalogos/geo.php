<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$section_name = "Ubicaciones";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $section_name; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/ubicaciones.css">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./scripts/geo-script.js"></script>

</head>

<body ng-app="geoApp" ng-controller="GeoController">
    <?php include '../menu.php'; ?>
    <div class="container content-wrapper">
        <div class="button-row btn-group btn-group-toggle" data-toggle="buttons">
            <button class="btn-outline-primary-custom" ng-click="showPage('Paises')" ng-class="{active: activePage === 'Paises'}">Paises</button>
            <button class=" btn-outline-primary-custom" ng-click="showPage('Estados')" ng-class="{active: activePage === 'Estados'}">Estados</button>
            <button class=" btn-outline-primary-custom" ng-click="showPage('Ciudades')" ng-class="{active: activePage === 'Ciudades'}">Ciudades</button>
        </div>

        <div class="content" ng-class="{active: activePage === 'Paises'}" ng-show="activePage === 'Paises'">
            <div>
                <label for="lsPaises">Paises</label>
                <ul id="lsPaises" class="list-group fixed-height">
                    <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="pais in listaPaises" value="{{pais.idpais}}">
                        {{pais.nombre}}
                        <span>
                            <i class="fas fa-edit mr-2" ng-click="editPais(pais)"></i>
                            <i class="fas fa-trash" ng-click="deletePais(pais)"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div>
                <div>
                    <label for="newPais">País:</label>
                    <div ng-if="errorMessage" class="alert alert-danger" role="alert">
                        {{ errorMessage }}
                    </div>
                    <input type="text" id="newPais" ng-model="pais_nuevo" class="form-control" />
                    <button type="button" ng-click="registrarPais()" class="btn btn-primary-custom mt-2">Guardar País</button>
                </div>
            </div>
        </div>

        <div class="content" ng-class="{active: activePage === 'Estados'}" ng-show="activePage === 'Estados'">
            <div>
                <label for="lsPaises">Seleccione un país:</label>
                <ul id="lsPaises" class="list-group fixed-height">
                    <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="pais in listaPaises" ng-click="selectPais(pais)" ng-class="{active: pais.idpais === entidad.idpais}">
                        {{pais.nombre}}
                    </li>
                </ul>
            </div>
            <div>
                <h2>Estados del país seleccionado:</h2>
                <ul id="lsEstados" class="list-group fixed-height">
                    <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="estado in listaEstados" ng-click="selectEstado(estado)" ng-class="{active: estado.idestado === entidad.idestado}">
                        {{estado.nombre}}
                        <span>
                            <i class="fas fa-edit mr-2" ng-click="editEstado(estado)"></i>
                            <i class="fas fa-trash" ng-click="deleteEstado(estado)"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div>
                <label for="newEstado">Estado:</label>
                <div ng-if="errorMessage" class="alert alert-danger" role="alert">
                    {{ errorMessage }}
                </div>
                <input type="text" id="newEstado" ng-model="estado_nuevo" class="form-control" />
                <button type="button" ng-click="registrarEstado()" class="btn btn-primary-custom mt-2">Guardar Estado</button>
            </div>
        </div>

        <div class="content" ng-class="{active: activePage === 'Ciudades'}" ng-show="activePage === 'Ciudades'">
            <div class="d-flex">
                <div class="flex-fill">
                    <label for="lsPaises">Seleccione un país:</label>
                    <ul id="lsPaises" class="list-group fixed-height">
                        <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="pais in listaPaises" ng-click="selectPais(pais)" ng-class="{active: pais.idpais === entidad.idpais}">
                            {{pais.nombre}}
                        </li>
                    </ul>
                </div>
                <div class="flex-fill ml-3">
                    <label for="lsEstados">Seleccione un estado:</label>
                    <ul id="lsEstados" class="list-group fixed-height">
                        <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="estado in listaEstados" ng-click="selectEstado(estado)" ng-class="{active: estado.idestado === entidad.idestado}">
                            {{estado.nombre}}
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <h2>Ciudades del estado seleccionado:</h2>
                <ul id="lsCiudades" class="list-group fixed-height">
                    <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="ciudad in listaCiudades">
                        {{ ciudad.nombre }}
                        <span>
                            <i class="fas fa-edit mr-2" ng-click="editCiudad(ciudad)"></i>
                            <i class="fas fa-trash" ng-click="deleteCiudad(ciudad)"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div>
                <label for="newCiudad">Ciudad:</label>
                <div ng-if="errorMessage" class="alert alert-danger" role="alert">
                    {{ errorMessage }}
                </div>
                <input type="text" id="newCiudad" ng-model="ciudad_nueva" class="form-control" />
                <button type="button" ng-click="registrarCiudad()" class="btn btn-primary-custom mt-2">Guardar Ciudad</button>
            </div>
        </div>
    </div>

    <?php include './modal/editar-ubicacion.php'; ?>
</body>

</html>