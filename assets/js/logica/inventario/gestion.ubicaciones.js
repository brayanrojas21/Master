/* global app */
var Modelo = {
    formulario: "#frm",
    listaUbicaciones: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionUbicaciones = {
    constructor: function () {
        gestionUbicaciones.listado_ubicaciones();
        $(Modelo.formulario).on('submit', gestionUbicaciones.grabar);
    },
    listado_ubicaciones: function (e) {
        var data = {};
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_ubicaciones', data, false, gestionUbicaciones.repuesta_ubicaciones);
    },
    repuesta_ubicaciones: function (respuesta) {
        //Select
        var lista_sucursal = $('[sucursal]');
        //tabla
        var multiple = $('.multiple');
        var cuerpo = $('[cuerpo]');
        var modal = $('#modal');
        //Fin tablas estados
        var datos = respuesta.datos;
        var sucursales = respuesta.sucursales;
        Modelo.listaUbicaciones = datos;
        //Asignación de datos
        var columnas = [
            { data: 'tipo_ubicacion' },
            { data: 'numeracion' },
            { data: 'nombre' },
            { data: 'estado' },
            { data: 'nombre',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>Editar</a>";
                }
            }
        ];

        app.datatables(cuerpo, datos, columnas);
        app.buscador(multiple, null, 0);
        
        //sucursales
        for (var i = 0; i < sucursales.length; i++) {
            var registro = sucursales[i];
            var fila = '<option value="' + registro.id_sucursal + '">' + registro.id_sucursal + ' - ' + registro.nombre + '</option>';
            lista_sucursal.append(fila);
        }

        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            Modelo.opcion = "agregar_ubicacion";
            multiple.val(null).trigger("change.select2");
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            Modelo.pos = pos;
            var lista = Modelo.listaUbicaciones[pos];
            $.each(lista, function (a, b) {
                modal.find('[name="' + a + '"]').trigger("change.select2").val(b);
            });
            Modelo.opcion = "editar_ubicacion";
            modal.modal('show');
        });
    },

    grabar: function (e) {
        e.preventDefault();
        const formulario = $(Modelo.formulario);
        var pos = Modelo.pos;
        var datos = Modelo.listaUbicaciones[pos];
        var id = (Modelo.opcion == "editar_ubicacion") ? datos.id_ubicacion : 0;
        var form_data = new FormData(formulario[0]);
        form_data.append('id_ubicacion', id);
        form_data.append('gestion', Modelo.opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_ubicacion', form_data, true, app.mensaje);
    },


};
gestionUbicaciones.constructor();
