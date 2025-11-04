<?php
/**
 * Plantilla HTML para la orden de servicio en formato recibo
 * Este archivo contiene solo la estructura HTML y recibe las variables desde la función principal
 */
?>
<table style='width: 100%;'>
    <tbody>
        <tr>
            <td>
                <table style='width:100%'>
                    <tbody>
                        <tr>
                            <td>
                                <table style='padding-top: 10px;width:100%'>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table style='width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='line-height: 20px; vertical-align: top; text-align:center;'>
                                                                <img src='.<?php echo $empresa->logo; ?>' style='width:120px'>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='vertical-align: top;'>
                                                <table style='width:100%' align='center'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                <table>
                                                                    <tbody>
                                                                        <?php if ($id_orden != 0 && isset($row["tipo"]) && $row["tipo"] == "final"): ?>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Número de orden:</b><br>
                                                                                <?php echo $row["cod"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endif; ?>

                                                                        <?php if (isset($row["tipo"]) && $row["tipo"] == "final"): ?>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Fecha Inicio:</b><br><?php echo $fec_in; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Fecha Final:</b><br><?php echo $fec_fin; ?>
                                                                            </td>
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
                                <table width='100%' style='border-top: 2px dotted;'>
                                    <tbody>
                                        <tr>
                                            <td style='vertical-align: top;'>
                                                <table align='left' style='width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 15px; color: #000;text-align:center;'>
                                                                <strong>Datos del Cliente</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Empresa/Nombre:</b><br><?php echo $equipo["nombre_empresa"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Nit/Cédula:</b><br><?php echo $equipo["nit_empresa"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Teléfono:</b><br><?php echo $equipo["telefono_encargado"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Dirección:</b><br><?php echo $equipo["direccion_empresa"]; ?>
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
                                        <tr>
                                            <td style='vertical-align: top;'>
                                                <table style='border-top: 2px dotted;width:100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='font-size: 15px; color: #000;text-align:center;'>
                                                                <strong>Datos del Equipo</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Tipo atención:</b><br><?php echo $datos["tipo_atencion"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Tipo producto:</b><br><?php echo $equipo["tipo_equipo"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Modelo:</b><br><?php echo $equipo["modelo"]; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style='font-size: 12px; color: #000; line-height: 20px; vertical-align: top; '>
                                                                                <b>Marca:</b><br><?php echo $equipo["marca"]; ?>
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
            </td>
        </tr>
    </tbody>
</table>

<div style='padding-left:8pt;padding-right:8pt'>
    <p style='font-size: 15px; color: #000;text-align:center;display:block;border-top: 1.5px dotted;'>
        <strong>Datos del Servicio</strong>
    </p>
    <pre style='font-size: 12px;'><b>Descripcion:</b> <?php echo $datos['observacion']; ?></pre>
    <hr>
    <pre style='font-size: 12px;'><b>Diagnostico:</b> <?php echo $datos['diagnostico']; ?></pre>
    <hr>
    <pre style='font-size: 12px;'><b>Entregado:</b> <?php echo $datos['nota_final']; ?></pre>
</div>

<table style='background:white;width: 100%;padding-top:10px;'>
    <tbody>
        <tr>
            <td>
                <table style='background-color:white;width:100%'>
                    <tbody>
                        <tr>
                            <td>
                                <table style='width:100%'>
                                    <thead>
                                        <tr>
                                            <th style='font-size: 12px; color: black; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;' align='left'>Nombre</th>
                                            <th style='font-size: 12px; color: black; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;width: 10px;'>Cant.</th>
                                            <th style='font-size: 12px; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;' align='right'>Sub. Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td height='1' style='background: black;' colspan='3'></td>
                                        </tr>
                                        <tr>
                                            <td height='10' colspan='3'></td>
                                        </tr>
                                        <?php
                                        $v_total = 0;
                                        $vb_total = 0;
                                        foreach ($cotiza as $data) : 
                                            [$cant, $nomb] = is_numeric($data[1]) && !is_numeric($data[2]) ? [intval($data[1]), $data[2]] : [intval($data[2]), $data[1]];
                                            $unidad = intval($data[4]);
                                            $iva = is_numeric($data[5]) ? floatval($data[5]) : 0;  
                                            $desc = is_numeric($data[6]) ? floatval($data[6]) : 0;  
                                            $total = intval(($cant * $unidad) * (1 - $desc / 100) * (1 + $iva / 100));
                                            $v_total += $total; ?>
                                        <tr>
                                            <td style='font-size: 10px; color: black; line-height: 18px; vertical-align: top; padding:10px 0;word-break: break-word!important;' class='article'><?php echo $nomb; ?></td>
                                            <td style='font-size: 12px; color: black; line-height: 18px; vertical-align: top; padding:10px 0;word-break: break-word!important;' align='center'><?php echo $cant; ?></td>
                                            <td style='font-size: 12px; color: #1e2b33; line-height: 18px; vertical-align: top; padding:10px 0;word-break: break-word!important;' align='right'><?php echo number_format($total); ?></td>
                                        </tr>
                                        <tr>
                                            <td height='1' colspan='3' style='border-bottom:1px solid #e4e4e4'></td>
                                        </tr>
                                        <?php endforeach; ?>
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

<table style='background-color:white;width:100%;'>
    <tbody>
        <tr>
            <td>
                <table style='background-color:white;width:100%'>
                    <tbody>
                        <tr>
                            <td>
                                <table style='width:100%'>
                                    <tbody>
                                        <?php if (!empty($abonos)): 
                                            foreach ($abonos as $key => $data_abono):
                                                $key = $key + 1;
                                                $cant = $data_abono[0];
                                                $vb_total += $cant;
                                        ?>
                                        <tr>
                                            <td style='font-size: 12px; color: black; vertical-align: top; text-align:right;'><b>Abono <?php echo $key; ?>: </b>$<?php echo number_format($cant); ?></td>
                                        </tr>
                                        <?php 
                                            endforeach;
                                        endif; 
                                        
                                        $cotiza_abono = ($v_total - $vb_total);
                                        $totalPagar = number_format($cotiza_abono);
                                        ?>
                                        <tr>
                                            <td style='font-size: 12px; color: black; vertical-align: top; text-align:right;'><b>Total: </b>$<?php echo $totalPagar; ?></td>
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

<?php 
$imagenes_guardadas = json_decode($datos['imagenes_guardadas'] ?? '[]');

$tipos_imagen = [
    0 => 'Imágenes Entrada',
    2 => 'Imágenes Finales'
];

if (($datos['tipo'] ?? '') === 'final') :
    foreach ($tipos_imagen as $indice => $titulo) :
        if (!empty($imagenes_guardadas[$indice])) :
            $imagenes = array_filter(explode("|", $imagenes_guardadas[$indice]));
            if (count($imagenes)) : ?>
                <div style='padding:6pt;text-align:center'>
                    <table style='border-top: 2px dotted;width:100%;text-align:center'>
                        <tbody>
                            <tr>
                                <td style='font-size: 11px; color: black; line-height: 1; vertical-align: top;padding-bottom: 18px;'>
                                    <strong><?= $titulo ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <?php foreach ($imagenes as $img): ?>
                                        <img src='../assets/images/ordenes/<?= $img ?>' style='width:130px;vertical-align: top;padding: 2px;'>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            endif;
        endif;
    endforeach;
endif;
?>