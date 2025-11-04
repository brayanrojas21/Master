<div class="modal modal-2 fade" id="modal_mensajero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-focus="false">
    <div class="modal-dialog  modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-primary" id="exampleModalLabel">Selección de mensajero</h2>
                <button type="button" class="close ms-5" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm_mensajeros" data-opcion="false" data-tipo="mensajeros">
                <div class="modal-body pt-0 pb-0">
                    <div class="card">
                        <div class="container-fluid p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mensajero">Mensajero</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-lg" id="mensajero" name="mensajero" mensajero="true" titulo="mensajero" required></select>
                                            <button class="btn btn-primary" crearModal="true" type="button">Crear mensajero</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="d-none list-ticked" removerMensajero="true">
                                        <li nombre_mensajero="campo"></li>
                                        <li celular_mensajero="campo"></li>
                                        <li fecha_mensajero="campo"></li>
                                    </ul>
                                    <button class="btn btn-danger d-none enviar" removerMensajero="true" type="button">Remover mensajero</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary enviar" type="button">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>