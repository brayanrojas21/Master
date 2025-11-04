<!-- SmartWizard html -->
<div estados="true">
    <ul class="nav">
        <?php
        foreach ($estados as $key => $dato) {
        $paso = ($key - 1);?>
        <li class="nav-item">
            <a class="nav-link paso_<?=$paso;?>" data-texto="<?=$dato;?>" data-paso="<?=$paso;?>" href="#step-<?=$key;?>">
                <div class="num"><?=$key;?></div>
                <?=$dato;?>
            </a>
        </li>
        <?php } ?>
    </ul>

    <div class="tab-content h-auto rounded">
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" pasos="true">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="observacion">Añade una observación</label>
                        <textarea rows="9" class="form-control rounded caja" requerido id="observacion" name="observacion" titulo="Observación"></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Imagen</label>
                        <div id="imagen2" name="imagen2" requerido class="dropzone rounded dropzone-design text-center imagen2">
                            <div class="dz-default dz-message"><span>Arrastra la imagen aquí o da click para subirlos</span></div>
                        </div>
                    </div>
                </div>
                <div notificaciones="true">
                    <div class="notificaciones">
                        <button role="button" class="btn btn-success btn-sm" id="whatsapp" enviar_mensaje="true" desde="whatsapp" tipo="nuevo">
                            Notificar al Whatsapp <i class="fa fa-whatsapp" aria-hidden="true"></i>
                        </button>
                        <button role="button" class="btn btn-primary btn-sm" id="correo" desde="correo" size="big" tipo="nuevo" enviar_mensaje="true">
                            Notificar al Correo <i class="fa fa-envelope" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?=$estados_boton;?>
        </div>


        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" pasos="true">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="observacion">Añade un diagnóstico</label>
                        <textarea rows="9" class="form-control rounded caja" id="diagnostico" name="diagnostico" requerido titulo="Diagnóstico"></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Imagen</label>
                        <div id="imagen4" name="imagen4" class="dropzone rounded dropzone-design text-center imagen4">
                            <div class="dz-default dz-message"><span>Arrastra la imagen aquí o da click para subirlos</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-check d-flex justify-content-center">
                <input class="form-check-input me-2" type="checkbox" name="reparado" role="button" data-value="" reparado>
                <label class="form-check-label" for="reparado">
                    <b>Reparado</b>. en el estado de <b>Reparación</b> aparecerá el texto que pondrás aquí
                </label>
            </div>
            <?=$estados_boton;?>
        </div>

        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3" pasos="true">
            <div class="table-responsive">
                <table class="table table-sm rounded-bordered" tablas="true" cotizar="cotizar">
                    <thead class="text-center bg-light">
                        <tr>
                            <th style="width: 1% !important;">Código</th>
                            <th style="width: 280px;">Descripción</th>
                            <th style="width: 60px;">Cantidad</th>
                            <th style="width: 100px;">Tipo</th>
                            <th style="width: 120px;">VR Unitario</th>
                            <th style="width: 80px;">IVA(%)</th>
                            <th style="width: 90px;">Descuento(%)</th>
                            <th style="width: 120px;">VR Total</th>
                            <th style="width: 40px;"></th>
                            <th style="width: 40px;" class="text-center">
                                <button class="btn btn-inverse-success caja" type="button" mas="true">
                                    <i class="fa fa-plus m-0"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody campos="true">
                        <tr class="bg-light tr">
                            <td>
                                <div style="width: 360px">
                                    <select class="form-control form-control-sm caja prod" cod="true" si="true" productos="true" titulo="Cotización - Código" data-old="Fila nueva">
                                    </select>
                                </div>
                            </td>
                            <td><input type="text" class="form-control form-control-sm caja" si="true" descripcion requerido titulo="Cotización - Descripción" data-old="Fila nueva"></td>
                            <td><input type="number" class="form-control form-control-sm caja cantidad" calc si="true" cant cantidad requerido titulo="Cotización - Cantidad" data-old="Fila nueva"></td>
                            <td><select name="tlb_tipo" class="form-control form-control-sm caja" si="true" tipo requerido titulo="Cotización - Tipo" data-old="Fila nueva">
                                    <option value="" selected>-- Seleccionar --</option>
                                    <option value="interno">Interno</option>
                                    <option value="externo">Externo</option>
                                </select></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text bg-white pe-0 border-end-0" id="basic-addon1">$</span>
                                    <input type="number" class="form-control form-control-sm ps-1 border-start-0 caja" calc si="true" unidad requerido titulo="Cotización - VR Unitario" data-old="Fila nueva">
                                </div>
                            </td>
                            <td><input type="text" class="form-control form-control-sm caja" calc si="true" iva max="100" titulo="Cotización - IVA" data-old="Fila nueva"></td>
                            <td><input type="number" class="form-control form-control-sm caja" calc si="true" descuento max="100" titulo="Cotización - descuento" data-old="Fila nueva"></td>
                            <td><span total="true">0</span></td>
                            <td class="d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input checkbox caja" type="checkbox" data-ok="true" si="true" role="button" listo="ok" requerido title="Respuesto listo">
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-inverse-danger btn-rounded btn-icon caja" type="button" remover="true"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"></td>
                            <td colspan="3" total_final="true"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div notificaciones="true" class="m-4">
                <div class="notificaciones">
                    <h4 class="fw-bold mb-3">Notifica al cliente y envía el contrato de condiciones</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-danger btn-sm" type="button" PDF="true" tipo="final" size="big" title="Descargar cotización">
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-success btn-sm" role="button" id="whatsapp" enviar_mensaje="true" tipo="cotizacion" desde="whatsapp" title="Notificar al Whatsapp">
                            Notificar al Whatsapp <i class="fa fa-whatsapp fa-2" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" role="button" id="correo" enviar_mensaje="true" tipo="cotizacion" desde="correo" size="big" title="Notificar al Correo">
                            Notificar al Correo <i class="fa fa-envelope" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="d-flex justify-content-center">
                            <span class="badge bg-inverse-secondary badge-pill p-3 w-100 d-flex align-items-center justify-content-center gap-2">
                                <input class="form-check-input c-pointer" type="radio" name="estado_cotizacion" id="flexRadioDefault1" data-value="1" pendiente>
                                <label class="form-check-label mt-1 c-pointer text-secondary" for="flexRadioDefault1">Pendiente por aprobación</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="d-flex justify-content-center">
                            <span class="badge bg-inverse-secondary badge-pill p-3 w-100 d-flex align-items-center justify-content-center gap-2">
                                <input class="form-check-input c-pointer" type="radio" name="estado_cotizacion" id="flexRadioDefault2" data-value="2" no-autoriza>
                                <label class="form-check-label mt-1 c-pointer text-secondary" for="flexRadioDefault2">No autoriza</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="d-flex justify-content-center">
                            <span class="badge bg-inverse-secondary badge-pill p-3 w-100 d-flex align-items-center justify-content-center gap-2">
                                <input class="form-check-input c-pointer" type="radio" name="estado_cotizacion" id="flexRadioDefault3" data-value="3" no-justifica>
                                <label class="form-check-label mt-1 c-pointer text-secondary" for="flexRadioDefault3">No se justifica</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="d-flex justify-content-center">
                            <span class="badge bg-inverse-secondary badge-pill p-3 w-100 d-flex align-items-center justify-content-center gap-2">
                                <input class="form-check-input c-pointer" type="radio" name="estado_cotizacion" id="flexRadioDefault4" data-value="4" aprobar>
                                <label class="form-check-label mt-1 c-pointer text-secondary" for="flexRadioDefault4">Aprobar</label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <?=$estados_boton;?>
        </div>


        <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4" pasos="true">
            <div class="form-group">
                <label for="observacion">Añade una nota (Opcional)</label>
                <textarea rows="9" class="form-control rounded caja" id="notas" name="notas" titulo="Nota"></textarea>
            </div>
            <i cmp-reparado></i>
            <?=$estados_boton;?>
        </div>

        <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5" pasos="true">
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="form-group">
                        <label for="nota_final">Nota final (Opcional)</label>
                        <textarea rows="10" class="form-control rounded caja" id="nota_final" name="nota_final" titulo="Nota final"></textarea>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="form-group">
                        <label>Imagen final entrega</label>
                        <div id="imagen3" requerido name="imagen3" class="dropzone rounded dropzone-design text-center imagen3">
                            <div class="dz-default dz-message"><span>Arrastra la imagen aquí o da click para subirlos</span></div>
                        </div>
                    </div>
                </div>
                <div notificaciones="true" class="mt-4">
                    <div class="notificaciones">
                        <button class="btn btn-success btn-sm" role="button" id="whatsapp" enviar_mensaje="true" tipo="entrega" desde="whatsapp" title="Notificar al Whatsapp">
                            Notificar al Whatsapp <i class="fa fa-whatsapp fa-2" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-primary btn-sm caja" role="button" id="correo" enviar_mensaje="true" tipo="entrega" desde="correo" size="big">Notificar al Correo <i class="fa fa-envelope" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-end text-secondary fst-italic small" time="true"></div>
            <div class="row" caja_estados="true">
                <div class="col-md-6 col-sm-12">
                    <div class="form-check">
                        <input class="form-check-input me-2" type="checkbox" name="acepto[]" acepto="acepto" role="button">
                        <label class="form-check-label" for="acepto_1">
                            Me responsabilizo de pasar al siguiente paso y no poder editar después
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 text-end">
                    <div class="form-check">
                        <button class="btn btn-outline-danger btn-sm" type="button" next="true" baja="true" disabled>
                            Dar de baja <i class="fa fa-thumbs-down"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" type="button" next="true" disabled>
                            Entregar <i class="fa fa-trophy" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-5" pasos="true">
            <div class="container">
                <div contenido-final=true class="mt-3">
                    <label>Compartir encuesta</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-white" placeholder="Url de la encuesta" inp-encuesta readonly>
                        <button class="btn btn-success" encuesta-whatsapp tipo="encuesta" type="button"><i class="fa fa-whatsapp"></i> Enviar a Whatsapp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
