<?php

class Caja {

    private $id_caja;
    private $cod_caja;
    private $id_cliente;
    private $id_usuario;
    private $id_sucursal;
    private $fecha;
    private $tabla_productos;
    private $pago;

    public function getId_caja() {
        return $this->id_caja;
    }

    public function setId_caja( $id_caja ) {
        $this->id_caja = $id_caja;
    }

    public function getCod_caja() {
        return $this->cod_caja;
    }

    public function setCod_caja( $cod_caja ) {
        $this->cod_caja = $cod_caja;
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

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha( $fecha ) {
        $this->fecha = $fecha;
    }

    public function getTabla_productos() {
        return $this->tabla_productos;
    }

    public function setTabla_productos( $tabla_productos ) {
        $this->tabla_productos = $tabla_productos;
    }

    public function getPago() {
        return $this->pago;
    }

    public function setPago( $pago ) {
        $this->pago = $pago;
    }

}
