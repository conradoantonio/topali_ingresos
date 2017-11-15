/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{3,50}$/i;
var regExprPlacas = /^[a-z A-Z \d_\s \-]{0,10}$/i;
var regExprDomicilio = /^([a-z ñ áéíóúäëïöüâêîôûàèìòùç # \d . , : ; &' " /]{2,})$/i;
var btn_guardar_ingreso = $("#guardar-ingreso");
btn_guardar_ingreso.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#visitante'), regExprTexto) == false ? inputs.push('Visitante') : ''
    validarInput($('input#texto_placas'), regExprPlacas) == false ? inputs.push('Placas') : ''
    validarSelect($('select#tipo_visita_id')) == false ? inputs.push('Tipo visita') : ''
    validarSelect($('select#casas')) == false ? inputs.push('Casa') : ''
    validarInput($('input#va_con'), regExprTexto) == false ? inputs.push('¿Con quién va?') : ''
    validarArchivo($('input#foto_personal')) == false ? inputs.push('Foto personalizada') : ''

    if (inputs.length == 0) {
        $('#guardar-ingreso').hide();
        $('#guardar-ingreso').submit();
    } else {
        $('#guardar-ingreso').show();
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

$( "input#visitante" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#texto_placas" ).blur(function() {
    validarInput($(this), regExprPlacas);
});
$( "select#tipo_visita_id" ).change(function() {
    validarSelect($(this));
});
$( "select#casas" ).change(function() {
    validarSelect($(this));
});
$( "input#va_con" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#foto_personal" ).change(function() {
    validarArchivo($(this));
});

function validarInput (campo,regExpr) {
    if (!$(campo).val().match(regExpr)) {
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

$('input#foto_personal').bind('change', function() {
    if ($(this).val() != '') {

        kilobyte = (this.files[0].size / 1024);
        mb = kilobyte / 1024;

        archivo = $(this).val();
        extension = archivo.split('.').pop().toLowerCase();

        if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
            swal({
                title: "Archivo no válido",
                text: "Debe seleccionar una imágen con formato jpg, jpeg o png, y debe pesar menos de 5MB",
                type: "error",
                confirmButtonText: 'Aceptar',
                allowEscapeKey: false
            });
        }
    }
});

function validarArchivo(campo) {
    archivo = $(campo).val();
    extension = archivo.split('.').pop().toLowerCase();

    if ($(campo).val() == '' || $(campo).val() == null) {
        return true;
    } else if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '<br>';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}
/*Fin del código para validar el archivo que importa datos desde excel*/