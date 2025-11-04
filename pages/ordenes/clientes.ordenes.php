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
                                        <h1 >Mis de Ordenes de trabajo</h1>
                                    </div>
                                </div>
                                <div class="contenido" hidden>
                                    <table cuerpo="true" class="table principal dt-responsive nowrap table-sm w-100 table-hover table-bordered rounded-table">
                                        <thead class="thead-secondary">
                                            <tr >
                                                <th class="w-100px">Orden</th>
                                                <th width="100px">Tipo atención</th>
                                                <th width="300px">Tipo Equipo</th>
                                                <th width="100px">Modelo Comercial</th>
                                                <th width="300px">Marca</th>
                                                <th>Fecha de ingreso</th>
                                                <th width="100px">Estado</th>
                                                <th width="1px"></th>
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

<!-- Llama para relación con otras ordenes -->
<?=$ordenModal; ?>

<script defer src="./assets/js/logica/ordenes/clientes.ordenes.js?v<?=uniqid();?>"></script>
