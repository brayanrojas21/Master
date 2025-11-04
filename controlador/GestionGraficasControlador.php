<?php

require_once '../modelo/basedatos/Conexion.php';
require_once '../modelo/vo/Ordenes.php';
require_once '../modelo/dao/GraficasDao.php';
require_once './reportes/vistas.excel.php';
require_once './GenericoControlador.php';
require_once './GestionDatos.php';
require_once './excepcion/ValidacionExcepcion.php';
require_once './util/Validacion.php';
require_once '../vendor/autoload.php';
use Shuchkin\SimpleXLSXGen;

class GestionUsuarioControlador extends GenericoControlador {

    private $usuarioDAO;

    public function __construct( &$cnn = NULL ) {
        if ( empty( $cnn ) ) {
            $cnn = Conexion::conectar();
        }
        $this->graficasDAO = new GraficasDAO( $cnn );
    }

    public function listado() {
        try {
            Validacion::validar( ['sucursal' => 'obligatorio'], $_POST );
            $usuario = GenericoControlador::SesionBack();
            $sucursal = $_POST['sucursal'] ?? null;
            $datos = $this->graficasDAO->listado_tipo( $sucursal );
            if ( $datos ) {
                foreach ( $datos as $dato ) {
                    // Procesar abonos
                    if ( !empty( $dato->abonos ) ) {
                        $abonos = array_filter( explode( "|", $dato->abonos ) );

                        $dato->abonos = array_reduce( $abonos, function ( $sum, $tab ) {
                            $valor = explode( "Ω", $tab )[0] ?? 0;
                            return $sum + ( is_numeric( $valor ) ? $valor : 0 );
                        }
                        , 0 );
                    }
                    // Procesar encuesta
                    if ( !empty( $dato->encuesta ) ) {
                        $dato->encuesta = explode( "|", $dato->encuesta );
                    }
                }
            }

            $this->respuestaJSON( ['codigo' => 1, 'datos' => $datos] );
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

    public function reporte() {
        try {
            Validacion::validar( ['fecha' => 'obligatorio'], $_POST );
            $totales = json_decode( $_POST["totales"] );
            $generales = json_decode( $_POST["general"] );
            $titulo = "Reporte {$_POST['fecha']}";
            if ( $totales->id_sucursal > 0 ) {
                $ehtml = VistasEXCEL::reporte_excel( $generales );
                // Generar el archivo Excel
                $this->respuestaJSON( ['codigo' => 1, 'archivo' => $ehtml, 'titulo' => $titulo] );
            } else {
                throw new ValidacionExcepcion( 'Error!, No hay datos en el rango de fechas', -1 );
            }
        } catch ( ValidacionExcepcion $error ) {
            $this->respuestaJSON( ['codigo' => $error->getCode(), 'mensaje' => $error->getMessage()] );
        }
    }

}

$controlador = new GestionUsuarioControlador();
$opcion = $_GET['opcion'];
$controlador->$opcion();
