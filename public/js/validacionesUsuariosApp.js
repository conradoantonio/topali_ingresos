/*Código para validar el formulario de datos del usuario*/
var inputs = [];
var msgError = '';
var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var regExprNum = /^[0-9]{1,18}$/;
var regExprTelefono = /^[0-9 \- + ( ) \s]{1,22}$/;
var regExprFecha = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/;
var btn_enviar_usuario_app = $("#guardar-datos-usuario");
btn_enviar_usuario_app.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#nombre_completo'), regExprNombre) == false ? inputs.push('Nombre') : ''
    validarInput($('input#correo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#telefono'), regExprTelefono) == false ? inputs.push('Teléfono') : ''
    validarSelect($('select#sexo_id')) == false ? inputs.push('Sexo') : ''
    validarInput($('input#fecha_nacimiento'), regExprFecha) == false ? inputs.push('Fecha de nacimiento') : ''
    validarInput($('input#password'), regExprNombre) == false ? inputs.push('Password') : ''

    if (inputs.length == 0) {
        $('#guardar-datos-usuario').hide();
        $('#guardar-datos-usuario').submit();
    }
    else {
        $('#guardar-datos-usuario').show();
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "input#nombre_completo" ).blur(function() {
    validarInput($(this), regExprNombre);
});
$( "input#correo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#telefono" ).blur(function() {
    validarInput($(this), regExprTelefono);
});
$( "select#sexo_id" ).change(function() {
    validarSelect($(this));
});
$("input#fecha_nacimiento").on('blur change', function(e) {
   validarInput($(this), regExprFecha);
});
$("input#password").on('blur change', function(e) {
   validarInput($(this), regExprNombre);
});

function validarInput (campo,regExpr) {
    if($('form#form_usuarios_app input#id').val() != '' && $(campo).attr('name') == 'password' && $(campo).val() == '') {
        return true;
    } else if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
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
/*Fin de código para validar el formulario de datos del usuario*/
