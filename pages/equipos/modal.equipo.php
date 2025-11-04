<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="p-3">
                <h4 class="text-center mb-5">Detalle del equipo</h4>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="tipo_equipo">Tipo de equipo</label>
                            <input type="text" class="form-control" id="tipo_equipo" name="tipo_equipo" placeholder="Ej. Taladro, pulidora..." required <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="modelo">Modelo Comercial</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="modelo2">Modelo Técnico</label>
                            <input type="text" class="form-control" id="modelo2" name="modelo2" <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="serie">Serie</label>
                            <input type="text" class="form-control" id="serie" name="serie" <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="codigo_interno">Código interno</label>
                            <input type="text" class="form-control" id="codigo_interno" name="codigo_interno" placeholder="Si no lo conoces, déjalo en blanco" <?=$null;?>>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" <?=$null;?>></textarea>
                        </div>
                    </div>
                     <div class="col-12" debaja>
                        <div class="form-group">
                            <label for="descripcion">Argumentos de baja</label>
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" <?=$null;?>></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 col-md-12 border">
            <div class="informacion p-3">
                <h4 class="text-center mb-5">Información adicional</h4>
                <div class="col-12">
                    <div class="form-group">
                        <label>Imagen equipo</label>
                        <div id="imagen" name="imagen" class="dropzone dropzone-design text-center" required>
                            <div class="dz-default dz-message"><span>Arrastra la imagen aquí o da click para subirlos</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="multiple form-control text-dark required hidden show-tick" id="estado" name="estado" data-style="form-control-lg" <?=$null;?> required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="inactivo">Dar de baja</option>
                        </select>
                        <div class="text-danger error"></div>
                    </div>
                </div>
                <?php if ($user->tipo == "empleados" && $null == false) { ?>
                <div class="col-12">
                    <div class="form-group">
                        <label for="id_cliente">Selecciona Cliente</label>
                        <select class="multiple form-control text-dark hidden show-tick" id="id_cliente" name="id_cliente" data-live-search="true" data-size="3" data-style="form-control-lg" cliente="true" data-container="body" required>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
