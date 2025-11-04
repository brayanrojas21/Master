<?php

class Cliente {

    private $id_cliente;
    private $nombre_empresa;
    private $nit_empresa;
    private $direccion_empresa;
    private $correo_electronico;
    private $clave;
    private $nombre_encargado;
    private $telefono_encargado;
    private $telefono2_encargado;
    private $cedula_encargado;
    private $cargo_encargado;
    private $nombre_representante;
    private $telefono_representante;
    private $correo_representante;
    private $servicios_aprobados;
    private $estado;
    private $sucursales;

    public function getId_cliente() {
        return $this->id_cliente;
    }

    public function setId_cliente( $id_cliente ) {
        $this->id_cliente = $id_cliente;
    }

    public function getNombre_empresa() {
        return $this->nombre_empresa;
    }

    public function setNombre_empresa( $nombre_empresa ) {
        $this->nombre_empresa = $nombre_empresa;
    }

    public function getNit_empresa() {
        return $this->nit_empresa;
    }

    public function setNit_empresa( $nit_empresa ) {
        $this->nit_empresa = $nit_empresa;
    }

    public function getDireccion_empresa() {
        return $this->direccion_empresa;
    }

    public function setDireccion_empresa( $direccion_empresa ) {
        $this->direccion_empresa = $direccion_empresa;
    }

    public function getCorreo_electronico() {
        return $this->correo_electronico;
    }

    public function setCorreo_electronico( $correo_electronico ) {
        $this->correo_electronico = $correo_electronico;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave( $clave ) {
        $this->clave = $clave;
    }

    public function getNombre_encargado() {
        return $this->nombre_encargado;
    }

    public function setNombre_encargado( $nombre_encargado ) {
        $this->nombre_encargado = $nombre_encargado;
    }

    public function getTelefono_encargado() {
        return $this->telefono_encargado;
    }

    public function setTelefono_encargado( $telefono_encargado ) {
        $this->telefono_encargado = $telefono_encargado;
    }

    public function getCedula_encargado() {
        return $this->cedula_encargado;
    }

    public function setCedula_encargado( $cedula_encargado ) {
        $this->cedula_encargado = $cedula_encargado;
    }

    public function getCargo_encargado() {
        return $this->cargo_encargado;
    }

    public function setCargo_encargado( $cargo_encargado ) {
        $this->cargo_encargado = $cargo_encargado;
    }

    public function getNombre_representante() {
        return $this->nombre_representante;
    }

    public function setNombre_representante( $nombre_representante ) {
        $this->nombre_representante = $nombre_representante;
    }

    public function getTelefono_representante() {
        return $this->telefono_representante;
    }

    public function setTelefono_representante( $telefono_representante ) {
        $this->telefono_representante = $telefono_representante;
    }

    public function getCorreo_representante() {
        return $this->correo_representante;
    }

    public function setCorreo_representante( $correo_representante ) {
        $this->correo_representante = $correo_representante;
    }

    public function getServicios_aprobados() {
        return $this->servicios_aprobados;
    }

    public function setServicios_aprobados( $servicios_aprobados ) {
        $this->servicios_aprobados = $servicios_aprobados;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado( $estado ) {
        $this->estado = $estado;
    }
    
    public function getSucursales() {
        return $this->sucursales;
    }

    public function setSucursales( $sucursales ) {
        $this->sucursales = $sucursales;
    }
    
     public function getTelefono2_encargado() {
        return $this->telefono2_encargado;
    }

    public function setTelefono2_encargado( $telefono2_encargado ) {
        $this->telefono2_encargado = $telefono2_encargado;
    }
}
