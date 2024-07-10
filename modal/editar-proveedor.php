<div id="modalProveedor" class="modal fade" role="dialog">
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
                        <input type="text" id="txtRFC" ng-model="detalles_proveedor.rfc" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre Comercial:</label>
                        <input type="text" id="txtNombreFiscal" ng-model="detalles_proveedor.nombrecomercial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nombre referencia:</label>
                        <input type="text" id="txtNombreComun" ng-model="detalles_proveedor.nombrecomun" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Direccion:</label>
                        <input type="text" id="txtDireccion" ng-model="detalles_proveedor.direccion" class="form-control" />
                    </div>
                </div>
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label>País:</label>
                        <input type="text" id="txtPais" value="detalles_proveedor.idpais" ng-model="detalles_proveedor.nombrepais" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado:</label>
                        <input type="text" id="txtEstado" value="detalles_proveedor.idestado" ng-value="detalles_proveedor.nombreestado" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Ciudad:</label>
                        <input type="text" id="txtCiudad" value="detalles_proveedor.idciudad" ng-value="detalles_proveedor.nombreciudad" class="form-control" disabled/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Teléfono:</label>
                        <input type="text" id="txtTelefono" ng-model="detalles_proveedor.telefono" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Correo:</label>
                        <input type="text" id="txtCorreo" ng-model="detalles_proveedor.correo" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Página Web:</label>
                        <input type="text" id="txtWeb" ng-model="detalles_proveedor.web" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Monto crédito:</label>
                        <input type="text" id="txtCredito" ng-model="detalles_proveedor.credito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Días crédito:</label>
                        <input type="text" id="txtDiasCredito" ng-model="detalles_proveedor.diascredito" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Saldo:</label>
                        <input type="text" id="txtSaldo" ng-model="detalles_proveedor.saldo" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Banco:</label>
                        <input type="text" id="txtBanco" value="detalles_proveedor.idbanco" ng-value="detalles_proveedor.nombrebanco" class="form-control" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cuenta:</label>
                        <input type="text" id="txtCuenta" ng-model="detalles_proveedor.cuenta" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label>CLABE:</label>
                        <input type="text" id="txtClabe" ng-model="detalles_proveedor.clabe" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-click="Actualizar_Proveedor(detalles_proveedor)" class="btn btn-primary-custom"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>