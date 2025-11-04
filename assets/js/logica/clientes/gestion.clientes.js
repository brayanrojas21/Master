/* global app */
var Modelo = {
    formulario: "#frm_clientes",
    listaClientes: [],
    opcion: "",
    pos: -1
};

var gestionClientes = {
    constructor: function () {
        gestionClientes.listado();
        $(Modelo.formulario).on('submit', gestionClientes.grabar);
    },
    listado: function (e) {
        var data = {};
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_clientes', data, false, gestionClientes.repuesta_listado);
    },
    repuesta_listado: function (respuesta) {
        var multiple = $('.multiple');
        var cuerpo = $('table');
        var modal = $('#modal');
        var datos = respuesta.datos;
        var surcursal = respuesta.sucur;
        Modelo.listaClientes = datos;
        //Listados
        var lista_sucur = $('[sucursales]');
        //Asignación de datos
        var columnas = [
            { data: 'nit_empresa' },
            { data: 'nombre_empresa' },
            { data: 'nombre' },
            { data: 'cedula_encargado' },
            { data: 'telefono_encargado' },
            { data: 'correo_electronico' },
            { data: 'estado',
                "render": function (data, type, row) {
                    var clase = (row.estado == "Activo") ? "badge-success" : "bg-danger";
                    return '<label class="badge ' + clase + '" >' + row.estado + '</label>';
                }
            },
            { data: 'estado',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>editar</a>";
                }
            }
        ];
        
        app.datatables(cuerpo, datos, columnas);
        app.buscador(multiple, null, 0);
        
        //sucursales
        for (var i = 0; i < surcursal.length; i++) {
            var registro = surcursal[i];
            var fila = '<option value="' + registro.id_sucursal + '">' + registro.id_sucursal + " - " + registro.nombre  + '</option>';
            lista_sucur.append(fila);
        }
        
        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            multiple.val(null).trigger("change.select2");
            Modelo.opcion = "agregar_cliente";
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            var servicios = $('[name="servicios_aprobados[]"]');
            var sucursales = $('[name="sucursales[]"]');
            Modelo.pos = pos;
            Modelo.opcion = "editar_cliente";
            var lista = Modelo.listaClientes[pos];
            $.each(lista, function (a, b) {
                $('[name="' + a + '"]').val(b);
            });
            servicios.val(JSON.parse(lista.servicios_aprobados)).trigger("change.select2");
            sucursales.val(JSON.parse(lista.sucursales)).trigger("change.select2");
            modal.modal('show');
        });
        
        url = new URL(window.location.href);
        if (url.searchParams.has('mod')) {
            $("[agregar]").click();
        }
        modal.on('click', '[data-bs-dismiss]', function() {
              modal.modal('hide');
          });
    },
    
    grabar: function (e) {
        e.preventDefault();
        var formulario = $(Modelo.formulario);
        var id = 0;
        var pos = Modelo.pos;
        var datos = Modelo.listaClientes[pos];
        var clave = $("#clave_nueva").val() || "";
        var estado = $('#estado').val() || "";
        var form_data = new FormData(formulario[0]);
        if (Modelo.opcion == "editar_cliente") {
            if (clave) {
                form_data.append('encryp', "encryp");
            } else {
                clave = datos.clave;
            }
            form_data.append('clave_nueva', clave);
            id = datos.id_cliente;
        }
        form_data.append('id_cliente', id);
        form_data.append('estado', estado);
        form_data.append('gestion', Modelo.opcion);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=gestionar_cliente', form_data, true, app.mensaje);
    },
};
gestionClientes.constructor();