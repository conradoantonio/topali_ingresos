base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
function checarSolicitudIngresoCoto(id,nombre,token) {
    url = base_url.concat('/solicitudes/ingreso/checar');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "solicitud_id":id,
            "_token":token
        },
        success: function(data) {
            swal({
                title: 'Se ha marcado como checada esta solicitud <span style="color:#F8BB86">' + nombre + '</span> exitosamente, esta página se recargará automáicamente ahora',
                type: "success",
                showConfirmButton: false,
            }, 
                function() {
                    location.reload();
            });
            setTimeout("location.reload()",1200);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema aprobando esta solicitud, porfavor intente otra vez o recargue la página.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}
