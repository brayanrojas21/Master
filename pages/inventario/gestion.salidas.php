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
                                        <h1 class="mb-1">Inventario - Salidas</h1>
                                        <p class="text-muted fs-6 mb-0">Ver los productos que salen del inventario, ya sea por órdenes de servicio o ventas en caja. Registra cantidad, precio y actualiza el stock automáticamente. Solo se guarda una vez por orden o caja para evitar duplicados. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cuerpo="true" salidas="true" class="table dt-responsive nowrap table-sm w-100 table-hover">
                                    <thead class="thead-secondary p-4">
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio de venta</th>
                                            <th>Usuario</th>
                                            <th>Precio total</th>
                                            <th>Fecha de salida</th>
                                            <th>Salida</th>
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
<script defer src="./assets/js/logica/inventario/gestion.salidas.js?v<?=uniqid();?>"></script>
