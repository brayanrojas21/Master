/* global app */
var Modelo = {
    formulario: "#frm",
    listaProductos: [],
    equipos: [],
    opcion: "",
    tipo: "",
    pos: -1
};

var gestionProductos = {
    constructor: function () {
        gestionProductos.listado_productos();
        $(Modelo.formulario).on('submit', gestionProductos.grabar);
    },
    listado_productos: function (e) {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_productos', data, false, gestionProductos.repuesta_productos);
    },
    repuesta_productos: function (respuesta) {
        const { datos, proveedores, ubicaciones } = respuesta;
        const lista_proveedor = $('[proveedor]');
        const lista_ubicacion = $('[ubicacion]');
        const cuerpo = $('[productos]');
        const lista_marcas = $('[marcas]');
        const multiple = $('.multiple');
        const modal = $('#modal_productos');
        Modelo.listaProductos = datos;
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone(".imagen_producto", dropconfig);

        const columnas = [
            {
                data: 'imagen_producto',
                render: (data, type, full) => {
                    const img = full.imagen ? `./assets/images/productos/${full.imagen_producto}` : './assets/images/imagen_blanco.jpg';
                    return `<img class='rounded img-fluid' src='${img}' />`;
                }
            },
            { data: 'codigo_producto' },
            { data: 'nombre_producto' },
            { data: 'precio_compra',
                "render": function (data, type, row) {
                    return app.formatoPrecio(row.precio_compra);
                }
            },
            { data: 'precio_venta',
                "render": function (data, type, row) {
                    return app.formatoPrecio(row.precio_venta);
                }
            },
            { data: 'stock_existente' },
            { data: 'proveedor' },
            { data: 'ubicacion' },
            {
                data: 'tipo',
                render: (data, type, full, meta) =>
                    `<button class='btn btn-inverse-secondary btn-rounded btn-icon editar' role='button' pos='${meta.row}'><i class='fa fa-pencil'></i></button>`
            }
        ];
        app.datatables(cuerpo, datos, columnas);
        app.buscador(multiple, null, 0);
        app.buscador(lista_marcas, app.selectConfig('buscar_marcas'), 1);
        app.crearModal("marcas");
        proveedores.forEach(p => {
            lista_proveedor.append(`<option value="${p.id_proveedor}" data-id="${p.nit}">${p.nit} - ${p.nombre_proveedor}</option>`);
        });
        ubicaciones.forEach(u => {
            lista_ubicacion.append(`<option value="${u.id_ubicacion}">${u.tipo_ubicacion} - ${u.numeracion}</option>`);
        });
        $('[agregar]').on('click', e => {
            e.preventDefault();
            Modelo.opcion = "agregar_producto";
            $(Modelo.formulario).trigger("reset");
            app.imagenes(myDropzone, "", "productos", true);
            lista_marcas.empty();
            app.desbloquearNoMod();
            modal.modal('show');
        });
        cuerpo.on('click', '.editar', function () {
            Modelo.opcion = "editar_producto";
            const pos = $(this).attr('pos');
            Modelo.pos = pos;
            const item = Modelo.listaProductos[pos];
            app.imagenes(myDropzone, item.imagen_producto, "productos", true);
            lista_marcas.append(new Option(item.marca, item.marca));
            $.each(item, (k, v) => $('[name="' + k + '"]').val(v).trigger("change.select2"));
            app.abririmagen();
            app.bloquearNoMod();
            modal.modal('show');
        });
        //para carga masiva por excel
        app.carga_excel("productos", true, gestionProductos.repuesta_carga);
    },
    
    repuesta_carga: function (respuesta) { 
        if (respuesta.codigo != 1) {
            return Swal.fire({ title: respuesta.mensaje, icon: 'warning' });
        }
        info.cerrar = true;
        app.cerrar_before();
        Swal.close();
        var precios = respuesta.precios;
        $("#modal_carga").modal('show');
        var prod = $("[prod]");
        var titulo = (precios == "true") ? "Actualizar precios" : "Cargar productos";
        $(".modal-title").text(titulo);
        if(precios == "true") {
            var arrg = [];
            var aa = 0;
            $.each(Modelo.listaProductos, function (a, b) {
                $.each(respuesta.datos, function (c, d) {
                    if (b.codigo_producto == d[0] && b.nit_proveedor == d[5]) {
                        arrg[aa] = respuesta.datos[c];
                        aa++;
                    }
                    if (d[5] == "") {
                        app.mensaje({codigo: -1, mensaje: 'Se necesita Nit del proveedor para actualizar precios.'});
                    }
                });
            });
            Modelo.tipo = "actualizar_precios";
            app.tablas_estados(prod, arrg, "prod", true);
            $(".act").attr("disabled","disabled");
        } 
        if (precios == "false"){
            Modelo.tipo = "grabar_carga";
            app.tablas_estados(prod, respuesta.datos, "prod", true);
            $(".act").removeAttr("disabled");
        }
        $("#frm_carga").off('click', '.enviar').on('click', '.enviar', function (e) {
            e.stopImmediatePropagation();
            gestionProductos.grabar_carga(precios);
        });
    },
    
    grabar: function (e) {
        e.preventDefault();
        const formulario = $(Modelo.formulario)[0];
        const { pos, opcion, listaProductos } = Modelo;
        const datos = listaProductos[pos] || {};
        const codigo = $("#codigo_producto").val();
        const proveedor = $("#id_proveedor").val();
        const imagen = $('#imagen_producto')[0].dropzone.files;
        const imagen_nombre = (imagen.length > 0) ? imagen[0].name : "";
        const id = opcion === "editar_producto" ? datos.id_productos : 0;
        // Validar duplicado
        if (listaProductos.some(e => e.codigo_producto == codigo && e.id_proveedor == proveedor)) {
            return app.mensaje({ codigo: -1, mensaje: `ERROR: Ya existe el producto con proveedor.` });
        }
        // Crear form data
        const form_data = new FormData(formulario);
        form_data.append('imagen_producto', imagen);
        form_data.append('imagen_nombre', imagen_nombre ?? "");
        form_data.append('sucursal', sucursal);
        form_data.append('id_productos', id);
        form_data.append('gestion', opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_producto', form_data, true, app.mensaje);
    },
    
    grabar_carga: function (precios) {
        let arreglo = [], estado = 0, lista = Modelo.listaProductos;
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
                    if (!val) err("Se necesita CÓDIGO.");
                    else $el.removeClass("border-danger");
                }
                //verificar si tiene proveedor
                if (cls.includes("provee")) {
                    prov = val;
                    if (!val) err("Se necesita proveedor.");
                    else $el.removeClass("border-danger");
                }
                if (cls.includes("ubica") && !val) err("Se necesita ubicación.");
            });
            // Validación combinada código + proveedor
            if (Modelo.tipo === "grabar_carga" && cod && prov) {
                const existe = lista.some(e => e.codigo_producto == cod && e.id_proveedor == prov);
                if (existe) {
                    estado++;
                    $(tr).addClass("table-danger"); 
                    $(tr).find('input, select, textarea').first().focus();
                    app.mensaje({codigo: -1, mensaje: `ERROR: Ya existe producto con proveedor. Fila: ${fila}`});
                } else {
                    $(tr).removeClass("table-danger"); 
                }
            }
            arreglo[tr_idx] = sub;
        });
        if (Modelo.tipo === "actualizar_precios") {
            arreglo.forEach(data => {
                let match = lista.find(e => data[0] == e.codigo_producto && data[5] == e.id_proveedor);
                if (match) data[9] = match.id_productos;
            });
        }
        if (estado === 0) {
            info.cerrar = false;
            let form_data = new FormData();
            form_data.append('sucursal', sucursal);
            form_data.append('arreglo', JSON.stringify(arreglo));
            form_data.append('tipo', Modelo.tipo);
            app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_cargaProductos', form_data, true, app.mensaje);
            app.cerrar(Modelo.formulario);
        }
    }, 

};
gestionProductos.constructor();
