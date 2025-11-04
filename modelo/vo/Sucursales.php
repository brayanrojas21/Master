<?php

class Sucursales {

    private $id_sucursal;
    private $nombre;
    private $direccion;
    private $descripcion;
    private $estado;
    private $id_usuario;

    public function getId_sucursal() {
        return $this->id_sucursal;
    }

    public function setId_sucursal( $id_sucursal ) {
        $this->id_sucursal = $id_sucursal;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre( $nombre ) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion( $direccion ) {
        $this->direccion = $direccion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion( $descripcion ) {
        $this->descripcion = $descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado( $estado ) {
        $this->estado = $estado;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario( $id_usuario ) {
        $this->id_usuario = $id_usuario;
    }
}

