<?php ( !isset( $side_bar ) ) ? header( 'Location: /' ) : ""; ?>
<div class="container-scroller">
    <?=$nav_bar; ?>
    <div class="container-fluid page-body-wrapper">
        <?=$side_bar; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <?=$precarga; ?>
                                <div class="product-nav-wrapper p-4 pb-0 row">
                                    <div class="col-lg-6 col-md-5">
                                        <h1>Mis equipos</h1>
                                        <p>Aquí puedes ver tus equipos registrados ya sea activo o inactivo</p>
                                    </div>
                                    <div class="col-lg-6 col-md-7 product-filter-options">
                                        <div class="pr-5 ms-auto my-auto p-2">
                                            <button class="btn btn-danger" agregar="true">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table cuerpo="true" class="table dt-responsive nowrap table-sm w-100 table-hover">
                                        <thead class="thead-secondary p-4">
                                            <tr>
                                                <th class="w-100px">Imagen</th>
                                                <th>Cliente</th>
                                                <th>Tipo de equipo</th>
                                                <th>Modelo</th>
                                                <th>Marca</th>
                                                <th>Serie</th>
                                                <th>Código interno</th>
                                                <th>Estado</th>
                                                <th class="w-100px"></th>
                                            </tr>
                                            <tr class="filtros">
                                                <th class="filtro hidden"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th ></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Gestionar equipo</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm">
                <div class="modal-body">
                    <?=$equipo;?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script defer src="./assets/js/logica/equipos/gestion.equipos.js?v<?=uniqid();?>"></script>
