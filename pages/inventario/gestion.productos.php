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
                                        <h1 class="mb-1">Inventario - Productos</h1>
                                        <p class="text-muted fs-6 mb-0"> Gestión y visualización de productos internos del centro de servicio. Administra insumos, repuestos y herramientas. </p>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm border border-end border-white" agregar="true"> Añadir productos <i class="fa fa-plus"></i> </button>
                                            <button class="btn btn-primary btn-sm border border-white" carga="true"> Carga masiva productos <i class="fa fa-upload"></i> </button> <a class="btn btn-primary btn-sm border border-start border-white" stock="true" href="./entradas">
                                                Actualizar stock <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tabla de productos -->
                            <div class="table-responsive">
                                <table cuerpo="true" productos="true" class="table table-sm table-hover dt-responsive nowrap p-0 w-100">
                                    <thead class="thead-secondary">
                                        <tr>
                                            <th class="w-100px">Imagen</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Precio de compra</th>
                                            <th>Precio de venta</th>
                                            <th>Stock</th>
                                            <th>Proveedor</th>
                                            <th>Ubicación</th>
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
<div class="modal fade" id="modal_productos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Gestionar Productos</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm">
                <div>
                    <?=$producto;?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
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
                <h2 class="modal-title" id="exampleModalLabel">Carga Productos</h2>
                <button type="button" class="close cerrar" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm_carga">
                <div class="modal-body pb-0">
                    <div class="mensaje"></div>
                    <div class="card">
                        <div class="table-responsive p-4">
                            <table class="table table-sm table-bordered prod" tablas="true" prod="prod">
                                <thead class="text-center">
                                    <tr class="text-center bg-dark">
                                        <td width="6%" class="text-white">Código</td>
                                        <td width="10%" class="text-white">Descripción</td>
                                        <td width="5%" class="text-white">Precio compra</td>
                                        <td width="5%" class="text-white">Precio venta</td>
                                        <td width="4%" class="text-white">marca</td>
                                        <td width="3%" class="text-white">Proveedor</td>
                                        <td width="4%" class="text-white">Ubicación</td>
                                        <td width="1%" class="text-white">stock exis.</td>
                                        <td width="1%" class="text-white">stock min.</td>
                                        <td width="1%" class="text-center">
                                            <button class="btn btn-primary btn-sm act" type="button" mas="true"> <i class="fa fa-plus"></i> </button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody campos="true">
                                    <tr class="bg-light tr">
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja cod act" si="true" cod requerido>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja act" si="true" descripcion requerido>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja" si="true" requerido>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja" si="true">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja act" si="true">
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm caja provee act data-id" si="true" proveedor requerido>
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm caja ubica act" si="true" ubicacion requerido>
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja act" si="true">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm caja act" si="true">
                                        </td>
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
<script defer src="./assets/js/logica/inventario/gestion.productos.js?v<?=uniqid();?>"></script>
