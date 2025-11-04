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
                                        <h1>Inventario - Proveedores</h1>
                                        <p class="m-0">Aquí puedes Agregar los proveedores</p>
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
                                                <th>NIT</th>
                                                <th>Nombre Proveedor</th>
                                                <th>Nombre contacto</th>
                                                <th>Telefono</th>
                                                <th>Correo</th>
                                                <th class="w-100px"></th>
                                            </tr>
                                            <tr class="filtros">
                                                <th class="filtro"></th>
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
                <h2 class="modal-title" id="exampleModalLabel">Gestionar Proveedor</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label for="nit">NIT</label>
                                    <input type="text" class="form-control" id="nit" name="nit" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipo_equipo">Nombre de Proveedor</label>
                                    <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" required>
                                </div>
                            </div>
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label for="nombre_contacto">Nombre de contacto</label>
                                    <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto">
                                </div>
                            </div>
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label for="telefono_contacto">Telefono de contacto</label>
                                    <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
                                </div>
                            </div>
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label for="correo_electronico">Correo Electronico</label>
                                    <input type="text" class="form-control" id="correo_electronico" name="correo_electronico" required>
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

<script defer src="./assets/js/logica/inventario/gestion.proveedores.js?v<?=uniqid();?>"></script>
