/* global app */
var ModeloGraficas = {
    datos: [],
    tipos: [],
    ecotizar: [],
    start: "",
    end: "",
    modelo: [false, ""],
    pos: -1
};


var pdf = {
    tablas: {},
    solodato: {},
    soloPorcentajes: {},
    torta: {},
    modelo: {},
    lineal: [],
    fecha: "",
};
var gestionMenu = {
    constructor: function () {
        const reporte = $("[reporte]");
        // Definir listas de estados y tipos
        ModeloGraficas.ecotizar = Object.freeze([
            "Sin elegir",
            "Pendiente por aprobación",
            "No autoriza",
            "No se justifica",
            "Aprobado"
        ]);
        ModeloGraficas.tipos = Object.freeze({
            "[tcotizar]": "tcotizar",
            "[atencion]": "atencion",
            "[ordenes]": "ordenes",
            "[testado]": "testado",
            "[lista]": "lista"
        });
        // Cargar menú y asignar evento
        gestionMenu.listado();
        reporte.click(gestionMenu.reporte);
    },
    listado: function (e) {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionGraficasControlador.php?opcion=listado', data, false, gestionMenu.repuesta_listado);
    },
    repuesta_listado: function (respuesta) {
        var rango = $('#reportrange');
        var modelo = $('[modelo]');
        var cajasFiltros = $(".caja-filtros");
        var modelosSelec = {};
        var datos = respuesta.datos;
        var listCajas = [
            { selector: $('[modeloc]'), valores: ["modelo comercial", "modelo"] },
            { selector: $('[modelot]'), valores: ["modelo técnico", "modelo2"] },
            { selector: $('[marca]'), valores: ["Marca", "marca"] }
        ];
        gestionMenu.fechas();
        gestionMenu.fechasComparar(null, datos);
        gestionMenu.lista(datos);
        gestionMenu.ordenes(datos);
        gestionMenu.atencion(datos);
        gestionMenu.tcotizar(datos);
        gestionMenu.testado(datos);
        //actualizar fechas
        rango.on('apply.daterangepicker', function (e, picker) {
            e.stopImmediatePropagation();
            ModeloGraficas.start = picker.startDate.format('YYYY-MM-DD');
            ModeloGraficas.end = picker.endDate.format('YYYY-MM-DD');
            //Quitar grafica 
            ModeloGraficas.modelo = [false, ""];
            gestionMenu.actualizacion(null, datos);
            //Actualizar filtro el 1 es el tipo y el dos la busqueda de datos
            listCajas.forEach(function (item) {
                gestionMenu.Filtros(item.selector, item.valores[0], item.valores[1]);
            });
        });
        //recorrido a las listas de cajas
        listCajas.forEach(function (item) {
            gestionMenu.Filtros(item.selector, item.valores[0], item.valores[1]);
            item.selector.change(function (e) {
                e.preventDefault();
                // Recorrer todas las cajas de listCajas
                listCajas.forEach(function (item) {
                    var opSelec = item.selector.find(":selected"); 
                    var tieneAttr = opSelec.attr("data-attr") === "todos";
                    var Mestado = !tieneAttr;
                    var valores = item.selector.val();
                    // Si "Todos" está seleccionado, vaciamos la selección; de lo contrario, guardamos los valores
                    modelosSelec[item.valores[1]] = Mestado ? (valores || "") : "";
                });
                ModeloGraficas.modelo = [true, modelosSelec];
                gestionMenu.actualizacion(item.valores[1], datos);
                gestionMenu.actualizarFiltros($(this), cajasFiltros, listCajas);
            });
        });
    },
    actualizarFiltros: function (cajaActiva, cajasFiltros, listCajas) { 
        var indexActiva = cajasFiltros.index(cajaActiva);
        if (indexActiva >= 0) {
             listCajas.forEach(function (item, index) {
                 if (indexActiva != index || cajaActiva.val() == "-- Todos --") {
                     gestionMenu.Filtros(item.selector, item.valores[0], item.valores[1]);
                 }
            });
        } 
    },
    actualizacion: function (tipo, datos) { 
        $.each(ModeloGraficas.tipos, function (i, dato) {
            //destruye todos los canvas para volver a graficar
            $(i).html('<canvas class="my-4 my-md-auto chartjs-render-monitor" id="' + i + '"></canvas>');
            gestionMenu.fechasComparar(tipo, datos);
            gestionMenu[dato](datos);
        });
    },
    lista: function (datos) {
        const eFin = [
            "Nueva recepción",
            "Diagnóstico",
            "Cotización",
            "Reparación",
            "Entrega",
            "eliminado",
            "De baja"
        ];
        const valores = {
            totales: gestionMenu.SoloDato("id_sucursal", []),
            finalizadas: gestionMenu.SoloDato("estado", eFin),
            diagnostico: gestionMenu.soloPorcentajes("Diagnóstico"),
            cotizacion: gestionMenu.soloPorcentajes("Cotización"),
            reparacion: gestionMenu.soloPorcentajes("Reparación"),
            entrega: gestionMenu.soloPorcentajes("Entrega")
        };
        const mapeoHtml = {
            tTotales: valores.totales,
            tFinal: valores.finalizadas,
            tDiagnostico: valores.diagnostico,
            tCotizacion: valores.cotizacion,
            tReparacion: valores.reparacion,
            tEntrega: valores.entrega
        };
        Object.entries(mapeoHtml).forEach(([key, value]) => {
            $(`[${key}]`).html(value);
        });
        gestionMenu.ttestados(datos);
        gestionMenu.ttencuestas(datos);
    },
    Filtros: function (caja, texto, opcion) {
        var data = {};
        var valorSelec = caja.val();
        caja.empty();
        //Sumar y preparar
        $.each(ModeloGraficas.datos, function (_, dato) {
            var key = dato[opcion] !== null ? dato[opcion] : "Sin " + texto;
            data[key] = (data[key] || 0) + 1;
        });
        //dejar un valor vacio
        caja.append($('<option>', {
            "data-attr": "todos",
            "text": "-- Todos --",
        }));
        //Asignar a la caja los modelos disponibles
        $.each(data, function (key, cantidad) {
            var val = (key != "Sin " + texto) ? key : null;
            var fila = '<option value="' + val + '" data-subtext="' + cantidad + '">' + key + '</option>';
            caja.append(fila);
        });
        // Restaurar la selección anterior si sigue existiendo
        caja.val(caja.find(`option[value="${valorSelec}"]`).length ? valorSelec : "-- Todos --");
        //agregar buscador
        if (!caja.hasClass("select2-hidden-accessible")) {
            app.buscador(caja, null, 0);
        }
    },
    atencion: function (datos) {
        var ctx = document.getElementById('[atencion]').getContext('2d');
        var data = {
            labels: [],
            datasets: []
        };
        var arg = {}
        var evitar = [];
        //Asignar datos previo a agrupar
        if (ModeloGraficas.datos.length > 0) {
            arg = gestionMenu.GraficaTorta("tipo_atencion", evitar);
            //Ajustar asignar datos
            data = {
                labels: arg.titulos,
                datasets: [{
                    data: arg.resultados,
                    backgroundColor: arg.colores,
                }]
            }
        }
        //Graficar
        gestionMenu.graficar(ctx, data, "pie", datos);
    },
    tcotizar: function (datos) {
        var ctx = document.getElementById('[tcotizar]').getContext('2d');
        var data = {
            labels: [],
            datasets: []
        };
        var arg = {};
        var ajuste = {
            titulos: [],
            colores: []
        };
        var evitar = ["0"];
        //Asignar datos previo a agrupar
        if (ModeloGraficas.datos.length > 0) {
            arg = gestionMenu.GraficaTorta("estado_cotizacion", evitar);
            //Ajustar titulos y colores
            $.each(arg.titulos, function (i, dato) {
                var titulo = ModeloGraficas.ecotizar[dato];
                var color = gestionMenu.RGB(gestionMenu.hash(titulo))
                ajuste.titulos.push(titulo);
                ajuste.colores.push(color);
            });
            //ajustar para graficar
            data = {
                labels: ajuste.titulos,
                datasets: [{
                    data: arg.resultados,
                    backgroundColor: ajuste.colores,
                }]
            }
        }
        //Graficar
        pdf.torta["cotizacion"] = ajuste;
        gestionMenu.graficar(ctx, data, "pie", datos);
    },
    testado: function (datos) {
        var ctx = document.getElementById('[testado]').getContext('2d');
        var data = {
            labels: [],
            datasets: []
        };
        var arg = {}
        var evitar = ["Nueva recepción", "eliminado"];
        //Asignar datos previo a agrupar
        if (ModeloGraficas.datos.length > 0) {
            arg = gestionMenu.GraficaTorta("estado", evitar);
            //Ajustar asignar datos
            data = {
                labels: arg.titulos,
                datasets: [{
                    data: arg.resultados,
                    backgroundColor: arg.colores,
                }]
            }
        }
        //Graficar
        gestionMenu.graficar(ctx, data, "pie", datos);
    },
    ordenes: function (datos) {
        var ctx = document.getElementById('[ordenes]').getContext('2d');
        var data = {
            labels: [],
            datasets: []
        };
        var arg = {}
        //Asignar datos previo a agrupar
        if (ModeloGraficas.datos.length > 0) {
            data = gestionMenu.GraficaLineal("tipo_atencion");
        }
        //Graficar
        gestionMenu.graficar(ctx, data, "line", datos);
    },
    ttestados: function (datos) {
        var urlParams = new URLSearchParams(window.location.search);
        //Cuerpo 
        var cuerpo = $("[ttentrega]");
        //Ignorar
        let ttentregadata = [
            "Nueva recepción", "Diagnóstico", "Reparación", 
            "Finalizado", "eliminado", "De baja"
        ];
        //Asignación de datos
        let columnas = [
            { data: 'cod_orden' },
            { data: 'data_empr' },
            { data: 'estado',
                "render": function (data, type, row) {
                    var clase = (row.estado == "Activo") ? "badge-success" : "bg-danger";
                    return '<label class="badge ' + clase + '" >' + row.estado + '</label>';
                }
            },
            { data: 'tipo_equipo' },
            { data: 'modelo2' },
            { data: 'nit_empresa',
                "render": function (data, type, row) {
                    let suc = urlParams.get('suc') || 0;
                    return `<a class='btn btn-outline-primary p-2 w-100' href='./ordenes?suc=${suc}&orden=${row.cod_orden}' target='_blank'>ver</a>`;
                }
            }
        ];
        //Tabla
        datos = gestionMenu.SoloTablas("estado", ttentregadata);
        app.datatables(cuerpo, datos, columnas);
    },
    ttencuestas: function (datos) {
        var urlParams = new URLSearchParams(window.location.search);
        //Cuerpo 
        var cuerpo = $("[ttencuesta]");
        //Ignorar
        //Asignación de datos
        var columnas = [
            { data: 'cod_orden' },
            { data: 'data_empr' },
            { data: 'tipo_equipo' },
            { data: 'modelo2' },
            { data: 'estado',
                "render": function (data, type, row) {
                    
                    var estrellas = "";
                    for (var i = 0; i < row.encuesta[2]; i++) {
                        estrellas += ' <i class="fa fa-star-o"></i> ';
                    }
                    return '<label>' + estrellas + ' (' + row.encuesta[2] + ')' + '</label>';
                }
            },
            { data: 'nit_empresa',
                "render": function (data, type, row) {
                    var suc = urlParams.get('suc') || 0;
                    return "<a class='btn btn-outline-primary p-2 w-100' href='./ordenes?suc=" + suc + "&orden=" + row.cod_orden + "' target='_blank'>ver</a>";
                }
            }
        ];
        //Tabla
        datos = gestionMenu.SoloTablas("encuesta", []);
        app.datatables(cuerpo, datos, columnas);
    },
    SoloTablas: function (tipo, evitar) {
        var data = [];
        //Sumar y preparar
        cont = 0;
        $.each(ModeloGraficas.datos, function (i, dato) {
            if (!evitar.includes(dato[tipo]) && dato[tipo] != null && dato[tipo] != '') {
                data[cont] = dato;
                cont++;
            }
        });
        //Regresar datos
        pdf.tablas[tipo] = data;
        return data;
    },
    SoloDato: function (tipo, evitar) {
        var cont = 0
        //Sumar y preparar
        $.each(ModeloGraficas.datos, function (i, dato) {
            if (!evitar.includes(dato[tipo]) && dato[tipo] != null && dato[tipo] != '') {
                cont += 1;
            }
        });
        //Regresar datos
        pdf.solodato[tipo] = cont;
        return cont;
    },
    soloPorcentajes: function (tipo) {
        let datos = ModeloGraficas.datos || [];
        let datosValidos = datos.filter(dato => dato.estado && ["Diagnóstico", "Cotización", "Reparación", "Entrega"].includes(dato.estado));
        let conteo = datosValidos.filter(dato => dato.estado === tipo).length;
        let total = datosValidos.length ? ((conteo / datosValidos.length) * 100).toFixed(0) + "%" : "0%";
        pdf.soloPorcentajes[tipo] = total;
        return total;

    },
    GraficaTorta: function (tipo, evitar) {
        let cont = {
            resultados: {},
            colores: {}
        };
        let arg = {
            titulos: [],
            resultados: [],
            colores: []
        };
        // Sumar y preparar datos
        ModeloGraficas.datos.forEach(dato => {
            let clave = dato[tipo];
            if (clave && !evitar.includes(clave)) {
                cont.colores[clave] = cont.colores[clave] || gestionMenu.RGB(gestionMenu.hash(clave));
                cont.resultados[clave] = (cont.resultados[clave] || 0) + 1;
            }
        });
        // Agrupar datos en arrays
        Object.entries(cont.resultados).forEach(([clave, valor]) => {
            arg.titulos.push(clave);
            arg.resultados.push(valor);
            arg.colores.push(cont.colores[clave]);
        });
        // Guardar y retornar el resultado
        pdf.torta[tipo] = arg;
        return arg;
    },
    GraficaLineal: function (tipo) {
        let resultados = {
            ajuste: ModeloGraficas.datos.sort(gestionMenu.sort),
            agrupar: {},
            grafica: {},
            fechas: new Set()
        };
        let retorno = { datasets: [], labels: [] };
        // Procesar datos y organizar por fecha y tipo de atención
        resultados.ajuste.forEach(dato => {
            let fecha = moment(dato.fecha).format('D MMM YY');
            let tipoAtencion = dato[tipo];
            let color = gestionMenu.RGB(gestionMenu.hash(dato.tipo_atencion));

            resultados.fechas.add(fecha);
            resultados.agrupar[tipoAtencion] = resultados.agrupar[tipoAtencion] || {};
            resultados.agrupar[tipoAtencion][fecha] = (resultados.agrupar[tipoAtencion][fecha] || 0) + 1;

            if (!resultados.grafica[tipoAtencion]) {
                resultados.grafica[tipoAtencion] = { label: tipoAtencion, data: [], borderColor: color, fill: false };
            }
        });
        // Ordenar las fechas
        let fechasOrdenadas = Array.from(resultados.fechas).sort((a, b) => moment(a, 'MMM D') - moment(b, 'MMM D'));
        retorno.labels = fechasOrdenadas;
        // Convertir los datos a formato gráfico
        Object.entries(resultados.grafica).forEach(([tipoAtencion, dataset]) => {
            dataset.data = fechasOrdenadas.map(fecha => resultados.agrupar[tipoAtencion][fecha] || 0);
            retorno.datasets.push(dataset);
        });
        // Guardar y retornar el resultado
        pdf.lineal[tipo] = retorno;
        return retorno;
    },
    graficar: function (grafica, data, tipo) {
        let canva = $(grafica)[0].canvas;
        let alerta = $(canva).parent().parent().parent();
        // Destruir gráfico anterior si existe
        if (grafica.myChart) {
            grafica.myChart.destroy();
        }
        // Crear nueva gráfica si hay datos
        if (ModeloGraficas.datos.length > 0) {
            grafica.myChart = new Chart(grafica, {
                type: tipo,
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            });
        }
        // Mostrar alerta si no hay datos
        alerta.find(".alerta").html(data.labels.length > 0 ? "" : 
            '<h4 class="text-danger">Upsss... Al parecer no hay datos <i class="fa fa-frown-o" aria-hidden="true"></i></h4>'
        );
    },
    fechas: function (e) {
        let start = moment().subtract(29, 'days'), end = moment();
        ModeloGraficas.start = start;
        ModeloGraficas.end = end;
        gestionMenu.rango(start, end);
        //Asignar plugins
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, gestionMenu.rango);
    },
    fechasComparar: function (tipo, datos) {
        //Modelo
        var modelo = ModeloGraficas.modelo;
        //Comparar fechas
        var fech1 = moment(ModeloGraficas.start);
        var fech2 = moment(ModeloGraficas.end);
        var arreglo = [];
        $.each(datos, function (i, dato) {
            var fechdata = moment(dato.fecha).format('YYYY-MM-DD');
            var fech = moment(fechdata);
            if (fech >= fech1 && fech <= fech2) {
                if (modelo[0] == true) {
                    // Filtra solo claves que NO estén vacías
                    var clavesValidas = Object.keys(modelo[1]).filter(clave => modelo[1][clave] !== "");
                    // Si no hay claves válidas, tomar todos los datos
                    var coincide = clavesValidas.length === 0 || 
                        clavesValidas.every(function (clave) {
                            return dato[clave] == (modelo[1][clave] == 'null' ? null : modelo[1][clave]);
                        });
                    if (coincide) {
                        arreglo.push(dato);
                    }
                } else {
                    arreglo.push(dato); 
                }
            }
        });
        
        ModeloGraficas.datos = arreglo;
    },
    rango: function (start, end) {
        pdf.fecha = (start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#reportrange span').html(pdf.fecha);
        ModeloGraficas.start = start.format('YYYY-MM-DD');
        ModeloGraficas.end = end.format('YYYY-MM-DD');
        
    },
    hash: function (str) {
        let hash = 0;
        for (let char of str) {
            hash = char.charCodeAt(0) + ((hash << 10) - hash);
        }
        return hash;
    },
    RGB: function (i) {
        return "#" + (((i * 9876543) & 0x707070) | 0x909090).toString(16).slice(-6).toUpperCase();
    },
    sort: function (a, b) {
        return a.fecha.localeCompare(b.fecha);
    },
    reporte: function (e) {
        e.preventDefault();
        var lineal1 = document.getElementById("[ordenes]").toDataURL("image/png");
        var torta1 = document.getElementById("[atencion]").toDataURL("image/png");
        var torta2 = document.getElementById("[tcotizar]").toDataURL("image/png");
        var torta3 = document.getElementById("[testado]").toDataURL("image/png");
        var form_data = new FormData();
        form_data.append('fecha', pdf.fecha);
        form_data.append('lineal1', lineal1);
        form_data.append('torta1', torta1);
        form_data.append('torta2', torta2);
        form_data.append('torta3', torta3);
        //form_data.append('tablas_', JSON.stringify(pdf.tablas));
        form_data.append('totales', JSON.stringify(pdf.solodato));
        //form_data.append('soloPorcentajes', JSON.stringify(pdf.soloPorcentajes));
        form_data.append('datatorta', JSON.stringify(pdf.torta));
        form_data.append('general', JSON.stringify(ModeloGraficas.datos));
        app.ajax('controlador/GestionGraficasControlador.php?opcion=reporte', form_data, true, app.respuesta_excel);
    },

};
gestionMenu.constructor();