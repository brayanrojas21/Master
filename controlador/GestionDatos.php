<?php

class DatosGenerales {

    public static function servicios() {
        $arreglo = [
            "mdi-wrench" => "gestion de equipos",
            "mdi-account-multiple" => "gestion empleados",
            "mdi-account" => "gestion clientes",
            "mdi-archive" => "gestion inventario",
            "mdi-home-map-marker" => "gestion sucursales",
            "mdi-cart" => "punto de venta",
            "mdi-file-multiple" => "ordenes",
        ];
        return $arreglo;
    }

    public static function servicios_clientes() {
        $arreglo = [
            "Mis Equipos",
            "Mis Ordenes",
        ];
        return $arreglo;
    }

    public static function estados() {
        $arreglo = [
            1 => "Nueva recepción",
            2 => "Diagnóstico",
            3 => "Cotización",
            4 => "Reparación",
            5 => "Entrega",
            6 => "Finalizado",
        ];
        return $arreglo;
    }
    public static function inventario() {
        $arreglo = [
            "productos",
            "entradas",
            "salidas",
            "ubicaciones",
            "proveedores",
        ];
        return $arreglo;
    }
    
    public static function datos_correo($msg, $titulo) {
        return [
            "host"      => "smtp.gmail.com",
            "port"      => 465,
            "secure"    => "ssl",
            "SMTPAuth"  => true,
            "username"  => "adsomtiae@gmail.com",
            "password"  => "xdtf hnpo wjaw kcwf",
            "setfrom"   => "adsomtiae@gmail.com",
            "address"   => "amigobrayan809@gmail.com",
            "titulo"    => $titulo,
            "msgHTML"   => $msg
        ];
    }
    
  
    
}
