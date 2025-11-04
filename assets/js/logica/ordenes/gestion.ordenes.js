/* global app */
const Modelo = {
    formulario: "#frm",
    listaOrdenes: [],
    listaEquipo: [],
    equipos: [],
    fechas: [],
    pasos: [],
    estado: [],
    opcion: "",
    baja: false,
    id_orden: "",
    contEncuesta: "",
    pos: -1
};

const DPZ = [];

var gestionOrdenes = {
    constructor: function () {
        var data = new FormData();
        data.append('sucursal', sucursal);
        $(Modelo.formulario).on('submit', gestionOrdenes.grabar);
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=listado_ordenes', data, false, gestionOrdenes.repuesta_listado, false, true);
    },
    repuesta_listado: function (respuesta) {
        const { datos, user, tipo, est } = respuesta;
        const contenedor = $("[contenido-final]");
        const lista_productos = $('[productos]');
        const lista_clientes = $('[cliente]');
        const lista_equipos = $('[equipos]');
        const lista_marcas = $('[marcas]');
        const lista_mensajeros = $('[mensajero]');
        const atencion = $("[atencion]");
        const estados = $('[estados]');
        const multiple = $('.multiple');
        const cuerpo = $('[cuerpo]');
        const modal = $('#modal');
        const EstadoCotizar = $('[name="estado_cotizacion"]');
        const cotizar = $("[cotizar]");
        const abonos = $("[abonos]");
        const repuestos = $("[repuestos]");
        // Inicializar Dropzone
        for (let i = 2; i <= 4; i++) {
            DPZ.push(new Dropzone(`.imagen${i}`, dropmultiple));
        }
        // Asignar datos globales
        info.user = user;
        Modelo.contEncuesta = contenedor.html();
        Modelo.listaOrdenes = datos;
        app.estados(estados, 0);
        app.abririmagen();
        app.abrir_modal();
        // Configuración de columnas para DataTables
        const columnas = [
            { data: 'cod_orden' },
            { data: 'data_empr'},
            { data: 'tipo_atencion',
                "render": function (data, type, row) {
                    var texto = (row.tipo_atencion == "garantía") ? row.tipo_atencion + ': ' + row.atencion_texto : row.tipo_atencion;
                    return texto;
                }
            },
            {
                "data": 'estado',
                "render": (data, type, row) => {
                    const colores = {
                        "Nueva recepción": "btn-primary",
                        "Diagnóstico": "btn-warning",
                        "Cotización": "btn-info",
                        "Reparación": "btn-success",
                        "Entrega": "btn-secondary",
                        "Finalizado": "btn-dark"
                    };
                    return `<b class="w-100 text-start text-truncate badge badge-dot me-4 text-dark my-auto"><i class="${colores[row.estado] || 'bg-light'}"></i>${row.estado}</b>`;
                }
            },
            { data: 'tipo_equipo' },
            { data: 'modelo2' },
            { data: 'marca' },
            {
                data: 'empleado',
                render: function (data, type, row) {
                    const fecha = moment(row.fecha).format('MMM D [del] YYYY, hh:mm A');
                    const icono = row.id_mensajero 
                        ? `<small class="text-secondary c-help" data-title="${row.nombre_mensajero}">Mensajero <i class="fa fa-check"></i></small>` 
                        : '';
                    return `<b class="text-primary c-help d-block" data-title="${fecha}">${row.empleado}</b>${icono}`;
                }
            },
            { data: 'fecha_final',
                "render": function (data, type, full, meta) {
                    return "<button class='btn btn-inverse-secondary btn-rounded btn-icon editar' role='button'  data-id='" + full.cod_orden + "' pos='" + meta.row + "'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
                }
            }
        ];
        app.datatables(cuerpo, datos, columnas, tipo === "Tecnico");
        app.cerrar(Modelo.formulario);
        // Configuración de select2 para clientes y marcas
        app.buscador(lista_clientes, app.selectConfig('buscar_clientes'), 1);
        app.buscador(lista_marcas, app.selectConfig('buscar_marcas'), 1);
        app.buscador(lista_mensajeros, app.selectConfig('buscar_mensajeros'), 1);
        app.buscador(lista_equipos, null, 0);
        app.buscador(atencion, null, 0);
        // Evento para agregar orden
        $('[agregar]').off('click').on('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            // Actualizar directamente info
            info.hcerrar = true;
            info.historial = '';
            Modelo.id_orden = '';
            Modelo.baja = false;
            Modelo.opcion = 'agregar_orden';
            Modelo.pasos = [];
            // Limpiar formulario
            $(Modelo.formulario).trigger("reset");
            lista_clientes.empty();
            lista_equipos.empty();
            $('.detalle, [fecha-creacion],[fecha-final]').html("");
            // Limpiar listas y tablas
            app.ocultar_mostrar("si");
            app.cargarimagenes(DPZ, [], "ordenes");
            app.cambio(lista_clientes, 0, "equipos", 0, true);
            gestionOrdenes.tipo_atencion("", multiple);
            app.estados(estados, 0);
            gestionOrdenes.estados(estados, "aviable");
            app.tablas_estados(cotizar, "", "cotizar", true);
            app.tablas_estados(abonos, "", "abonos", true);
            app.mostrar_equipo(lista_equipos, "", "equipos");
            app.mensajero(false);
            // Limpiar historial
            app.historial([]);
            gestionOrdenes.Gestion();
            $("[data-old]").data("old", "");
            $("[cmp-reparado]").text("");
        });

        // Evento para editar orden
        cuerpo.off('click', '.editar').on('click', '.editar', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            //cerrar modal
            Swal.fire(swalload);
            //variables
            const pos = $(this).attr('pos');
            const lista = Modelo.listaOrdenes[pos];
            Modelo.pos = pos;
            Modelo.id_orden = lista.id_orden;
            Modelo.opcion = "editar_orden";
            Modelo.baja = lista.estado === "De baja";
            info.hcerrar = false;
            lista_clientes.empty();
            lista_equipos.empty();
            $(Modelo.formulario).trigger("reset");
            //carga imagenes
            const arrimg = [lista.imagen1, lista.imagen2, lista.imagen3].map(img => img || []);
            app.cargarimagenes(DPZ, arrimg, "ordenes");
            lista_clientes.append(new Option(lista.data_empr, lista.id_cliente));
            app.ocultar_mostrar("no");
            Modelo.pasos = lista.tiempos ? JSON.parse(lista.tiempos) : [];
            app.cambio(lista_clientes, lista.id_cliente, "equipos", lista.id_equipo, true);
            gestionOrdenes.tipo_atencion(lista.tipo_atencion, lista.atencion_texto, lista.id_equipo, multiple);
            app.estados(estados, lista.posicion);
            app.tablas_estados(cotizar, lista.tabla_cotizacion, "cotizar", true);
            app.tablas_estados(abonos, lista.abonos, "abonos", true);
            $.each(lista, (idx, valor) => {
                $('[name="' + idx + '"]').val(valor).attr("data-old", valor).trigger("change.select2");
            });
            //tabla de cotizacion
            if (lista.estado_cotizacion > 0) {
                $(EstadoCotizar[parseInt(lista.estado_cotizacion) - 1]).prop("checked", true);
            } else {
                EstadoCotizar.prop("checked", false);
            }
            //mensajero 
            app.mensajero(lista);
            // Historial
            $(Modelo.formulario).find("select").each(function () {
                var selected = $(this).find(":selected");
                if (selected.val()) $(this).attr("data-old", selected.text());
            });
            //asignaciones
            gestionOrdenes.estados(estados, est, tipo);
            gestionOrdenes.encuesta(lista);
            //historiales
            info.historial = lista.historial ?? '';
            app.historial(lista.historial_final);
            $(".id_pos").text(lista.cod_orden);
            //eventos
            gestionOrdenes.Gestion();
            //mensajes
            const fecha = `CREADO: ${moment(lista.fecha).format(fecha_texto)}`;
            const fechaFin = lista.posicion > 4 ? `FINALIZADO: ${moment(lista.fecha_final).format(fecha_texto)}` : "";
            $('[fecha-creacion]').html(fecha);
            $('[fecha-final]').html(fechaFin);
        });

        // Eventos para generación de PDF
        $('[pdf]').off('click').on('click', function (e) {
            e.preventDefault();
            gestionOrdenes.generarPDF($(this).attr("tipo"), $(this).attr("size"));
        });
        
        //Enviar mensaje a whatsapp o correo
        $('[enviar_mensaje]').off('click').on('click', function (e) {
            e.preventDefault();
            const desde = $(this).attr("desde");
            const form_data = gestionOrdenes.recolectar_datos();
            form_data.append('tipo', $(this).attr("tipo"));
            form_data.append('size', $(this).attr("size"));
            app.ajax('./controlador/GestionUsuarioControlador.php?opcion=generar_' + desde , form_data, true, app.respuestaCorreoWhatsapp);
        });
    },
    Gestion: function (e) {
        var comenzar = $("[comenzar]");
        var cont = $(".detalles_cont");
        if (!info.hcerrar) {
            comenzar.hide();
            cont.removeAttr("hidden");
        } else {
            $(".id_pos").text("-");
            comenzar.show();
            cont.attr("hidden", "hidden")
        }
    },
    generarPDF: function (tipo, size) {
        var form_data = gestionOrdenes.recolectar_datos();
        form_data.append('tipo', tipo);
        form_data.append('size', size);
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=imprimir_ordenes', form_data, true, app.respuesta_pdf, false, true);
    },
    tipo_atencion: function (tipo, val, id, multiple) {
        const caja = $("[caja_nueva]");
        const atencion = $("[atencion]");
        //const lista = Modelo.listaOrdenes;
        caja.empty();
        if (tipo === "garantía") {
            caja.html(`
                <input type="text" class="form-control atencion_texto" 
                       name="atencion_texto" titulo="Garantía" value="${val}">`);
        }
        if (tipo === "reingreso") {
            id = id || $("#id_equipo :selected").val();
            info.reingreso = val;
            //mostrar caja;
            caja.html(`
                <div class="input-group">
                    <select class="multiple form-control text-dark hidden show-tick"
                            name="atencion_texto" titulo="Reingreso" data-live-search="true"
                            data-size="3" orden_final="true" reingreso data-style="form-control-lg">
                    </select>
                    <button class="btn btn-primary" type="button" 
                            detalle-reingreso>Ver detalle de la ORDEN</button>
                </div>`);
            const orden_final = $("[orden_final]");
            app.cambio(orden_final, id, "reingreso", Modelo.id_orden, false);
        }
        //cambiar de tipo atención
        atencion.change(function (e) {
            e.stopImmediatePropagation();
            gestionOrdenes.tipo_atencion(this.value, "", "", multiple);
        });
    },
    estados: function (caja, est, tipo) {
        let stepInfo = caja.smartWizard("getStepInfo");
        let reparado = $("[reparado]");
        let current = parseInt(stepInfo.currentStep);
        let step = current + 1;
        let paso = $(`#step-${step}`);
        let CurrentDate = moment().format(formato);
        let lista = Modelo.listaOrdenes[Modelo.pos]?.fecha ?? CurrentDate;
        let fechaCrea = moment(lista).format(formato);
        let fecha = moment().format(fecha_ahora);
        let hora = moment().format(hora_ahora);
        let user = info.user;
        let actual_texto = caja.find(".paso_" + current).data("texto");
        let texto = Modelo.baja ? "De baja" : actual_texto;
        reparado.toggleClass("leer", step > 2);
        paso.find(".caja").off("keydown").removeAttr(est).removeClass("leer");
        paso.find(".dropzone").removeClass("leer");
        // Mostrar secciones y limpiar tiempos
        $("[pasos]").find("[caja_estados]").show();
        $("[pasos]").find("[time]").text("");
        gestionOrdenes.tecnico(tipo);
        Modelo.estado = [current, texto];
        // Calcular y mostrar el tiempo en cada paso
        for (let i = 1; i < step; i++) {
            var stp = $("#step-" + i);
            var last = (i - 1);
            var lst = (last in Modelo.pasos && Modelo.pasos[last] != null) ? Modelo.pasos[last] : fechaCrea;
            var fecha_new = moment(Modelo.pasos[i]);
            var fecha_last = moment(lst);
            //Mostrar tiempo
            var SS = fecha_new.diff(fecha_last, 'seconds');
            var MM = fecha_new.diff(fecha_last, 'minutes');
            var HH = fecha_new.diff(fecha_last, 'hours');
            var DD = fecha_new.diff(fecha_last, 'days');
            var MMM = fecha_new.diff(fecha_last, 'months');
            SS = (SS < 0) ? "0 Seg" : (SS > 59) ? "" : SS + " Seg";
            MM = (MM <= 0) ? "" : (MM > 59) ? "" : MM + " Min";
            HH = (HH <= 0) ? "" : (HH > 24) ? "" : HH + " Hrs";
            DD = (DD <= 0) ? "" : (DD > 30) ? "" : DD > 1 ? DD + " Dias" : DD + " Dia";
            MMM = (MMM <= 0) ? "" : MMM + " Mes(es)";
            var forma = (MMM + DD + HH + MM + SS);
            //Poner en cada estado el tiempo
            stp.find("[caja_estados]").hide();
            stp.find("[time]").text("Tiempo en el paso: " + forma);
            //deshabilitar caja
            if (est === "readonly") {
                stp.find(".dropzone").addClass("leer");
                stp.find(".caja").attr(est, est).addClass("leer");
                gestionOrdenes.tecnico(tipo);
            }
        }
        // Definir acciones para los radio buttons
        const acciones = [
            { selector: "[baja]", action: () => Modelo.baja = true },
            { selector: "[no-justifica]", action: deBaja },
            { selector: "[no-autoriza], [pendiente]", action: pasar },
            { selector: "[aprobar]", action: aprobarRepuestos },
            { selector: "[acepto]", action: toggleNext },
            { selector: "[reparado]", action: toggleReparado },
            { selector: "[next]", action: validarSiguientePaso }
        ];
        // Ejecutar acciones si los elementos ya están marcados al cargar la vista
        acciones.forEach(({ selector, action }) => {
            let elem = paso.find(selector);
            elem.on("click", action);
            if (elem.is(":checked")) action.call(elem);
        });
        //dar de baja
        function deBaja() {
            paso.find("[acepto]").prop("checked", false);
            paso.find("[next]").prop("disabled", true).attr("hidden", true);
            paso.find("[baja-justifica]").removeAttr("hidden");
        }
        //pasar
        function pasar() {
            paso.find("[acepto]").prop("checked", false);
            paso.find("[next]").prop("disabled", true).removeAttr("hidden");
            paso.find("[baja-justifica]").attr("hidden", true);
        }
        //siguiente
        function toggleNext() {
            paso.find("[next]").prop("disabled", !$(this).is(":checked"));
        }
        //aprobar
        function aprobarRepuestos() {
            pasar();
            let estado = 0;
            $("[listo]").each((_, elem) => {
                if (!$(elem).is(":checked")) estado = 1;
            });
            if (estado) {
                $(this).prop("checked", false).addClass("border-danger");
                app.mensaje({ codigo: -1, mensaje: 'ERROR: Todos los repuestos deben estar listos antes de aceptar.' });
            } else {
                let tipo = $(this).data("ocultar");
                if (tipo) $(`[${tipo}]`).prop("hidden", !this.checked);
            }
        }
        //siguiente
        function validarSiguientePaso() {
            let estado = 0;
            if (!Modelo.baja) {
                let Ecotizar = paso.find("[name=estado_cotizacion]");
                if (Ecotizar.length && !Ecotizar.is(":checked")) {
                    estado++;
                    Ecotizar.addClass("border-danger");
                } else {
                    Ecotizar.removeClass("border-danger");
                }
                paso.find("[requerido]").each((_, elem) => {
                    let invalido = false;
                    if ($(elem).hasClass("form-control") && !elem.value) invalido = true;
                    if ($(elem).hasClass("checkbox") && !$(elem).is(":checked")) invalido = true;
                    if ($(elem).hasClass("dropzone")) {
                        let id = `#${$(elem).attr("id")}`;
                        if ($(id)[0].dropzone.files.length <= 0) invalido = true;
                    }
                    $(elem).toggleClass("border-danger", invalido);
                    if (invalido) estado++;
                });
            }
            if (estado === 0) {
                let baja = Modelo.baja ? 5 : step;
                Modelo.pasos[step] = moment().format(formato);
                caja.smartWizard("goToStep", baja, true);
                gestionOrdenes.estados(caja, est);
                let arrg = `${fecha}•Estado•${hora}•${user}|0|${Modelo.estado[1]}|¦`;
                info.historial += arrg;
                gestionOrdenes.tecnico(tipo);
                gestionOrdenes.reparado(lista);
            } else {
                app.mensaje({ codigo: -1, mensaje: 'ERROR: Debe llenar todos los campos requeridos.' });
            }
        }
        //reparado
        function toggleReparado() {
            $(this).data("value", $(this).is(":checked") ? moment().format(fecha_texto) : "");
        }
    },
    grabar: function (e) {
        e.preventDefault();
        var form_data = gestionOrdenes.recolectar_datos();
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=grabar_ordenes', form_data, true, gestionOrdenes.respuesta_orden);
    },
    recolectar_datos: function (e) {
        let formulario = $(Modelo.formulario);
        let pos = Modelo.pos;
        let datos = Modelo.listaOrdenes[pos];
        let caja = $("[estados]");
        let reparado = formulario.find("[reparado]").data("value");
        let campos = formulario.find("[cotizar] > [campos] > tr");
        let abonos = formulario.find("[abonos] > [campos] > tr");
        let id_cliente = formulario.find("#id_cliente option:selected").data("pos");
        let id_equipo = formulario.find("#id_equipo option:selected").data("pos");
        let estado_cotizacion = formulario.find("[name='estado_cotizacion']:checked").data("value") || 0;
        let cadenasImg = ["", "", ""];
        let cadena = "", abono_cadena = "";
        let arreglo = [];
        let abonos_arreglo = [];
        let id = "", cod = 0, estado = Modelo.estado[1], fech = 0;
        let imagenes = [
            $(".imagen2")[0].dropzone.files, // Recepción
            $(".imagen4")[0].dropzone.files, // Diagnóstico
            $(".imagen3")[0].dropzone.files  // Entrega
        ];
        // Recoger datos generales
        campos.each((tr_idx, tr) => {
            let sub = [];
            $(tr).find("td [si='true']").each((td_idx, td) => {
                let dat = $(td).is(":checked") ? "ok" : $(td).val() ?? "";
                if ($(td).hasClass("prod")) {
                    let valor = $(td).val() ?? "";
                    let codigo = $(td).find(":selected").text();
                    cadena += `${valor}Ω`;
                    sub[td_idx] = valor;
                    sub[8] = codigo;
                } else {
                    if ($(td).hasClass("cantidad")) {
                        dat = dat || 0;
                    }
                    cadena += `${dat}Ω`;
                    sub[td_idx] = dat;
                }
            });
            cadena += tr_idx < campos.length - 1 ? "|" : "";
            arreglo[tr_idx] = sub;
        });
        // Recolección de abonos
        abonos.each((tr_idx, tr) => {
            let sub = [];
            let filaVacia = true;
            $(tr).find("td [si='true']").each((td_idx, td) => {
                let valor = $(td).val();
                if (valor) filaVacia = false; // Si hay al menos un dato, la fila no está vacía
                sub[td_idx] = valor;
            });
            if (!filaVacia) { // Solo agregamos si la fila tiene datos
                abono_cadena += sub.join("Ω") + (tr_idx < abonos.length - 1 ? "|" : "");
                abonos_arreglo.push(sub);
            }
        });
        // Si existe orden
        if (Modelo.opcion === "editar_orden") {
            id = datos.id_orden;
            fech = datos.fecha;
            cod = datos.cod_orden;
        }
        // Agrupar datos de envío
        let form_data = new FormData(formulario[0]);
        // Procesar imágenes
        imagenes.forEach((tipoImagenes, tipID) => {
            tipoImagenes.forEach((imagen, imgID) => {
                if (imagen instanceof Blob) {
                    form_data.append("imagenes[]", imagen, imagen.nombre);
                    form_data.append("tipo_img[]", tipID);
                } else {
                    cadenasImg[tipID] += imagen.nombre + (imgID < tipoImagenes.length - 1 ? "|" : "");
                }
            });
        });
        // Agregar datos al formulario
        form_data.append("cadena", cadena);
        form_data.append("sucursal", sucursal);
        form_data.append("arreglo", JSON.stringify(arreglo));
        form_data.append("id_orden", id);
        form_data.append("id_mensajero", info.msgro ?? '');
        form_data.append("cod", cod);
        form_data.append("gestion", Modelo.opcion);
        form_data.append("imagenes_guardadas", JSON.stringify(cadenasImg));
        form_data.append("posicion", Modelo.estado[0]);
        form_data.append("estado", estado);
        form_data.append("fecha", fech);
        form_data.append("tiempos", JSON.stringify(Modelo.pasos));
        form_data.append("equipo", JSON.stringify(info.equipos[id_equipo]));
        form_data.append("historial", info.historial);
        form_data.append("estado_cotizacion", estado_cotizacion);
        form_data.append("abono", JSON.stringify(abonos_arreglo));
        form_data.append("abono_cadena", abono_cadena);
        form_data.append("reparado", reparado);
        form_data.append("cerrar", info.cerrar);
        return form_data;
    },
    respuesta_orden: function (respuesta) {
        if (respuesta.codigo !== 1) {
            return app.mensaje({ codigo: -1, mensaje: respuesta.mensaje });
        }
        let datos = respuesta.datos;
        let arrimg = [
            datos.imagen1 || [],
            datos.imagen2 || [],
            datos.imagen3 || []
        ];
        // Asignación de información
        let cuerpo = $('[cuerpo]').DataTable();
        let equipo = info.equipos.find(x => x.id_equipo === datos.id_equipo);
        console.log(equipo);
        let equipoDesc = `${equipo.codigo_interno} - ${equipo.tipo_equipo}, ${equipo.serie}`;
        let fecha = `CREADO: ${moment(datos.fecha).format(fecha_texto)}`;
        let fechaFin = (datos.posicion > 4) ? `FINALIZADO: ${moment(datos.fecha_final).format(fecha_texto)}` : "";
        // Configuración de estado
        Object.assign(info, { cerrar: false, hcerrar: false });
        gestionOrdenes.Gestion();
        $('[name="id_equipo"]').data("old", equipoDesc);
        $('[fecha-final]').html(fechaFin);
        // Cargar imágenes
        app.cargarimagenes(DPZ, arrimg, "ordenes");
        // Actualizar encuesta
        gestionOrdenes.encuesta(datos);
        // Actualizar historial
        $.each(datos, (idxDatos, valDatos) => {
            $(`[name="${idxDatos}"]`).data("old", valDatos);
        });
        //mensajero 
        app.mensajero(datos);
        // Cambiar datos si se está agregando una orden nueva
        if (respuesta.gst === "agregar_orden") {
            let idx = Modelo.listaOrdenes.push(datos);
            Modelo.opcion = "editar_orden";
            Modelo.pos = idx - 1;
            app.cerrar_before();
            $(".id_pos").text(datos.cod_orden);
            $('[fecha-creacion]').html(datos);
            cuerpo.row.add(datos).draw();
            info.historial = '';
            app.historial(datos.historial_final);
        } else {
            Modelo.listaOrdenes[Modelo.pos] = datos;
            cuerpo.row(Modelo.pos).data(datos);
            info.historial = datos.historial;
            app.historial(datos.historial_final);
        }
        app.cerrar(Modelo.formulario);
        // Mostrar mensaje de éxito
        app.mensaje({ codigo: 1, mensaje: respuesta.mensaje, norecarga: 'true' });
    },

    tecnico: function (tipo) {
        if (tipo == "Tecnico") {
            $(".caja_nit_empresa, .caja_telefono_encargado").parent().parent().remove();
            $(".form-control, .caja, .dropzone").addClass("leer");
            $("#diagnostico, .imagen4").removeClass("leer");
        }
    },
    
    reparado: function () {
        var reparado = $("[reparado]");
        if (reparado.is(':checked')) {
            var diagTexto = $("#diagnostico").val();
            $('[name="notas"]').val(diagTexto);
        }
    },
    
    encuesta: function (respuesta) {
        var url = respuesta.encuesta_url;
        var datos = respuesta.encuesta;
        var estado = respuesta.estado;
        var contenedor = $("[contenido-final]");
        // No imprimir nada si el estado es "baja"
        if (estado === "De baja") {
            contenedor.html(estado);
            return;
        }
        var recargar = `
            <div class='text-center'>
                <div class='btn btn-primary m-2 p-2' role='button' recargar>Refrescar</div>
            </div>`;

        if (estado === "Finalizado") {
            if (datos) {
                Modelo.listaOrdenes[Modelo.pos].encuesta = datos;
                const estrellas = (num) => "<i class='fa fa-star text-warning'></i>".repeat(num);
                const contenido = `
                    <div class="mb-2"><b>Solucionamos la inquietud o problema:</b> ${datos[0]}.</div>
                    <div class="mb-2"><b>Atención:</b> ${estrellas(datos[1])} <span class="text-muted">(${datos[1]}/5)</span></div>
                    <div class="mb-2"><b>Satisfacción:</b> ${estrellas(datos[2])} <span class="text-muted">(${datos[2]}/5)</span></div>
                    <div class="mb-2"><b>Recomienda a un amigo o familiar:</b> ${datos[3]}.</div>
                    <div class="mb-0"><b>Comentario:</b> ${datos[4]}.</div>
                `;
                contenedor.html(contenido);
            } else {
                contenedor.html(Modelo.contEncuesta);
                contenedor.append(recargar);
                $("[inp-encuesta]").val(url);
            }
        } else {
            contenedor.html("<h3 class='text-center'>Advertencia, debe guardar la orden de servicio para poder compartir la encuesta.</h3>");
        }
        // Buscar si se llenó la encuesta
        $("[recargar]").click(function (e) {
            e.stopImmediatePropagation();
            $(this).text("Cargando...");
            var form_data = gestionOrdenes.recolectar_datos();
            form_data.append("url", url);
            setTimeout(function () {
                app.ajax("./controlador/GestionUsuarioControlador.php?opcion=recargarEncuesta", form_data, false, gestionOrdenes.encuesta);
            }, 1000);
        });
        // Encuesta vía WhatsApp
        $("[encuesta-whatsapp]").click(function (e) {
            e.stopImmediatePropagation();
            var tipo = $(this).attr("tipo");
            var form_data = gestionOrdenes.recolectar_datos();
            form_data.append("url", url);
            form_data.append("tipo", tipo);
            app.ajax("./controlador/GestionUsuarioControlador.php?opcion=generar_whatsapp", form_data, true, app.respuestaCorreoWhatsapp);
        });
    },

};
gestionOrdenes.constructor();