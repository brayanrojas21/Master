<div class="modal modal-2 fade" id="detalle_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog  modal-xl modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title col-12 col-md-6" id="exampleModalLabel">Orden de servicio #
                    <span class="align-middle" ref-id-orden></span>
                </h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="align-middle fst-italic" ref-fecha></div>
                <div class="align-middle fst-italic" ref-fechafin></div>
                <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="card border shadow">
                        <div class="card-header" role="tab" id="heading-10">
                            <h6 class="mb-0">
                                <a data-bs-toggle="collapse" href="#control_<?=$i;?>" aria-expanded="<?=($i == 1) ? "true" : "false";?>" aria-controls="control_<?=$i;?>"> <?=$dato[$i];?> </a>
                            </h6>
                        </div>
                        <div id="control_<?=$i;?>" class="collapse <?=($i == 1) ? 'show' : '';?>" role="tabpanel" aria-labelledby="heading-10" data-bs-parent="#accordion-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-auto text-center row" imagenes-orden-ref imagenes_<?=$i;?>></div>
                                    <div class="col-sm-12 col-md" contenido-orden-ref  contenido_<?=$i;?>></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="mt-3 mb-3 card-body border">
                    <h4>Abonos</h4>
                    <div contenido-orden-ref abonos-ref></div>
                </div>
                <div class="rounded bg-notita p-3">
                    <div contenido-orden-ref nota-ref></div>
                </div>
            </div>
        </div>
    </div>
</div>