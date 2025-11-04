/* global app */
var Modelo = {
    formulario: "#frm",
    listaProveedores: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionProveedores = {
    constructor: function () {
        gestionProveedores.listado_proveedores();
        $(Modelo.formulario).on('submit', gestionProveedores.grabar);
    },
    listado_proveedores: function (e) {
        var data = {};
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_proveedores', data, false, gestionProveedores.repuesta_proveedores);
    },
    repuesta_proveedores: function (respuesta) {
        //tabla
        var multiple = $('.multiple');
        var cuerpo = $('[cuerpo]');
        var modal = $('#modal');
        //Fin tablas estados
        var datos = respuesta.datos;
        Modelo.listaProveedores = datos;
        //Asignación de datos
        var columnas = [
            { data: 'nit' },
            { data: 'nombre_proveedor' },
            { data: 'nombre_contacto' },
            { data: 'telefono_contacto' },
            { data: 'correo_electronico' }, 
            { data: 'correo_electronico',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>Editar</a>";
                }
            }
        ];

        app.datatables(cuerpo, datos, columnas);
        app.buscador(multiple, null, 0);

        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            multiple.val(null).trigger("change.select2");
            Modelo.opcion = "agregar_proveedor";
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            Modelo.pos = pos;
            var lista = Modelo.listaProveedores[pos];
            $.each(lista, function (a, b) {
                console.log(a);
                modal.find('[name="' + a + '"]').val(b).trigger("change.select2");
            });
            Modelo.opcion = "editar_proveedor";
            modal.modal('show');
        });
    },

    grabar: function (e) {
        e.preventDefault();
        const formulario = $(Modelo.formulario);
        var pos = Modelo.pos;
        var datos = Modelo.listaProveedores[pos];
        var id = (Modelo.opcion == "editar_proveedor") ? datos.id_proveedor : 0;
        var form_data = new FormData(formulario[0]);
        form_data.append('id_proveedor', id);
        form_data.append('gestion', Modelo.opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_proveedor', form_data, true, app.mensaje);
    },


};
gestionProveedores.constructor();
