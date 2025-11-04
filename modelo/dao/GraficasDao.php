<?php

class GraficasDAO {

    /**
    *
    * @var PDO
    */
    private $cnn;

    public function __construct( &$cnn ) {
        $this->cnn = $cnn;
    }
    
    public function listado_tipo( $sucursal ) {
        $sql = "SELECT o.id_orden, o.cod_orden, o.id_sucursal, o.tipo_atencion, o.estado,o.fecha, o.fecha_final, o.tiempos,o.estado,o.estado_cotizacion, o.abonos, o.encuesta, e.nombre as 'empleado', c.id_cliente, c.nit_empresa , c.nombre_empresa, concat(c.nit_empresa, ' - ', c.nombre_empresa) as data_empr, c.cedula_encargado , c.nombre, i.tipo_equipo, i.modelo, i.modelo2, i.marca, i.serie FROM ordenes_servicio o LEFT JOIN clientes c ON o.id_cliente = c.id_cliente LEFT JOIN inventario_equipos i ON o.id_equipo = i.id_equipo LEFT JOIN empleados e ON o.id_usuario = e.id_usuario WHERE o.id_sucursal=:sucursal ORDER BY o.id_orden DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal'=>$sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }
    
}