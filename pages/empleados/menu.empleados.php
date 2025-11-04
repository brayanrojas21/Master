<div class="container-scroller">
    <?=$nav_bar; ?>
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?=$side_bar; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-transparent shadow-none">
                            <?=$precarga; ?>
                            <div class="card-body">
                                <div class="row">
                                    <?php 
                                    if ($dataEmpr->sucursales) { ?>
                                    <h2 class="text-center">Sucursales</h2>
                                    <?php 
                                        foreach ($sucursales as $key => $datos) {  ?>
                                    <div class="col-md-4 col-xl-3 d-flex">
                                        <a class="card card-statistics text-decoration-none w-100" href="?suc=<?=$key;?>">
                                            <div class="card-block text-center my-auto">
                                                <h2 class="m-b-20"><?=$datos->nombre?></h2>
                                            </div>
                                        </a>
                                    </div>
                                    <?php } 
                                    } ?>
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2 bg-white mb-3 p-2">

                                    <!-- Selector de rango de fechas -->
                                    <div class="btn-group p-2 dropdown">
                                        <div class="dropdown">
                                            <div id="reportrange" class="btn btn-white text-light py-0 border-right dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-calendar text-dark"></i>&nbsp;
                                                <span class="text-dark"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <div class="input-group" style="width:350px!important">
                                            <label class="input-group-text bg-white" for="modelo">Modelo comercial:</label>
                                            <select class="form-select form-select-sm caja-filtros" class="multiple form-control text-dark hidden show-tick my-auto" id="modelo" data-style="form-control-sm" modeloc="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <div class="input-group" style="width:350px!important">
                                            <label class="input-group-text bg-white" for="modelo2">Modelo técnico:</label>
                                            <select class="form-select form-select-sm caja-filtros" class="multiple form-control text-dark hidden show-tick my-auto" id="modelo2" data-style="form-control-sm" modelot="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <div class="input-group" style="width:350px!important">
                                            <label class="input-group-text bg-white" for="marca">Marca:</label>
                                            <select class="form-select form-select-sm caja-filtros" class="multiple form-control text-dark hidden show-tick my-auto" id="marca" data-style="form-control-sm" marca="true">
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Botón excel -->
                                    <div class="btn-group p-2">
                                        <button type="button" class="btn btn-link text-dark py-0 border-right" role="button" reporte>
                                            <i class="fa fa-file-excel-o me-1"></i>Excel
                                        </button>
                                    </div>
                                </div>

                                <div class="card card-statistics ">
                                    <div class="row">
                                        <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                    <i class="mdi mdi-briefcase text-primary me-0 me-sm-4 icon-lg"></i>
                                                    <div class="wrapper text-center text-sm-left">
                                                        <p class="card-text mb-0 text-dark">Total de ordenes</p>
                                                        <div class="fluid-container">
                                                            <h3 class="mb-0 font-weight-medium text-dark" tTotales>0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline text-primary me-0 me-sm-4 icon-lg"></i>
                                                    <div class="wrapper text-center text-sm-left">
                                                        <p class="card-text mb-0 text-dark">Punto de venta</p>
                                                        <div class="fluid-container">
                                                            <h3 class="mb-0 font-weight-medium text-dark">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                    <i class="mdi mdi-trophy-outline text-primary me-0 me-sm-4 icon-lg"></i>
                                                    <div class="wrapper text-center text-sm-left">
                                                        <p class="card-text mb-0 text-dark">Ingresos totales</p>
                                                        <div class="fluid-container">
                                                            <h3 class="mb-0 font-weight-medium text-dark">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                    <i class="mdi mdi-briefcase-check text-primary me-0 me-sm-4 icon-lg"></i>
                                                    <div class="wrapper text-center text-sm-left">
                                                        <p class="card-text mb-0 text-dark">Ordenes finalizadas</p>
                                                        <div class="fluid-container">
                                                            <h3 class="mb-0 font-weight-medium text-dark" tFinal>0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Ordenes por tipo de atención</h4>
                                                <div class="alerta"></div>
                                                <div class="row">
                                                    <div class="col-md-6 aligner-wrapper grafica" ordenes>
                                                        <canvas class="my-4 my-md-auto w-100 h-100" id="[ordenes]"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Tipos de atención</h4>
                                                <div class="alerta"></div>
                                                <div class="row">
                                                    <div class="col-md-6 aligner-wrapper grafica" atencion>
                                                        <canvas class="my-4 my-md-auto" id="[atencion]"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-8 grid-margin stretch-card">
                                        <div class="card">
                                            <h4 class="card-title pt-5 ps-4">Ordenes pendientes por cotizar y por entregar</h4>
                                            <div class="alerta"></div>
                                            <div class="row">
                                                <div class="col-md-6 aligner-wrapper w-100">
                                                    <table cuerpo="true" ttentrega class="table dt-responsive nowrap table-sm w-100 table-hover">
                                                        <thead class="p-4">
                                                            <tr>
                                                                <th class="w-100px">Orden</th>
                                                                <th width='400px'>Cliente</th>
                                                                <th>Estado</th>
                                                                <th>Tipo Equipo</th>
                                                                <th>Modelo comercial</th>
                                                                <th class="w-100px"></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Estados de ordenes en cotización</h4>
                                                <div class="alerta"></div>
                                                <div class="row">
                                                    <div class="col-md-6 aligner-wrapper grafica" tcotizar>
                                                        <canvas class="my-4 my-md-auto chartjs-render-monitor" id="[tcotizar]"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-statistics ">
                                        <div class="row">
                                            <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                        <i class="mdi mdi-file-find text-primary me-0 me-sm-4 icon-lg"></i>
                                                        <div class="wrapper text-center text-sm-left">
                                                            <p class="card-text mb-0 text-dark">En diagnóstico</p>
                                                            <div class="fluid-container">
                                                                <h3 class="mb-0 font-weight-medium text-dark" tDiagnostico>-</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                        <i class="mdi mdi-table-edit text-primary me-0 me-sm-4 icon-lg"></i>
                                                        <div class="wrapper text-center text-sm-left">
                                                            <p class="card-text mb-0 text-dark">En cotización</p>
                                                            <div class="fluid-container">
                                                                <h3 class="mb-0 font-weight-medium text-dark" tCotizacion>-</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                        <i class="mdi mdi-hospital text-primary me-0 me-sm-4 icon-lg"></i>
                                                        <div class="wrapper text-center text-sm-left">
                                                            <p class="card-text mb-0 text-dark">En reparación</p>
                                                            <div class="fluid-container">
                                                                <h3 class="mb-0 font-weight-medium text-dark" tReparacion>-</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                                        <i class="mdi mdi-marker-check text-primary me-0 me-sm-4 icon-lg"></i>
                                                        <div class="wrapper text-center text-sm-left">
                                                            <p class="card-text mb-0 text-dark">Entrega</p>
                                                            <div class="fluid-container">
                                                                <h3 class="mb-0 font-weight-medium text-dark" tEntrega>-</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 grid-margin stretch-card">
                                        <div class="card">
                                            <h4 class="card-title pt-5 ps-4">Calificación de encuestas de satisfacción</h4>
                                            <div class="alerta"></div>
                                            <div class="row">
                                                <div class="col-md-6 aligner-wrapper w-100">
                                                    <table cuerpo="true" ttencuesta class="table dt-responsive nowrap table-sm w-100 table-hover">
                                                        <thead class="p-4">
                                                            <tr>
                                                                <th class="w-100px">Orden</th>
                                                                <th width='400px'>Cliente</th>
                                                                <th>Tipo Equipo</th>
                                                                <th>Modelo comercial</th>
                                                                <th>Puntuación</th>
                                                                <th class="w-100px"></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Estados de ordenes sin nueva recepción</h4>
                                                <div class="alerta"></div>
                                                <div class="row">
                                                    <div class="col-md-6 aligner-wrapper grafica" testado>
                                                        <canvas class="my-4 my-md-auto chartjs-render-monitor" id="[testado]"></canvas>
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
            </div>

        </div>
    </div>
</div>
<link rel="stylesheet" href="./assets/css/daterangepicker.css">
<script defer src="./assets/vendors/moment/daterangepicker.js?v1"></script>
<script defer src="./assets/vendors/chart.js/Chart.min.js"></script>
<script defer src="./assets/vendors/moment/moment-precise-range.min.js"></script>
<script defer src="./assets/js/logica/gestion.menu.js?v<?=uniqid();?>"></script>
