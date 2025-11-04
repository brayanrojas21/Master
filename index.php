<?php

$vista = 'Panel';
require_once "./controlador/GestionVistaControlador.php";
$controlador = new VistaControlador();
$validador = ( isset( $_GET["view"] ) ) ? true : false;
$dato = ( isset( $_GET["suc"] ) ) ? $_GET["suc"] : 0;

// Todo esta lógica hara el papel de un FrontController
if ( !$validador ) {
    call_user_func( array( $controlador, $vista ), $vista, $dato );
} else {
    $accion =  ( $validador ) ? $_GET["view"] : 'Error';
    if ( method_exists( $controlador, $accion ) ) {
        call_user_func( array( $controlador, $accion ), $accion, $dato );
    } else {
        call_user_func( array( $controlador, 'Error' ), $accion, $dato );
    }
}