// Formatos de fecha y hora
const formato = "YYYY-MM-DDTHH:mm:ss",
    hora_ahora = "hh:mm:ss A",
    fecha_ahora = "YYYY-MM-DD",
    fecha_texto = "MMMM D [del] YYYY, hh:mm A";

// Configuración de SweetAlert para carga
const swalload = {
    title: "Cargando...",
    icon: 'warning',
    showConfirmButton: false,
    allowOutsideClick: false
};

// Configuración de pasos en formularios/procesos
const pasos = {
    enableUrlHash: false,
    theme: 'dots',
    toolbar: {
        showNextButton: false,
        showPreviousButton: false
    },
    keyboard: {
        keyNavigation: false
    }
};

// Configuración base para Dropzone
const dropBaseConfig = {
    url: "assets/images",
    acceptedFiles: ".png, .jpeg, .jpg",
    addRemoveLinks: true,
    thumbnailWidth: 500,
    thumbnailHeight: 500,
    thumbnailMethod: "contain",
    timeout: 180000,
    accept(file, done) {
        done();
    },
    init() {
        this.on("error", (file) => {
            if (file.accepted) {
                let preview = document.querySelector('.dz-error:last-child');
                preview?.classList.replace('dz-error', 'dz-success');
            } else {
                this.removeFile(file);
            }
        });
    }
};

// Configuración para subir una sola imagen
const dropconfig = {
    ...dropBaseConfig,
    maxFiles: 1,
    accept: dropBaseConfig.accept,
    init() {
        dropBaseConfig.init.call(this);
        this.on("addedfile", function (file) {
            if (this.files.length > 1) {
                this.removeAllFiles();
                this.addFile(file);
            }
            file.nombre = file.status ? app.archivoUnico(file.name) : file.name;
            app.abririmagen();
        });
    },
    maxfilesexceeded(file) {
        this.removeAllFiles();
        this.addFile(file);
    }
};

// Configuración para subir múltiples imágenes
const dropmultiple = {
    ...dropBaseConfig,
    uploadMultiple: true,
    accept: dropBaseConfig.accept,
    init() {
        dropBaseConfig.init.call(this);
        this.on("addedfile", function (file) {
            file.nombre = file.status ? app.archivoUnico(file.name) : file.name;
            app.abririmagen();
        });
        this.on("addedfiles", () => {
            info.cerrar = true
            app.cerrar_before();
        });
    }
};

const info = {
    user: "",
    tr: [],
    data: [],
    equipos: [],
    listaClientes: [],
    equipo: [],
    productos: [],
    orden: [],
    reingreso: 0,
    msgro: "",
    historial: "",
    sumas: {
        suma1: 0,
        suma2: 0
    },
    opcion: "",
    cerrar: false,
    hcerrar: false,
    id_equipo: -1
};

$(document).on('input keypress', 'form input', function (e) {
    let form = $(this).closest('form');
    if ((e.which === 13 && !form.hasClass('permitir-enter')) || ['|', 'Ω', '•'].includes(e.key)) {
        return false;
    }
    $(this).val($(this).val().replace(/[|Ω]/g, ''));
});

var app = {
    ajax: function (url, data, carga, funcion, json, async = true) {
        if (carga) Swal.fire(swalload);
        $.ajax({
            url,
            type: 'POST',
            data,
            async,
            dataType: json ? "html" : "text",
            contentType: !!json,
            processData: false,
            cache: false,
            success: (respuesta) => funcion(json ? respuesta : JSON.parse(respuesta)),
            error: (jqXHR, textStatus, errorThrown) => {
                let mensajeError = "Error en la petición.";
                if (jqXHR.status) {
                    mensajeError += ` Código: ${jqXHR.status}`;
                }
                if (jqXHR.responseText) {
                    try {
                        let jsonError = JSON.parse(jqXHR.responseText);
                        mensajeError += ` - ${jsonError.mensaje || jsonError.error || "Error desconocido"}`;
                    } catch (e) {
                        mensajeError += ` - Respuesta no válida`;
                    }
                }
                app.mensaje({ codigo: -1, mensaje: mensajeError });
            }
        });
    },

    buscador: function (caja, url, minimo = 1, minsize = true, tags = false) {
        const sizeClass = minsize === false ? 'select2--small' : null;
        let ajaxConfig = null;
        if (url) {
            const metodo = url.metodo || '';
            ajaxConfig = {
                url: './controlador/GestionUsuarioControlador.php?opcion=buscar',
                delay: 250,
                cache: true,
                data: function (params) {
                    return {
                        q: params.term,
                        metodo: metodo,
                        sucursal: sucursal,
                        type: 'public'
                    };
                },
                processResults: url.processResults
            };
        }
        //aplicar select2 a caja
        caja.select2({
            language: 'es',
            width: 'auto',
            minimumInputLength: minimo,
            theme: 'bootstrap-5',
            dropdownParent: caja.parents(':eq(7)'),
            placeholder: 'Escribe en la caja para buscar',
            selectionCssClass: sizeClass,
            dropdownCssClass: sizeClass,
            tags: tags,
            createTag: function (params) {
                const valor = `${params.term} (borrador)`;
                return {
                    id: valor,
                    text: valor,
                    newOption: true
                };
            },
            ajax: ajaxConfig
        }).on('select2:open', function (e) {
            const evt = 'scroll.select2';
            $(e.target).parents().off(evt);
            $(window).off(evt);
        });
    },

    eliminarbuscador: function (caja) {
        if (caja.hasClass("select2-hidden-accessible")) {
            caja.select2("destroy");
        }
    },

    selectConfig: function (metodo, esProducto = false) {
        return {
            metodo,
            processResults: function ({ datos }) {
                if (esProducto) {
                    return {
                        results: datos.map((item, index) => ({
                            text: item.data_prod ?? "",
                            id: item.id_productos,
                            pos: index,
                            datos: item
                        }))
                    };
                } else {
                    return {
                        results: datos.map(({ data_empr, id_principal, nombre }) => ({
                            text: data_empr ?? nombre ?? "",
                            id: id_principal ?? nombre
                        }))
                    };
                }
            }
        };
    },
    
    mensaje: function (respuesta) {
        var boton = $("button");
        Swal.fire({
            title: respuesta.mensaje,
            icon: respuesta.codigo > 0 ? 'success' : 'warning',
            confirmButtonText: respuesta.codigo > 0 ? 'Aceptar' : 'Entendido',
            customClass: {
                confirmButton: 'btn'
            },
            allowOutsideClick: true,
            allowEscapeKey: true, 
            backdrop: true,
            willClose: () => {
                if (respuesta.codigo > 0 && typeof respuesta.norecarga === "undefined") {
                    boton.attr("disabled", "disabled");
                    location.reload();
                }
            }
        });

    },

    confirmacion: function (texto) {
        var alerta = Swal.fire({
            html: texto,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            customClass: {
                confirmButton: 'btn ',
                cancelButton: 'btn'
            }
        })
        return alerta;
    },

    datatables: function (cuerpo, datos, columnas, filtr) {
        var urlParams = new URLSearchParams(window.location.search);
        var precarga = $("[precarga]");
        var table = cuerpo.DataTable({
            processing: true,
            responsive: true,
            data: datos,
            orderCellsTop: true,
            columns: columnas,
            order: [],
            destroy: true,
            columnDefs: [{
                responsivePriority: -1,
                "targets": 'no-sort',
                "orderable": false,
                "targets": -1
        }],
            initComplete: function () {
                var api = this.api();
                cuerpo.find('.filtro').each((i, el) => {
                    const $celda = $(el);
                    // Verifica que NO esté oculta (por clase o estilo) antes de crear el input
                    if (!$celda.hasClass('hidden') && $celda.is(':visible')) {
                        $('<input type="text" class="form-control form-control-sm" placeholder="Buscar">')
                            .appendTo($celda.empty())
                            .on('keyup', function () {
                                table.column(i).search(this.value).draw();
                            });
                    }
                });
                app.fadeout(precarga);
                app.responsive(cuerpo, table, api.columns().responsiveHidden().toArray());
            },
            createdRow: (row) => $('td', row).slice(1, -1).each(function () {
                !$(this).children('[data-title]').length && $(this).text().trim() !== '' && $(this)
                    .attr('data-title', $(this).text())
                    .css('cursor', 'help');
            })
        });
        //Filtrado por orden
        if (urlParams.has('orden')) {
            let valor = urlParams.get('orden');
            table.columns(0).search(`^${valor}$`, true, false).draw();
            $(document).ready(() => $(`[data-id='${valor}']`).click());
        }
        //Validar
        if (filtr) {
            table.columns(3).search("Nueva recepción|Diagnóstico", true, false).draw();
            $(".filtro").eq(3).empty();
        }
        //Responsive
        table.on('responsive-resize', (e, datatable, columns) => app.responsive(cuerpo, table, columns));
        //Dibujar
        table.on("draw.dt", () => table.columns.adjust());
    },

    responsive: function (cuerpo, table, columns) {
        for (i = 0; i < columns.length; i++) {
            if (columns[i]) {
                $('.filtros th:eq(' + i + ')').show();
            } else {
                $('.filtros th:eq(' + i + ')').hide();
            }
        }
    },

    fadeout: function (precarga) {
        $('.contenido').removeAttr("hidden");
        precarga.fadeOut(500, function () {
            $('body').removeClass("nooverflow");
            $(this).remove();
        });
    },

    paginacion: function (paginacion) {
        paginacion.flexiblePagination({
            itemsPerPage: 9,
            itemSelector: 'div.product-item:visible',
            pagingControlsContainer: '#pagingControls',
            showingInfoSelector: '#showingInfo',
            showGotoFirst: false,
            showGotoLast: false,
            btnNextText: "Siguiente",
            btnPreviousText: "Anterior",
        });
    },

    imagenes: function (myDropzone, img, tipo, estado, valid) {
        if (valid !== false) myDropzone.removeAllFiles();
        if (img) {
            let mockFile = {
                name: img
            };
            ["addedfile", "thumbnail", "complete"].forEach(event =>
                myDropzone.emit(event, mockFile, dropconfig.url + "/" + tipo + "/" + img)
            );
            myDropzone.files.push(mockFile);
        }
        estado ? myDropzone.enable() : (myDropzone.disable(), $(".dz-remove").remove());
    },


    cargarimagenes: function (myDropzone, img, tipo) {
        //Limpiar campos
        $.each(myDropzone, function (idxDPZ, valDPZ) {
            valDPZ.removeAllFiles()
        });
        //Cargar Imagenes
        if (img.length > 0) {
            $.each(img, function (idxImg, valImg) {
                $.each(valImg, function (idxImgID, valImgValor) {
                    //Visualizar imagen
                    app.imagenes(myDropzone[idxImg], valImgValor, tipo, true, false);
                });
            });
        }
    },

    abririmagen: function () {
        $(".dz-preview").off("click").on("click", function (e) {
            e.stopImmediatePropagation();
            let imagen = $(this).find("img").attr("src");
            Swal.fire({
                heightAuto: false,
                width: 1000,
                imageUrl: imagen,
                imageAlt: "Equipo",
                confirmButtonText: 'Confirmar',
                html: `
                    <a href="${imagen}" target="_blank" class="btn btn-primary btn-sm">Ver imagen</a>
                    <a href="${imagen}" class="btn btn-danger btn-sm" download>Descargar</a>`,
                customClass: {
                    confirmButton: 'btn btn-primary',
                }
            });
        });
    },

    cambio: function (lista, dato, tipo, id, cambia) {
        // Prepara los datos para la petición
        const form_data = new FormData();
        form_data.append('vista', `lista_${tipo}`);
        form_data.append('tipo', tipo);
        form_data.append('id', dato);
        form_data.append('id2', id ?? "");
        // Si debe cambiar dinámicamente
        if (cambia) {
            lista.off('change').on('change', function (e) {
                e.stopImmediatePropagation();
                app.cambio(lista, this.value, tipo);
                $('.detalle').empty();
                app.limpiaratencion();
            });
        }
        // Llamada AJAX
        app.cambioajax(form_data, tipo);
    },
    cambioajax: function (data, tipo) {
        var data = data;
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=listado', data, true, app.repuesta_lista, false, true);
    },

    repuesta_lista: function (respuesta) {
        const datos = respuesta.datos;
        const tipo = respuesta.tipo
        let caja = $('[ ' + tipo + ']');
        caja.empty();
        // Si hay datos, llenar la caja con las opciones
        if (datos) {
            //llenar campo para equipos
            if (tipo == "equipos") {
                let opciones = '';
                info.equipos = datos;
                for (var i = 0; i < datos.length; i++) {
                    var registro = datos[i];
                    opciones += '<option value="' + registro.id_equipo + '" data-pos="' + i + '">' +
                        registro.codigo_interno + ' - ' + registro.tipo_equipo + ', ' + registro.serie +
                        ' (' + registro.modelo + ', ' + registro.modelo2 + ')</option>';
                }
                caja.append(opciones).val(respuesta.id);
                let selected = caja.find(":selected");
                let lista_pos = selected.data("pos");
                caja.data("old", selected.text());
                app.mostrar_equipo(caja, lista_pos, "equipos");
            }
            //llenar campos para ordenes reingresadas
            if (tipo == "reingreso") {
                let opciones = '';
                const boton = $("[detalle-reingreso]");
                for (var i = 0; i < datos.length; i++) {
                    var registro = datos[i];
                    opciones += `<option value="${registro.id_orden}">
                                    ${registro.cod_orden} - ${registro.nit_empresa}, ${registro.nombre_empresa} (${registro.estado})
                                </option> `;
                }
                // Configuración del buscador
                caja.append(opciones);
                app.buscador(caja, null, 0);
                caja.val(info.reingreso).trigger('change.select2');
                let detalleOrden = datos.find(x => x.id_orden == info.reingreso);
                info.orden = detalleOrden
                app.detalleOrden(boton);
                caja.change(function (e) {
                    e.stopImmediatePropagation();
                    detalleOrden = datos.find(x => x.id_orden == $(this).val());
                    info.orden = detalleOrden;
                    app.detalleOrden(boton);
                });
                swal.close();
            }
        }
    },

    ocultar_mostrar: function (hidden) {
        (hidden == "si") ? $("[caja_oculta]").attr("hidden", "hidden"): "";
        $('[mostrar]').change(function (e) {
            e.stopImmediatePropagation();
            var tipo = $(this).attr("data-ocultar");
            $("[" + tipo + "]").prop("hidden", !this.checked);
        });
    },

    estados: function (estados, paso) {
        estados.smartWizard("reset");
        estados.smartWizard(pasos);
        estados.smartWizard("goToStep", paso, true);
    },

    tablas_estados: function (tabla, data, tipo, clon, edit) {
        var cuerpo = tabla.children("tbody");
        app.duplicar_campo(tabla, tipo, clon);
        //Poner datos
        if (data) {
            cuerpo.empty();
            $.each(data, function (i, dato) {
                var tr = app.tablas_campos(dato, info.tr[tipo], tipo);
                
                cuerpo.append(tr);
            });
            app.cambios_tablas(tabla, tipo, clon);
        } else {
            cuerpo.empty();
            cuerpo.append(info.tr[tipo]);
            app.cambios_tablas(tabla, tipo, clon);
        }
        //añadir item
        tabla.on('click', '[mas]', function (e) {
            e.stopImmediatePropagation();
            cuerpo.append(info.tr[tipo]);
            app.cambios_tablas(tabla, tipo, clon);
            $("[aprobar]").prop('checked', false);
        });
        //remover item
        tabla.on('click', '[remover]', function (e) {
            e.stopImmediatePropagation();
            var mensaje = "¿Estás seguro de remover el campo?";
            var alerta = app.confirmacion(mensaje);
            alerta.then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('tr').remove();
                    app.cambios_tablas(tabla, tipo, clon);
                }
            })
        });
    },

    duplicar_campo: function (tabla, tipo) {
        tabla.find('tbody tr:first').each(function (e) {
            $(this).find(".caja").each(function (i, item) {
                const $el = $(this);
                $el.val("");
                $el.prop('checked', false);
                // Si es un SELECT prod
                if ($el.hasClass('prod')) {
                    $el.find('option').remove(); 
                }
                // Eliminar buscador select2 u otro
                app.eliminarbuscador($el);
            });
            var clon = $(this).html();
            info.tr[tipo] = "<tr>" + clon + "</tr>";
        });
    },

    tablas_campos: function (datos, campo, tipo) {
        var tr = $.parseHTML(campo);
        $(tr).find(".caja").each(function (i) {
            let $el = $(this), val = datos[i];
            if ($el.is('select.data-id')) {
                let opt = $el.find('option').filter((_, o) => $(o).data('id') == val);
                if (opt.length) $el.val(opt.val());
            } else if ($el.hasClass("prod") && val) {
                let obj = typeof val === 'object' ? val : {}, id = obj.id_productos || val,
                    txt = obj.data_prod || val, stock = obj.stock_existente || "";
                if (!$el.val()) $el.append(new Option(txt, id, true, true)).attr({"data-cant": stock, "data-old": txt});
            } else {
                $el.val(val).attr("data-old", val);
            }
            if ($el.is(':checkbox')) $el.prop("checked", val === "ok");
        });

        return tr;
    },

    cambios_tablas: function (tabla, tipo, clon) {
        app.calcular_tabla(tabla);
        //Calcular
        tabla.find("[calc]").change(function (e) {
            e.stopImmediatePropagation();
            app.cambios_tablas(tabla, tipo, clon);
        });
    },

    calcular_tabla: function (tabla) {
        var sum = 0,
            sum2 = 0;
        // Aplicar buscador a los productos en la tabla (incluyendo nuevos)
        tabla.find('[productos]').each(function () {
            var caja = $(this);
            if (!caja.hasClass("select2-hidden-accessible") && caja.hasClass("prod")) {
                app.buscador(caja, app.selectConfig('buscar_productos', true), 1, false, true);
            }
        });
        // Delegación de eventos para manejar la selección de un producto en cualquier fila
        tabla.on('select2:select', '[productos]', function (e) {
            e.preventDefault();
            var selector = $(this),
                infor = e.params.data.datos,
                prod = selector.val(),
                existe = 0,
                fila = selector.closest("tr");
            // Verificar si el producto ya está en otra fila
            tabla.find(".prod").not(this).each(function () {
                if ($(this).children(`option[value="${prod}"]:selected`).length) {
                    existe++;
                }
            });
            // Validar y asignar valores
            if (existe > 0) {
                selector.find("option").remove();
                e.params.data.datos = null;
                app.mensaje({ codigo: -1,  mensaje: 'ERROR: Producto está seleccionado en otra fila!' });
            } else {
                selector.data("cant", infor ? infor.stock_existente : "");
                fila.find('[descripcion]').val(infor ? infor.nombre_producto : "");
                fila.find('[tipo]').val(infor ? infor.tipo : "");
                fila.find('[unidad]').val(infor ? infor.precio_venta : "");
                fila.find('[iva]').val(infor ? infor.iva : "");
                fila.find('[cantidad]').val(0);
            }
        });
        // Delegación de eventos para validar cantidad
        tabla.on("input", "[cantidad]", function () {
            const $input = $(this),
                  fila = $input.closest("tr"),
                  max = parseInt(fila.find("[cod]").data("cant")),
                  valor = parseInt($input.val());

            // Bloquear negativos o NaN
            if (isNaN(valor) || valor < 0) {
                $input.val(0);
                return;
            }

            // Limitar al stock disponible
            if (valor > max) {
                $input.val(max);
                app.mensaje({
                    codigo: -1,
                    mensaje: `ERROR: Solo hay en stock: ${max}`
                });
            }
        });
        // Calcular totales
        tabla.find('tr:has(td):not(:last)').each(function () {
            var fila = $(this);
            var cant = fila.find('[cantidad]').val() || 0,
                unidad = fila.find('[unidad]').val() || 0,
                desc = fila.find('[descuento]').val() || 0,
                iva = $.isNumeric(fila.find('[iva]').val()) ? fila.find('[iva]').val() : 0;
            var total = cant * unidad,
                total_desc = (total * desc) / 100,
                total_con_desc = total - total_desc,
                total_iva = (total_con_desc * iva) / 100,
                total_final = parseInt(total_con_desc + total_iva);
            fila.find('[total]').html(`$${app.formatoPrecio(total_final)}`).data("val", total_final);
            fila.find('[abono]').attr("data-val", fila.find('[abono]').val() || 0);
        });
        // Calcular sumas de totales y abonos
        tabla.find('[total]').each(function () {
            sum += parseInt($(this).data("val"));
            info.sumas.suma1 = sum;
        });
        //Abono
        $('[abono]').each(function () {
            sum2 += parseInt($(this).attr("data-val"));
            info.sumas.suma2 = sum2;
        });
        // Mostrar total de cotización y abonos
        tabla.find('[total_final]').html(`$${app.formatoPrecio(sum)}`);
        let totalPagar = app.formatoPrecio(info.sumas.suma1 - info.sumas.suma2);
        let totalColor = (parseInt(totalPagar) > 0) ? "badge-success" : "badge-danger";
        $('[total_abonos]').html(`<b>TOTAL:</b> <label class='badge ${totalColor} badge-pill p-2'>$${totalPagar}</label>`);
    },

    mostrar_equipo: function (lista, valor, tipo) {
        var datos = info.equipos[valor];
        $.each(datos, function (a, b) {
            $('.caja_' + a).text(b);
        });
        $("#modal").modal('show');
        swal.close();
        //Actualizar
        lista.change(function (e) {
            e.stopImmediatePropagation();
            var pos = $(this).find(':selected').data("pos");
            app.mostrar_equipo(lista, pos, tipo);
            app.limpiaratencion();
        });
    },

    abrir_modal: function (form = false) {
        // Agregar el contenido del modal al body
        $(".crear_modal").off('click').on('click', function (e) {
            e.preventDefault();
            var modal = $(this).data("modal") ?? "",
                envio = $(this).data("envio") ?? "",
                necesita = $(this).data("necesita") ?? "",
                esSubmit = $(this).is("[esSubmit]") ?? "";
            info.opcion = envio;
            $(envio).trigger("reset");
            app.crearModal(necesita);
            // Mostrar el modal
            $(modal).modal("show");
            // Manejar el evento de envío dentro del modal
            $(envio).off('click', '.enviar').on('click', '.enviar', function (e) {
                e.stopImmediatePropagation();
                app.grabar_modal(modal, esSubmit)
            });
            
        });
    },

    grabar_modal: function (modal, esSubmit) {
        var formulario = $(info.opcion),
            formPrincipal = $("#frm"),
            form_data = new FormData(formulario[0]),
            id_cliente = formPrincipal.find("[cliente]").val() || 0,
            id_mensajero = formulario.find("#mensajero").val() || "";
        //recolección
        form_data.append('gestion', "agregar_" + formulario.data("tipo"));
        form_data.append('id_cliente', id_cliente);
        form_data.append('sucursales[]', sucursal);
        form_data.append('id_equipo', 0);
        //envio de datos
        if (esSubmit) {
            info.msgro = id_mensajero;
            formPrincipal.submit();
        } else {
            app.ajax('./controlador/GestionUsuarioControlador.php?opcion=' + formulario.data("opcion"), form_data, true, app.respuesta_modal);
        }
    },

    respuesta_modal: function (respuesta) {
        if (respuesta.codigo == 1) {
            Swal.fire({
                title: respuesta.mensaje,
                icon: 'success',
            });
            $(".modal-2").modal("hide");
            //datos
            if (respuesta.id > 0) {
                var form_data = new FormData();
                form_data.append('id', respuesta.id);
                form_data.append('gst', respuesta.gst);
                app.ajax('./controlador/GestionUsuarioControlador.php?opcion=' + respuesta.tipo, form_data, true, app.caja_respuesta);
            }
        } else {
            Swal.fire({
                title: respuesta.mensaje,
                icon: 'warning',
            });
        }
    },
    caja_respuesta: function (respuesta) {
        var datos = respuesta.datos,
            lista_clientes = $('[cliente]'),
            lista_equipos = $('[equipos]');
        swal.close();
        if (respuesta.tipo === "cliente") {
            var pos = info.listaClientes.length;
            info.listaClientes.push(datos[0]);
            datos.forEach((registro) => {
                lista_clientes.append(
                    `<option value="${registro.id_cliente}" data-pos="${pos}">
                        ${registro.nit_empresa} - ${registro.nombre_empresa}
                    </option>`
                );
            });
            lista_clientes.val(datos[0].id_cliente).trigger("change").focus();
            app.limpiaratencion();
        }
        if (respuesta.tipo === "equipo") {
            var pos = Object.keys(info.equipos).length;
            info.equipos[pos] = datos[0];
            datos.forEach((registro) => {
                lista_equipos.append(
                    `<option value="${registro.id_equipo}" data-pos="${pos}">
                        ${registro.codigo_interno} - ${registro.tipo_equipo}, 
                        ${registro.serie} (${registro.modelo}, ${registro.modelo2})
                    </option>`
                );
            });
            app.mostrar_equipo(lista_equipos, "", "equipos");
            lista_equipos.val(datos[0].id_equipo).trigger("change").focus();
            app.limpiaratencion();
        }
    },

    limpiaratencion: function (e) {
        $("[atencion]").val("").trigger("change.select2");
        $("[caja_nueva]").empty();
    },

    cerrar: function (form) {
        const fecha = moment().format(fecha_ahora);
        const user =  info.user;
        $(form).on("change paste select2:select", "input, select, textarea, button", function (e) {
            e.stopPropagation();
            info.cerrar = true;
            app.cerrar_before();
            if (info.cerrar) {
                const $el = $(this);
                const titulo = $el.attr("titulo") || "";
                if (titulo) {
                    const old = $el.data("old") || "";
                    const valor = $el.is("select") && $el.val() ? $el.find("option:selected").text() : $el.val();
                    const pos = $el.closest("tr").index() + 1;
                    const hora = moment().format(hora_ahora);
                    info.historial += `${fecha}•${titulo}•${hora}•${user}|${pos}|${valor}|${old}¦`;
                }
            }
        });
        app.cerrar_before();
    },

    cerrar_before: function () {
        var close = $(".cerrar");
        if (info.cerrar) {
            $(window).bind('beforeunload', function (e) {
                return info.cerrar;
            });
            close.removeAttr("data-bs-dismiss");
            close.click(function (e) {
                e.stopImmediatePropagation();
                if (info.cerrar) {
                    var mensaje = "<h3>¿Salir sin guardar?</h3>";
                    var alerta = app.confirmacion(mensaje);
                    alerta.then((result) => {
                        if (result.isConfirmed) {
                            $(window).unbind('beforeunload');
                            $("#modal, .modalgeneral").modal("hide");
                            info.cerrar = false;
                            app.cerrar_before();
                        }
                    })
                } else {
                    $(window).unbind('beforeunload');
                    close.attr("data-bs-dismiss", "modal");
                }
            });
        } else {
            $(window).unbind('beforeunload');
            close.attr("data-bs-dismiss", "modal");
        }
    },

    respuesta_pdf: function (respuesta) {
        if (respuesta.codigo == 1) {
            const blob = app.base64ToBlob(respuesta.pdf, 'application/pdf');
            const url = URL.createObjectURL(blob);
            iframe = document.createElement('iframe');
            document.body.appendChild(iframe);
            iframe.style.display = 'none';
            iframe.src = url;
            iframe.onload = function () {
                try {
                    iframe.focus();
                    iframe.contentWindow.print();
                    swal.close();
                } catch (error) {
                    var a = document.createElement("a");
                    a.href = url;
                    a.download = respuesta.titulo + ".pdf";
                    a.click();
                    swal.close();
                }
            };
        } else {
            app.mensaje({
                codigo: -1,
                mensaje: respuesta.mensaje
            });
        }
    },
    
    carga_excel: function (tipo, mostrarPrecios = false, funcion) {
        $('[carga]').on('click', e => {
            e.preventDefault();
            const htmlContenido = `
                <div class="d-flex flex-column align-items-center mt-3 gap-2">
                    <a class="btn btn-success btn-sm" href="./assets/excel/${tipo}.xlsx" download>Descargar plantilla</a>
                    ${mostrarPrecios ? `
                    <div class="form-check">
                        <input class="form-check-input solo_precios" type="checkbox" id="solo_precios">
                        <label class="form-check-label" for="solo_precios">Actualizar solo precios</label>
                    </div>` : ''}
                </div>`;
            Swal.fire({
                title: 'Seleccionar Excel',
                html: htmlContenido,
                input: 'file',
                inputAttributes: { accept: '.xlsx', 'aria-label': 'Sube el archivo Excel' },
                showCancelButton: true,
                confirmButtonText: 'Cargar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed && result.value) {
                    const formData = new FormData();
                    formData.append('tipo', tipo);
                    formData.append('excel', result.value);
                    formData.append('sucursal', sucursal);
                    formData.append('precios', mostrarPrecios && $(".solo_precios").is(":checked") ? true : false);
                    app.ajax('controlador/GestionUsuarioControlador.php?opcion=carga_excel', formData, true, funcion);
                }
            });
        });
    },

    respuesta_excel: function (respuesta) {
        if (respuesta.codigo == 1) {
            const blob = app.base64ToBlob(respuesta.archivo, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = respuesta.titulo + '.xlsx';
            a.click();
            swal.close();
        } else {
            app.mensaje({
                codigo: -1,
                mensaje: respuesta.mensaje
            });
        }
    },

    detalleOrden: function (boton) {
        if (info.orden) {
            boton.removeAttr("disabled");
            boton.click(function (e) {
                e.stopImmediatePropagation();
                //Asignación datos
                app.datosOrdenes(true);
            })
        } else {
            boton.attr("disabled", "disabled");
        }
    },

    datosOrdenes: function (conNota) {
        var modal = $("#detalle_modal"),
            dat = info.orden;
        var fecha = moment(dat.fecha).format('MMMM D [del] YYYY, hh:mm A'),
            fechafin = dat.fecha_final ? moment(dat.fecha_final).format('MMMM D [del] YYYY, hh:mm A') : "";
        $("[ref-id-orden]").html(dat.cod_orden);
        $("[ref-fecha]").html(`CREADO: ${fecha}`);
        $("[ref-fechafin]").html(fechafin ? `FINALIZADO: ${fechafin}` : "");
        $("[imagenes-orden-ref], [contenido-orden-ref]").html("");
        function appendImages(selector, images) {
            $.each(images, (_, img) => {
                $(selector).append(`<div class="dz-preview h-auto p-1 w-img-2" role="button">
                                        <img src="./assets/images/ordenes/${img}" class="mw-100 rounded img-fluid" title="Ver más">
                                    </div>`);
            });
        }
        appendImages("[imagenes_1]", dat.imagen1);
        appendImages("[imagenes_2]", dat.imagen3);
        appendImages("[imagenes_5]", dat.imagen2);
        $("[contenido_1]").html(`<h4>Observación: </h4>${dat.observacion}`);
        $("[contenido_2]").html(`<h4>Diagnóstico: </h4>${dat.diagnostico}`);
        $("[contenido_4]").html(`<h4>Observación: </h4>${dat.notas}`);
        $("[contenido_5]").html(`<h4>Observación: </h4>${dat.nota_final}`);
        var recep_titl = ["Código", "Descripción", "Cantidad", "Tipo", "VR Unitario", "IVA(%)", "Descuento(%)", "Aprobación"];
        var cotiza = ["", "Pendiente por aprobación", "No autoriza", "No se justifica", "Aprobado"];
        var recep = `
        <div class="alert alert-warning"><b>Atención!</b> Solo informativo, NO se va a calcular precios.</div>
        <div class="table-responsive">
            <table class="table table-bordered rounded-table">
                <thead><tr class="bg-dark text-white">
                    ${recep_titl.map(t => `<th>${t}</th>`).join("")}
                </tr></thead>`;

        $.each(dat.tabla_cotizacion, (_, fila) => {
            recep += `<tr>${recep_titl.map((_, i) => {
                let value = Array.isArray(fila[i]) ? fila[i][0].data_prod : fila[i];
                if (i === 4) value = `$ ${app.formatoPrecio(parseFloat(value) || 0)}`;
                return `<td title="${value}" class="c-help">${value}</td>`;
            }).join("")}</tr>`;
        });
        recep += `</table></div><h4 class='ps-2 pt-2'>${cotiza[dat.estado_cotizacion]}</h4>`;
        $("[contenido_3]").append(recep);
        var abono_titl = ["Cantidad", "Fecha", "Descripción"];
        var abono = `
        <div class="table-responsive">
            <table class="table table-bordered rounded-table">
                <thead><tr class="bg-dark text-white">
                    ${abono_titl.map(t => `<th>${t}</th>`).join("")}
                </tr></thead>`;
        $.each(dat.abonos, (_, fila) => {
            abono += `<tr>${abono_titl.map((_, i) => {
            let value = fila[i];
            if (i === 0) value = `$ ${app.formatoPrecio(parseFloat(value) || 0)}`;
            return `<td title="${value}" class="c-help">${value}</td>`;
        }).join("")}</tr>`;
        });
        abono += `</table></div>`;
        $("[abonos-ref]").append(abono);
        $("[nota-ref]").html(conNota ? dat.notita : "");
        app.abririmagen();
        modal.modal('show');
    },

    historial: function (data) {
        var caja = $(".edit"),
            tabla = $("[historial_tabla]");
        if (!info.cerrar) {
            caja.removeAttr("disabled");
            tabla.empty();

            $.each(data, function (fecha, horas) {
                var fechaFormateada = moment(fecha).locale('es').format('MMMM. D [del] YYYY'),
                    fila = `<div class="card border">
                                <div class="card-header bg-white"><span class="fs-4">${fechaFormateada}</span></div>
                                <div class="card-body p-0"><ul class="list-group list-group-flush">`;
                $.each(horas, function (hora, tipos) {
                    if (hora) {
                        var horaFormateada = moment(hora, hora_ahora).format('hh:mm A');
                        fila += `<li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto w-100">
                                        <div class="fw-bold">${horaFormateada}</div>
                                        <ul class="list-group list-group-flush">`;
                        $.each(tipos, function (tipo, dato) {
                            var [estado, , newData, oldData] = dato;
                            fila += `<li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-2 col-sm-6 col-12"><b>${tipo}</b></div>
                                            <div class="col-lg-1 col-sm-6 col-12"><b class="text-primary"><i class="btn-secondary"></i>${estado}</b></div>
                                            <div class="col-lg-5 col-sm-6 col-12"><b>Nuevo:</b> ${newData}</div>
                                            ${oldData ? `<div class="col-lg-4 col-sm-6 col-12"><b>Anterior:</b> ${oldData}</div>` : ""}
                                        </div>
                                    </li>`;
                        });
                        fila += `</ul></div></li>`;
                    }
                });
                tabla.append(fila + "</ul></div></div>");
            });
        } else caja.attr("disabled", "disabled");
    },

    crearModal: function (tipo) {
        $("[crearModal]").off('click').on('click', function (e) {
            e.preventDefault();
            let htmlCampos = `<div class="ps-5 pe-5">`;
            if (tipo === 'marcas') {
                htmlCampos += `
                    <input id="inp_nombre" class="form-control mb-2" placeholder="Nombre de la marca" autocomplete="off">
                    <input id="inp_extra" class="form-control" placeholder="Palabras clave" autocomplete="off">`;
            } else if (tipo === 'mensajeros') {
                htmlCampos += `
                    <input id="inp_nombre" class="form-control mb-2" placeholder="Nombre del mensajero" autocomplete="off">
                    <input id="inp_extra" class="form-control" placeholder="Celular" autocomplete="off">`;
            } else {
                htmlCampos += `
                    <input id="inp_nombre" class="form-control" placeholder="Ingrese ${tipo}" autocomplete="off">`;
            }
            htmlCampos += `</div><p class="mt-2">Al guardar, debes buscar la ${tipo}</p>`;
            Swal.fire({
                title: `Crear ${tipo}`,
                html: htmlCampos,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar"
            }).then(function (result) {
                if (result.isConfirmed) {
                    const nombre = $('#inp_nombre').val() || '';
                    const extra = $('#inp_extra').val() || '';
                    const form = new FormData();
                    form.append('nombre', nombre);
                    form.append('extra', extra);
                    form.append('estado', 'activo');
                    form.append('gestion', 'agregar_' + tipo);
                    form.append('existe', 'buscar_' + tipo);
                    form.append('sucursal', sucursal);
                    app.ajax('./controlador/GestionUsuarioControlador.php?opcion=grabar_sweet', form, true, app.respuestaSweet, false, true);
                }
            });
        });
    },

    respuestaSweet: function (respuesta) {
        if (respuesta.codigo > 0) {
            Swal.fire({
                title: respuesta.mensaje,
                icon: 'success',
            });
        } else {
            Swal.fire({
                html: respuesta.mensaje,
                icon: 'warning',
            });
        }
    },
    
    mensajero: function (r) {
        const c = $('[btnMensajero="true"]'), rm = $("[removerMensajero]");
        if (!c.length) return;
        if (!r) return c.empty();
        $("#mensajero").val("").trigger("change.select2");
        const tiene = !!r.id_mensajero,
            nombre = tiene ? r.nombre_mensajero : 'Añadir',
            borde = tiene ? 'border-primary' : '',
            icono = tiene ? '<i class="fa fa-envelope bg-primary text-white"></i>' : '<i class="mdi mdi-account-plus"></i>',
            html = `
            <button class="avatar avatar-lg border-2 rounded-circle border ${borde} crear_modal"
                type="button" title="Añadir Mensajero"
                data-modal="#modal_mensajero" data-envio="#frm_mensajeros"
                data-necesita="mensajeros" esSubmit="true">${icono}</button>
            <small class="avatar-text" title="${nombre}">${nombre}</small>`;
        if (tiene) {
            $('[nombre_mensajero]').text(r.nombre_mensajero);
            $('[fecha_mensajero]').text(moment(r.fecha_mensajero).format('MMMM D [del] YYYY, hh:mm A'));
            $('[celular_mensajero]').text(r.celular_mensajero);
            rm.removeClass("d-none");
        } else {
            $('[nombre_mensajero], [fecha_mensajero], [celular_mensajero]').text('');
            rm.addClass("d-none");
        }
        c.html(html);
        app.abrir_modal();
    },
    
    respuestaCorreoWhatsapp: function (respuesta) {
        if (respuesta.codigo == 1) {
            if (respuesta.tipo == "whatsapp") {
                window.open(respuesta.mensaje, '_blank');
                 swal.close();
            } else {
                app.mensaje({ codigo: -1, mensaje: respuesta.mensaje });
            }
        } else {
            app.mensaje({ codigo: -1, mensaje: respuesta.mensaje });
        }
    },

    base64ToBlob: function (base64, type = "application/octet-stream") {
        const binStr = atob(base64);
        const len = binStr.length;
        const arr = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            arr[i] = binStr.charCodeAt(i);
        }
        return new Blob([arr], {
            type: type
        });
    },

    archivoUnico: function (nombre) {
        var renombre = "_" + Date.now() + "_" + nombre;
        return renombre;
    },

    bloquearNoMod: function () {
        $('[noMod]').each(function() {
            const $el = $(this);
            if ($el.is('input, textarea, select')) {
              $el
                .prop('readonly', true)
                .css('pointer-events', 'none')
                .on('keydown paste drop cut input', e => e.preventDefault())
                .off('focus')
                .blur();
            }
        });
    },

    desbloquearNoMod: function () {
        $('[noMod]').each(function() {
            const $el = $(this);
            if ($el.is('input, textarea, select')) {
              $el
                .prop('readonly', false)
                .css('pointer-events', '')
                .off('keydown paste drop cut input');
            }
        });
    },
    
    formatoPrecio: function (numero) {
        return parseFloat(numero).toLocaleString("en-US");
    },
    
    precioFormatos: function () {
        $('[precio="true"]').each(function() {
        new AutoNumeric(this, {
            currencySymbol: '',
            decimalCharacter: '.',
            digitGroupSeparator: ',',
            decimalPlaces: 0
        });
    });
    },
    
};
