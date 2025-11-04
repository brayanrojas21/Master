<?php
/**
 * Plantilla HTML para los correos
 * Este archivo contiene solo la estructura HTML y recibe las variables desde la función principal
 */
?>

<table style="background:#f3f3f3; width:100%;" cellpadding="0" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td style="padding: 50px;">
                <table style="width: 550px;margin: 0 auto" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr style="border-bottom:1px dashed #ddd">
                            <td style="font-family: Nunito, sans-serif; font-size: 20px; font-weight: bold; text-align: center; color: #001737; padding-bottom: 22px">
                                Notificación de servicio técnico
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 20px;"> 
                                <img style="float:left; height:40px;" src="<?= $base_url . str_replace('./', '/', $empresa->logo) ?>" alt="Logo">
                                <p style="font-family: Nunito, sans-serif; font-size: 13px; color:#bbb; float:right; margin-top: 10px;">
                                    Centro de servicio - <?php echo $empresa->nombre; ?>
                                </p>
                            </td>
                        </tr>
                        <?php if (isset($datos['recep_cadena']) && $datos['recep_cadena'] != "") : ?>
                           <?php 
                            $imagen1 = explode("|", $datos['recep_cadena']);?>
                            <tr>
                                <td style="padding-top: 20px;"> 
                                    <img 
                                        src="<?php echo htmlspecialchars($base_url . '/assets/images/ordenes/' . $imagen1[0]); ?>" 
                                        alt="Imagen del servicio técnico" 
                                        style="max-width: 100%; width: 100%; border-radius: 10px; display: block; margin-top: 20px;" 
                                    />
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="border-radius: 10px;background: #fff;padding: 30px 40px 20px 40px;margin-top: 20px;display: block;">
                                <p style="font-family: Nunito, sans-serif; font-size: 16px; font-weight: 500; color: #2b80ff;">¡Hola <?php echo $equipo->nombre_empresa; ?>!</p>
                                <p style="font-family: Nunito, sans-serif; font-size: 14px; color: #001737;">
                                    📌 Estado de tu orden de servicio: <strong><?php echo $datos['cod']; ?></strong><br><br>
                                    🛠 <strong>Detalles del equipo:</strong><br>
                                    • Tipo: <?php echo $equipo->tipo_equipo; ?><br>
                                    • Modelo: <?php echo $equipo->modelo; ?><br>
                                    • Marca: <?php echo $equipo->marca; ?><br><br>
                                    <?php echo $detalleTexto; ?><br>
                                    <?php echo $extra; ?>
                                </p>
                                <p style="font-family: Nunito, sans-serif; font-size: 13px; color: #bbbbbb; margin-top: 20px;">
                                    Si tienes dudas, no dudes en contactarnos. ¡Gracias por confiar en nosotros! 😊
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="margin: 20px auto 10px auto;" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Nunito, sans-serif; font-size: 13px; color: #001737; text-align: center;">
                                © <?php echo date('Y'); ?> <?php echo $empresa->nombre; ?>. Todos los derechos reservados.
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
