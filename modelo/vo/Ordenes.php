<?php

class Ordenes {

    private $id_orden;
    private $id_equipo;
    private $id_cliente;
    private $id_usuario;
    private $id_sucursal;
    private $id_mensajero;
    private $tipo_atencion;
    private $atencion_texto;
    private $estado;
    private $observacion;
    private $diagnostico;
    private $notas;
    private $tabla_cotizacion;
    private $tabla_inventario;
    private $tabla_piezas;
    private $fecha;
    private $fecha_final;
    private $tabla_listo;
    private $imagenes;
    private $imagen_diagnostico;
    private $imagenes_final;
    private $nota_final;
    private $posicion;
    private $tiempos;
    private $cod_orden;
    private $notita;
    private $reparado;
    private $estado_cotizacion;
    private $abonos;
    private $historial;
    private $encuesta;

    public function getId_orden() {
        return $this->id_orden;
    }

    public function setId_orden( $id_orden ) {
        $this->id_orden = $id_orden;
    }
    

    public function getId_equipo() {
        return $this->id_equipo;
    }

    public function setId_equipo( $id_equipo ) {
        $this->id_equipo = $id_equipo;
    }

    public function getId_cliente() {
        return $this->id_cliente;
    }

    public function setId_cliente( $id_cliente ) {
        $this->id_cliente = $id_cliente;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario( $id_usuario ) {
        $this->id_usuario = $id_usuario;
    }
    
    public function getId_sucursal() {
        return $this->id_sucursal;
    }

    public function setId_sucursal( $id_sucursal ) {
        $this->id_sucursal = $id_sucursal;
    }
    
    public function getId_mensajero() {
        return $this->id_mensajero;
    }

    public function setId_mensajero( $id_mensajero ) {
        $this->id_mensajero = $id_mensajero;
    }

    public function getTipo_atencion() {
        return $this->tipo_atencion;
    }

    public function setTipo_atencion( $tipo_atencion ) {
        $this->tipo_atencion = $tipo_atencion;
    }

    public function getAtencion_texto() {
        return $this->atencion_texto;
    }

    public function setAtencion_texto( $atencion_texto ) {
        $this->atencion_texto = $atencion_texto;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado( $estado ) {
        $this->estado = $estado;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion( $observacion ) {
        $this->observacion = $observacion;
    }

    public function getDiagnostico() {
        return $this->diagnostico;
    }

    public function setDiagnostico( $diagnostico ) {
        $this->diagnostico = $diagnostico;
    }

    public function getNotas() {
        return $this->notas;
    }

    public function setNotas( $notas ) {
        $this->notas = $notas;
    }

    public function getTabla_cotizacion() {
        return $this->tabla_cotizacion;
    }

    public function setTabla_cotizacion( $tabla_cotizacion ) {
        $this->tabla_cotizacion = $tabla_cotizacion;
    }

    public function getTabla_inventario() {
        return $this->tabla_inventario;
    }

    public function setTabla_inventario( $tabla_inventario ) {
        $this->tabla_inventario = $tabla_inventario;
    }

    public function getTabla_piezas() {
        return $this->tabla_piezas;
    }

    public function setTabla_piezas( $tabla_piezas ) {
        $this->tabla_piezas = $tabla_piezas;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha( $fecha ) {
        $this->fecha = $fecha;
    }

    public function getFecha_final() {
        return $this->fecha_final;
    }

    public function setFecha_final( $fecha_final ) {
        $this->fecha_final = $fecha_final;
    }

    public function getTabla_listo() {
        return $this->tabla_listo;
    }

    public function setTabla_listo( $tabla_listo ) {
        $this->tabla_listo = $tabla_listo;
    }

    public function getImagenes() {
        return $this->imagenes;
    }

    public function setImagenes( $imagenes ) {
        $this->imagenes = $imagenes;
    }
    
    public function getImagenes_final() {
        return $this->imagenes_final;
    }

    public function setImagenes_final( $imagenes_final ) {
        $this->imagenes_final = $imagenes_final;
    }

    public function getNota_final() {
        return $this->nota_final;
    }

    public function setNota_final( $nota_final ) {
        $this->nota_final = $nota_final;
    }

    public function getPosicion() {
        return $this->posicion;
    }

    public function setPosicion( $posicion ) {
        $this->posicion = $posicion;
    }
    
    public function getTiempos() {
        return $this->tiempos;
    }

    public function setTiempos( $tiempos ) {
        $this->tiempos = $tiempos;
    }
    
     public function getImagen_diagnostico() {
        return $this->imagen_diagnostico;
    }

    public function setImagen_diagnostico( $imagen_diagnostico ) {
        $this->imagen_diagnostico = $imagen_diagnostico;
    }
    
     public function getCod_orden() {
        return $this->cod_orden;
    }

    public function setCod_orden( $cod_orden ) {
        $this->cod_orden = $cod_orden;
    }
    
    public function getNotita() {
        return $this->notita;
    }

    public function setNotita( $notita ) {
        $this->notita = $notita;
    }
    
    public function getReparado() {
        return $this->reparado;
    }

    public function setReparado( $reparado ) {
        $this->reparado = $reparado;
    }
     
     public function getEstado_cotizacion() {
        return $this->estado_cotizacion;
    }

    public function setEstado_cotizacion( $estado_cotizacion ) {
        $this->estado_cotizacion = $estado_cotizacion;
    }
     
    public function getAbonos() {
        return $this->abonos;
    }

    public function setAbonos( $abonos ) {
        $this->abonos = $abonos;
    }
     
    public function getHistorial() {
        return $this->historial;
    }

    public function setHistorial( $historial ) {
        $this->historial = $historial;
    }
    
     public function getEncuesta() {
        return $this->encuesta;
    }

    public function setEncuesta( $encuesta ) {
        $this->encuesta = $encuesta;
    }

}

