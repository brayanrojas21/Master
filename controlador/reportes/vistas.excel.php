<?php

class VistasEXCEL {

    public static function reporte_excel( $datos ) {
         // Definir el estilo de los encabezados
        $headerStyle = '<style bgcolor="#FF0000" color="#FFFFFF" height="30" border="#000000"><middle><center>';
        $headerEndStyle = '</center></middle></style>';
        $fecha = date( "Y-m-d" );
        // estados cotizacion
        $estadoCotizacionMap = [ "", "Pendiente por aprobación", "No autoriza", "No se justifica", "Aprobado" ];
        // Definir los encabezados sin estilos
        $headers = [];
        $headersText = [
            'Código Orden', 'Tipo de Atención', 'Estado', 'Fecha creado', 'Fecha finalizado', 'Estado Cotización',
            'Creador', 'NIT Empresa', 'Nombre Empresa/Cliente', 'Cédula Encargado', 'Nombre',
            'Tipo de Equipo', 'Modelo Comercial', 'Modelo Técnico', 'Marca', 'Serie'
        ];
        //recorrido a encabezados
        foreach ($headersText as $header) {
            $headers[] = $headerStyle . $header . $headerEndStyle;
        }
        // Convertir los objetos en un array bidimensional con los nuevos encabezados
        $rows = [$headers];
        // Iniciar con los encabezados
        foreach ( $datos as $item ) {
            $estadoCotizacion = isset($estadoCotizacionMap[$item->estado_cotizacion]) ? 
                            $estadoCotizacionMap[$item->estado_cotizacion] : "";
            $fechaFin = ($item->estado === 'Finalizado' || $item->estado === 'De baja') ? $item->fecha_final : "";
            //asignación de datos
            $rowData = [
                $item->cod_orden,
                $item->tipo_atencion,
                $item->estado,
                $item->fecha,
                $fechaFin,
                $estadoCotizacion,
                $item->empleado,
                $item->nit_empresa,
                $item->nombre_empresa,
                $item->cedula_encargado,
                $item->nombre,
                $item->tipo_equipo,
                $item->modelo,
                $item->modelo2,
                $item->marca,
                $item->serie
            ];
            //dejarles estilos
            $rows[] = array_map(fn($value) => '<style border="#000000"><left>' . $value . '</left></style>', $rowData);
        }
        $xlsx = Shuchkin\SimpleXLSXGen::fromArray($rows);
        // Capturar el contenido del archivo en un buffer
        ob_start();
        $xlsx->saveAs('php://output');
        $xlsxContent = ob_get_clean(); // Obtener el contenido del buffer
        $base64 = base64_encode($xlsxContent);
        return $base64;
        
    }

}
