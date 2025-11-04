<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper pt-0">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-xl-4 col-lg-9 col-md-12 mx-auto">

                    <div class="auth-form-light text-left p-5">
                        <a href="./">
                            <i class="mdi mdi-keyboard-backspace my-auto"></i>
                            regresar
                        </a>
                        <div class="brand-logo text-center">
                            <img src="<?=$dataEmpr->logo;?>" alt="logo">
                        </div>
                        <h4>Ingreso de <?=$tipo?></h4>
                        <form class="pt-3 permitir-enter" id="frm" data-tipo="<?=$tipo?>">
                            <div class="mensaje"></div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" class="form-control" id="usuario">
                            </div>
                            <div class="form-group">
                                <label>Clave</label>
                                <input type="password" class="form-control" id="clave">
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>