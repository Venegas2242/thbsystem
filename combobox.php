<?php
require_once 'cod-formulario-abc.php';

function generarComboBoxEstados() {
    $producto = new Productos();
    $estados = $producto->ObtenerEstados();
    echo '<div class="col-sm-4">';
    echo '    <label>Estado:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbEstado" class="form-control" ng-model="producto.idestado">';
    echo '            <option value="">Seleccione un estado</option>';
    foreach ($estados as $estado) {
        echo '            <option value="' . $estado["idestado"] . '">' . $estado["nombre"] . '</option>';
    }
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}

function generarComboBoxPaises() {
    $producto = new Productos();
    $paises = $producto->ObtenerPaises();
    echo '<div class="col-sm-4">';
    echo '    <label>Pais:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbPais" class="form-control" ng-model="producto.idpais">';
    echo '            <option value="">Seleccione un pais</option>';
    foreach ($paises as $pais) {
        echo '            <option value="' . $pais["idpais"] . '">' . $pais["nombre"] . '</option>';
    }
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}

function generarComboBoxCiudades() {
    $producto = new Productos();
    $ciuedades = $producto->ObtenerCiudad();
    echo '<div class="col-sm-4">';
    echo '    <label>Ciudad:</label>';
    echo '    <div class="form-group">';
    echo '        <select id="cmbCiudad" class="form-control" ng-model="producto.idciudad">';
    echo '            <option value="">Seleccione una ciudad</option>';
    foreach ($ciuedades as $ciudad) {
        echo '            <option value="' . $ciudad["idciudad"] . '">' . $ciudad["nombre"] . '</option>';
    }
    echo '        </select>';
    echo '    </div>';
    echo '</div>';
}

generarComboBoxPaises();
generarComboBoxEstados();
generarComboBoxCiudades();

?>