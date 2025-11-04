<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-7 col-md-12">
            <div class="detalles card ms-4 p-4">
                <!-- Código producto -->
                <div class="form-group">
                    <label for="codigo_producto" class="form-label">Código del producto</label>
                    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" required>
                </div>
                <!-- Información del producto -->
                <div class="row mb-3">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="nombre_producto" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="marcas" class="form-label">Marca</label>
                            <div class="input-group">
                                <select class="form-control" id="marcas" name="marca" marcas="true" titulo="marca" required></select>
                                <button class="btn btn-primary btn-sm" crearModal="true" type="button">Crear marca</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="id_proveedor" class="form-label">Proveedor</label>
                            <select class="multiple form-control text-dark required hidden show-tick" id="id_proveedor" name="id_proveedor" proveedor="true" data-style="form-control-lg" required></select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="id_ubicacion" class="form-label">Ubicación</label>
                            <select class="multiple form-control text-dark required hidden show-tick" id="id_ubicacion" name="id_ubicacion" ubicacion="true" data-style="form-control-lg" required></select>
                        </div>
                    </div>
                </div>
                <!-- Precios y stock -->
                <div class="row g-2">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="precio_compra" class="form-label">Precio compra</label>
                            <input type="text" precio="true" class="form-control" id="precio_compra" name="precio_compra">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="precio_venta" class="form-label">Precio venta</label>
                            <input type="text" precio="true" class="form-control" id="precio_venta" name="precio_venta">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="stock_min" class="form-label">Stock mínimo</label>
                            <input type="number" class="form-control" id="stock_min" name="stock_min" min="1">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="stock_existente" class="form-label c-pointer" data-title='Solo se puede modificar desde "Entradas"'>
                                Stock existente <i class="fa fa-question-circle" aria-hidden="true"></i>
                            </label>
                            <input type="number" class="form-control" id="stock_existente" name="stock_existente" noMod="true" min="1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5 col-md-12">
            <div class="informacion card me-4 p-4">
                <div class="col-12">
                    <div class="form-group">
                        <label>Imagen del producto</label>
                        <div id="imagen_producto" name="imagen_producto" class="dropzone dropzone-design text-center imagen_producto">
                            <div class="dz-default dz-message"><span>Arrastra la imagen aquí o da click para subirlos</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="multiple form-control text-dark required hidden show-tick" id="tipo" name="tipo" data-style="form-control-lg" required>
                                    <option value="interno">Interno</option>
                                    <option value="externo">Externo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="iva">IVA (%)</label>
                                <input type="text" class="form-control" id="iva" name="iva">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
