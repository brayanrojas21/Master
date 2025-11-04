/* global app */
var Modelo = {
    formulario: "#frm",
    listaSalidas: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionSalidas = {
    constructor: function () {
        gestionSalidas.listado_salidas();
    },
    listado_salidas: function (e) {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_salidas', data, false, gestionSalidas.repuesta_salidas);
    },
    repuesta_salidas: function (respuesta) {
        var urlParams = new URLSearchParams(window.location.search);
        //tabla
        var multiple = $('.multiple');
        var cuerpo = $('[salidas]');
        var modal = $('#modal_salidas');
        //Fin tablas estados
        var datos = respuesta.datos;
        Modelo.listaSalidas = datos;
        //Asignación de datos
        var columnas = [
            { data: 'codigo_producto' },
            { data: 'nombre_producto' },
            { data: 'cant_salida' },
            { data: 'precio_venta' },
            { data: 'usuario' },
            { data: 'fecha_salida',
                "render": function (data, type, full, meta) {
                    var cant = full.cant_salida;
                    var prec = full.precio_venta;
                    var tot = cant * prec;
                    return app.formatoPrecio(tot);
                }
            },
            { data: 'fecha_salida',
                "render": function (data, type, full, meta) {
                    return moment(full.fecha_salida).format('MMM D [del] YYYY, hh:mm A');
                }
            },
            {
                data: 'salida',
                render: function (data, type, row) {
                    let suc = urlParams.get('suc') || 0;

                    if (row.id_orden !== null) {
                        return `<a class=' w-100' href='./ordenes?suc=${suc}&orden=${row.cod_orden}' target='_blank'>Orden de servicio #${row.cod_orden}</a>`;
                    } else if (row.id_caja !== null) {
                        return `<a class='  w-100' href='./caja?suc=${suc}&id=${row.id_caja}' target='_blank'>Ver caja</a>`;
                    } else {
                        return `<span class='text-muted'>Sin destino</span>`;
                    }
                }
            },
            { data: 'salida',
                 render: (data, type, full, meta) =>
                    `<button class='btn btn-inverse-secondary btn-rounded btn-icon editar p-0' role='button' pos='${meta.row}'><i class='fa fa-eye'></i></button>`
            }
        ];

        app.datatables(cuerpo, datos, columnas);
        
        cuerpo.on('click', '.editar', function (e) {
            const pos = $(this).attr('pos');
            Modelo.pos = pos;
            const lista = Modelo.listaSalidas[pos];
            const total = lista.cant_salida * lista.precio_venta;
            const fecha = moment(lista.fecha_salida).format('MMM D [del] YYYY, hh:mm A');
            Swal.fire({
                title: 'Detalle de salida',
                width: 'auto',
                confirmButtonText: 'Cerrar',
                html:`
                    <div class="text-start p-5 pb-0">
                        <p><b>Fecha salida:</b> ${fecha}</p>
                        <p><b>Código:</b> ${lista.codigo_producto}</p>
                        <p><b>Nombre:</b> ${lista.nombre_producto}</p>
                        <p><b>Marca:</b> ${lista.marca} | <b>Modelo:</b> ${lista.modelo}</p>
                        <p><b>Proveedor:</b> ${lista.proveedor} | <b>Ubicación:</b> ${lista.tipo_ubicacion}</p>
                        <p><b>Compra:</b> $${app.formatoPrecio(lista.precio_compra)}</p>
                        <p><b>IVA:</b> ${lista.iva}% | <b>Stock Min:</b> ${lista.stock_min} | <b>Existente:</b> ${lista.stock_existente}</p>
                        <p><b>Cant:</b> ${lista.cant_salida} | <b>Precio venta:</b> $${app.formatoPrecio(lista.precio_venta)}</p>
                        <p class="fw-bold badge badge-success badge-pill"><b>Total:</b> $${app.formatoPrecio(total)}</p>
                    </div> `
            });
        });
    },
};
gestionSalidas.constructor();
