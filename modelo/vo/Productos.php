<?php

class Productos {

    private $id_producto;
    private $codigo_producto;
    private $nombre_producto;
    private $marca;
    private $precio_compra;
    private $precio_venta;
    private $modelo;
    private $stock_existente;
    private $stock_min;
    private $imagen_producto;
    private $imagen_barras;
    private $id_proveedor;
    private $id_ubicacion;
    private $id_usuario;
    private $id_sucursal;
    private $tipo;
    private $iva;

    public function getId_producto() {
        return $this->id_producto;
    }

    public function setId_producto( $id_producto ) {
        $this->id_producto = $id_producto;
    }

    public function getCodigo_producto() {
        return $this->codigo_producto;
    }

    public function setCodigo_producto( $codigo_producto ) {
        $this->codigo_producto = $codigo_producto;
    }

    public function getNombre_producto() {
        return $this->nombre_producto;
    }

    public function setNombre_producto( $nombre_producto ) {
        $this->nombre_producto = $nombre_producto;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca( $marca ) {
        $this->marca = $marca;
    }

    public function getPrecio_compra() {
        return $this->precio_compra;
    }

    public function setPrecio_compra( $precio_compra ) {
        $this->precio_compra = $precio_compra;
    }

    public function getPrecio_venta() {
        return $this->precio_venta;
    }

    public function setPrecio_venta( $precio_venta ) {
        $this->precio_venta = $precio_venta;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo( $modelo ) {
        $this->modelo = $modelo;
    }

    public function getStock_existente() {
        return $this->stock_existente;
    }

    public function setStock_existente( $stock_existente ) {
        $this->stock_existente = $stock_existente;
    }

    public function getStock_min() {
        return $this->stock_min;
    }

    public function setStock_min( $stock_min ) {
        $this->stock_min = $stock_min;
    }

    public function getImagen_producto() {
        return $this->imagen_producto;
    }

    public function setImagen_producto( $imagen_producto ) {
        $this->imagen_producto = $imagen_producto;
    }

    public function getImagen_barras() {
        return $this->imagen_barras;
    }

    public function setImagen_barras( $imagen_barras ) {
        $this->imagen_barras = $imagen_barras;
    }

    public function getId_proveedor() {
        return $this->id_proveedor;
    }

    public function setId_proveedor( $id_proveedor ) {
        $this->id_proveedor = $id_proveedor;
    }

    public function getId_ubicacion() {
        return $this->id_ubicacion;
    }

    public function setId_ubicacion( $id_ubicacion ) {
        $this->id_ubicacion = $id_ubicacion;
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

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo( $tipo ) {
        $this->tipo = $tipo;
    }
    
    public function getIva() {
        return $this->iva;
    }

    public function setIva( $iva ) {
        $this->iva = $iva;
    }
}