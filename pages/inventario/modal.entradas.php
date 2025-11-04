<div class="container-fluid">
    <div class="row">
        <div class="account-user-info ms-auto mb-5">
            <button class="btn btn-danger" agregar_entr="true">Actualiza estock</button>
        </div>
        <table cuerpo="true" class="table dt-responsive nowrap table-sm w-100 table-hover table-bordered">
            <thead class="thead-secondary p-4">
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Cantidad de entrada</th>
                    <th>Precio de compra</th>
                    <th>Usuario</th>
                    <th>Precio total</th>
                    <th>Fecha de entrada</th>
                </tr>
            </thead>
            <tbody campos="true"></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_entradas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Actualiza estock</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="frm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="detalles p-3">
                            <h4 class="text-center mb-5">Selecciona un producto</h4>
                            <?=$user;?>
                         
                        </div>
                        <div class="row">
                        <h4 class="text-center mb-5">Añade entrada</h4>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="nombre_empresa">Cantidad</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad">
                            </div>
                        </div>
                         <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="nombre_empresa">Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio">
                            </div>
                        </div>
                         <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="nombre_empresa">Stock Nuevo</label>
                                <input type="text" class="form-control" id="stock_nuevo" name="nombre_empresa">
                            </div>
                        </div>
                         <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="nombre_empresa">Valor total</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
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
<script defer src="./assets/js/logica/gestion.entradas.js?v<?=uniqid();?>"></script>