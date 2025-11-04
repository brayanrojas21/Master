<?php
/**
 * Plantilla HTML para la orden de servicio
 * Este archivo contiene solo la estructura HTML y recibe las variables desde la función principal
 */
?>

<table style='width:100%'>
    <tbody>
        <tr>
            <td>
                <table style='width:100%'>
                    <tbody>
                        <tr>
                            <td>
                                <table style='width:100%'>
                                    <tbody>
                                        <tr>
                                            <td align='left' style='vertical-align:bottom;'>
                                                <table style='width:50px;'>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <barcode code='<?php echo $id_orden; ?>' type='C93' size='1.7' />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align='center' style='font-size: 15px; color: #000; word-break: break-word!important;'><?php echo $id_orden; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td align='right'>
                                                <table style='width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size:12px;color:#000;vertical-align:top;'>
                                                            <img src='.<?php echo $empresa->logo; ?>' style='width:95px'></td>
                                                        </tr>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'> 
                                                            <b>Número de orden:</b> <?php echo $id_orden; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='border: 1px solid;'>
                                    <tbody>
                                        <tr>
                                            <td width='50%' style='vertical-align: top;'>
                                                <table align='left' style='padding: 3.5px;width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;width:120px;'><b>Empresa/Nombre:</b></td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["nombre_empresa"]; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Nit/Cédula:</b></td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["nit_empresa"]; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Teléfono:</b></td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["telefono_encargado"]; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width='50%' style='vertical-align: top;'>
                                                <table align='right' style='padding: 3.5px;width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Centro De Servicio:</b> </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $empresa->nombre; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '><b>Telefono:</b> </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $empresa->telefono; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '><b>Dirección:</b> </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $empresa->direccion; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style='border: 1px solid;padding: 3.5px;margin-top:10px;width: 100%;'>
                                    <tbody>
                                        <tr>
                                            <td width='50%' style='vertical-align: top;'>
                                                <table align='left' style='padding: 3.5px;width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;width:115px;'><b>Tipo producto:</b>
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["tipo_equipo"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Modelo Comercial:</b> 
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["modelo"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                         <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Modelo Tecnico:</b> 
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["modelo2"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Marca:</b> 
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["marca"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width='50%' style='vertical-align: top;'>
                                                <table align='right' style='padding: 3.5px;width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Serie:</b> 
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["serie"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Código interno:</b> 
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $equipo["codigo_interno"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'> <b>Tipo atención:</b>
                                                                            </td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $datos["tipo_atencion"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Fecha De Ingreso:</b></td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $fec_in; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top;'><b>Fecha De Salida:</b></td>
                                                                            <td style='font-size: 12px; color: #000; word-break: break-word!important;'><?php echo $fec_fin; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Descripción, Diagnóstico y Entrega: Sección mejorada para manejar textos largos -->
<div style='padding: 6px;width: 100%;'>
    <div style='border: 1.7px solid;padding: 15px;width: 100%;'>
        <!-- Descripción con manejo mejorado de texto largo -->
        <div style="margin-bottom: 10px;">
            <b style='font-size: 12px;'>Descripción:</b>
            <div style='font-size: 12px; line-height: 1.5; white-space: pre-wrap; word-wrap: break-word; max-width: 100%; overflow: auto;'><?php echo $datos['observacion']; ?></div>
        </div>
        
        <!-- Diagnóstico con manejo mejorado de texto largo -->
        <div style="margin-bottom: 10px;">
            <b style='font-size: 12px;'>Diagnóstico:</b>
            <div style='font-size: 12px; line-height: 1.5; white-space: pre-wrap; word-wrap: break-word; max-width: 100%; overflow: auto;'><?php echo $datos['diagnostico']; ?></div>
        </div>
        
        <!-- Entrega (solo si es informe final) -->
        <?php if ($datos["tipo"] == "final") : ?>
        <div>
            <b style='font-size: 12px;'>Entrega:</b>
            <div style='font-size: 12px; line-height: 1.5; white-space: pre-wrap; word-wrap: break-word; max-width: 100%; overflow: auto;'><?php echo $datos['nota_final']; ?></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<table style='background-color:white;width:100%;margin-top: 10px;'>
    <tbody>
        <tr>
            <td>
                <table style='background-color:white;width:100%'>
                    <tbody>
                        <tr>
                            <td>
                                <style>
                                    table.cotizacion,table.cotizacion th,table.cotizacion td {
                                      border: 1px solid black;
                                      border-collapse: collapse;
                                    }
                                    table.cotizacion td {
                                      padding: 5px;
                                    }
                                </style>
                                <table style='width:100%;border-collapse: collapse;' class='cotizacion'>
                                    <thead>
                                        <tr>
                                            <th style='font-size: 12px; color: black; padding: 5px;text-align:center;'>Código</th>
                                            <th style='font-size: 12px; color: black; padding: 5px;text-align:center;'>Nombre</th>
                                            <th style='font-size: 12px; color: black; padding: 5px;text-align:center;' width='50px'>Cant.</th>
                                            <?php if ($datos["size"] != "final") : ?>
                                                <th style='font-size: 12px; color: #1e2b33; width: 100px;text-align:center;'>Valor Uni.</th>
                                                <th style='font-size: 12px; color: #1e2b33; padding: 5px;width: 100px;text-align:center;'>Total</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subtotal_base = 0;  // Subtotal antes de IVA y descuento
                                        $total_iva = 0;      // Total del IVA
                                        $total_descuento = 0; // Total del descuento
                                        $v_total = 0;        // Total final
                                        $vb_total = 0;
                                        foreach ($cotiza as $data) : 
                                            [$cant, $nomb] = is_numeric($data[1]) && !is_numeric($data[2]) ? [intval($data[1]), $data[2]] : [intval($data[2]), $data[1]];
                                            $unidad = intval($data[4]);
                                            $iva = is_numeric($data[5]) ? floatval($data[5]) : 0;  
                                            $desc = is_numeric($data[6]) ? floatval($data[6]) : 0;  

                                            // Cálculos paso a paso
                                            $subtotal_item = $cant * $unidad;                           // Subtotal del item (sin IVA ni descuento)
                                            $descuento_item = $subtotal_item * ($desc / 100);           // Descuento del item
                                            $base_con_descuento = $subtotal_item - $descuento_item;     // Base después del descuento
                                            $iva_item = $base_con_descuento * ($iva / 100);             // IVA sobre la base con descuento
                                            $total_item = $base_con_descuento + $iva_item;              // Total final del item

                                            // Acumular totales
                                            $subtotal_base += $subtotal_item;
                                            $total_descuento += $descuento_item;
                                            $total_iva += $iva_item;
                                            $v_total += $total_item;
                                            ?>
                                            <tr>
                                                <td style='font-size: 10px;'><?php echo $data[8]; ?></td>
                                                <td style='font-size: 10px; word-wrap: break-word;' class='article'><?php echo $nomb; ?></td>
                                                <td style='font-size: 12px;' align='center'><?php echo $cant; ?></td>
                                                <?php if ($datos["size"] != "final") : ?>
                                                    <td align='right'>$<?php echo number_format($unidad); ?></td>
                                                    <td align='right'>$<?php echo number_format($subtotal_item); ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>

                                        <?php if ($datos["size"] !== "final") : ?>
                                            <!-- Subtotal (antes de IVA y descuento) -->
                                            <tr style='border-top: 1px solid #ddd;'>
                                                <td align='right' colspan='4' style='padding: 5px;'><b>Subtotal</b></td>
                                                <td align='right' style='padding: 5px;'><b>$<?php echo number_format($subtotal_base); ?></b></td>
                                            </tr>

                                            <!-- Total descuento -->
                                            <?php if ($total_descuento > 0) : ?>
                                            <tr>
                                                <td align='right' colspan='4' style='padding: 5px;'><b>Descuento</b></td>
                                                <td align='right' style='padding: 5px;'><b>-$<?php echo number_format($total_descuento); ?></b></td>
                                            </tr>
                                            <?php endif; ?>

                                            <!-- Total IVA -->
                                            <?php if ($total_iva > 0) : ?>
                                            <tr>
                                                <td align='right' colspan='4' style='padding: 5px;'><b>IVA</b></td>
                                                <td align='right' style='padding: 5px;'><b>$<?php echo number_format($total_iva); ?></b></td>
                                            </tr>
                                            <?php endif; ?>

                                            <!-- Total -->
                                            <tr>
                                                <td align='right' colspan='4' style='padding: 5px;'><b>Total</b></td>
                                                <td align='right' style='padding: 5px;'><b>$<?php echo number_format($v_total); ?></b></td>
                                            </tr>

                                            <!-- Abonos -->
                                            <?php if (!empty($abonos)) : ?>
                                                <?php foreach ($abonos as $key => $data_abono) : ?>
                                                    <?php 
                                                    $key = $key + 1;
                                                    $cant = $data_abono[0];
                                                    $vb_total += $cant;
                                                    ?>
                                                    <tr>
                                                        <td align='right' colspan='4' style='padding: 5px;'><b>Abono <?php echo $key; ?></b></td>
                                                        <td align='right' style='padding: 5px;'><b>-$<?php echo number_format($cant); ?></b></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <!-- Total a pagar -->
                                            <?php 
                                            $cotiza_abono = ($v_total - $vb_total);
                                            $totalPagar = number_format($cotiza_abono);
                                            ?>
                                            <tr style='border-top: 2px solid #333; background-color: #f8f9fa;'>
                                                <td align='right' colspan='4' style='padding: 8px;'><b style='font-size: 13px;'>TOTAL A PAGAR</b></td>
                                                <td align='right' style='padding: 8px;'><b >$<?php echo $totalPagar; ?></b></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Firmas -->
<?php if ($datos["posicion"] >= 4 && $datos["size"] != "final") : ?>
    <table width='100%' style="margin-top: 20px;">
        <tbody>
            <tr>
                <td style='font-size: 12px;text-align:center;width:50%;'>
                <hr noshade='noshade' style='border-color: black; color: black;width:75%;vertical-align:bottom;margin-top: 50px;'><br>
                Firma Cliente</td>
                <td style='font-size: 12px;text-align:center;width:50%;'>
                <hr noshade='noshade' style='border-color: black; color: black;width:75%;vertical-align:bottom;margin-top: 50px;'><br>
                Firma Responsable</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<!-- Tirilla desprendible con borde punteado 
<div style="width:100%; margin-bottom:15px; border-bottom:2px dashed #000; border-top:2px dashed #000; padding-bottom:10px;">
    <table style="width:100%; font-size:12px;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <strong>Orden Nº:</strong> <?php echo $id_orden; ?>
                </td>
                <td style="width:50%;">
                    <strong>Empresa:</strong> <?php echo $equipo["nombre_empresa"]; ?>
                </td>
            </tr>
            <tr>
                <td style="width:50%;">
                    <strong>NIT/Cédula:</strong> <?php echo $equipo["nit_empresa"]; ?>
                </td>
                <td style="width:50%;">
                    <strong>Tipo producto:</strong> <?php echo $equipo["tipo_equipo"]; ?>
                </td>
            </tr>
            <tr>
                <td style="width:50%;">
                    <strong>Modelo comercial:</strong> <?php echo $equipo["modelo"]; ?>
                </td>
                <td style="width:50%;">
                    <strong>Modelo técnico:</strong> <?php echo $equipo["modelo2"]; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>-->


<!-- Imágenes -->
<table width='100%' style='border-collapse: collapse;margin-top: 15px;'>
    <tbody>
        <tr>
            <?php
            $imagenes_guardadas = json_decode($datos['imagenes_guardadas'] ?? '[]');
            $tipos_imagenes = [
                0 => 'Imágenes de Recepción',
                1 => 'Imágenes de Diagnóstico',
                2 => 'Imágenes de Entrega'
            ];
            // Contar cuántas posiciones tienen imágenes
            $celdas = count(array_filter([0, 1, 2], fn($i) => !empty($imagenes_guardadas[$i])));
            $anchoCelda = $celdas > 0 ? 100 / $celdas : 0;

            // Mostrar imágenes
            foreach ($tipos_imagenes as $index => $titulo) :
                $imagenes = array_filter(explode('|', $imagenes_guardadas[$index] ?? ''));
                if (!$imagenes) continue;
            ?>
                <td style="border: 1px solid; vertical-align: top; text-align: center; width:<?= $anchoCelda ?>%">
                    <div style="font-weight: bold; font-size: 12px; margin-bottom: 5px;"><?= $titulo ?></div>
                    <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                        <?php foreach ($imagenes as $img) : ?>
                            <img src="../assets/images/ordenes/<?= $img ?>" style="max-width:100px; height:auto; margin: 5px;">
                        <?php endforeach; ?>
                    </div>
                </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
