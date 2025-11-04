<?php
require_once 'modelo/basedatos/Conexion.php';
require_once 'modelo/dao/UsuarioDao.php';
require_once 'GenericoControlador.php';
require_once 'excepcion/ValidacionExcepcion.php';
require_once 'util/Validacion.php';
require_once 'GestionDatos.php';

class VistaControlador  extends GenericoControlador {

    private $usuarioDAO;

    public function __construct( &$cnn = NULL ) {
        if ( empty( $cnn ) ) {
            $cnn = Conexion::conectar();
        }
        $this->usuarioDAO = new UsuarioDAO( $cnn );
        $this->sesion = "sesion";
        $this->SideBar = "partials/_sidebar.php";
        $this->NavBar = "partials/_navbar.php";
        $this->Equipo = "pages/equipos/modal.equipo.php";
        $this->Estados = "pages/ordenes/modal.estados.php";
        $this->Inventario = "pages/modal.inventario.php";
        $this->EstadosOrden = "partials/_estados.php";
        $this->precarga = "partials/_precarga.php";
        $this->Productos = "pages/inventario/modal.productos.php";
        $this->Entradas = "pages/inventario/modal.entradas.php";
        $this->Salidas = "pages/inventario/modal.salidas.php";
        $this->Ubicaciones = "pages/modal.ubicaciones.php";
        $this->Proveedores = "pages/modal.proveedores.php";
        $this->orden = "partials/_orden.php";
        $this->modalClientes = "pages/clientes/modal.min.clientes.php";
        $this->modalEquipos = "pages/equipos/modal.min.equipos.php";
        $this->modalMensajero = "pages/mensajero/modal.min.mensajero.php";
    }

    public function Panel( $vista ) {
        $dataEmpr = $this->usuarioDAO->empresa();
        $titulo = ucwords( str_replace( "_", " ", $vista ) );
        //Datos requeridos
        require_once "partials/_header.php";
        require_once "pages/inicio.php";
    }

    public function Ingresar_clientes( $vista ) {
        GenericoControlador::CerrarSesion();
        $dataEmpr = $this->usuarioDAO->empresa();
        $titulo = ucwords( str_replace( "_", " ", $vista ) );
        $tipo = "clientes";
        $js = $this->sesion;
        //Datos requeridos
        require_once "partials/_header.php";
        require_once "pages/login.php";
        require_once "partials/_footer.php";
    }

    public function Ingresar_empleados( $vista ) {
        GenericoControlador::CerrarSesion();
        $dataEmpr = $this->usuarioDAO->empresa();
        $titulo = ucwords( str_replace( "_", " ", $vista ) );
        $tipo = "empleados";
        $js = $this->sesion;
        //Datos requeridos
        require_once "partials/_header.php";
        require_once "pages/login.php";
        require_once "partials/_footer.php";
    }

    public function Registro( $vista ) {
        GenericoControlador::CerrarSesion();
        $dataEmpr = $this->usuarioDAO->empresa();
        $titulo = ucwords( str_replace( "_", " ", $vista ) );
        //Datos Vistas
        require_once "partials/_header.php";
        require_once "pages/registro.php";
        require_once "partials/_footer.php";
    }

    private function obtenerDatosGenerales( $vista, $dato ) {
        $user = GenericoControlador::Sesion();
        $side_bar = $user->servicios_aprobados;
        $iconos = DatosGenerales::servicios();
        $data_side = GenericoControlador::iconos( $side_bar, $iconos );
        $inventario = DatosGenerales::inventario();
        $mi_sucur = ( isset( $user->sucursales ) && $user->tipo == "empleados" )
        ? json_decode( $user->sucursales )
        : "clientes";
        $titulo = ucwords( str_replace( "_", " ", $vista ) );
        $dataEmpr = $this->usuarioDAO->empresa();
        $sucursales = $this->usuarioDAO->listado_sucursales();
        $sucursales = GenericoControlador::Sucursales( $sucursales, $mi_sucur );
        $nav_bar = GenericoControlador::SideBar( $dataEmpr, $this->NavBar, $data_side, $user, $mi_sucur, $dato, $inventario, $sucursales );
        $side_bar = GenericoControlador::SideBar( $dataEmpr, $this->SideBar, $data_side, $user, $mi_sucur, $dato, $inventario, $titulo );
        $precarga = GenericoControlador::vistas( $this->precarga, $sucursales, $dato, $dataEmpr );
        $data_validacion = in_array( "gestion inventario", $data_side ) ? array_merge( $data_side, [$vista] ) : $data_side;
        return compact( 'user', 'data_side', 'inventario', 'mi_sucur', 'dataEmpr', 'sucursales', 'nav_bar', 'side_bar', 'precarga', 'data_validacion', 'titulo' );
    }

    public function Inicio( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        require_once "partials/_header.php";
        require_once "pages/{$user->tipo}/menu.{$user->tipo}.php";
        require_once "partials/_footer.php";
    }

    public function gestion_empleados( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $servicios = DatosGenerales::servicios();
        require_once "partials/_header.php";
        require_once "pages/empleados/gestion.empleados.php";
        require_once "partials/_footer.php";
    }

    public function gestion_clientes( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $servicios = DatosGenerales::servicios_clientes();
        require_once "partials/_header.php";
        require_once "pages/clientes/gestion.clientes.php";
        require_once "partials/_footer.php";
    }

    public function gestion_de_equipos( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $equipo = GenericoControlador::Equipo( $this->Equipo, $user, false );
        require_once "partials/_header.php";
        require_once "pages/equipos/inventario_equipos.php";
        require_once "partials/_footer.php";
    }

    public function gestion_sucursales( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        GenericoControlador::ValidarVista( $vista, $data_side, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/sucursales/gestion.sucursales.php";
        require_once "partials/_footer.php";
    }

    public function ordenes( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $estados = DatosGenerales::estados();
        $ordenModal = GenericoControlador::vistas( $this->orden, "", $estados, $dataEmpr );
        $estadosOrden = GenericoControlador::vistas( $this->EstadosOrden, "", "", $dataEmpr );
        $modalClientes = GenericoControlador::vistas( $this->modalClientes, "", "", $dataEmpr );
        $modalEquipos = GenericoControlador::vistas( $this->modalEquipos, "", "", $dataEmpr );
        $modalMensajero = GenericoControlador::vistas( $this->modalMensajero, "", "", $dataEmpr );
        $estados_vista = GenericoControlador::Estados( $this->Estados, $user, $estados, $estadosOrden );
        GenericoControlador::ValidarVista( $vista, $data_side, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/ordenes/gestion.ordenes.php";
        require_once "partials/_footer.php";
    }

    //Inventario
    public function productos( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $producto = GenericoControlador::Equipo( $this->Productos, $user, "aviable" );
        GenericoControlador::ValidarVista( $vista, $data_validacion, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/inventario/gestion.productos.php";
        require_once "partials/_footer.php";
    }

    public function entradas( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $producto = GenericoControlador::Equipo( $this->Productos, $user, "disabled" );
        GenericoControlador::ValidarVista( $vista, $data_validacion, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/inventario/gestion.entradas.php";
        require_once "partials/_footer.php";
    }

    public function salidas( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $producto = GenericoControlador::Equipo( $this->Productos, $user, "disabled" );
        GenericoControlador::ValidarVista( $vista, $data_validacion, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/inventario/gestion.salidas.php";
        require_once "partials/_footer.php";
    }

    public function proveedores( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $producto = GenericoControlador::Equipo( $this->Productos, $user, "disabled" );
        GenericoControlador::ValidarVista( $vista, $data_validacion, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/inventario/gestion.proveedores.php";
        require_once "partials/_footer.php";
    }

    public function ubicaciones( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        GenericoControlador::ValidarVista( $vista, $data_validacion, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/inventario/gestion.ubicaciones.php";
        require_once "partials/_footer.php";
    }

    public function punto_de_venta( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $modalClientes = GenericoControlador::vistas( $this->modalClientes, "", "", $dataEmpr );
        GenericoControlador::ValidarVista( $vista, $data_side, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/punto_venta/gestion.caja.php";
        require_once "partials/_footer.php";
    }

    public function encuesta( $titulo ) {
        $id = isset( $_GET['o'] ) ? $_GET['o'] : -1;
        $nOrden = GenericoControlador::Desencriptar( $id );
        $v = $this->usuarioDAO->encuesta_orden( $nOrden );
        $dataEmpr = $this->usuarioDAO->empresa();
        $aviable = ( $id != "" && $v != null && $v->encuesta == "" ) ? true : false;
        require_once "partials/_header.php";
        require_once "pages/ordenes/{$titulo}.php";
        require_once "partials/_footer.php";
    }

    public function gestion_informes( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        GenericoControlador::ValidarVista( $vista, $data_side, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/gestion.pdf1.php";
        require_once "partials/_footer.php";
    }

    public function gestion_pdf( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        require_once "pages/gestion.pdf1.php";
    }

    public function mis_ordenes( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        $estados = DatosGenerales::estados();
        $ordenModal = GenericoControlador::vistas( $this->orden, "", $estados, $dataEmpr );
        $estadosOrden = GenericoControlador::vistas( $this->EstadosOrden, "", "", $dataEmpr );
        $estados_vista = GenericoControlador::Estados( $this->Estados, $user, $estados, $estadosOrden );
        GenericoControlador::ValidarVista( $vista, $data_side, $mi_sucur, $dato );
        require_once "partials/_header.php";
        require_once "pages/ordenes/clientes.ordenes.php";
        require_once "partials/_footer.php";
    }

    public function sin_acceso( $vista, $dato ) {
        extract( $this->obtenerDatosGenerales( $vista, $dato ) );
        require_once "partials/_header.php";
        require_once "pages/sinacceso.php";
        require_once "partials/_footer.php";
    }

    public function error() {
        $dataEmpr = $this->usuarioDAO->empresa();
        $titulo = "404";
        require_once "partials/_header.php";
        require_once "pages/404.php";
        require_once "partials/_footer.php";
    }

}

$c = new VistaControlador();
