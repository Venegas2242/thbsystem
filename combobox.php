<?php
require_once 'cod-formulario-abc.php';

function generarComboBoxPaises() {
    echo '<div class="col-sm-4">';
    echo '    <label>País:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbPais" ng-model="producto.idpais" ng-change="cambiarPais()" class="form-control">';
    echo '            <option value="">Seleccione un país</option>';
    echo '            <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>';
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}

function generarComboBoxEstados() {
    echo '<div class="col-sm-4">';
    echo '    <label>Estado:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbEstado" ng-model="producto.idestado" ng-change="cambiarEstado()" class="form-control">';
    echo '            <option value="">Seleccione un estado</option>';
    echo '            <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>';
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}

function generarComboBoxCiudades() {
    echo '<div class="col-sm-4">';
    echo '    <label>Ciudad:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbCiudad" ng-model="producto.idciudad" class="form-control">';
    echo '            <option value="">Seleccione una ciudad</option>';
    echo '            <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>';
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}


generarComboBoxPaises();
generarComboBoxEstados();
generarComboBoxCiudades();

?>