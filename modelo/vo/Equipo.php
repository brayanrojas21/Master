<?php

class Equipo {

    private $id_equipo;
    private $id_cliente;
    private $codigo_interno;
    private $tipo_equipo;
    private $modelo;
    private $modelo2;
    private $marca;
    private $serie;
    private $imagen;
    private $descripcion;
    private $estado;

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

    public function getCodigo_interno() {
        return $this->codigo_interno;
    }

    public function setCodigo_interno( $codigo_interno ) {
        $this->codigo_interno = $codigo_interno;
    }

    public function getTipo_equipo() {
        return $this->tipo_equipo;
    }

    public function setTipo_equipo( $tipo_equipo ) {
        $this->tipo_equipo = $tipo_equipo;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo( $modelo ) {
        $this->modelo = $modelo;
    }
    
    public function getModelo2() {
        return $this->modelo2;
    }

    public function setModelo2( $modelo2 ) {
        $this->modelo2 = $modelo2;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca( $marca ) {
        $this->marca = $marca;
    }

    public function getSerie() {
        return $this->serie;
    }

    public function setSerie( $serie ) {
        $this->serie = $serie;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen( $imagen ) {
        $this->imagen = $imagen;
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
}
