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
                                        <h1>Gestión de empleados</h1>
                                        <p class="m-0">Aquí puedes ver tus empleados registrados ya sean activos o inactivos </p>
                                    </div>
                                    <div class="col-lg-6 col-md-7 product-filter-options">
                                        <div class="account-user-info ms-auto">
                                            <button class="btn btn-danger" agregar="true">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabla" class="table dt-responsive nowrap table-sm w-100 table-hover table-bordered">
                                        <thead class="thead-secondary p-4">
                                            <tr>
                                                <th>Cédula</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Correo</th>
                                                <th class="w-100px">Estado</th>
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
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Gestionar empleado</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm">
                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-xl-8 col-lg-7 col-md-12">
                                <div class="detalles p-3">
                                    <h4 class="text-center mb-5">Detalle del empleado</h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="cedula">Cédula</label>
                                                <input type="text" class="form-control" id="cedula" name="cedula" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="apellido">Apellido</label>
                                                <input type="text" class="form-control" id="apellido" name="apellido">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="correo_electronico">Correo</label>
                                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="privilegio">Privilegio</label>
                                                <select class="multiple form-control  text-dark required hidden show-tick" id="privilegio" name="privilegio" data-style="form-control-lg" required>
                                                    <option value="Administrador">Administrador</option>
                                                    <option value="Comun">Común</option>
                                                    <option value="Tecnico">Técnico</option>
                                                </select>
                                                <div class="text-danger error"></div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select class="multiple form-control  text-dark required hidden show-tick" id="estado" name="estado" data-style="form-control-lg" required>
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                                <div class="text-danger error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-5 col-md-12 border">
                                <div class="informacion p-3">
                                    <h4 class="text-center mb-5">Información adicional</h4>
                                    <div class="form-group mt-3">
                                        <label for="clave">Clave Nueva</label>
                                        <input type="text" class="form-control" id="clave_nueva" name="clave_nueva">
                                    </div>
                                    <div class="form-group">
                                        <label for="estado">Sucursales</label>
                                        <select class="multiple form-control  text-dark hidden show-tick" id="sucursales" name="sucursales[]" data-style="form-control-lg" sucursales="true" multiple required></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="servicios_aprobados">Servicios para empleados</label>
                                        <select class="multiple form-control text-dark" id="servicios_aprobados" data-style="form-control-lg" name="servicios_aprobados[]" multiple required>
                                            <?php foreach($servicios as $ser) { ?>
                                            <option value="<?=$ser; ?>"><?=$ser; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                        <i class="mdi mdi-alert"></i>
                                        Puedes seleccionar multiples opciones, pero recuerda que es lo que el usuario va a ver
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
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

<script defer src="./assets/js/logica/empleados/gestion.empleados.js?v<?=uniqid();?>"></script>
