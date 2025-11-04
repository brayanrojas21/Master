// Configuración de notificaciones tipo toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true
});

var inicioSesion = {
    constructor: function () {
        //$('.multiple').selectpicker(select);
        $('#frm').on('submit', inicioSesion.validarinicio);
        $('#frm_registro').on('submit', inicioSesion.registro);
    },
    validarinicio: function (e) {
        e.preventDefault();
        var formulario = $('#frm');
        var tipo = formulario.data("tipo");
        var usuario = formulario.find('#usuario').val();
        var clave = formulario.find('#clave').val();
        var form_data = new FormData();
        form_data.append('usuario', usuario);
        form_data.append('tipo', tipo);
        form_data.append('clave', clave);
        inicioSesion.ajax('controlador/GestionUsuarioControlador.php?opcion=iniciarSesion', form_data, true, inicioSesion.repuestaInicio);
    },
    registro: function (e) {
        e.preventDefault();
        var formulario = $('#frm_registro');
        var form_data = new FormData(formulario[0]);
        form_data.append('id_cliente', 0);
        form_data.append('nombre_representante', "");
        form_data.append('telefono_representante', "");
        form_data.append('correo_representante', "");
        form_data.append('gestion', "agregar_cliente");
        form_data.append('estado', "Activo");
        form_data.append('tipo', "registro");
        inicioSesion.ajax('gestionar_cliente', form_data, true, inicioSesion.repuestaInicio);
    },
    ajax: function (url, data, carga, funcion, json, async = true) {
        $.ajax({
            url, type: 'POST', data, async, dataType: "text", contentType: !!json, processData: false, cache: false,
            success: r => funcion(json ? r : JSON.parse(r)),
            error: jqXHR => inicioSesion.mensaje({ 
                codigo: -1, 
                mensaje: 'Error en la petición.'
            })
        });
    },
    mensaje: function (respuesta) {
        Swal.fire({
            title: respuesta.mensaje,
            icon: respuesta.codigo > 0 ? 'success' : 'warning',
            confirmButtonText: respuesta.codigo > 0 ? 'Aceptar' : 'Entendido',
            customClass: {
                confirmButton: 'btn'
            }
        })
    },
    repuestaInicio: function (respuesta) {
        if (respuesta.codigo < 0) {
            inicioSesion.mensaje(respuesta);
        } else {
            Toast.fire({
                icon: 'success',
                title: respuesta.mensaje
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    location.href = "./" + respuesta.href;
                }
            })
        }
    }
};
inicioSesion.constructor();
