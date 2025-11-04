<div class="modal modal-2 fade" id="modal_clientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog  modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-primary" id="exampleModalLabel">Agregar cliente</h2>
                <button type="button" class="close ms-5" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm_clientes" data-opcion="gestionar_cliente" data-tipo="cliente">
                <div class="modal-body pt-0 pb-0">
                    <div class="card">
                        <div class="container-fluid p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nit_empresa">Nit empresa / Cédula</label>
                                        <input type="text" class="form-control" id="nit_empresa" name="nit_empresa" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_empresa">Nombre empresa / persona</label>
                                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_empresa">Dirección empresa / persona</label>
                                        <input type="text" class="form-control" id="direccion_empresa" name="direccion_empresa">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_encargado">Nombre encargado</label>
                                        <input type="text" class="form-control" id="nombre_encargado" name="nombre">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="correo_electronico">Correo de contacto</label>
                                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefono_encargado">Teléfono principal</label>
                                        <input type="text" class="form-control" id="telefono_encargado" name="telefono_encargado">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefono_encargado">Teléfono secundario</label>
                                        <input type="text" class="form-control" id="telefono2_encargado" name="telefono2_encargado">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary enviar" type="button">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
