<?php

class VistasMensajes {

    public static function generar_mensaje( $datos, $formato, $dataEmpr, $base_url ) {
        $tipo = $datos["tipo"];
        $url = rawurlencode($datos["url"] ?? "");
        $equipo = is_string($datos["equipo"]) ? json_decode($datos["equipo"]) : $datos["equipo"];
        $detalles = [
            "cotizacion" => [
                "detalle" => "Contiene los siguientes hallazgos según el diagnóstico: {diagnostico}.",
                "extra" => "Se adjunta la cotización del servicio para ser aprobada e iniciar la reparación."
            ],
            "nuevo" => [
                "detalle" => "Ha sido registrado en el centro de servicio.",
                "extra" => "Te avisaremos sobre el estado de tu equipo ⚙️🪛"
            ],
            "entrega" => [
                "detalle" => "Tu equipo fue reparado y está listo para entregar.",
                "extra" => "Puedes acercarte para recoger tu equipo en el horario de atención establecido. Que tengas buen día ⚙️🪛"
            ],
            "encuesta" => [
                "detalle" => "Queremos invitarte a calificar tu experiencia.",
                "extra" => "A través del enlace {$url} para ayudarnos a mejorar. Gracias por tu ayuda ⚙️🪛"
            ]
        ];
        $detalle = $detalles[$tipo] ?? ["detalle" => "Información no disponible.", "extra" => ""];
        $reemplazos = [
            "{empresa}" => $equipo->nombre_empresa,
            "{cod}" => $datos["cod"],
            "{tipo_equipo}" => $equipo->tipo_equipo,
            "{modelo}" => $equipo->modelo,
            "{marca}" => $equipo->marca,
            "{detalle}" => $detalle["detalle"],
            "{extra}" => $detalle["extra"],
            "{diagnostico}" => $datos['diagnostico'] ?? ""
        ];
        if ($formato === 'whatsapp') {
            $mensaje = "🔧 ¡Hola, {empresa}! %0A%0A📌 Estado de tu orden de servicio: *{cod}* %0A%0A🛠 *Detalles del equipo:* %0A• Tipo: {tipo_equipo} %0A• Modelo: {modelo} %0A• Marca: {marca} %0A%0A{detalle}%0A{extra}%0A%0AGracias por confiar en nosotros. Si tienes alguna duda, estamos para ayudarte. 😊";
            foreach ($reemplazos as $key => $value) {
                $mensaje = str_replace($key, $value, $mensaje);
            }
            return str_replace("&", "%26", $mensaje);
        }
        // Para formato HTML (correo)
        if ($formato === 'html') {
            // Reemplazar {diagnostico} si aplica
            $diagnostico = $datos['diagnostico'] ?? '';
            $detalleTexto = str_replace('{diagnostico}', $diagnostico, $detalle['detalle']);
            $extra = $detalle['extra'];
            // Variables para pasar a la plantilla
            $template_vars = compact('dataEmpr', 'equipo', 'datos', 'detalleTexto', 'extra', 'base_url');
            // Renombrar claves para ser coherentes en la plantilla
            $empresa = $dataEmpr;
            $detalle = $detalleTexto;
            extract($template_vars);
            // Incluir plantilla y devolver contenido HTML
            ob_start();
            include __DIR__ . "/plantillas/correo.info.php";
            return ob_get_clean();
        }
    }

    
}
