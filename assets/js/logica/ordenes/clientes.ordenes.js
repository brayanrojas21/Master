/* global app */
var Modelo = {
    pos: -1
};

var gestionOrdenes = {
    constructor: function () {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=clientes_ordenes', data, false, gestionOrdenes.repuesta_listado, false, true);
    },
    repuesta_listado: function (respuesta) {
        var datos = respuesta.datos;
        var cuerpo = $('[cuerpo]');
        var columnas = [
            { data: 'cod_orden' },
            { data: 'tipo_atencion',
                "render": function (data, type, row) {
                    var texto = (row.tipo_atencion == "garantía") ? row.tipo_atencion + ': ' + row.atencion_texto : row.tipo_atencion;
                    return texto;
                }
            },
            { data: 'tipo_equipo' },
            { data: 'modelo' },
            { data: 'marca' },
            { data: 'fecha',
                "render": function (data, type, row) {
                    var fecha = moment(row.fecha).format('MMMM D [del] YYYY, hh:mm A');
                    return fecha ;
                }
            },
            { data: 'estado',
                "render": function (data, type, row) {
                    return '<label class="w-100 text-truncate badge bg-danger" >' + row.estado + '</label>';
                }
            },
            { data: 'fecha_final',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary ver p-2' data-id='" + full.cod_orden + "' pos='" + meta.row + "'>Ver</a>";
                }
            }
        ];
        
        app.datatables(cuerpo, datos, columnas, false);
        $("#example").DataTable({
            responsive: true
          });
        
        cuerpo.on('click', '.ver', function (e) {
            var pos = $(this).attr('pos');
            info.orden = datos[pos];
            app.datosOrdenes();
        });

        $('[pdf]').click(function (e) {
            e.preventDefault();
            var tipo = $(this).attr("tipo");
            var size = $(this).attr("size");
            gestionOrdenes.generarPDF(tipo, size);
        });

      
    },
    generarPDF: function (tipo, size) {
        var form_data = gestionOrdenes.recolectar_datos();
        form_data.append('tipo', tipo);
        form_data.append('size', size);
        app.ajax('./controlador/GestionUsuarioControlador.php?opcion=imprimir_ordenes', form_data, true, app.respuesta_pdf, false, true);
    },
    

};
gestionOrdenes.constructor();
