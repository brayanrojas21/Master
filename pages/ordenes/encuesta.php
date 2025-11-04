<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper pt-0">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-xl-8 col-lg-9 col-md-12 mx-auto">
                    <?php if ($aviable) { ?>
                    <div class="auth-form-light text-left p-5">
                        <h2 class="modal-title" id="exampleModalLabel">Orden de servicio #<?=$v->cod_orden?>
                        </h2>
                        <div class="brand-logo text-center">
                            <img src="<?=$dataEmpr->logo?>">
                        </div>
                        <form class="pt-3" id="frm">
                            <div>
                                <h4>Tu opinión es muy importante para nosotros, te invitamos a que realices la siguiente encuesta para ayudarnos a mejorar, muchas gracias</h4>
                            </div>
                            <div class="mt-2">
                                <p>1. ¿Solucionamos tu inquietud o problema?</p>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="uno" id="si_uno" autocomplete="off" value="si" required>
                                    <label class="btn btn-outline-primary" for="si_uno">Si</label>
                                    <input type="radio" class="btn-check" name="uno" id="no_uno" autocomplete="off" value="no">
                                    <label class="btn btn-outline-primary" for="no_uno">No</label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>2. ¿Cómo te pareció la atención por parte de nuestro equipo?</p>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="dos" id="muy_mala" autocomplete="off" value="1" required>
                                    <label class="btn btn-outline-primary" for="muy_mala">Muy mala</label>
                                    <input type="radio" class="btn-check" name="dos" id="mala" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="mala">Mala</label>
                                    <input type="radio" class="btn-check" name="dos" id="regular" autocomplete="off" value="3">
                                    <label class="btn btn-outline-primary" for="regular">Regular</label>
                                    <input type="radio" class="btn-check" name="dos" id="buena" autocomplete="off" value="4">
                                    <label class="btn btn-outline-primary" for="buena">Buena</label>
                                    <input type="radio" class="btn-check" name="dos" id="muy_buena" autocomplete="off" value="5">
                                    <label class="btn btn-outline-primary" for="muy_buena">Muy Buena</label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>3. Del 1 al 5 donde <b>1</b> es poco satisfecho y <b>5</b> muy satisfecho, ¿que tan satisfecho está con el servicio otorgado?</p>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="tres" id="satisfecho1" autocomplete="off" value="1" required>
                                    <label class="btn btn-outline-primary" for="satisfecho1">1</label>

                                    <input type="radio" class="btn-check" name="tres" id="satisfecho2" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="satisfecho2">2</label>

                                    <input type="radio" class="btn-check" name="tres" id="satisfecho3" autocomplete="off" value="3">
                                    <label class="btn btn-outline-primary" for="satisfecho3">3</label>

                                    <input type="radio" class="btn-check" name="tres" id="satisfecho4" autocomplete="off" value="4">
                                    <label class="btn btn-outline-primary" for="satisfecho4">4</label>

                                    <input type="radio" class="btn-check" name="tres" id="satisfecho5" autocomplete="off" value="5">
                                    <label class="btn btn-outline-primary" for="satisfecho5">5</label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>4. ¿Recomendarías este centro de servicio a un amigo o familiar que necesite mantenimiento o reparación de sus equipos?</p>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="cuatro" id="recomendar1" autocomplete="off" value="si" required>
                                    <label class="btn btn-outline-primary" for="recomendar1">Si</label>

                                    <input type="radio" class="btn-check" name="cuatro" id="recomendar2" autocomplete="off" value="no">
                                    <label class="btn btn-outline-primary" for="recomendar2">No</label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>5. ¿Tienes alguna sugerencia que nos permita mejorar nuestro servicio? (opcional)</p>
                                <textarea rows="9" class="form-control caja" name="pqr"></textarea>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Enviar</button>
                            </div>
                        </form>
                    </div>
                    <?php } else { ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8 my-auto">
                                <h1>Orden de servicio sin encuesta</h1>

                            </div>
                            <div class="col-sm-4">
                                <div class="text-center">
                                    <img src="<?=$dataEmpr->logo;?>" alt="logo" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script defer src="./assets/js/logica/ordenes/gestion.encuesta.js?v<?=uniqid();?>"></script>
