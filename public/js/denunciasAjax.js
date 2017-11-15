base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
function validarDenuncia(denuncia_id,status,razon,td_id,token) {
    url = base_url.concat('/denuncias/validar');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "denuncia_id":denuncia_id,
            "status":status,
            "razon":razon,
            "_token":token
        },
        success: function(data) {
            $('#modal_denuncia_detalles').modal('hide');
            var msg = status == 0 ? 'Rechazada' : 'Procesada';
            swal({
                title: "Bien",
                text: "La denuncia ha sido "+ msg +" correctamente",
                type: "success",
                allowEscapeKey: true,
                allowOutsideClick: true,
                showLoaderOnConfirm: false,
                timer: 2000
            });
            $("tr#"+td_id).find("td").eq(13).text(razon);
            $("tr#"+td_id).find("td").eq(12).children().remove();
            $("tr#"+td_id).find("td").eq(12).append(status == 0 ? '<span class="label label-danger">'+msg+'</span>' : '<span class="label label-success">'+msg+'</span>');
        },
        error: function(xhr, status, error) {
            $('#modal_denuncia_detalles').modal('hide');
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema actualizando el status de la denuncia, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}
