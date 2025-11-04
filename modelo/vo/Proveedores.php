<?php

class Proveedores {

    private $id_proveedor;
    private $nombre_proveedor;
    private $nombre_contacto;
    private $telefono_contacto;
    private $correo_electronico;
    private $nit;

    public function getId_proveedor() {
        return $this->id_proveedor;
    }

    public function setId_proveedor( $id_proveedor ) {
        $this->id_proveedor = $id_proveedor;
    }

    public function getNombre_proveedor() {
        return $this->nombre_proveedor;
    }

    public function setNombre_proveedor( $nombre_proveedor ) {
        $this->nombre_proveedor = $nombre_proveedor;
    }

    public function getNombre_contacto() {
        return $this->nombre_contacto;
    }

    public function setNombre_contacto( $nombre_contacto ) {
        $this->nombre_contacto = $nombre_contacto;
    }

    public function getTelefono_contacto() {
        return $this->telefono_contacto;
    }

    public function setTelefono_contacto( $telefono_contacto ) {
        $this->telefono_contacto = $telefono_contacto;
    }

    public function getCorreo_electronico() {
        return $this->correo_electronico;
    }

    public function setCorreo_electronico( $correo_electronico ) {
        $this->correo_electronico = $correo_electronico;
    }

    public function getNit() {
        return $this->nit;
    }

    public function setNit( $nit ) {
        $this->nit = $nit;
    }
}