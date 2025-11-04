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
                            <div class="card-body">
                                <div class="product-nav-wrapper row">
                                    <div class="col-lg-6 col-md-5">
                                        <h1>Inventario - Ubicaciones</h1>
                                        <p class="m-0">Aquí puedes ver las ubicaciones el las cuales se encuentran los productos (Ejemplo: Bodega, vitrina...) </p>
                                    </div>
                                    <div class="col-lg-6 col-md-7 product-filter-options">
                                        <div class="account-user-info ms-auto">
                                            <button class="btn btn-danger" agregar="true">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table cuerpo="true" class="table dt-responsive nowrap table-sm w-100 table-hover table-bordered">
                                        <thead class="thead-secondary p-4">
                                            <tr>
                                                <th>Tipo de Ubicación</th>
                                                <th>Numeración</th>
                                                <th>Nombre Sucursal</th>
                                                <th width="5%">Estado Sucursal</th>
                                                <th class="w-100px"></th>
                                            </tr>
                                            <tr class="filtros">
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th class="filtro"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody campos="true"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Gestionar Ubicación</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div>
                <form id="frm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tipo_ubicacion">Tipo de Ubicación</label>
                                        <input type="text" class="form-control" id="tipo_ubicacion" name="tipo_ubicacion" placeholder="Ej. estante, bodega..." required>
                                    </div>
                                </div>
                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="numeracion">Numeración</label>
                                        <input type="text" class="form-control" id="numeracion" name="numeracion">
                                    </div>
                                </div>
                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea rows="5" class="form-control" id="descripcion" name="descripcion"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_sucursal">Sucursal</label>
                                        <select class="multiple form-control  text-dark required hidden show-tick" id="id_sucursal" name="id_sucursal" sucursal="true" data-style="form-control-lg" required></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script defer src="./assets/js/logica/inventario/gestion.ubicaciones.js?v<?=uniqid();?>"></script>
