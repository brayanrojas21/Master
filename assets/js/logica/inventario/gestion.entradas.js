/* global app */
var Modelo = {
    formulario: "#frm",
    listaEntradas: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionEntradas = {
    constructor: function () {
        gestionEntradas.listado_entradas();
    },
    listado_entradas: function (e) {
        const data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_entradas', data, false, gestionEntradas.repuesta_entradas);
    },
    repuesta_entradas: function (respuesta) {
        //Select
        const { datos } = respuesta;
        const lista_productos = $('[productos]');
        const cajas = $('[cajas]');
        //tabla
        const multiple = $('.multiple');
        const cuerpo = $('[entradas]');
        const modal = $('#modal');
        //Fin tablas estados
        Modelo.listaEntradas = datos;
        //Asignación de datos
        var columnas = [
            { data: 'codigo_producto' },
            { data: 'nombre_producto' },
            { data: 'proveedor' },
            { data: 'cant_entrada' },
            { data: 'precio_entrada',
                "render": function (data, type, row) {
                    return app.formatoPrecio(row.precio_entrada);
                }
            },
            { data: 'usuario' },
            { data: 'fecha_entrada',
                "render": function (data, type, full, meta) {
                    var cant = full.cant_entrada;
                    var prec = full.precio_entrada;
                    var tot = cant * prec;
                    return app.formatoPrecio(tot);
                }
            },
            { data: 'fecha_entrada',
                "render": function (data, type, full, meta) {
                    return moment(full.fecha_entrada).format('MMM D [del] YYYY, hh:mm A');
                }
            },
            { data: 'tipo',
                 render: (data, type, full, meta) =>
                    `<button class='btn btn-inverse-secondary btn-rounded btn-icon editar p-0' role='button' pos='${meta.row}'><i class='fa fa-eye'></i></button>`
            }
        ];

        app.datatables(cuerpo, datos, columnas);
        app.buscador(lista_productos, app.selectConfig('buscar_productos',true), 1);
        app.cerrar(Modelo.formulario);
        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            lista_productos.empty();
            cajas.empty();
            $(Modelo.formulario).trigger("reset");
            lista_productos.off("select2:select");
            $(Modelo.formulario).off("submit");
            lista_productos.on("select2:select", function (e) {
                const pos = e.params.data.pos ?? '',
                      datos = e.params.data.datos;
                gestionEntradas.logica(lista_productos, datos);
            });
            $(Modelo.formulario).on("submit", function (e) {
                e.preventDefault();
                gestionEntradas.grabar();
            });
            modal.modal('show');
        });
        cuerpo.on('click', '.editar', function (e) {
            const pos = $(this).attr('pos');
            Modelo.pos = pos;
            const lista = Modelo.listaEntradas[pos];
            const total = lista.cant_entrada * lista.precio_entrada;
            const fecha = moment(lista.fecha_entrada).format('MMM D [del] YYYY, hh:mm A');
            Swal.fire({
                title: 'Detalle de entrada',
                width: 'auto',
                confirmButtonText: 'Cerrar',
                html:`
                    <div class="text-start p-5 pb-0">
                        <p><b>Fecha entrada:</b> ${fecha}</p>
                        <p><b>Código:</b> ${lista.codigo_producto}</p>
                        <p><b>Nombre:</b> ${lista.nombre_producto}</p>
                        <p><b>Marca:</b> ${lista.marca} | <b>Modelo:</b> ${lista.modelo}</p>
                        <p><b>Proveedor:</b> ${lista.proveedor} | <b>Ubicación:</b> ${lista.tipo_ubicacion}</p>
                        <p><b>Compra:</b> $${app.formatoPrecio(lista.precio_compra)} | <b>Venta:</b> $${app.formatoPrecio(lista.precio_venta)}</p>
                        <p><b>IVA:</b> ${lista.iva}% | <b>Min:</b> ${lista.stock_min} | <b>Existente:</b> ${lista.stock_existente}</p>
                        <p><b>Cant:</b> ${lista.cant_entrada} | <b>Precio entrada:</b> $${app.formatoPrecio(lista.precio_entrada)}</p>
                        <p class="fw-bold badge badge-success badge-pill"><b>Total:</b> $${app.formatoPrecio(total)}</p>
                    </div> `
            });
        });
        //para carga masiva por excel
        app.carga_excel("entradas", false, gestionEntradas.repuesta_carga);
    },

    grabar: function (e) {
        info.cerrar = false;
        const formulario = $(Modelo.formulario);
        var precio = formulario.find('[precio]').val() || 0;
        var stock_nuevo = formulario.find('[stock_nuevo]').text() || 0;
        var form_data = new FormData(formulario[0]);
        form_data.append('precio', precio);
        form_data.append('stock_nuevo', stock_nuevo);
        form_data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_entrada', form_data, true, app.mensaje);
        app.cerrar(Modelo.formulario);
    },

    logica: function (lista, datos) {
        console.log(datos);
        var cant = $("[cantidad]").val() || 0;
        var precio = $("[precio]").val() || 0;
        //Totales
        var stk_nuevo = (parseFloat(datos.stock_existente) + parseFloat(cant));
        var tot = (cant * precio);
        $("[stock_nuevo]").text(stk_nuevo);
        $("[valor_total]").text(app.formatoPrecio(tot));
        $.each(datos, function (a, b) {
            $('.caja_' + a).text(b);
        });
        $(".caja").change(function (e) {
            e.preventDefault();
            gestionEntradas.logica(lista, datos);
        });
    },
    
    repuesta_carga: function (respuesta) { 
        if (respuesta.codigo !== 1) {
            return Swal.fire({ title: respuesta.mensaje || "Error", icon: 'warning' });
        }
        info.cerrar = true;
        app.cerrar_before();
        Swal.close();
        $("#modal_carga").modal('show');
        // Llenar select de productos
        $(".caja").removeClass("border-danger");
        const $cod = $("[cod]").empty().append('<option value="">--Seleccionar--</option>');
        for (const [_, [val, text]] of Object.entries(respuesta.productos)) {
            $cod.append(new Option(text, val));
        }
        // Pintar tabla
        app.tablas_estados($("[prod]"), respuesta.datos, "prod", true);
        // Botón enviar
        $("#frm_carga").off('click', '.enviar').on('click', '.enviar', e => {
            e.stopImmediatePropagation();
            gestionEntradas.grabar_carga();
        });
    },
    
    grabar_carga: function () {
        let arreglo = [], estado = 0, lista = Modelo.listaEntradas;
        let campos = $("#frm_carga").find('[campos] > tr');
        campos.each(function (tr_idx, tr) {
            let sub = [], fila = tr_idx + 1;
            let cod = "", prov = "";
            $(tr).find('[si="true"]').each(function (td_idx, el) {
                let $el = $(el), val = $el.val(), cls = $el.attr("class") || "";
                sub[td_idx] = val;
                const err = (msg) => {
                    estado++;
                    $el.addClass("border-danger");
                    app.mensaje({codigo: -1, mensaje: `ERROR: ${msg} Fila: ${fila}`});
                };
                //verificar si tiene código
                if (cls.includes("cod")) {
                    cod = val;
                    if (!val) err("Se necesita producto.");
                    else $el.removeClass("border-danger");
                }
            });
            arreglo[tr_idx] = sub;
        });
        if (estado === 0) {
            info.cerrar = false;
            let form_data = new FormData();
            form_data.append('sucursal', sucursal);
            form_data.append('arreglo', JSON.stringify(arreglo));
            app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_cargaEntradas', form_data, true, app.mensaje);
            app.cerrar(Modelo.formulario);
        }
    }, 
};
gestionEntradas.constructor();
