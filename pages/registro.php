<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-xl-9 col-lg-9 col-md-12 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo text-center">
                            <img src="./assets/images/logo.png">
                        </div>
                        <h4 class="text-center">Crea tu usuario cliente</h4>
                        <h6 class="font-weight-light text-center">Regístrate Fácilmente en nuestra plataforma</h6>
                        <div class="mensaje"></div>
                        <form class="pt-3 permitir-enter" id="frm_registro">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="nombre_empresa">Nombre de la empresa</label>
                                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
                                    </div>
                                    <div class="form-group">
                                        <label for="nit_empresa">NIT de la empresa</label>
                                        <input type="text" class="form-control" id="nit_empresa" name="nit_empresa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion_empresa">Direccion de la empresa</label>
                                        <input type="text" class="form-control" id="direccion_empresa" name="direccion_empresa">
                                    </div>

                                    <div class="form-group">
                                        <label for="correo">Correo electronico (para iniciar sesión)</label>
                                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="clave">Clave</label>
                                        <input type="password" class="form-control" id="clave_nueva" name="clave_nueva" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="cedula_encargado">Cédula del encargado</label>
                                        <input type="text" class="form-control" id="cedula_encargado" name="cedula_encargado" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_encargado">Nombre del encargado</label>
                                        <input type="text" class="form-control" id="nombre_encargado" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono_encargado">Telefono de la persona encargada</label>
                                        <input type="text" class="form-control" id="telefono_encargado" name="telefono_encargado">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">

                            </div>
                            <div class="mt-3 text-center">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium" type="submit">REGISTRATE</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> ¿Ya tienes una cuenta? <a href="./Ingresar_clientes" class="text-primary">Ingresa</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<script defer src="./assets/js/logica/sesion.js"></script>
