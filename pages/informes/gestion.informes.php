<?php ( !isset( $side_bar ) ) ? header( 'Location: /' ) : ""; ?>

<div class="container-scroller">
    <?=$nav_bar; ?>
    <div class="container-fluid page-body-wrapper">
        <?=$side_bar; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <h1>Informes de equipos</h1>
                    <div class="col-xl-8 col-lg-7 col-md-12">
                        <div class="detalles p-3">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label for="id_cliente">Elige un equipo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" required>
                                        <button class="btn btn-outline-danger" type="button" id="button-addon2">Buscar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="id_cliente" class="mb-5">Eligue el tipo de informe que quieres generar</label>
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Informe General</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Certificado de baja</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Orden de servicio</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        descarga el informe de este equipo <br> <i class="mdi mdi-folder-download " style="font-size:100px"></i></div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">descarga el certificado de baja de este equipo<br> <i class="mdi mdi-folder-download " style="font-size:100px"></i></div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">descarga el informe de este equipo<br> <i class="mdi mdi-folder-download " style="font-size:100px"></i></div>
                </div>
            </div>

        </div>
    </div>
</div>
