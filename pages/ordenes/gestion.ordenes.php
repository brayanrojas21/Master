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
                                    <h1>Gestión de Ordenes de servicio</h1>
                                </div>
                                <div class="col-lg-6 col-md-7 product-filter-options">
                                    <?php if ($user->privilegio != "tecnico" ) { ?>
                                    <div class="account-user-info ms-auto">
                                        <button class="btn btn-primary btn-sm" agregar="true">
                                            Agregar <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cuerpo="true" class="table principal dt-responsive nowrap table-sm w-100 table-hover p-0">
                                    <thead>
                                        <tr>
                                            <th style="width:6%;">Orden</th>
                                            <th style="width:28%;">Cliente</th>
                                            <th style="width:10%;">Tipo atención</th>
                                            <th style="width:10%;">Estado</th>
                                            <th style="width:14%;">Tipo Equipo</th>
                                            <th style="width:14%;">Modelo comercial</th>
                                            <th style="width:12%;">Marca</th>
                                            <th style="width:4%;">Creador</th>
                                            <th style="width:2%;"></th>
                                        </tr>
                                        <tr class="filtros">
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="filtro"></th>
                                            <th class="boton"></th>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-focus="false" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card w-100 p-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <!-- Título + ID + Badge -->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <h2 class="modal-title m-0 text-primary">
                                Orden de servicio #<span class="id_pos"></span>
                            </h2>
                            <span class="badge bg-danger h5 m-0" mitipo="true"></span>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="btn-group">
                                <button type="button" title="Descargar recibo en PDF" class="btn btn-primary btn-sm dropdown-toggle edit caja" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                    Descargar recibo en PDF <i class="fa fa-file-text" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" type="button" PDF="true" tipo="final" size="big">Tamaño grande</button></li>
                                    <li><button class="dropdown-item" type="button" PDF="true" tipo="final" size="small">Tamaño pequeño</button></li>
                                    <li><button class="dropdown-item edit caja" type="button" PDF="true" tipo="final" size="final">Generar Informe</button></li>
                                </ul>
                            </div>

                            <button title="Ver historial" class="btn btn-primary btn-sm edit" type="button" data-bs-toggle="modal" data-bs-target="#historial_modal" historial disabled>
                                Ver historial <i class="fa fa-history" aria-hidden="true"></i>
                            </button>

                            <button type="button" class="btn-close cerrar" aria-label="Close"></button>
                        </div>

                    </div>
                </div>
            </div>
            <form id="frm">
                <div class="modal-body pt-0">
                    <div class="container-fluid">
                        <div class="detalles">
                            <div class="row">
                                <!-- Selección de Cliente y Equipo -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card p-5">
                                        <div class="form-group">
                                            <label for="id_cliente">Selecciona cliente</label>
                                            <div class="input-group">
                                                <select class="form-control form-control-lg multiple" id="id_cliente" name="id_cliente" cliente="true" titulo="Cliente" required></select>
                                                <button class="btn btn-primary crear_modal caja" type="button" data-modal="#modal_clientes" data-envio="#frm_clientes">Crear cliente</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_equipo">Selecciona equipo</label>
                                            <div class="input-group">
                                                <select class="form-control form-control-lg multiple" id="id_equipo" name="id_equipo" equipos="true" titulo="Equipos" required></select>
                                                <button class="btn btn-primary crear_modal caja" type="button" data-modal="#modal_equipos" data-envio="#frm_equipos" data-necesita="marcas">Crear equipo</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo_atencion">Tipo de atención</label>
                                            <select class="form-control rounded" id="tipo_atencion" name="tipo_atencion" atencion="true" required titulo="Tipo de atención">
                                                <option value="reparación" selected>Reparación</option>
                                                <option value="garantía">Garantía</option>
                                                <option value="reingreso">Reingreso</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div caja_nueva="true"></div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <!-- Botón Mensajero -->
                                            <div class="col-md-2 col-12 d-flex flex-column align-items-center mb-2 mb-md-0" btnMensajero="true"></div>

                                            <!-- Fechas -->
                                            <div class="col-md-10 col-12 d-flex flex-column text-end">
                                                <div class="fst-italic small" fecha-creacion></div>
                                                <div class="fst-italic text-primary small" fecha-final></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Datos del Cliente -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="p-4 text-primary card">
                                        <h2 class="ps-2">Datos del cliente</h2>
                                        <ul class="list-group list-group-flush text-break rounded">
                                            <?php 
                                            $datos_cliente = [
                                                "Nombre del cliente" => "caja_nombre_empresa",
                                                "NIT" => "caja_nit_empresa",
                                                "Dirección" => "caja_direccion_empresa",
                                                "Nombre del Encargado" => "caja_nombre",
                                                "Teléfono del encargado" => "caja_telefono_encargado",
                                                "Correo de contacto" => "caja_correo_electronico"
                                            ];
                                            foreach ($datos_cliente as $label => $class) { ?>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 fw-bold"><?php echo $label; ?>:</div>
                                                    <div class="col-md-6 col-sm-12 <?php echo $class; ?> detalle"></div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <!-- Datos del Equipo -->
                                    <div class="mt-3 p-4 text-primary card">
                                        <h2 class="ps-2">Datos del equipo</h2>
                                        <ul class="list-group list-group-flush rounded text-break">
                                            <?php 
                                            $datos_equipo = [
                                                "Tipo de equipo" => "caja_tipo_equipo",
                                                "Marca" => "caja_marca",
                                                "Serie" => "caja_serie",
                                                "Modelo comercial" => "caja_modelo",
                                                "Modelo técnico" => "caja_modelo2",
                                                "Código interno" => "caja_codigo_interno"
                                            ];
                                            foreach ($datos_equipo as $label => $class) { ?>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 fw-bold"><?php echo $label; ?>:</div>
                                                    <div class="col-md-6 col-sm-12 <?php echo $class; ?> detalle"></div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" comenzar>
                        <div class="alert alert-warning alert-dismissible fade show m-2" role="alert">
                            <strong>¡Atención!</strong> Al hacer clic en COMENZAR, se generará la orden de servicio y se le asignará un número único.
                        </div>
                        <button class="btn btn-light cerrar" type="button">
                            Cancelar
                        </button>
                        <button class="btn btn-primary comenzar" type="submit">
                            Comenzar
                        </button>
                    </div>
                    <div id="estados" class="detalles_cont" hidden>
                        <?=$estados_vista;?>
                    </div>
                    <div class="col-12 detalles_cont" hidden>
                        <div class="row">
                            <div id="notita_general" class="form-group col-lg-5 col-sm-12">
                                <div class="card p-4">
                                    <label for="observacion">Añade notas a esta orden (esto no lo vera el cliente)</label>
                                    <textarea rows="9" class="form-control bg-notita" requerido id="notita" name="notita" titulo="Nota interna"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-7 col-sm-12">
                                <div class="card">
                                    <label for="observacion" class="p-4">Añade abonos a la orden</label>
                                    <div class="table-responsive ">
                                        <table class="table table-sm mb-5" tablas="true" abonos>
                                            <thead class="text-center bg-light">
                                                <tr>
                                                    <th width="20%">Abono</th>
                                                    <th width="10%">Fecha</th>
                                                    <th width="30%">Descripción</th>
                                                    <th width="1%" class="text-center pe-4">
                                                        <button class="btn btn-inverse-success btn-sm caja" type="button" mas="true">
                                                            <i class="fa fa-plus m-0"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody campos="true">
                                                <tr class="bg-light tr">
                                                    <td>
                                                        <div class="input-group ps-4">
                                                            <span class="input-group-text bg-white pe-0 border-end-0">$</span>
                                                            <input type="number" class="form-control form-control-sm ps-1 border-start-0 caja abono" calc abono si="true" titulo="Abono">
                                                        </div>
                                                    </td>
                                                    <td><input type="date" class="form-control form-control-sm caja" si="true" titulo="Fecha abono"></td>
                                                    <td><input type="text" class="form-control form-control-sm caja" si="true" titulo="Descripción abono"></td>
                                                    <td class="text-center pe-4">
                                                        <button class="btn btn-inverse-danger btn-rounded btn-icon caja" type="button" remover="true"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2" total_abonos="true"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer detalles_cont pt-0" hidden>
                    <button class="btn btn-light cerrar" type="button">Cerrar</button>
                    <button class="btn btn-primary" type="submit">
                        Guardar <i class="mdi mdi-content-save" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-2 fade" id="historial_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog  modal-lg modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header p-3 border-0 d-flex justify-content-end">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pt-0" historial_tabla="true"></div>
        </div>
    </div>
</div>

<!-- Llama para relación con otras ordenes -->
<?=$ordenModal; ?>
<?=$modalClientes; ?>
<?=$modalEquipos; ?>
<?=$modalMensajero; ?>

<script defer src="./assets/js/logica/ordenes/gestion.ordenes.js?v<?=time();?>"></script>
