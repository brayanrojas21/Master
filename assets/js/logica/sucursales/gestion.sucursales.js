/* global app */
var Modelo = {
    formulario: "#frm",
    listaSucursales: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionSucursales = {
    constructor: function () {
        gestionSucursales.listado_sucursales();
        $(Modelo.formulario).on('submit', gestionSucursales.grabar);
    },
    listado_sucursales: function (e) {
        var data = {};
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_sucursales', data, false, gestionSucursales.repuesta_sucursales);
    },
    repuesta_sucursales: function (respuesta) {
        //Select
        var lista_usuarios = $('[usuarios]');
        //tabla
        var multiple = $('.multiple');
        var cuerpo = $('[cuerpo]');
        var modal = $('#modal');
        //Fin tablas estados
        var datos = respuesta.datos;
        var usuarios = respuesta.usuarios;
        Modelo.listaSucursales = datos;
        //Asignación de datos
        var columnas = [
            { data: 'id_sucursal' },
            { data: 'nombre' },
            { data: 'direccion' },
            { data: 'estado' },
            { data: 'nombre',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>Editar</a>";
                }
            }
        ];

        app.datatables(cuerpo, datos, columnas);
        
        //sucursales
        for (var i = 0; i < usuarios.length; i++) {
            var registro = usuarios[i];
            var fila = '<option value="' + registro.id_usuario + '">' + registro.cedula + ' - ' + registro.nombre + ' - ' + registro.apellido + '</option>';
            lista_usuarios.append(fila);
        }
        
        app.buscador(multiple, null, 0);

        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            Modelo.opcion = "agregar_sucursal";
            multiple.val(null).trigger("change.select2");
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            Modelo.pos = pos;
            var lista = Modelo.listaSucursales[pos];
            $.each(lista, function (a, b) {
                modal.find('[name="' + a + '"]').val(b).trigger("change.select2");
            });
            Modelo.opcion = "editar_sucursal";
            modal.modal('show');
        });
    },

    grabar: function (e) {
        e.preventDefault();
        const formulario = $(Modelo.formulario);
        var pos = Modelo.pos;
        var datos = Modelo.listaSucursales[pos];
        var id = (Modelo.opcion == "editar_sucursal") ? datos.id_sucursal : 0;
        var form_data = new FormData(formulario[0]);
        form_data.append('id_sucursal', id);
        form_data.append('gestion', Modelo.opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_sucursales', form_data, true, app.mensaje);
    },


};
gestionSucursales.constructor();