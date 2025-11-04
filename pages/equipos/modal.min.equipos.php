<div class="modal modal-2 fade" id="modal_equipos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-focus="false">
    <div class="modal-dialog  modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-primary" id="exampleModalLabel">Crea un Equipo</h2>
                <button type="button" class="close ms-5" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm_equipos" data-opcion="grabar_equipo" data-tipo="equipo">
                <div class="modal-body pt-0 pb-0">
                    <div class="card">
                        <div class="container-fluid p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nit_empresa">Tipo de Equipo</label>
                                        <input type="text" class="form-control" id="tipo_equipo" name="tipo_equipo" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_empresa">Modelo Técnico</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="correo_electronico">Modelo Comercial</label>
                                        <input type="text" class="form-control" id="modelo2" name="modelo2" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefono_encargado">Marca</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-lg" id="marcas" name="marca" marcas="true" titulo="marca" required></select>
                                            <button class="btn btn-primary" crearModal="true" type="button">Crear marca</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefono_encargado">Serie</label>
                                        <input type="text" class="form-control" id="serie" name="serie">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefono_encargado">Código Interno</label>
                                        <input type="text" class="form-control" id="codigo_interno" name="codigo_interno">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="direccion_empresa">Estado</label>
                                        <select class="form-control form-control-lg" id="estado" name="estado" required>
                                            <option value="activo">Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                        </select>
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
