/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{3,50}$/i;
var regExprNum = /^[a-z ñ # 0-9 \s]{1,40}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var btn_guardar_ingreso = $("#guardar-datos-casa");
btn_guardar_ingreso.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#folio_casa'), regExprNum) == false ? inputs.push('Folio') : ''
    validarInput($('input#responsable'), regExprTexto) == false ? inputs.push('Responsable') : ''
    validarInput($('input#correo_nuevo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#password'), regExprTexto) == false ? inputs.push('Contraseña') : ''
    validarInput($('input#calle_manzana'), regExprTexto) == false ? inputs.push('Calle manzana') : ''

    if (inputs.length == 0) {
        $('#guardar-datos-casa').hide();
        $.ajax({
            url:$("form#form_casas").attr('action'),
            method:"POST",
            data:$('#form_casas').serialize(),
            success:function(response){
                var buttons_table = "<button type='button' class='btn btn-info editar-casa btn-guardia-edit'>Editar</button><button type='button' class='btn btn-danger eliminar-casa btn-guardia-delete' status-casa='3'>Borrar</button>";
                var oTable = $('#example3').dataTable();
                oTable.fnClearTable();
                $.each(response,function(i,e){
                    if ( response.length > 0 ){
                        oTable.dataTable().fnAddData( 
                        [
                            e.id,
                            e.folio_casa,
                            e.responsable,
                            e.coto_id,
                            e.coto_nombre,
                            e.subcoto_id,
                            e.subcoto_nombre,
                            e.correo,
                            e.calle_manzana,
                            e.contra,
                            buttons_table
                        ] );      
                    }
                })
                $("table tbody tr td:nth-child(2), table tbody tr td:nth-child(4), table tbody tr td:nth-child(5), table tbody tr td:nth-child(6), table tbody tr td:nth-child(7), table tbody tr td:nth-child(8), table tbody tr td:nth-child(9), table tbody tr td:nth-child(10)").addClass("hide");
                clean();
            }
        })
        //$('#guardar-datos-casa').submit();
    } else {
        console.log(inputs);
        $('#guardar-datos-casa').show();
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

$( "input#folio_casa" ).blur(function() {
    validarInput($(this), regExprNum);
});
$( "input#responsable" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#correo_nuevo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password" ).blur(function() {
    validarInput($(this), regExprTexto);
});
$( "input#calle_manzana" ).blur(function() {
    validarInput($(this), regExprTexto);
});

function validarInput (campo,regExpr) {
    if($('form#form_casas input#id').val() != '' && $(campo).attr('name') == 'password' && $(campo).val() == '') {
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