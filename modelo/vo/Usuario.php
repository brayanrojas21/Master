<?php

class Usuario {

    private $id_usuario;
    private $cedula;
    private $nombre;
    private $apellido;
    private $clave;
    private $estado;
    private $correo_electronico;
    private $privilegio;
    private $servicios_aprobados;
    private $sucursales;

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario( $id_usuario ) {
        $this->id_usuario = $id_usuario;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula( $cedula ) {
        $this->cedula = $cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre( $nombre ) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido( $apellido ) {
        $this->apellido = $apellido;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave( $clave ) {
        $this->clave = $clave;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado( $estado ) {
        $this->estado = $estado;
    }

    public function getCorreo_electronico() {
        return $this->correo_electronico;
    }

    public function setCorreo_electronico( $correo_electronico ) {
        $this->correo_electronico = $correo_electronico;
    }

    public function getPrivilegio() {
        return $this->privilegio;
    }

    public function setPrivilegio( $privilegio ) {
        $this->privilegio = $privilegio;
    }

    public function getServicios_aprobados() {
        return $this->servicios_aprobados;
    }

    public function setServicios_aprobados( $servicios_aprobados ) {
        $this->servicios_aprobados = $servicios_aprobados;
    }
    
    public function getSucursales() {
        return $this->sucursales;
    }

    public function setSucursales( $sucursales ) {
        $this->sucursales = $sucursales;
    }

}
