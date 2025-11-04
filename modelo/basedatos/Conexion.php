<?php

class Conexion {

    public static function conectar() {
        date_default_timezone_set('America/Bogota');
        $cnn = new PDO('mysql:host=localhost;port=3306;dbname=master', 'root', '');
        $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $cnn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        return $cnn;
    }

}