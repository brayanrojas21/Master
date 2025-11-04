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
                                            <div class="p-4 pb-0">
                                                <!-- Encabezado y botones -->
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-6">
                                                        <h1 class="mb-1">Inventario - Entradas</h1>
                                                        <p class="text-muted fs-6 mb-0"> Registro de productos ingresados al inventario. Cada entrada representa el ingreso de nuevos productos o reposición de existencias, registrando cantidad, precio y fecha para mantener actualizado el stock. </p>
                                                    </div>
                                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                                        <div class="btn-group " role="group">
                                                            <button class="btn btn-primary btn-sm border border-end border-white" agregar="true"> Añadir Entradas <i class="fa fa-plus"></i> </button>
                                                            <button class="btn btn-primary btn-sm border border-white" carga="true"> Carga masiva entradas <i class="fa fa-upload"></i> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table cuerpo="true" entradas="true" class="table table-hover table-sm w-100 p-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Nombre producto</th>
                                                            <th>Proveedor</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio compra</th>
                                                            <th>Empleado</th>
                                                            <th>Precio total</th>
                                                            <th>Fecha entrada</th>
                                                            <th class="w-100px"></th>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Actualiza stock</h2>
                    <button type="button" class="close cerrar" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <form id="frm">
                    <div class="modal-body pt-0">
                        <div class="container-fluid pt-0">
                            <!-- Sección: Selección de producto -->
                            <div class="p-4 mb-4">
                                <div class="row g-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="card ">
                                            <div class="card-body">
                                                <label for="id_productos" class="form-label">Producto</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="id_productos" name="id_productos" data-live-search="true" data-size="3" required productos="true"> </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-sm-12">
                                        <div class="card border-primary h-100">
                                            <div class="card-body" id="detalle_equipo" detalle_equipo="true">
                                                <h5 class="card-title mb-3" producto-nombre>Descripción del producto</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <ul class="list-group list-group-flush small">
                                                            <li class="list-group-item"><b>Código:</b> <span class="caja_codigo_producto" cajas></span></li>
                                                            <li class="list-group-item"><b>Producto:</b> <span class="caja_nombre_producto" cajas></span></li>
                                                            <li class="list-group-item"><b>Marca</b> <span class="caja_marca"></span></li>
                                                            <li class="list-group-item"><b>Modelo:</b> <span class="caja_modelo" cajas></span></li>
                                                            <li class="list-group-item"><b>Proveedor:</b> <span class="caja_proveedor" cajas></span></li>
                                                            <li class="list-group-item"><b>Ubicación:</b> <span class="caja_tipo_ubicacion" cajas></span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul class="list-group list-group-flush small">
                                                            <li class="list-group-item"><b>Precio de compra:</b> <span class="caja_precio_compra" cajas></span></li>
                                                            <li class="list-group-item"><b>Precio de venta:</b> <span class="caja_precio_venta" cajas></span></li>
                                                            <li class="list-group-item"><b>IVA (%):</b> <span class="caja_iva" cajas></span></li>
                                                            <li class="list-group-item"><b>Stock mínimo:</b> <span class="caja_stock_min" cajas></span></li>
                                                            <li class="list-group-item"><b>Stock existente:</b> <span class="caja_stock_existente badge badge-primary" cajas></span> </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sección: Registro de entrada -->
                            <div class="card p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control cant_entrada caja" id="cantidad" name="cantidad" cantidad="cantidad" required> </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="precio" class="form-label">Precio unitario</label>
                                        <input type="number" class="form-control precio_entrada caja" id="precio" name="precio" precio="precio" required> </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Stock actualizado</label>
                                        <p class="form-control-lg border rounded p-2 bg-light text-center" stock_nuevo="true" cajas>-</p>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label">Valor total</label>
                                        <p class="form-control-lg border rounded p-2 bg-light text-center" valor_total="true" cajas>-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light cerrar" type="button">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade modalgeneral" id="modal_carga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
        <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Cargar Entradas</h2>
                    <button type="button" class="close cerrar" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <form id="frm_carga">
                    <div class="modal-body">
                        <div class="mensaje"></div>
                        <div class="card p-4">
                            <div class="table-responsive card-body">
                                <table class="table table-sm table-bordered prod" tablas="true" prod="prod">
                                    <thead class="text-center">
                                        <tr class="text-center bg-dark">
                                            <td width="6%" class="text-white">Producto</td>
                                            <td width="1%" class="text-white">Cantidad</td>
                                            <td width="1%" class="text-white">Precio Compra</td>
                                            <td width="1%" class="text-center">
                                                <button class="btn btn-primary btn-sm act" type="button" mas="true"> <i class="fa fa-plus"></i> </button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody campos="true">
                                        <tr class="bg-light tr">
                                            <td>
                                                <select class="form-control form-control-sm caja caja cod act" si="true" cod requerido></select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm caja act" si="true"> </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm caja act" si="true"> </td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm caja" type="button" remover="true"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button class="btn btn-light cerrar" type="button">Cancelar</button>
                        <button class="btn btn-primary enviar" type="button">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script defer src="./assets/js/logica/inventario/gestion.entradas.js?v<?=uniqid();?>"></script>