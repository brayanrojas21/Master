<?php

// Conexión y modelos
require_once '../modelo/basedatos/Conexion.php';
// Value Objects ( VOs )
$voPath = '../modelo/vo/';
$voFiles = [
    'Ordenes', 'Caja', 'Salidas', 'Sucursales', 'Productos',
    'Proveedores', 'Ubicaciones', 'Entradas', 'Cliente', 'Equipo', 'Usuario'
];
foreach ( $voFiles as $vo ) {
    require_once $voPath . $vo . '.php';
}
// DAO
require_once '../modelo/dao/UsuarioDao.php';
// Controladores y utilidades
require_once './GenericoControlador.php';
require_once './GestionDatos.php';
require_once './excepcion/ValidacionExcepcion.php';
require_once './util/Validacion.php';
// Reportes
require_once './reportes/vistas.pdf.php';
require_once './reportes/vistas.mensajes.php';
// Librerías externas ( Composer )
require_once '../vendor/autoload.php';
use Shuchkin\SimpleXLSX;
use PHPMailer\PHPMailer\PHPMailer;

class GestionUsuarioControlador extends GenericoControlador {

    private $usuarioDAO;

    public function __construct( &$cnn = NULL ) {
        if ( empty( $cnn ) ) {
            $cnn = Conexion::conectar();
        }
        $this->usuarioDAO = new UsuarioDAO( $cnn );
    }

    public function iniciarSesion() {
        try {
            Validacion::validar( ['usuario' => 'obligatorio', 'clave' => 'obligatorio'], $_POST );
            $usuario = ( $_POST ['usuario'] );
            $clave = GenericoControlador::Encriptar( $_POST ['clave'] );
            $tipo = ( $_POST ['tipo'] );
            if ( $tipo == "empleados" || $tipo == "clientes" ) {
                $infoUsuario = $this->usuarioDAO->iniciarSesion( $usuario, $clave, $tipo );
                if ( $infoUsuario->estado == "Inactivo" ) {
                    throw new ValidacionExcepcion( 'Error!, Su usuario está inactivo, contactese con el Administrador', -1 );
                }
                session_start();
                $_SESSION['usuario_master'] = $infoUsuario;
                if ( $infoUsuario->servicios_aprobados ) {
                    $infoUsuario->servicios_aprobados = json_decode( $infoUsuario->servicios_aprobados );
                }
                $this->respuestaJSON( ['codigo' => 1, 'mensaje' => "Bienvenid@!", 'href' => "inicio" ] );
            } else {
                throw new ValidacionExcepcion( 'Error!, está ingresando de manera INADECUADA!', -1 );
            }
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Equipos

    public function listado() {
        try {
            Validacion::validar( ['id' => 'obligatorio' ], $_POST );
            $id = $_POST['id'];
            $id2 = $_POST['id2'];
            $vista = $_POST['vista'];
            GenericoControlador::existeMetodo( $this->usuarioDAO, $vista );
            $equipos = $this->usuarioDAO->$vista( $id, $id2 );
            if ( $vista === 'lista_reingreso' ) {
                GestionUsuarioControlador::ordenArray( $equipos );
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $equipos, 'tipo' => $_POST['tipo'], 'id' => $id2] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Equipo por id

    public function equipo_id() {
        try {
            Validacion::validar( ['id' => 'obligatorio' ], $_POST );
            $datos = $this->usuarioDAO->equipo_id( $_POST["id"] );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'tipo' => 'equipo'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function listado_equipos() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            $datos = GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $equipos = [];
            $clientes = [];
            if ( $datos->tipo == "clientes" ) {
                $equipos = $this->usuarioDAO->listado_equipos_clientes( $datos->id_cliente );
            } else {
                $equipos = $this->usuarioDAO->listado_equipos( $sucursal );
                $clientes = $this->usuarioDAO->listado_clientes( $sucursal );
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $equipos, 'clientes' => $clientes] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_equipo() {
        try {
            Validacion::validar( ['tipo_equipo' => 'obligatorio', 'estado' => 'obligatorio', 'marca' => 'obligatorio' ], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $_POST['id_cliente'] = ( $usuario->tipo == "clientes" ) ? $usuario->id_cliente : $_POST['id_cliente'];
            //validar que tenga cliente
            if ( $_POST['id_cliente'] <= 0 ) {
                throw new ValidacionExcepcion( 'ERROR: Se necesita un cliente.', -1 );
            }
            $gestion = $_POST['gestion'];
            $id_equipo = $_POST['id_equipo'];
            $equipoVO = new Equipo;
            $equipoVO->setId_equipo( $id_equipo );
            $nombreImg = [""];
            if ( isset( $_FILES['imagen'] ) ) {
                $nombreImg = GenericoControlador::procesar_imagenes( $_FILES['imagen'], [], '../assets/images/equipos', 30, [] );
            }
            $equipoVO->setId_cliente( $_POST['id_cliente'] );
            $equipoVO->setCodigo_interno( $_POST['codigo_interno'] );
            $equipoVO->setTipo_equipo( $_POST['tipo_equipo'] );
            $equipoVO->setModelo( $_POST['modelo'] );
            $equipoVO->setModelo2( $_POST['modelo2'] );
            $equipoVO->setMarca( $_POST['marca'] );
            $equipoVO->setSerie( $_POST['serie'] );
            $equipoVO->setImagen( $nombreImg[0] );
            $equipoVO->setDescripcion( ( isset ( $_POST['descripcion'] ) ) ? $_POST['descripcion'] : "" );
            $equipoVO->setEstado( $_POST['estado'] );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $respuesta = $this->usuarioDAO->$gestion( $equipoVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente', "tipo" => "equipo_id", "id" => $respuesta] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Empleados

    public function listado_empleados() {
        try {
            GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->listado_empleados();
            $sucursales = $this->usuarioDAO->listado_sucursales();
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'sucur' => $sucursales] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function gestionar_empleado() {
        try {
            Validacion::validar( ['cedula' => 'obligatorio', 'correo_electronico' => 'email', 'privilegio' => 'obligatorio', 'estado' => 'obligatorio', 'clave_nueva' => 'clave' ], $_POST );
            GenericoControlador::SesionBack();
            $gestion = $_POST['gestion'];
            $correo = $_POST['correo_electronico'];
            $servicios = $_POST['servicios_aprobados'];
            $sucursales = $_POST['sucursales'];
            $clave_vieja = $_POST['clave_nueva'];
            $clave_nueva = GenericoControlador::Encriptar( $clave_vieja );
            ( !in_array ( "inicio",  $servicios ) ) ? array_push( $servicios, "inicio" ) : "";
            if ( $_POST['id_usuario'] > 0 ) {
                if ( !isset( $_POST['encryp'] ) ) {
                    $clave_nueva = $clave_vieja;
                }
            } else {
                $this->usuarioDAO->validar_correo( "empleados", $correo );
            }
            $usuarioVO = new Usuario;
            $usuarioVO->setId_usuario( $_POST['id_usuario'] );
            $usuarioVO->setCedula( $_POST['cedula'] );
            $usuarioVO->setNombre( $_POST['nombre'] );
            $usuarioVO->setApellido( $_POST['apellido'] );
            $usuarioVO->setClave( $clave_nueva );
            $usuarioVO->setEstado( $_POST['estado'] );
            $usuarioVO->setCorreo_electronico( $correo );
            $usuarioVO->setPrivilegio( $_POST['privilegio'] );
            $usuarioVO->setServicios_aprobados( json_encode ( $servicios ) );
            //$usuarioVO->setSucursales( '["1"]' );
            $usuarioVO->setSucursales( json_encode ( $sucursales ) );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $this->usuarioDAO->$gestion( $usuarioVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Clientes

    public function cliente() {
        try {
            GenericoControlador::SesionBack();
            Validacion::validar( ['id' => 'obligatorio' ], $_POST );
            $datos = $this->usuarioDAO->cliente( $_POST["id"] );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'tipo' => 'cliente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function listado_clientes() {
        try {
            GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->listado_clientes_general();
            $sucursales = $this->usuarioDAO->listado_sucursales();
            if ( $datos ) {
                foreach ( $datos as $dato ) {
                    if ( $dato->sucursales ) {
                        $suc = [];
                        $sucursal = json_decode( $dato->sucursales );
                        foreach ( $sucursal as $key => $data ) {
                            $suc[$key] = str_replace( "|", "", $data );
                        }
                        $dato->sucursales = json_encode( $suc );
                    }
                }
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'sucur' => $sucursales] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function gestionar_cliente() {
        try {
            Validacion::validar( ['nit_empresa' => 'obligatorio', 'nombre_empresa' => 'obligatorio', 'clave_nueva' => 'clave' ], $_POST );
            $gestion = $_POST['gestion'];
            $id_cliente = $_POST['id_cliente'];
            $correo = $_POST['correo_electronico'];
            $clave_vieja = ( isset ( $_POST['clave_nueva'] ) ) ? $_POST['clave_nueva'] : "";
            $servicios = [];
            $sucursales = [];
            $existCliente = $this->usuarioDAO->cliente_nit( $_POST['nit_empresa'] );
            //validar si ya existe el cliente
            if ( $existCliente && $id_cliente == 0 ) {
                throw new ValidacionExcepcion( "El cliente ya existe con el NIT: {$_POST['nit_empresa']}", -1 );
            }
            if ( isset ( $_POST['servicios_aprobados'] ) ) {
                $servicios = $_POST['servicios_aprobados'];
                ( !in_array ( "inicio",  $servicios ) ) ? array_push( $servicios, "inicio" ) : "";
            }
            if ( isset ( $_POST['sucursales'] ) ) {
                foreach ( $_POST['sucursales'] as $key => $dato ) {
                    $sucursales[$key] = "|{$dato}|";
                }
            }
            $clave_nueva = GenericoControlador::Encriptar( $clave_vieja );
            if ( $id_cliente > 0 ) {
                if ( !isset( $_POST['encryp'] ) ) {
                    $clave_nueva = $clave_vieja;
                }
            } else {
                if ( $correo != "" ) {
                    $this->usuarioDAO->validar_correo( "clientes", $correo );
                }
            }
            $clienteVO = new Cliente;
            $clienteVO->setId_cliente( $_POST['id_cliente'] );
            $clienteVO->setNombre_empresa( $_POST['nombre_empresa'] );
            $clienteVO->setNit_empresa( $_POST['nit_empresa'] );
            $clienteVO->setDireccion_empresa( $_POST['direccion_empresa'] ?? '' );
            $clienteVO->setCorreo_electronico( $correo );
            $clienteVO->setClave( $clave_nueva );
            $clienteVO->setNombre_encargado( $_POST['nombre'] ?? '' );
            $clienteVO->setTelefono_encargado( $_POST['telefono_encargado'] );
            $clienteVO->setCedula_encargado( $_POST['cedula_encargado'] ?? '' );
            $clienteVO->setNombre_representante( $_POST['nombre_representante'] ?? '' );
            $clienteVO->setTelefono_representante( $_POST['telefono_representante'] ?? '' );
            $clienteVO->setTelefono2_encargado( $_POST['telefono2_encargado'] ?? '' );
            $clienteVO->setCorreo_representante( $_POST['correo_representante'] ?? '' );
            $clienteVO->setServicios_aprobados( json_encode ( $servicios ) );
            $clienteVO->setSucursales( json_encode ( $sucursales ) );
            $clienteVO->setEstado( $_POST['estado'] ?? "" );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $respuesta = $this->usuarioDAO->$gestion( $clienteVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente', "href" => "Ingresar_clientes", "tipo" => "cliente", "id" => $respuesta] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    // Ordenes de servicio

    public function ordenArray( $datos ) {
        try {
            if ( !$datos ) return;
            foreach ( $datos as $dato ) {
                // Imágenes
                $dato->imagen1 = ( !empty( $dato->imagenes ) ) ? explode( "|", $dato->imagenes ) : [];
                $dato->imagen2 = ( !empty( $dato->imagenes_final ) ) ? explode( "|", $dato->imagenes_final ) : [];
                $dato->imagen3 = ( !empty( $dato->imagen_diagnostico ) ) ? explode( "|", $dato->imagen_diagnostico ) : [];
                // Cotización
                if ( !empty( $dato->tabla_cotizacion ) ) {
                    $tabla = explode( "|", $dato->tabla_cotizacion );
                    $cotizacionArray = [];
                    foreach ( $tabla as $key => $registro ) {
                        $datosProducto = explode( "Ω", $registro );
                        $producto = ( stripos( $datosProducto[0], 'borrador' ) !== false ) ? 0 : $this->usuarioDAO->listado_productos( $datosProducto[0] );
                        $datosProducto[0] = $producto ?: $datosProducto[0];
                        $cantidad = $datosProducto[1] ?? "";
                        $descripcion = $datosProducto[2] ?? "";
                        if ( is_numeric( $cantidad ) && !is_numeric( $descripcion ) ) {
                            // Invertir si los campos están en orden contrario
                            $datosProducto[1] = $descripcion;
                            $datosProducto[2] = $cantidad;
                        }
                        $cotizacionArray[$key] = $datosProducto;
                    }
                    $dato->tabla_cotizacion = $cotizacionArray;
                }
                // Abonos
                if ( !empty( $dato->abonos ) ) {
                    $tablaAbonos = explode( "|", $dato->abonos );
                    $abonosArray = [];
                    foreach ( $tablaAbonos as $key => $registro ) {
                        $abonosArray[$key] = explode( "Ω", $registro );
                    }
                    $dato->abonos = $abonosArray;
                }
                // Historial
                $dato->historial_final = [];
                if ( $dato->historial !== "null" ) {
                    $historiales = explode( "¦", $dato->historial );
                    $historialEstructurado = [];
                    foreach ( $historiales as $registro ) {
                        if ( !empty( $registro ) ) {
                            $partes = explode( "•", $registro );
                            $items = explode( "|", $partes[3] );
                            $historialEstructurado[$partes[0]][$partes[2]][$partes[1]] = $items;
                        }
                    }
                    // Ordenar horas descendente dentro de cada fecha
                    foreach ( $historialEstructurado as &$porFecha ) {
                        krsort( $porFecha );
                    }
                    // Revertir fechas para orden descendente
                    $dato->historial_final = array_reverse( $historialEstructurado );
                }
                // Encuesta
                $dato->encuesta_url = "";
                if ( !empty( $dato->encuesta ) ) {
                    $dato->encuesta = explode( "|", $dato->encuesta );
                } else {
                    $puertoServidor = GenericoControlador::puertoServidor();
                    $token = GenericoControlador::Encriptar( $dato->id_orden );
                    $dato->encuesta_url = $puertoServidor . "/encuesta?o=" . rawurlencode( $token );
                }
            }
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function recargarEncuesta() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $id = $_POST["id_orden"];
            $url = $_POST["url"];
            $datos = $this->usuarioDAO->encuesta_orden( $id );
            if ( $datos->encuesta ) {
                $datos->encuesta = explode( "|", $datos->encuesta );
            }
            $this->respuestaJSON( ['codigo' => 1, 'encuesta' => $datos->encuesta, 'estado' => $datos->estado, 'encuesta_url' => $url] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function listado_ordenes() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $datos = $this->usuarioDAO->listado_ordenes( $sucursal );
            $disabled = ( $usuario->privilegio != "Administrador" ) ? "readonly" : "ok";
            GestionUsuarioControlador::ordenArray( $datos );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'est' => $disabled, 'user' => $usuario->nombre, 'tipo' => $usuario->privilegio] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function clientes_ordenes() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->clientes_ordenes( $usuario->id_cliente );
            GestionUsuarioControlador::ordenArray( $datos );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'user' => $usuario->nombre] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_ordenes() {
        try {
            Validacion::validar( ['id_cliente' => 'obligatorio', 'id_equipo' => 'obligatorio', 'tipo_atencion'=> 'obligatorio'], $_POST );
            // Obtención de usuario desde sesión
            $usuario = GenericoControlador::SesionBack();
            $id_usuario = $usuario->id_usuario;
            // Decodificación de datos
            $arreglo = json_decode( $_POST['arreglo'] );
            $imagenes_guardadas = json_decode( $_POST['imagenes_guardadas'] );
            $sucursal = $_POST['sucursal'];
            $gestion = $_POST['gestion'];
            $posicion = $_POST['posicion'];
            $estado = $_POST['estado'];
            $atencion_texto = $_POST['atencion_texto'] ?? "";
            
            // Establecer a null si no hay valor
            $tablaCotiza = $_POST['cadena'] ?? "";
            // Asignar valor vacío si no existe
            $id_mensajero = $_POST['id_mensajero'] ?? null;
            $id_mensajero = ( $id_mensajero === '' ) ? null : $id_mensajero;
            // Procesar imágenes si es necesario
            $cadenas = isset( $_FILES['imagenes'] )
            ? GenericoControlador::procesar_imagenes(
                $_FILES['imagenes'],
                $_POST['tipo_img'] ?? [],
                '../assets/images/ordenes',
                30,
                $imagenes_guardadas
            )
            : $imagenes_guardadas;
            $ordenExistente = $this->usuarioDAO->orden( $_POST['id_orden'] );
            $fecha_final = $ordenExistente[0]->fecha_final ?? 0;
            // VALIDAR SALIDAS SOLO UNA VEZ PARA POSICIÓN 4 
            if ( $posicion == 3 ) {
                $existen_salidas = $this->usuarioDAO->existen_salidas_orden( $_POST['id_orden'] );
                if ( !$existen_salidas ) {
                    foreach ( $arreglo as $key ) {
                        $id_productos = $key[0];
                        $cantidad = $key[2];
                        $precio = $key[4];
                        $iva = $key[5];
                        $descuento = $key[6];
                        $salidasVO = new Salidas;
                        $salidasVO->setId_productos( $id_productos );
                        $salidasVO->setId_orden( $_POST['id_orden'] );
                        $producto = $this->usuarioDAO->listado_productos( $id_productos );
                        if ( $producto ) {
                            $VerSalida = $this->usuarioDAO->consultar_salidas_orden( $salidasVO );
                            if ( !$VerSalida ) {
                                $StockExistente = $producto->stock_existente;
                                $total_salida = intval( $StockExistente ) - intval( $cantidad );
                                if ( $total_salida < 0 ) {
                                    throw new ValidacionExcepcion( "No cuenta con más stock del producto: ({$producto->data_prod})", -1 );
                                }
                                $salidasVO->setCant_salida( $cantidad );
                                $salidasVO->setPrecio_venta( $precio );
                                $salidasVO->setIva( $iva );
                                $salidasVO->setDescuento( $descuento );
                                $salidasVO->setSalida( "Orden servicio" );
                                $salidasVO->setStock( $total_salida );
                                $salidasVO->setId_usuario( $id_usuario );
                                $salidasVO->setId_caja( null );
                                $salidasVO->setId_sucursal( $sucursal );
                                $this->usuarioDAO->agregar_salidas( $salidasVO );
                                $this->usuarioDAO->actualizar_stock_producto( $total_salida, $id_productos );
                            }
                        }
                    }
                }
            }

            // GUARDAR FECHA FINAL UNA SOLA VEZ
            if ( $posicion == 5 ) {
                if ($ordenExistente && ($ordenExistente[0]->fecha_final ?? '') === '0000-00-00 00:00:00') {
                    $fecha_final = date("Y-m-d H:i:s");
                }
            }
            // Crear objeto de la orden y asignar datos
            $ordenesVO = new Ordenes;
            $ordenesVO->setId_orden( $_POST['id_orden'] );
            $ordenesVO->setId_equipo( $_POST['id_equipo'] );
            $ordenesVO->setId_cliente( $_POST['id_cliente'] );
            $ordenesVO->setId_usuario( $id_usuario );
            $ordenesVO->setId_sucursal( $sucursal );
            $ordenesVO->setId_mensajero( $id_mensajero );
            $ordenesVO->setTipo_atencion( $_POST['tipo_atencion'] );
            $ordenesVO->setAtencion_texto( $atencion_texto );
            $ordenesVO->setObservacion( $_POST['observacion'] );
            $ordenesVO->setDiagnostico( $_POST['diagnostico'] );
            $ordenesVO->setNotas( $_POST['notas'] );
            $ordenesVO->setTabla_cotizacion( $tablaCotiza );
            $ordenesVO->setAbonos( $_POST['abono_cadena'] );
            $ordenesVO->setFecha_final( $fecha_final );
            $ordenesVO->setImagenes( $cadenas[0] ?? "" );
            $ordenesVO->setImagen_diagnostico( $cadenas[1] ?? "" );
            $ordenesVO->setImagenes_final( $cadenas[2] ?? "" );
            $ordenesVO->setNota_final( $_POST['nota_final'] );
            $ordenesVO->setPosicion( $posicion );
            $ordenesVO->setEstado( $estado );
            $ordenesVO->setTiempos( $_POST['tiempos'] );
            $ordenesVO->setNotita( $_POST['notita'] );
            $ordenesVO->setReparado( $_POST['reparado'] );
            $ordenesVO->setEstado_cotizacion( $_POST['estado_cotizacion'] );
            $ordenesVO->setHistorial( $_POST['historial'] );
            // Llamada al método correspondiente ( según el valor de $gestion )
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $id = $this->usuarioDAO->$gestion( $ordenesVO );
            // Obtener los resultados de la orden
            $datos = $this->usuarioDAO->orden( $id );
            GestionUsuarioControlador::ordenArray( $datos );
            //Retorno a vista
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente', "datos" => $datos[0], "id" => $id, "gst" => $gestion] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //INVENTARIO

    public function listado_productos() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $datos = $this->usuarioDAO->listado_productos_generales( $sucursal );
            $proveedores = $this->usuarioDAO->listado_proveedores();
            $ubicaciones = $this->usuarioDAO->listado_ubicaciones( $sucursal );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'proveedores' => $proveedores, 'ubicaciones' => $ubicaciones] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_producto() {
        try {
            $usuario = GenericoControlador::SesionBack();
            Validacion::validar( ['codigo_producto' => 'obligatorio', 'nombre_producto' => 'obligatorio', 'id_proveedor' => 'obligatorio', 'id_ubicacion' => 'obligatorio', 'id_proveedor' => 'obligatorio' ], $_POST );
            $gestion = $_POST['gestion'];
            $id_productos = $_POST['id_productos'];
            $id_usuario = $usuario->id_usuario;
            $nombreImg = [""];
            //Subir imagenes de producto
            if ( isset( $_FILES['imagen_producto'] ) ) {
                $nombreImg = GenericoControlador::procesar_imagenes( $_FILES['imagen_producto'], [], '../assets/images/productos', 30, [] );
            }
            $productoVO = new Productos;
            $productoVO->setId_producto( $id_productos );
            $productoVO->setCodigo_producto( $_POST['codigo_producto'] );
            $productoVO->setNombre_producto( $_POST['nombre_producto'] );
            $productoVO->setMarca( $_POST['marca'] );
            $productoVO->setPrecio_compra( $_POST['precio_compra'] );
            $productoVO->setPrecio_venta( $_POST['precio_venta'] );
            $productoVO->setModelo( $_POST['modelo'] );
            $productoVO->setStock_existente( $_POST['stock_existente'] );
            $productoVO->setStock_min( $_POST['stock_min'] );
            $productoVO->setImagen_producto( $nombreImg[0] );
            $productoVO->setId_proveedor( $_POST['id_proveedor'] );
            $productoVO->setId_ubicacion( $_POST['id_ubicacion'] );
            $productoVO->setId_sucursal( $_POST['sucursal'] );
            $productoVO->setId_usuario( $id_usuario );
            $productoVO->setTipo( $_POST['tipo'] );
            $productoVO->setIva( $_POST['iva'] );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $this->usuarioDAO->$gestion( $productoVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );

        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function carga_excel() {
        try {
            GenericoControlador::SesionBack();
            Validacion::validar( ['precios' => 'obligatorio', 'sucursal' => 'obligatorio'], $_POST );
            $tipo = preg_replace( '/[^a-zA-Z0-9_-]/', '', $_POST["tipo"] ?? '' );
            $sucursal = $_POST['sucursal'];
            $precios = $_POST['precios'] ?? false;
            // Validar tipo
            if ( empty( $tipo ) || strlen( $tipo ) > 50 ) {
                throw new ValidacionExcepcion( 'Tipo de archivo inválido.', -1 );
            }
            // Validar archivo subido
            if ( !isset( $_FILES['excel'] ) || $_FILES['excel']['error'] !== UPLOAD_ERR_OK ) {
                throw new ValidacionExcepcion( 'Error: Debe seleccionar un archivo Excel válido.', -1 );
            }
            $archivo = $_FILES['excel'];
            // Validaciones de seguridad
            $maxSize = 10 * 1024 * 1024;
            // 10MB
            if ( $archivo['size'] > $maxSize || $archivo['size'] === 0 ) {
                throw new ValidacionExcepcion( 'Archivo inválido: muy grande (>10MB) o vacío.', -1 );
            }
            $extension = strtolower( pathinfo( $archivo['name'], PATHINFO_EXTENSION ) );
            $mimeType = mime_content_type( $archivo['tmp_name'] );
            if ( $extension !== 'xlsx' || !in_array( $mimeType, [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip'
            ] ) ) {
                throw new ValidacionExcepcion( 'Solo se permiten archivos .xlsx válidos.', -1 );
            }
            // Procesar archivo
            $carpeta = "../assets/excel/temp/";
            $nombreSeguro = preg_replace( '/[^a-zA-Z0-9_-]/', '', $tipo ) . '_' . uniqid() . '.xlsx';
            $rutaCompleta = $carpeta . $nombreSeguro;
            // Crear directorio si no existe
            if ( !is_dir( $carpeta ) ) {
                mkdir( $carpeta, 0755, true );
            }
            if ( !move_uploaded_file( $archivo['tmp_name'], $rutaCompleta ) ) {
                throw new ValidacionExcepcion( 'Error al procesar el archivo.', -1 );
            }
            // Leer Excel
            $xlsx = SimpleXLSX::parse( $rutaCompleta );
            if ( !$xlsx ) {
                unlink( $rutaCompleta );
                // Limpiar archivo
                throw new ValidacionExcepcion( 'Error: Archivo Excel corrupto o inválido.', -1 );
            }
            $datos = [];
            $productos = [];
            foreach ( $xlsx->rows() as $key => $fila ) {
                if ( $key > 8 ) {
                    if ( $tipo === 'entradas' ) {
                        $resultado = $this->usuarioDAO->existe_productos( $fila[0], $fila[1], $sucursal );
                        if ( !empty( $resultado ) ) {
                            $id_producto = $resultado->id_productos ?? 0;
                            $producto = $resultado->tproducto ?? '';
                            $datos[] = [$id_producto, $fila[2], $fila[3]];

                            $productos[$id_producto] = [$id_producto, $producto];
                        } else {
                            $datos[] = $fila;

                        }
                    } else {
                        $datos[] = $fila;
                    }
                }
            }
            // Limpiar archivo temporal
            unlink( $rutaCompleta );
            // Validar que hay datos
            if ( empty( $datos ) ) {
                throw new ValidacionExcepcion( 'El archivo no contiene datos válidos.', -1 );
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'precios' => $precios, 'productos' => $productos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_cargaProductos() {
        try {
            $usuario = GenericoControlador::SesionBack();
            Validacion::validar( ['arreglo' => 'obligatorio'], $_POST );
            $id_usuario = $usuario->id_usuario;
            $arreglo = json_decode( $_POST["arreglo"] );
            $tipo = $_POST["tipo"];
            $sucursal = $_POST["sucursal"];
            foreach ( $arreglo as $data ) {
                $productoVO = new Productos;
                $productoVO->setId_producto( $data[9] ?? 0 );
                $productoVO->setCodigo_producto( $data[0] );
                $productoVO->setNombre_producto( $data[1] );
                $productoVO->setMarca( $data[4] );
                $productoVO->setPrecio_compra( $data[2] );
                $productoVO->setPrecio_venta( $data[3] );
                $productoVO->setModelo( "" );
                $productoVO->setStock_existente( $data[7] );
                $productoVO->setStock_min( $data[8] );
                $productoVO->setImagen_producto( "" );
                $productoVO->setId_proveedor( $data[5] );
                $productoVO->setId_ubicacion( $data[6] );
                $productoVO->setId_sucursal( $sucursal );
                $productoVO->setId_usuario( $id_usuario );
                $productoVO->setTipo( "interno" );
                $productoVO->setIva( "" );
                $metodo = $tipo === "grabar_carga" ? "agregar_producto" : "editar_precios";
                $this->usuarioDAO->$metodo( $productoVO );
            }
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Entradas

    public function listado_entradas() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $datos = $this->usuarioDAO->listado_entradas_generales( $sucursal );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_entrada() {
        try {
            Validacion::validar( ['id_productos' => 'obligatorio', 'cantidad' => 'obligatorio', 'precio' => 'obligatorio'], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $id_usuario = $usuario->id_usuario;
            $stock_nuevo = $_POST["stock_nuevo"];
            $entradasVO = new Entradas;
            $entradasVO->setCant_entrada( $_POST["cantidad"] );
            $entradasVO->setPrecio_compra( $_POST["precio"] );
            $entradasVO->setId_productos( $_POST["id_productos"] );
            $entradasVO->setStock( $stock_nuevo );
            $entradasVO->setId_usuario( $id_usuario );
            $entradasVO->setId_sucursal( $_POST['sucursal'] );
            $this->usuarioDAO->agregar_entrada( $entradasVO );
            $this->usuarioDAO->actualizar_stock_producto( $stock_nuevo, $_POST["id_productos"] );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_cargaEntradas() {
        try {
            $usuario = GenericoControlador::SesionBack();
            Validacion::validar( ['arreglo' => 'obligatorio'], $_POST );
            $id_usuario = $usuario->id_usuario;
            $arreglo = json_decode( $_POST["arreglo"] );
            $sucursal = $_POST["sucursal"];
            foreach ( $arreglo as $data ) {
                // Obtener stock actual
                $stock_actual = $this->usuarioDAO->obtener_stock_producto( $data[0] );
                $stock_nuevo = $stock_actual + $data[1];
                // Asegurarse de crear la instancia correctamente
                $entradasVO = new Entradas;
                $entradasVO->setCant_entrada( $data[1] );
                $entradasVO->setPrecio_compra( $data[2] );
                $entradasVO->setId_productos( $data[0] );
                $entradasVO->setStock( $stock_nuevo );
                $entradasVO->setId_usuario( $id_usuario );
                $entradasVO->setId_sucursal( $sucursal );
                // Guardar la entrada y actualizar el stock
                $this->usuarioDAO->agregar_entrada( $entradasVO );
                $this->usuarioDAO->actualizar_stock_producto( $stock_nuevo, $data[0] );
            }
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Entradas registradas correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }
    //Salidas

    public function listado_salidas() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $datos = $this->usuarioDAO->listado_salidas_generales( $sucursal );
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Ubicaciones

    public function listado_ubicaciones() {
        try {
            GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->listado_ubicaciones_generales();
            $sucursales = $this->usuarioDAO->listado_sucursales();
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'sucursales' => $sucursales] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_ubicacion() {
        try {
            GenericoControlador::SesionBack();
            Validacion::validar( ['tipo_ubicacion' => 'obligatorio', 'id_sucursal' => 'obligatorio' ], $_POST );
            $gestion = $_POST['gestion'];
            $ubicacionVO = new Ubicacion;
            $ubicacionVO->setId_ubicacion( $_POST['id_ubicacion'] );
            $ubicacionVO->setTipo_ubicacion( $_POST['tipo_ubicacion'] );
            $ubicacionVO->setNumeracion( $_POST['numeracion'] );
            $ubicacionVO->setDescripcion( $_POST['descripcion'] );
            $ubicacionVO->setId_sucursal( $_POST['id_sucursal'] );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $this->usuarioDAO->$gestion( $ubicacionVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //proveedores

    public function listado_proveedores() {
        try {
            GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->listado_proveedores();
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_proveedor() {
        try {
            GenericoControlador::SesionBack();
            Validacion::validar( ['nombre_proveedor' => 'obligatorio', 'telefono_contacto' => 'obligatorio', 'correo_electronico' => 'email', 'nit' => 'obligatorio' ], $_POST );
            $gestion = $_POST['gestion'];
            $proveedorVO = new Proveedores;
            $proveedorVO->setId_proveedor( $_POST['id_proveedor'] );
            $proveedorVO->setNombre_proveedor( $_POST['nombre_proveedor'] );
            $proveedorVO->setNombre_contacto( $_POST['nombre_contacto'] );
            $proveedorVO->setTelefono_contacto( $_POST['telefono_contacto'] );
            $proveedorVO->setCorreo_electronico( $_POST['correo_electronico'] );
            $proveedorVO->setNit( $_POST['nit'] );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $this->usuarioDAO->$gestion( $proveedorVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Surcursales

    public function listado_sucursales() {
        try {
            GenericoControlador::SesionBack();
            $datos = $this->usuarioDAO->listado_sucursales();
            $usuarios = $this->usuarioDAO->listado_empleados();
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'usuarios' => $usuarios] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_sucursales() {
        try {
            GenericoControlador::SesionBack();
            Validacion::validar( ['nombre' => 'obligatorio', 'estado' => 'obligatorio'], $_POST );
            $gestion = $_POST['gestion'];
            $sucursalesVO = new Sucursales;
            $sucursalesVO->setId_sucursal( $_POST['id_sucursal'] );
            $sucursalesVO->setNombre( $_POST['nombre'] );
            $sucursalesVO->setDireccion( $_POST['direccion'] );
            $sucursalesVO->setDescripcion( $_POST['descripcion'] );
            $sucursalesVO->setEstado( $_POST['estado'] );
            $sucursalesVO->setId_usuario( $_POST['id_usuario'] );
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestion );
            $this->usuarioDAO->$gestion( $sucursalesVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Caja

    public function listado_caja() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_POST );
            GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'];
            $datos = $this->usuarioDAO->listado_caja_generales( $sucursal );
            $clientes = $this->usuarioDAO->listado_clientes( $sucursal );
            if ( $datos ) {
                foreach ( $datos as $dato ) {
                    //Cotizacion tabla
                    if ( $dato->tabla_productos ) {
                        $tabla = explode( "|", $dato->tabla_productos );
                        $generalArray = [];
                        foreach ( $tabla as $key => $tab ) {
                            $general = explode( "Ω", $tab );
                            $generalArray[$key] = $general;
                        }
                        $dato->tabla_productos = $generalArray;
                    }
                }
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos, 'clientes' => $clientes] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function agregar_caja() {
        try {
            Validacion::validar( ['id_cliente' => 'obligatorio', 'pago' => 'obligatorio', 'cadena'=> 'obligatorio'], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $id_usuario = $usuario->id_usuario;
            $arreglo = json_decode( $_POST['arreglo'] );
            $cod_caja = date( "YmdHis" );
            $sucursal = $_POST['sucursal'];
            foreach ( $arreglo as $key ) {
                $cantidad = $key[1];
                $precio = $key[4];
                $iva = $key[5];
                $descuento = $key[6];
                $id_productos = $key[7];
                $total_salida = ( isset( $key[8] ) ) ? $key[8] : 0;
                //Buscar si el código existe
                $producto = $this->usuarioDAO->listado_productos( $id_productos );
                if ( $producto ) {
                    //Grabar salida
                    $salidasVO = new Salidas;
                    $salidasVO->setCant_salida( $cantidad );
                    $salidasVO->setPrecio_venta( $precio );
                    $salidasVO->setIva( $iva );
                    $salidasVO->setDescuento( $descuento );
                    $salidasVO->setSalida( "Caja" );
                    $salidasVO->setStock( $total_salida );
                    $salidasVO->setId_productos( $id_productos );
                    $salidasVO->setId_usuario( $id_usuario );
                    $salidasVO->setCod_orden( "" );
                    $salidasVO->setCod_caja( $cod_caja );
                    $salidasVO->setId_sucursal( $sucursal );
                    $this->usuarioDAO->agregar_salidas( $salidasVO );
                    //Modificar stock
                    $this->usuarioDAO->actualizar_stock_producto( $total_salida, $id_productos );
                }
            }
            $cajaVO = new Caja;
            $cajaVO->setCod_caja( $cod_caja );
            $cajaVO->setId_cliente( $_POST['id_cliente'] );
            $cajaVO->setId_usuario( $id_usuario );
            $cajaVO->setId_sucursal( $sucursal );
            $cajaVO->setTabla_productos( $_POST['cadena'] );
            $cajaVO->setPago( $_POST['pago'] );
            $this->usuarioDAO->agregar_caja( $cajaVO );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function buscar() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio' ], $_REQUEST );
            $datos = [];
            $sucursal = $_REQUEST['sucursal'];
            $metodo = $_REQUEST['metodo'];
            $usuario = GenericoControlador::SesionBack();
            $palabras = isset( $_REQUEST['q'] ) ? $_REQUEST['q'] : "";
            GenericoControlador::existeMetodo( $this->usuarioDAO, $metodo );
            //validar que haya palabras
            if ( $palabras != "" ) {
                $datos = $this->usuarioDAO->$metodo( $palabras, $sucursal );
            }
            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function grabar_sweet() {
        try {
            Validacion::validar( ['nombre' => 'obligatorio', 'sucursal' => 'obligatorio'  ], $_POST );
            $gestionCrear = $_POST['gestion'];
            $gestionBuscar = $_POST['existe'];
            $sucursal = $_REQUEST['sucursal'];
            $nombre = $_POST['nombre'];
            $Datos = [
                "nombre" => $_POST['nombre'],
                "extra" => $_POST['extra'],
                "estado" => $_POST['estado']
            ];
            $existe = $this->usuarioDAO->$gestionBuscar( $nombre, $sucursal );
            if ( $existe ) {
                throw new ValidacionExcepcion( 'Ya existe el registro: ' . $nombre, -1 );
            }
            GenericoControlador::existeMetodo( $this->usuarioDAO, $gestionCrear );
            $this->usuarioDAO->$gestionCrear( $Datos );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    //Encuesta

    public function encuesta() {
        try {
            Validacion::validar( ['id' => 'obligatorio', 'cadena' => 'obligatorio' ], $_POST );
            $id_orden = GenericoControlador::Desencriptar( $_POST['id'] );
            $encuesta = $_POST['cadena'];
            $this->usuarioDAO->grabar_encuesta( $id_orden, $encuesta );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Se grabó correctamente'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function imprimir_ordenes() {
        try {
            Validacion::validar( ['id_cliente' => 'obligatorio', 'id_equipo' => 'obligatorio', 'tipo_atencion'=> 'obligatorio'], $_POST );
            $titulo = "Orden_Servicio({$_POST['cod']})";
            $dataEmpr = $this->usuarioDAO->empresa();
            //Si no ha guardado con las imagenes, devolver error
            if ( isset( $_FILES['imagenes'] ) || $_POST['cerrar'] == "true" ) {
                throw new ValidacionExcepcion( "Al parecer no ha guardado!", -1 );
            }
            //Enviar información
            if ( $_POST["size"] == "big" || $_POST["size"] == "final" ) {
                $ehtml = VistasPDF::Orden_servicio( $_POST, $dataEmpr );
            } else {
                $ehtml = VistasPDF::Orden_recibo( $_POST, $dataEmpr );
            }
            $this->respuestaJSON( ['codigo' => 1, 'pdf' => $ehtml, 'titulo' => $titulo] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function generar_correo() {
        try {
            Validacion::validar( ['id_cliente' => 'obligatorio', 'id_equipo' => 'obligatorio', 'tipo_atencion'=> 'obligatorio', 'tipo'=> 'obligatorio'], $_POST );
            if ( $_POST['cerrar'] == "true" ) {
                throw new ValidacionExcepcion( "Al parecer no ha guardado!", -1 );
            }
            // Obtener datos base
            $tipo = $_POST["tipo"];
            $url = rawurlencode( $_POST["url"] ?? "" );
            $dataEmpr = $this->usuarioDAO->empresa();
            $titulo = "Contacto cliente - {$dataEmpr->nombre}";
            // Generar contenido del mensaje en formato HTML ( correo )
            $puertoServidor = GenericoControlador::puertoServidor();
            $html_content = VistasMensajes::generar_mensaje( $_POST, 'html', $dataEmpr, $puertoServidor );
            // Armar estructura de PHPMailer con título y contenido
            $datoscorreo = DatosGenerales::datos_correo( $html_content, $titulo );
            //generar recibo
            $ehtml = VistasPDF::Orden_servicio( $_POST, $dataEmpr );
            // Enviar correo
            $email = new PHPMailer;
            $this->usuarioDAO->mensaje( $datoscorreo, $email, $ehtml );
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => 'Gracias: Se envió correctamente.', 'tipo' => 'correo'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function generar_whatsapp() {
        try {
            Validacion::validar( ['id_cliente' => 'obligatorio', 'id_equipo' => 'obligatorio', 'tipo_atencion'=> 'obligatorio', 'tipo'=> 'obligatorio'], $_POST );
            if ( $_POST['cerrar'] == "true" ) {
                throw new ValidacionExcepcion( "Al parecer no ha guardado!", -1 );
            }
            $equipo = json_decode( $_POST["equipo"] );
            $telefono = $equipo->telefono_encargado ?? "";
            // Definir si es móvil o PC
            $whatTipo = ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false ) ? "api" : "web";
            // mensaje salida
            $mensaje = VistasMensajes::generar_mensaje( $_POST, "whatsapp", "null", "" );
            // Construir la URL final de WhatsApp
            $whatsapp_url = "https://{$whatTipo}.whatsapp.com/send?phone=57{$telefono}&text={$mensaje}";
            $this->respuestaJSON( ['codigo' => 1, 'mensaje' => $whatsapp_url, 'tipo' => 'whatsapp'] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

}

$controlador = new GestionUsuarioControlador();
$opcion = $_GET['opcion'] ?? '';
if ( method_exists( $controlador, $opcion ) ) {
    $controlador->$opcion();
}
