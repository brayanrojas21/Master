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
                                    <div class="col-lg-8 col-md-5">
                                        <h1>Punto de Venta</h1>
                                        <h3 class="mt-5">Querido Administrador</h3>
                                        <p>En esta vista podrás añadir ventas con el voton agregar y ver las ventas que has realizado en el tiempo el boton de ver</p>
                                    </div>
                                    <div class="col-lg-4 col-md-7 product-filter-options">
                                        <div class="account-user-info ms-auto">
                                            <button class="btn btn-danger" agregar="true">Agregar</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table cuerpo="true" class="table dt-responsive nowrap table-sm w-100 table-hover table-bordered">
                                            <thead class="thead-secondary p-4">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cliente</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha</th>
                                                    <th class="w-100px"></th>
                                                </tr>
                                                <tr class="filtros">
                                                    <th class="filtro"></th>
                                                    <th class="filtro"></th>
                                                    <th class="filtro"></th>
                                                    <th class="filtro"></th>
                                                    <td></td>
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
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Añade una venta</h2>
                <button class="btn btn-outline-danger" type="button" PDF="true" tipo="final" size="big">Descargar PDF<i class="fa fa-download" aria-hidden="true"></i></button>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="detalles p-3">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="id_cliente">Selecciona cliente</label>
                                        <div class="input-group">
                                            <select class="multiple form-control text-dark hidden show-tick caja" id="id_cliente" name="id_cliente" data-live-search="true" data-size="3" cliente="true" data-style="form-control-lg" data-container="body" required>
                                            </select>
                                            <button class="btn btn-outline-danger crear_modal" type="button" id="button-addon2" data-modal="#modal_clientes" data-envio="#frm_clientes">Crear cliente</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="id_cliente">Metodo de pago</label>
                                        <select class="multiple form-control text-dark hidden show-tick caja" id="pago" name="pago" atencion="true" data-style="form-control-lg" data-container="body" required>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="transaccion">Transaccion</option>
                                            <option value="garantia">Garantia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered cotizar" tablas="true" cotizar="cotizar">
                                <thead class="text-center">
                                    <tr class="text-center bg-dark">
                                        <td width="6%" class="text-white">Código</td>
                                        <td width="1%" class="text-white">Cantidad</td>
                                        <td width="10%" class="text-white">Descripción</td>
                                        <td width="5%" class="text-white">Tipo</td>
                                        <td width="5%" class="text-white">VR Unitario</td>
                                        <td width="4%" class="text-white">IVA(%)</td>
                                        <td width="3%" class="text-white">Descuento(%)</td>
                                        <td width="4%" class="text-white">VR Total</td>
                                        <td width="1%" class="text-center">
                                            <button class="btn btn-primary btn-sm caja" type="button" mas="true">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody campos="true">
                                    <tr class="bg-light">
                                        <td>
                                            <select class="form-control form-control-sm caja prod" cod="true" si="true" productos="true"></select>
                                        </td>
                                        <td><input type="number" class="form-control form-control-sm caja cantidad" calc si="true" cant cantidad requerido></td>
                                        <td><input type="text" name="tlb_nombre" class="form-control form-control-sm caja" si="true" descripcion requerido></td>
                                        <td><select name="tlb_tipo" class="form-control form-control-sm caja" si="true" tipo requerido>
                                                <option value="">-- Seleccionar --</option>
                                                <option value="interno">Interno</option>
                                                <option value="externo">Externo</option>
                                            </select></td>
                                        <td><input type="number" name="tlb_unidad" class="form-control form-control-sm caja" si="true" calc unidad requerido></td>
                                        <td><input type="text" name="tlb_iva" class="form-control form-control-sm caja" si="true" calc iva max="100"></td>
                                        <td><input type="number" name="tlb_descuento" class="form-control form-control-sm caja" calc si="true" descuento max="100"></td>
                                        <td><span total="true">0</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm caja" type="button" remover="true"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7"></td>
                                        <td colspan="2" total_final="true"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Confirma Compra</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?=$modalClientes; ?>
<script defer src="./assets/js/logica/punto_venta/gestion.caja.js?v<?=uniqid();?>"></script>
