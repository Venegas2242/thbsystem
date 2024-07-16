<div id="modalEntidadNuevo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Proveedor/Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="tipoEntidad">Tipo:</label>
                        <select id="tipoEntidad" ng-model="entidad.tipo" class="form-control">
                            <option value="">Proveedor</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtRFC">RFC:</label>
                        <input type="text" id="txtRFC" ng-model="entidad.rfc" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtNombreFiscal">Nombre Comercial:</label>
                        <input type="text" id="txtNombreFiscal" ng-model="entidad.nombrecomercial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtNombreComun">Nombre Referencia:</label>
                        <input type="text" id="txtNombreComun" ng-model="entidad.nombrecomun" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="txtDireccion">Dirección:</label>
                        <input type="text" id="txtDireccion" ng-model="entidad.direccion" class="form-control" />
                    </div>
                </div>
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label for="cmbPais">País:</label>
                        <select id="cmbPais" ng-model="entidad.idpais" ng-change="cambiarPais()" class="form-control">
                            <option value="">Seleccione un país</option>
                            <option ng-repeat="pais in listaPaises" value="{{pais.idpais}}">{{pais.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cmbEstado">Estado:</label>
                        <select id="cmbEstado" ng-model="entidad.idestado" ng-change="cambiarEstado()" class="form-control">
                            <option value="">Seleccione un estado</option>
                            <option ng-repeat="estado in listaEstados" value="{{estado.idestado}}">{{estado.nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cmbCiudad">Ciudad:</label>
                        <select id="cmbCiudad" ng-model="entidad.idciudad" class="form-control">
                            <option value="">Seleccione una ciudad</option>
                            <option ng-repeat="ciudad in listaCiudades" value="{{ciudad.idciudad}}">{{ciudad.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtTelefono">Teléfono:</label>
                        <input type="text" id="txtTelefono" ng-model="entidad.telefono" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCorreo">Correo:</label>
                        <input type="text" id="txtCorreo" ng-model="entidad.correo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtWeb">Página Web:</label>
                        <input type="text" id="txtWeb" ng-model="entidad.web" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtCredito">Monto Crédito:</label>
                        <input type="text" id="txtCredito" ng-model="entidad.credito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtDiasCredito">Días Crédito:</label>
                        <input type="text" id="txtDiasCredito" ng-model="entidad.diascredito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtSaldo">Saldo:</label>
                        <input type="text" id="txtSaldo" ng-model="entidad.saldo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cmbBanco">Banco:</label>
                        <select id="cmbBanco" ng-model="entidad.idbanco" class="form-control">
                            <option value="">Seleccione un banco</option>
                            <option ng-repeat="banco in listaBancos" value="{{banco.idbanco}}">{{banco.banco}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCuenta">Cuenta:</label>
                        <input type="text" id="txtCuenta" ng-model="entidad.cuenta" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtClabe">CLABE:</label>
                        <input type="text" id="txtClabe" ng-model="entidad.clabe" class="form-control" />
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