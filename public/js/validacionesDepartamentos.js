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
var btn_enviar_producto = $("#guardar_departamento");
btn_enviar_producto.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#nombre_departamento'), regExprTexto) == false ? inputs.push('Nombre departamento') : ''
    validarInput($('textarea#direccion'), regExprDomicilio) == false ? inputs.push('Dirección') : ''
    validarInput($('input#telefono_1'), regExprTel) == false ? inputs.push('Teléfono 1') : ''
    validarInput($('input#extension_tel_1'), regExprTel) == false ? inputs.push('Extensión teléfono 1') : ''
    validarInput($('input#telefono_2'), regExprTel) == false ? inputs.push('Teléfono 2') : ''
    validarInput($('input#extension_tel_2'), regExprTel) == false ? inputs.push('Extensión teléfono 2') : ''
    validarInput($('input#nombre_responsable'), regExprTexto) == false ? inputs.push('Nombre responsable') : ''
    validarInput($('input#puesto'), regExprTexto) == false ? inputs.push('Puesto') : ''
    validarInput($('input#contacto'), regExprTexto) == false ? inputs.push('Contacto') : ''
    validarSelect($('select#negocios_id')) == false ? inputs.push('Negocio id') : ''
    validarInput($('input#correo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#password'), regExprTexto) == false ? inputs.push('Password') : ''

    if (inputs.length == 0) {
        $('#guardar_departamento').hide();
        $('#guardar_departamento').submit();
    } else {
        $('#guardar_departamento').show();
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

$( "input#nombre_departamento" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "textarea#direccion" ).blur(function() {
    validarInput($(this), regExprDomicilio);
});
$( "input#telefono_1" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#extension_tel_1" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#telefono_2" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#extension_tel_2" ).blur(function() {
    validarInput($(this), regExprTel);
});
$( "input#nombre_responsable" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#puesto" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#contacto" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "select#negocios_id" ).change(function() {
    validarSelect($(this));
});
$( "input#correo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password" ).blur(function() {
    validarInput($(this), regExprTexto);
});

function validarInput (campo,regExpr) {
    if(($(campo).attr('name') == 'extension_tel_1' && $(campo).val() == '') || 
    ($(campo).attr('name') == 'extension_tel_2' && $(campo).val() == '') ||
    ($(campo).attr('name') == 'telefono_2' && $(campo).val() == '')) {
        $(campo).parent().removeClass("has-error");
        return true;
    } else if ($(campo).attr('name') == 'password' && $(campo).val() == '' && $("#formulario_departamento input#id").val() != '') {
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
        msgError = msgError + $(select).parent().children('label').text() + '<br>';
        return false;
    } else {
        $(select).parent().removeClass("has-error");
        return true;
    }
}