/* global app */
var Modelo = {
    formulario: "#frm",
    listaEquipos: [],
    listaClientes: [],
    opcion: "",
    pos: -1
};

var gestionEquipos = {
    constructor: function () {
        gestionEquipos.listado();
        $(Modelo.formulario).on('submit', gestionEquipos.grabar);
    },
    listado: function (e) {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_equipos', data, false, gestionEquipos.repuesta_listado);
    },
    repuesta_listado: function (respuesta) {
        var lista_clientes = $('[cliente]');
        var multiple = $('.multiple');
        var cuerpo = $('[cuerpo]');
        var paginacion = $('.product-item-wrapper');
        var modal = $('#modal');
        var datos = respuesta.datos;
        var clientes = respuesta.clientes;
        Modelo.listaEquipos = datos;
        Modelo.listaClientes = clientes;
        // Dropzone initialization
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#imagen", dropconfig);
        //Asignación de datos
        var columnas = [
            { data: 'imagen',
                "render": function (data, type, full, meta) {
                    var imgSrc = full.imagen ? `./assets/images/equipos/${full.imagen}` : './assets/images/imagen_blanco.jpg';
                    return `<img class='rounded img-fluid' src='${imgSrc}' />`;
                }
            },
            { data: 'nombre_empresa' },
            { data: 'tipo_equipo' },
            { data: 'modelo' },
            { data: 'marca' },
            { data: 'serie' },
            { data: 'codigo_interno' },
            { data: 'estado',
                "render": function (data, type, row) {
                    var clase = (row.estado == "activo") ? "badge-success" : "bg-danger";
                    return '<label class="badge ' + clase + '" >' + row.estado + '</label>';
                }
            },
            { data: 'cedula_encargado',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>editar</a>";
                }
            }
        ];
        app.datatables(cuerpo, datos, columnas);
        app.buscador(multiple, null, 0);

        //clientes
        for (var i = 0; i < clientes.length; i++) {
            var registro = clientes[i];
            var fila = '<option value="' + registro.id_cliente + '">' + registro.nit_empresa + ' - ' + registro.nombre_empresa + '</option>';
            lista_clientes.append(fila);
        }

        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            app.imagenes(myDropzone, "" , "equipos", true);
            multiple.val(null).trigger("change.select2");
            Modelo.opcion = "agregar_equipo";
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            Modelo.pos = pos;
            Modelo.opcion = "editar_equipo";
            var lista = Modelo.listaEquipos[pos];
            app.imagenes(myDropzone, lista.imagen , "equipos", true);
            $.each(lista, function (a, b) {
                $('[name="' + a + '"]').val(b).trigger("change.select2");
            });
            app.abririmagen();
            modal.modal('show');
        });
    },

    grabar: function (e) {
        e.preventDefault();
        const formulario = $(Modelo.formulario);
        var pos = Modelo.pos;
        var datos = Modelo.listaEquipos[pos];
        var cliente = $('#id_cliente');
        var imagen = $('#imagen')[0].dropzone.files;
        var imagen_nombre = (imagen.length > 0) ? imagen[0].name : "";
        var estado = $('#estado').val() || "";
        var id_cliente = (cliente[0]) ? cliente.val() || "" :
            (datos) ? datos.id_cliente : "";
        var id = (Modelo.opcion == "editar_equipo") ? datos.id_equipo : 0;
        var form_data = new FormData(formulario[0]);
        form_data.append('imagen', imagen[0]);
        form_data.append('imagen_nombre', imagen_nombre);
        form_data.append('id_equipo', id);
        form_data.append('id_cliente', id_cliente);
        form_data.append('estado', estado);
        form_data.append('gestion', Modelo.opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=grabar_equipo', form_data, true, app.mensaje);
    },
};
gestionEquipos.constructor();