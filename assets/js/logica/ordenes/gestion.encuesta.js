var gestionEncuesta = {
    constructor: function () {
        $('body').removeClass("nooverflow");
        $('#frm').on('submit', gestionEncuesta.validarEncuesta);
    },
    validarEncuesta: function (e) {
        e.preventDefault();
        var urlParams = new URLSearchParams(window.location.search);
        var pqr = $("[name=pqr]").val();
        var campos = ["uno", "dos", "tres", "cuatro"];
        var cadena = "";
        $.each(campos, function (tr_idx, tr) {
            var valores = $("[name='" + tr + "']:checked").val();
            cadena += valores + "|";

        });
        cadena += pqr;
        var form_data = new FormData();
        form_data.append('cadena', cadena);
        form_data.append('id', urlParams.get('o'));
        app.ajax('controlador/GestionUsuarioControlador.php?opcion=Encuesta', form_data, true, gestionEncuesta.repuestaEncuesta);
    },

    repuestaEncuesta: function (respuesta) {
        if (respuesta.codigo == 1) {
            swal.close();
            $("#frm").html("<h1 class='text-center'>Gracias por completar la encuesta de su orden de servicio!.</h1>");
            setTimeout(function () {
                document.location.reload()
            }, 6000);
        } else {
            app.mensaje({
                codigo: -1,
                mensaje: respuesta.mensaje
            });
        }
    }
};
gestionEncuesta.constructor();
