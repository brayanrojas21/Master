/* global app */
var Modelo = {
    formulario: "#frm",
    listacaja: [],
    equipos: [],
    opcion: "",
    pos: -1
};

var gestionCaja = {
    constructor: function () {
        gestionCaja.listado_caja();
        $(Modelo.formulario).on('submit', gestionCaja.grabar);
    },
    listado_caja: function (e) {
        var data = new FormData();
        data.append('sucursal', sucursal);
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=listado_caja', data, false, gestionCaja.repuesta_caja);
    },
    repuesta_caja: function (respuesta) {
        //Select
        var lista_clientes = $('[cliente]');
        //tabla
        var multiple = $('.multiple');
        var lista_productos = $('[productos]');
        var cuerpo = $('[cuerpo]');
        var modal = $('#modal');
        var cotizar = $("[cotizar]");
        //Fin tablas estados
        var datos = respuesta.datos;
        var clientes = respuesta.clientes;
        var productos = respuesta.productos;
        info.productos = productos;
        Modelo.listacaja = datos;
        app.abrir_modal();
        //Asignación de datos
        var columnas = [
            { data: 'id_caja' },
            { data: 'nombre' },
            { data: 'usuario' },
            { data: 'fecha' },
            { data: 'usuario',
                "render": function (data, type, full, meta) {
                    return "<a class='btn btn-outline-primary editar p-2' pos= '" + meta.row + "'>Ver más</a>";
                }
            }
        ];
        
        var table = app.datatables(cuerpo, datos, columnas);
        
        //clientes
        for (var i = 0; i < clientes.length; i++) {
            var registro = clientes[i];
            var fila = '<option value="' + registro.id_cliente + '">' + registro.nit_empresa + ' - ' + registro.nombre_empresa + '</option>';
            lista_clientes.append(fila);
        }
        
        app.buscador(multiple, null, 0);
        
        $('[agregar]').on('click', function (e) {
            e.preventDefault();
            $(Modelo.formulario).trigger("reset");
            modal.find(".caja").removeAttr("disabled");
            $('.modal-footer').removeAttr("hidden");
            $(".editable-select").removeAttr("hidden");
            app.tablas_estados(cotizar, "", "cotizar", true);
            multiple.val(null).trigger("change.select2");
            modal.modal('show');
        });

        cuerpo.on('click', '.editar', function (e) {
            var pos = $(this).attr('pos');
            Modelo.pos = pos;
            var lista = Modelo.listacaja[pos];
            app.tablas_estados(cotizar, lista.tabla_productos, "cotizar", true);
            $.each(lista, function (a, b) {
                modal.find('[name="' + a + '"]').val(b).trigger("change.select2");
            });
            modal.find(".caja").attr("disabled", "disabled");
            $('.modal-footer').attr("hidden", "hidden");
            modal.modal('show');
        });
    },

    grabar: function (e) {
        e.preventDefault();
        var formulario = $(Modelo.formulario);
        var campos = formulario.find('[campos] > tr');
        var cadena = "";
        var arreglo = [];
        var prod = "";
        campos.each(function (tr_idx, tr) {
            var sub = [];
            $(tr).children('td').children('[si]').each(function (td_idx, td) {
                var id = $(td).data("id");
                var pos = $(td).data("pos");
                var dat = $(td).val();
                cadena +=  dat + "Ω";
                sub[td_idx] = dat;
                if (id) {
                    prod = info.productos[pos];
                    sub[7] = id;
                }
                //Descontar 
                if ($(td).hasClass("cantidad")) {
                    var cant = $(td).val();
                    var exist = prod.stock_existente;
                    var resta = (parseInt(exist) - parseInt(cant));
                    if (resta < 0) {
                        var camp = tr_idx + 1;
                        app.mensaje({codigo:-1,mensaje:'ERROR: No tienes suficiente stock para la fila #' + camp + ', Solo hay en stock: ' + exist  });
                        $(this).addClass("border-danger");
                    } else {
                        sub[8] = resta;
                        $(this).removeClass("border-danger");
                    }
                }
            });
            cadena +=  "|";
            arreglo[tr_idx] = sub;
        });
        cadena = cadena.slice(0, -1);
        var form_data = new FormData(formulario[0]);
        form_data.append('cadena', cadena);
        form_data.append('sucursal', sucursal);
        form_data.append('arreglo', JSON.stringify(arreglo));
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=agregar_caja', form_data, true, app.mensaje);
    },

};
gestionCaja.constructor();