<div id="modalProducto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>RFC:</label>
                        <input type="text" id="txtRFC" ng-model="producto.rfc" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre Comercial:</label>
                        <input type="text" id="txtNombreFiscal" ng-model="producto.nombrecomercial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre referencia:</label>
                        <input type="text" id="txtNombreComun" ng-model="producto.nombrecomun" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Direccion:</label>
                        <input type="text" id="txtDireccion" ng-model="producto.direccion" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>País:</label>
                        <select id="cmbPais" ng-model="ubicacion.idpais" ng-change="cambiarPais()" class="form-control">
                            <option value="">Seleccione un país</option>
                            <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado:</label>
                        <select id="cmbEstado" ng-model="ubicacion.idestado" ng-change="cambiarEstado()" class="form-control">
                            <option value="">Seleccione un estado</option>
                            <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md4">
                        <label>Ciudad:</label>
                        <select id="cmbCiudad" ng-model="ubicacion.idciudad" class="form-control">
                            <option value="">Seleccione una ciudad</option>
                            <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Teléfono:</label>
                        <input type="text" id="txtTelefono" ng-model="producto.telefono" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Correo:</label>
                        <input type="text" id="txtCorreo" ng-model="producto.correo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Página Web:</label>
                        <input type="text" id="txtWeb" ng-model="producto.web" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Monto crédito:</label>
                        <input type="text" id="txtCredito" ng-model="producto.credito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Días crédito:</label>
                        <input type="text" id="txtDiasCredito" ng-model="producto.diascredito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Saldo:</label>
                        <input type="text" id="txtSaldo" ng-model="producto.saldo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Banco:</label>
                        <input type="text" id="txtBanco" ng-model="producto.idbanco" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cuenta:</label>
                        <input type="text" id="txtCuenta" ng-model="producto.cuenta" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>CLABE:</label>
                        <input type="text" id="txtClabe" ng-model="producto.clabe" class="form-control" />
                    </div>
                </div>
            </div>                        
            <div class="modal-footer">
                <button type="button" ng-click="Grabar()" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>