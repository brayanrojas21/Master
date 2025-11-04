<?php

class Entradas {

    private $id_entrada;
    private $cant_entrada;
    private $precio_compra;
    private $stock;
    private $id_productos;
    private $id_usuario;
    private $id_sucursal;

    public function getId_entrada() {
        return $this->id_entrada;
    }

    public function setId_entrada( $id_entrada ) {
        $this->id_entrada = $id_entrada;
    }

    public function getCant_entrada() {
        return $this->cant_entrada;
    }

    public function setCant_entrada( $cant_entrada ) {
        $this->cant_entrada = $cant_entrada;
    }

    public function getPrecio_compra() {
        return $this->precio_compra;
    }

    public function setPrecio_compra( $precio_compra ) {
        $this->precio_compra = $precio_compra;
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
    
    public function getId_sucursal(){
		return $this->id_sucursal;
	}

	public function setId_sucursal($id_sucursal){
		$this->id_sucursal = $id_sucursal;
	}
}