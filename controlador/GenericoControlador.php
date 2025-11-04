<?php

class GenericoControlador {

    public function Encriptacion() {
        $encryp = [
            "method" => "*******",
            "key" => "********",
            "options" => 0,
            "iv" => '*********'
        ];
        return $encryp;
    }

    public function respuestaJSON( $info = array() ) {
        header( 'Content-Type:application/json' );
        $json = json_encode( $info );
        echo $json;
    }

    public function ValidarVista( $vista, $data_side, $sucur, $data ) {
        if ( !empty( $data_side ) ) {
            $url = str_replace( "_", " ", trim( $vista ) );
            // Validar acceso en $data_side
            if ( !in_array( $url, $data_side ) ) {
                header( 'Location: ./Sin_acceso' );
                exit;
            }
            // Validar acceso en sucursales si aplica
            if ( is_array( $sucur ) && !isset( $sucur[$data] ) ) {
                header( 'Location: ./Sin_acceso' );
                exit;
            }
        } else {
            header( 'Location: ./Sin_acceso' );
            exit;
        }
    }

    public function Sesion() {
        session_start();
        $user = [];
        if ( !isset( $_SESSION ['usuario_master'] ) ) {
            header( 'Location:./' );
        } else {
            $user = $_SESSION ['usuario_master'];
        }
        return $user;
    }

    public function SesionBack() {
        session_start();
        if ( !isset( $_SESSION ['usuario_master'] ) ) {
            throw new ValidacionExcepcion( "Upsss... Al parecer su sesión ha caducado, cierre todo y vuelva a ingresar!", -1 );
        } else {
            $user = $_SESSION ['usuario_master'];
            return $user;
        }
    }

    public function CerrarSesion() {
        session_start();
        session_destroy();
    }

    public function SideBar( $dataEmpr, $side_bar, $data_side, $user, $sucur, $dato, $inventario, $sucursales = NULL ) {
        ob_start();
        require( $side_bar );
        return ob_get_clean();
    }

    public function vistas( $vista, $sucursales, $dato, $dataEmpr ) {
        ob_start();
        require( $vista );
        return ob_get_clean();
    }

    public function Equipo( $equipo, $user, $null ) {
        ob_start();
        require( $equipo );
        return ob_get_clean();
    }

    public function Estados( $estado_vista, $user, $estados, $estados_boton ) {
        ob_start();
        require( $estado_vista );
        return ob_get_clean();
    }

    public function Sucursales( $sucursales, $mi_sucur ) {
        if ( $mi_sucur != "clientes" ) {
            foreach ( $sucursales as $key => $datos ) {
                if ( !in_array( $datos->id_sucursal, $mi_sucur ) ) {
                    unset( $sucursales[$key] ) ;
                }
            }
        }
        return array_values( $sucursales );
    }

    public function Encriptar( $valor ) {
        $dato = GenericoControlador::Encriptacion();
        $method = $dato["method"];
        $key = $dato["key"];
        $options = $dato["options"];
        $iv = $dato["iv"];
        $encryptedData = openssl_encrypt( $valor, $method, $key, $options, $iv );
        return $encryptedData;

    }

    public function Desencriptar( $valor ) {
        $dato = GenericoControlador::Encriptacion();
        $method = $dato["method"];
        $key = $dato["key"];
        $options = $dato["options"];
        $iv = $dato["iv"];
        $decryptedData = openssl_decrypt( $valor, $method, $key, $options, $iv );
        return $decryptedData;
    }

    public function procesar_imagenes( $archivos, $tipos, $ruta_destino, $calidad = 30, $imagenes_guardadas ) {
        $cadenas = [[], [], []];
        // Paso 1: Añadir imágenes guardadas al arreglo
        foreach ( $imagenes_guardadas as $tipo => $cadenaGuardada ) {
            if ( !empty( $cadenaGuardada ) ) {
                $imagenes = explode( '|', rtrim( $cadenaGuardada, '|' ) );
                foreach ( $imagenes as $nombre ) {
                    if ( trim( $nombre ) !== '' ) {
                        $cadenas[$tipo][] = $nombre;
                    }
                }
            }
        }
        // Paso 2: Procesar nuevas imágenes
        foreach ( ( array )$archivos['name'] as $key => $nombreOriginal ) {
            if ( empty( $nombreOriginal ) ) continue;
            // Validar si es imagen
            $tmp = is_array( $archivos['tmp_name'] ) ? $archivos['tmp_name'][$key] : $archivos['tmp_name'];
            $info = getimagesize( $tmp );
            if ( !$info ) continue;
            // Limpiar nombre
            $mime_permitidos = ['image/jpeg', 'image/png'];
            if ( !in_array( $info['mime'], $mime_permitidos ) ) continue;
            $nombreSeguro = preg_replace( '/[^a-zA-Z0-9._-]/', '_', basename( $nombreOriginal ) );
            $ruta_final = rtrim( $ruta_destino, '/' ) . '/' . $nombreSeguro;
            // Redimensionar y guardar
            if ( self::resize_image( $tmp, $ruta_final, $calidad ) ) {
                $tipo = is_array( $tipos ) ? ( $tipos[$key] ?? 0 ) : $tipos;
                $cadenas[$tipo][] = $nombreSeguro;
            }
        }
        // Convertir arrays en cadenas separadas por "|"
        foreach ( $cadenas as &$lista ) {
            $lista = implode( '|', $lista );
        }
        return $cadenas;
    }

    public function resize_image( $archivo, $ruta_destino, $calidad ) {
        $info = getimagesize( $archivo );
        if ( !$info ) return false;
        $imagen = match( $info['mime'] ) {
            'image/jpeg' => imagecreatefromjpeg( $archivo ),
            'image/png'  => imagecreatefrompng( $archivo ),
            'image/gif'  => imagecreatefromgif ( $archivo ),
            default      => false
        }
        ;
        if ( $imagen ) {
            imagejpeg( $imagen, $ruta_destino, $calidad );
            imagedestroy( $imagen );
            return true;
        }
        return false;
    }

    public function iconos( $servicios, $iconos_base ) {
        // Invertirlo: servicio => ícono
        $iconos_default = array_flip( $iconos_base );
        $resultado = [];
        foreach ( $servicios as $servicio ) {
            $icono = $iconos_default[$servicio] ?? 'mdi-home';
            $resultado[$icono] = $servicio;
        }
        $data_side = array_reverse ( $resultado );
        return $data_side;
    }

    public function puertoServidor() {
        $protocolo = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? "https" : "http";
        $host = $_SERVER['SERVER_NAME'];
        $puerto = ( $_SERVER['SERVER_PORT'] != 80 ) ? ":{$_SERVER['SERVER_PORT']}" : "";
        return "{$protocolo}://{$host}{$puerto}";
    }

    public function existeMetodo( $usuarioDAO, $metodo ) {
         // Validar que el método empiece por 'buscar_' y exista en usuarioDAO
        if ( !method_exists( $usuarioDAO, $metodo ) ) {
            throw new ValidacionExcepcion( 'Error!, Método no permitido.', -1 );
        }
    }

}
