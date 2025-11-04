<?php

class VistasPDF {

    public static function Orden_servicio($datos, $dataEmpr) {
        try {
            return self::generarPDF(
                $datos,
                $dataEmpr,
                __DIR__ . '/plantillas/pdf.orden_grande.php',
                [
                    'header' => true,
                    'footer_text' => 'Estimado Cliente Después de Pasados 90 Días NO se Responde por la Herramienta',
                    'titulo_final' => 'Informe Técnico',
                    'titulo_parcial' => 'Orden de servicio'
                ]
            );
        } catch (Exception $e) {
            throw new ValidacionExcepcion("Error en generación de orden de servicio: " . $e->getMessage(), -1);
        }
    }

    public static function Orden_recibo($datos, $dataEmpr) {
        try {
            return self::generarPDF(
                $datos,
                $dataEmpr,
                __DIR__ . '/plantillas/pdf.orden_recibo.php',
                [
                    'header' => false,
                    'titulo_final' => '',
                    'titulo_parcial' => '',
                    'custom_style' => "
                        <style>
                            @media print {
                                @page {
                                    margin: 0mm;
                                    sheet-size: 54mm 210mm;
                                }
                            }
                        </style>
                    "
                ]
            );
        } catch (Exception $e) {
            throw new ValidacionExcepcion("Error en generación de orden de servicio: " . $e->getMessage(), -1);
        }
    }
    
    private static function generarPDF($datos, $dataEmpr, $template_path, $opciones) {
        $fecha = date("Y-m-d");
        $equipo = json_decode($datos["equipo"], true);
        $cotiza = json_decode($datos["arreglo"], true);
        $abonos = json_decode($datos["abono"], true);
        $fechas = json_decode($datos["tiempos"], true);
        $esFinal = ($datos["size"] === "final");
        $row = $esFinal ? "3" : "7";
        $id_orden = (!empty($datos["cod"])) ? $datos["cod"] : 0;
        $fec_in = isset($datos["fecha"]) ? date('Y-m-d, h:i a', strtotime($datos["fecha"])) : "-";
        $fec_fin = !empty($fechas[5]) ? date('Y-m-d, h:i a', strtotime($fechas[5])) : "-";
        // Extraer variables para la plantilla
        $template_vars = [
            'empresa' => $dataEmpr,
            'equipo' => $equipo,
            'cotiza' => $cotiza,
            'abonos' => $abonos,
            'fechas' => $fechas,
            'row' => $row,
            'id_orden' => $id_orden,
            'fec_in' => $fec_in,
            'fec_fin' => $fec_fin,
            'datos' => $datos
        ];
        extract($template_vars);
        ob_start();
        include $template_path;
        $html_content = ob_get_clean();
        $tablas = $html_content;

        $custom_style = $opciones['custom_style'] ?? '';
        $ehtml = "<html>{$custom_style}<body>{$tablas}<div style='clear: both; margin: 0pt; padding: 0pt;'></div></body></html>";

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $mpdf->keep_table_proportions = true;

        if (!empty($opciones['header'])) {
            $texto = (in_array($datos["estado"], ["Finalizado", "Entrega"])) ? "" : $datos["estado"] . " - ";
            $titulo = $esFinal ? $opciones['titulo_final'] : $opciones['titulo_parcial'];
            $mpdf->defaultheaderline = 0;
            $mpdf->setHTMLHeader("<table width='100%'><tr>
                <td width='30%'>{DATE Y-m-d, h:i a}</td>
                <td width='70%' align='right' style='font-weight: bold; font-size:17px;vertical-align: top;'>{$texto}{$titulo}</td>
                </tr></table><hr>");
            $mpdf->SetFooter($opciones['footer_text'] . '||{PAGENO}');
            $mpdf->AddPageByArray(['margin-top' => 20, 'margin-bottom' => 17]);
            $mpdf->simpleTables = true;
            $mpdf->packTableData = true;
        }
        $mpdf->WriteHTML($ehtml);
        return base64_encode($mpdf->Output('', 'S'));
    }
    
}
