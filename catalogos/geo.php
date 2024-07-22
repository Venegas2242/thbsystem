<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login.php");
    exit();
}

$section_name = "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Page Application</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="./scripts/geo-script.js"></script>
    <style>
        .content {
            display: none;
        }

        .content.active {
            display: block;
        }
    </style>
</head>

<body ng-app="geoApp" ng-controller="GeoController">
    <button ng-click="showPage('Paises')">Paises</button>
    <button ng-click="showPage('Estados')">Estados</button>
    <button ng-click="showPage('Ciudades')">Ciudades</button>

    <div id="Paises" class="content">
        <h1>Bienvenido a la página de Países</h1>
        <div>
            <label for="lsPaises">Paises</label>
            <ul id="lsPaises">
                <li ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</li>
            </ul>
        </div>
        <div>
            <div>
                <label for="newPais">País:</label>
                <input type="text" id="newPais" ng-model="pais_nuevo" class="form-control" />

                <button type="button" ng-click="registrarPais()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar País</button>
            </div>
        </div>
    </div>
    <div id="Estados" class="content">
        <h1>Bienvenido a la página de Estados</h1>
        <div>
            <label for="paisSeleccionado">Seleccione un país:</label>

            <select id="paisSeleccionado" ng-model="entidad.idpais" ng-change="cambiarPais()" class="form-control">
                <option value="">-- Seleccione un país --</option>
                <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
            </select>
        </div>
        <div>
            <h2>Estados del país seleccionado:</h2>
            <ul id="lsEstados">
                <li ng-repeat="estado in listaEstados">{{ estado.nombre }}</li>
            </ul>
        </div>

        <div>
            <label for="newEstado">Estado:</label>
            <input type="text" id="newEstado" ng-model="estado_nuevo" class="form-control" />
            <button type="button" ng-click="registrarEstado()" class="btn btn-primary">Guardar Estado</button>
        </div>
    </div>

    <div id="Ciudades" class="content">
        <h1>Bienvenido a la página de Ciudades</h1>
        <div>
            <label for="paisSeleccionado">Seleccione un país:</label>

            <select id="paisSeleccionado" ng-model="entidad.idpais" ng-change="cambiarPais()" class="form-control">
                <option value="">-- Seleccione un país --</option>
                <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
            </select>
        </div>
        <div>
            <label for="estadoSeleccionado">Seleccione un estado:</label>

            <select id="estadoSeleccionado" ng-model="entidad.idestado" ng-change="cambiarEstado()" class="form-control">
                <option value="">-- Seleccione un estado --</option>
                <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
            </select>
        </div>
        <div>
            <h2>Ciudades del estado seleccionado:</h2>
            <ul id="lsCiudades">
                <li ng-repeat="ciudad in listaCiudades">{{ ciudad.nombre }}</li>
            </ul>
        </div>

        <div>
            <label for="newCiudad">Ciudad:</label>
            <input type="text" id="newCiudad" ng-model="ciudad_nueva" class="form-control" />
            <button type="button" ng-click="registrarCiudad()" class="btn btn-primary">Guardar Ciudad</button>
        </div>
    </div>
</body>

</html>