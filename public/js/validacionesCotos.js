/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
var regExprDomicilio = /^([a-z ñ áéíóúäëïöüâêîôûàèìòùç # \d . , : ; &' " /]{2,})$/i;
var regExprNum = /^[\d .]{1,}$/i;
var regExprTel = /^[ \- + ( ) \d \s]{3,18}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var btn_enviar_producto = $("#guardar_coto");
btn_enviar_producto.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#nombre'), regExprTexto) == false ? inputs.push('Nombre') : ''
    validarSelect($('select#tipo_servicio')) == false ? inputs.push('Tipo servicio') : ''
    validarInput($('input#unidad_privativa'), regExprTexto) == false ? inputs.push('Unidad privativa') : ''
    validarInput($('textarea#direccion'), regExprDomicilio) == false ? inputs.push('Dirección') : ''
    validarInput($('input#telefono_1'), regExprTel) == false ? inputs.push('Teléfono 1') : ''
    validarInput($('input#nombre_responsable'), regExprTexto) == false ? inputs.push('Nombre responsable') : ''
    validarInput($('input#correo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#password'), regExprTexto) == false ? inputs.push('Password') : ''
    /*Inputs de guardia*/
    validarInput($('input#nombre_responsable_guardia'), regExprTexto) == false ? inputs.push('Nombre responsable guardia') : ''
    validarInput($('input#correo_guardia'), regExprEmail) == false ? inputs.push('Correo guardia') : ''
    validarInput($('input#password_guardia'), regExprTexto) == false ? inputs.push('Password guardia') : ''

    if (inputs.length == 0) {
        //$('#guardar_coto').hide();
        //$('#guardar_coto').submit();
        $.ajax({
            url:$("form#form_coto").attr('action'),
            type:"POST",
            data:$("form#form_coto").serialize(),
            success:function(){
                $.ajax({
                    url:"/administrar/cotos",
                    method:"GET",
                    success:function(response){
                        var buttons_table = "<button type='button' class='btn btn-info btn-guardia-edit' id='details-service'>Editar</button><button type='button' class='btn btn-info btn-guardia-delete' id='delete-service'>Borrar</button>";
                        var oTable = $('#example3').dataTable();
                        oTable.fnClearTable();
                        $.each(response,function(i,e){
                            if ( response.length > 0 ){
                                oTable.dataTable().fnAddData( 
                                [
                                    e.id,
                                    e.nombre,
                                    e.tipo_servicio,
                                    e.unidad_privativa,
                                    e.direccion,
                                    e.telefono_1,
                                    e.num_lugares,
                                    e.nombre_responsable,
                                    e.correo_servicio,
                                    e.guardia_responsable,
                                    e.correo_guardia,
                                    e.id_estado,
                                    e.users_id,
                                    e.contra_user_servicio,
                                    e.contra_guardia,
                                    buttons_table
                                ] );      
                            }
                        })
                        $("table tbody tr td:nth-child(3), table tbody tr td:nth-child(4), table tbody tr td:nth-child(5), table tbody tr td:nth-child(6), table tbody tr td:nth-child(7), table tbody tr td:nth-child(8), table tbody tr td:nth-child(9), table tbody tr td:nth-child(10), table tbody tr td:nth-child(11), table tbody tr td:nth-child(12), table tbody tr td:nth-child(13), table tbody tr td:nth-child(14), table tbody tr td:nth-child(15)").addClass("hide");
                        clean();
                    }
                })
            }
        })
    } else {
        $('#guardar_coto').show();
        swal({
          title: 'Corrija los siguientes campos para continuar: ',
          type: 'error',
          html: '<p>'+msgError+'</p>',
          showCloseButton: true,
          confirmButtonText: 'Aceptar',
        }).catch(swal.noop);
        return false;
    }
});

$( "input#nombre" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "select#tipo_servicio" ).change(function() {
    validarSelect($(this));
});
$( "input#unidad_privativa" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "textarea#direccion" ).blur(function() {
    validarInput($(this), regExprDomicilio);
});
$( "input#telefono_1" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#nombre_responsable" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#correo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password" ).blur(function() {
    validarInput($(this), regExprTexto);
});
/*Inputs de guardia*/
$( "input#nombre_responsable_guardia" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#correo_guardia" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password_guardia" ).blur(function() {
    validarInput($(this), regExprTexto);
});


function validarInput (campo,regExpr) {
    if(($(campo).attr('name') == 'extension_tel_1' && $(campo).val() == '') || 
    ($(campo).attr('name') == 'extension_tel_2' && $(campo).val() == '') ||
    ($(campo).attr('name') == 'telefono_2' && $(campo).val() == '')) {
        $(campo).parent().removeClass("has-error");
        return true;
    } else if (($(campo).attr('name') == 'password' || $(campo).attr('name') == 'password_guardia') && $(campo).val() == '' && $("#formulario_coto input#id").val() != '') {
        $(campo).parent().removeClass("has-error");
        return true;
    } else if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '<br>';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

function validarSelect (select) {
    if ($(select).val() == '0' || $(select).val() == '' || $(select).val() == null) {
        $(select).parent().addClass("has-error");
        msgError = msgError + $(select).parent().children('label').text() + '\n';
        return false;
    } else {
        $(select).parent().removeClass("has-error");
        return true;
    }
}