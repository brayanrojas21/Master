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
                                    <div class="col-lg-6 col-md-5 ">
                                        <h1>Gestión de Surcursales</h1>
                                        <h3 class="mt-5">Querido Administrador</h3>
                                        <p>Aquí podas crear, ver y administrar las sucursales de tu negocio y ver los empleados asignados</p>
                                    </div>
                                    <div class="col-lg-6 col-md-7 product-filter-options">
                                        <div class="account-user-info ms-auto">
                                            <button class="btn btn-danger" agregar="true" data-bs-target="#modal" data-bs-toggle="modal">Crear Sucursal</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table cuerpo="true" id="sucursales" class="table dt-responsive nowrap table-sm w-100 table-hover table-bordered">
                                        <thead class="thead-secondary p-4">
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Direccion</th>
                                                <th>Estado</th>
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
    <div class="modal-dialog  modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Gestionar Sucursal</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div>
                <form id="frm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_empresa">Descripcion</label>
                                        <textarea rows="5" class="form-control" id="descripcion" name="descripcion"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="direccion_empresa">Encargado</label>
                                        <select class="multiple form-control  text-dark hidden show-tick" id="id_usuario" name="id_usuario" usuarios="true" data-live-search="true" data-size="3" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="direccion_empresa">Estado</label>
                                        <select class="multiple form-control  text-dark hidden show-tick" id="estado" name="estado" required>
                                            <option value="activo">Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                        </select>
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

<script defer src="./assets/js/logica/sucursales/gestion.sucursales.js?v<?=uniqid();?>"></script>
