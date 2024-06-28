<div id="modalProveedorNuevo" class="modal fade" role="dialog">
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
                        <input type="text" id="txtRFC" ng-model="proveedor.rfc" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre Comercial:</label>
                        <input type="text" id="txtNombreFiscal" ng-model="proveedor.nombrecomercial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre referencia:</label>
                        <input type="text" id="txtNombreComun" ng-model="proveedor.nombrecomun" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Direccion:</label>
                        <input type="text" id="txtDireccion" ng-model="proveedor.direccion" class="form-control" />
                    </div>
                </div>
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label>País:</label>
                        <select id="cmbPais" ng-model="proveedor.idpais" ng-change="cambiarPais()" class="form-control">
                            <option value="">Seleccione un país</option>
                            <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado:</label>
                        <select id="cmbEstado" ng-model="proveedor.idestado" ng-change="cambiarEstado()" class="form-control">
                            <option value="">Seleccione un estado</option>
                            <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Ciudad:</label>
                        <select id="cmbCiudad" ng-model="proveedor.idciudad" class="form-control">
                            <option value="">Seleccione una ciudad</option>
                            <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Teléfono:</label>
                        <input type="text" id="txtTelefono" ng-model="proveedor.telefono" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Correo:</label>
                        <input type="text" id="txtCorreo" ng-model="proveedor.correo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Página Web:</label>
                        <input type="text" id="txtWeb" ng-model="proveedor.web" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Monto crédito:</label>
                        <input type="text" id="txtCredito" ng-model="proveedor.credito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Días crédito:</label>
                        <input type="text" id="txtDiasCredito" ng-model="proveedor.diascredito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Saldo:</label>
                        <input type="text" id="txtSaldo" ng-model="proveedor.saldo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Banco:</label>
                        <input type="text" id="txtBanco" ng-model="proveedor.idbanco" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cuenta:</label>
                        <input type="text" id="txtCuenta" ng-model="proveedor.cuenta" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>CLABE:</label>
                        <input type="text" id="txtClabe" ng-model="proveedor.clabe" class="form-control" />
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