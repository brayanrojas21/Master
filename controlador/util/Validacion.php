<?php

class Validacion {

    /**
     * Verifiva que la informacion que escribe se recibe sea correcta
     * @param array $reglas Restricciones sobre los parametrso
     * @param array $info son los parametrsos $_POST o _$_GET
     */
    public static function validar(array $reglas, array $info) {
        foreach ($reglas as $parametro => $restriccion) {
            $parametro_legible = str_replace('_', ' ', $parametro);
            switch ($restriccion) {
                case 'obligatorio':
                    if (!isset($info[$parametro]) || empty($info[$parametro])) {
                        throw new ValidacionExcepcion("El campo $parametro_legible es obligatorio", -1);
                    }
                    break;
                case 'numero':
                    if (!is_numeric($info[$parametro])) {
                        throw new ValidacionExcepcion("El campo $parametro_legible debe ser un numero", -1);
                    }
                    break;
                case 'clave':
                    if (isset($info[$parametro]) && preg_match('/[a-zA-Z0-9]/', $info[$parametro])) {
                        if (strlen($info[$parametro]) < 8) {
                            throw new ValidacionExcepcion("El campo $parametro_legible debe tener mínimo 8 caracteres", -1);
                        }
                    }
                    break;
                case 'email':
                    if (filter_var($info[$parametro], FILTER_VALIDATE_EMAIL) == false) {
                        throw new ValidacionExcepcion("El campo $parametro_legible es incorrecto", -1);
                    }
                    break;
                case 'fecha':
                    $valores = explode('/', $fecha);
                    if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
                        
                    } else {
                        throw new ValidacionExcepcion("El fecha $parametro_legible es incorrecta", -1);
                    }
                    break;
            }
        }
    }

}
