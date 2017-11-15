/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{3,50}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var btn_guardar_ingreso = $("#guardar-datos-guardia");
btn_guardar_ingreso.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#responsable'), regExprTexto) == false ? inputs.push('Responsable') : ''
    validarSelect($('select#subcoto_id')) == false ? inputs.push('Subcoto') : ''
    validarInput($('input#correo_nuevo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#password'), regExprTexto) == false ? inputs.push('Contraseña') : ''

    if (inputs.length == 0) {
        $('#guardar-datos-guardia').hide();
        $('#guardar-datos-guardia').submit();
    } else {
        console.log(inputs);
        $('#guardar-datos-guardia').show();
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

$( "input#responsable" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "select#subcoto_id" ).change(function() {
    validarSelect($(this));
});
$( "input#correo_nuevo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password" ).blur(function() {
    validarInput($(this), regExprTexto);
});

function validarInput (campo,regExpr) {
    if($('form#form_guardias input#id').val() != '' && $(campo).attr('name') == 'password' && $(campo).val() == '') {
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
    if ($(select).attr('name') == 'subcoto_id' && ($(select).val() == '0' || $(select).val() == '' || $(select).val() == null)) {
        $(select).parent().removeClass("has-error");
        return true;
    } else if ($(select).val() == '0' || $(select).val() == '' || $(select).val() == null) {
        $(select).parent().addClass("has-error");
        msgError = msgError + $(select).parent().children('label').text() + '<br>';
        return false;
    } else {
        $(select).parent().removeClass("has-error");
        return true;
    }
}
/*Fin del código para validar el archivo que importa datos desde excel*/