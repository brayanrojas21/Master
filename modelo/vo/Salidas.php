<?php

class Salidas {

    private $id_salida;
    private $cant_salida;
    private $precio_venta;
    private $iva;
    private $descuento;
    private $fecha_salida;
    private $salida;
    private $stock;
    private $id_productos;
    private $id_usuario;
    private $id_orden;
    private $id_caja;
    private $id_sucursal;

    public function getId_salida() {
        return $this->id_salida;
    }

    public function setId_salida( $id_salida ) {
        $this->id_salida = $id_salida;
    }

    public function getCant_salida() {
        return $this->cant_salida;
    }

    public function setCant_salida( $cant_salida ) {
        $this->cant_salida = $cant_salida;
    }

    public function getPrecio_venta() {
        return $this->precio_venta;
    }

    public function setPrecio_venta( $precio_venta ) {
        $this->precio_venta = $precio_venta;
    }

    public function getIva() {
        return $this->iva;
    }

    public function setIva( $iva ) {
        $this->iva = $iva;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function setDescuento( $descuento ) {
        $this->descuento = $descuento;
    }

    public function getFecha_salida() {
        return $this->fecha_salida;
    }

    public function setFecha_salida( $fecha_salida ) {
        $this->fecha_salida = $fecha_salida;
    }

    public function getSalida() {
        return $this->salida;
    }

    public function setSalida( $salida ) {
        $this->salida = $salida;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock( $stock ) {
        $this->stock = $stock;
    }

    public function getId_productos() {
        return $this->id_productos;
    }

    public function setId_productos( $id_productos ) {
        $this->id_productos = $id_productos;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario( $id_usuario ) {
        $this->id_usuario = $id_usuario;
    }

    public function getId_orden() {
        return $this->id_orden;
    }

    public function setId_orden( $id_orden ) {
        $this->id_orden = $id_orden;
    }

    public function getId_caja() {
        return $this->id_caja;
    }

    public function setId_caja( $id_caja ) {
        $this->id_caja = $id_caja;
    }

    public function getId_sucursal() {
        return $this->id_sucursal;
    }

    public function setId_sucursal( $id_sucursal ) {
        $this->id_sucursal = $id_sucursal;
    }
}