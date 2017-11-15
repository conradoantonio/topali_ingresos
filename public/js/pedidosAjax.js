base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista
function obtenerInfoPedido(orden_id,token) {
    url = base_url.concat('/pedidos/obtener_info_pedido');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "orden_id":orden_id,
            "_token":token
        },
        success: function(data) {
            var newData = JSON.parse(data);

            $("table#detalle_pedido tbody").children().remove();
            var items = newData.pedido.line_items.data;
            /*Datos generales*/
            $('p#order_id').text(newData.pedido.id);
            $('p#payment_status').text(newData.pedido.payment_status);
            $('p#currency').text(newData.pedido.currency);
            $('p#total').text('$' + newData.pedido.amount/100);
            
            /*Datos de contacto*/
            $('p#customer_id').text(newData.pedido.customer_info.customer_id);
            $('p#name').text(newData.pedido.customer_info.name);
            $('p#phone').text(newData.pedido.customer_info.phone);
            $('p#email').text(newData.pedido.customer_info.email);
            
            /*Datos de envío*/
            $('p#shpping_c_receiver').text(newData.pedido.shipping_contact.receiver);
            $('p#shpping_c_phone').text(newData.pedido.shipping_contact.phone);
            $('p#num_guia').children().remove();
            $('p#num_guia').append(newData.guia ? '<span class="label label-success">'+newData.guia+'</span>' : '<span class="label label-important">Sin asignar </span>');
            $('p#costo_envio').text('$'+(newData.pedido.shipping_lines.data[0].amount/100));
            $('p#shpping_c_city').text(newData.pedido.shipping_contact.address.city);
            $('p#shpping_c_state').text(newData.pedido.shipping_contact.address.state);
            $('p#shpping_c_country').text(newData.pedido.shipping_contact.address.country);
            $('p#shpping_c_postal_code').text(newData.pedido.shipping_contact.address.postal_code);
            $('p#shipping_c_street1').text(newData.pedido.shipping_contact.address.street1);
            
            /*Detalles de pedido (Productos)*/
            for (var key in items) {
                if (items.hasOwnProperty(key)) {
                    $("table#detalle_pedido tbody").append(
                        '<tr class="" id="">'+
                            '<td class="table-bordered">'+items[key].name+'</td>'+
                            '<td class="table-bordered">$'+(items[key].unit_price / 100)+'</td>'+
                            '<td class="table-bordered">'+(items[key].quantity)+'</td>'+
                            '<td class="table-bordered">$'+((items[key].unit_price * items[key].quantity) / 100)+'</td>'+
                        '</tr>'
                    );
                }
            }
            $("table#detalle_pedido tbody").append(
                '<tr class="" id="">'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td class="bold">Costo de envío</td>'+
                    '<td>$'+(newData.pedido.shipping_lines.data[0].amount/100)+'</td>'+
                '</tr>'+
                '<tr class="" id="">'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td class="bold">Costo total</td>'+
                    '<td>$'+(newData.pedido.amount/100)+'</td>'+
                '</tr>'
            );

            $('div#campos_detalles').removeClass('hide');
            $('div#load_bar').addClass('hide');
        },
        error: function(xhr, status, error) {
            $('#detalles_pedido').modal('hide');
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema obteniendo los detalles de este pedido, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function asignarNumeroGuia(numero_guia,orden_id,td_guia,token) {
    url = base_url.concat('/pedidos/asignar_guia');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "numero_guia":numero_guia,
            "orden_id":orden_id,
            "_token":token
        },
        success: function() {
            swal({
                title: "Bien",
                text: "Número de guía "+ numero_guia +" asignado correctamente",
                type: "success",
                showLoaderOnConfirm: false,
                timer: 2000
            });
            td_guia.children().remove();
            td_guia.append('<span class="label label-success">'+numero_guia+'</span>');
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Ocurrió un problema asignando el número de guía a este pedido, por favor trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}
