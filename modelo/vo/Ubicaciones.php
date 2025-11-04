<?php

class Ubicacion {

    private $id_ubicacion;
    private $tipo_ubicacion;
    private $numeracion;
    private $descripcion;
    private $id_sucursal;

    public function getId_ubicacion() {
        return $this->id_ubicacion;
    }

    public function setId_ubicacion( $id_ubicacion ) {
        $this->id_ubicacion = $id_ubicacion;
    }

    public function getTipo_ubicacion() {
        return $this->tipo_ubicacion;
    }

    public function setTipo_ubicacion( $tipo_ubicacion ) {
        $this->tipo_ubicacion = $tipo_ubicacion;
    }

    public function getNumeracion() {
        return $this->numeracion;
    }

    public function setNumeracion( $numeracion ) {
        $this->numeracion = $numeracion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion( $descripcion ) {
        $this->descripcion = $descripcion;
    }

    public function getId_sucursal() {
        return $this->id_sucursal;
    }

    public function setId_sucursal( $id_sucursal ) {
        $this->id_sucursal = $id_sucursal;
    }
}