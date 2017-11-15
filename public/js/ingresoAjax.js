base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
function finalizarVisita(ingreso_id,nombre,token) {
    url = base_url.concat('/ingresos/marcar_salida');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "ingreso_id":ingreso_id,
            "_token":token
        },
        success: function(data) {
            swal({
                title: 'Se ha finalizado la visita de <span style="color:#9de0f6">' + nombre + '</span>, esta página se recargará automáicamente ahora',
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
                text: "Se encontró un problema finalizando la visita, porfavor intente otra vez o recargue la página.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}
