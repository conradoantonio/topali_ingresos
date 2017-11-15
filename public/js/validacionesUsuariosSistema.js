/*Código para validar el formulario de datos del usuario*/
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var inputs = [];
var msgError = '';
var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,150}$/i;
var regExprUser = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_ .]{5,20}$/i;
var regExprEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var btn_enviar_usuario_sistema = $("#guardar-usuario-sistema");

var td_buttons_admin = "<button type='button' class='btn btn-info editar-usuario'>Editar</button><button type='button' class='btn btn-danger eliminar-usuario-sistema'>Borrar</button>";
var td_buttons_common = "<button type='button' class='btn btn-danger eliminar-usuario-sistema'>Borrar</button>";

btn_enviar_usuario_sistema.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#correo_nuevo'), regExprEmail) == false ? inputs.push('Correo') : ''
    validarInput($('input#password'), regExprUser) == false ? inputs.push('Contraseña') : ''
    validarInput($('input#nombre_completo'), regExprNombre) == false ? inputs.push('Nombre completo') : ''
    validarSelect($('select#privilegios_id')) == false ? inputs.push('Privilegios') : ''
    validarArchivo($('input#foto_usuario')) == false ? inputs.push('Imagen') : ''

    if (inputs.length == 0) {
        //$('#guardar-usuario-sistema').hide();
        //$('#guardar-usuario-sistema').submit();
        $.ajax({
            url:$("form#form_usuario_sistema").attr('action'),
            type:"POST",
            data:$("form#form_usuario_sistema").serialize(),
            success:function(){
                $.ajax({
                    url:window.location.href,
                    method:"GET",
                    success:function(response){
                        var oTable = $('#example3').dataTable();
                        oTable.fnClearTable();
                        $.each(response,function(i,e){
                            if ( response.length > 0 ){
                                var actions;
                                if ( e.privilegios_id != 1 ) {
                                    actions = td_buttons_common;
                                } else {
                                    actions = td_buttons_admin;
                                }

                                oTable.dataTable().fnAddData( 
                                [
                                    e.id,
                                    e.nombre_completo,
                                    e.correo,
                                    e.foto_perfil,
                                    e.privilegios_id,
                                    e.tipo,
                                    e.contra,
                                    actions
                                ] );      
                            }
                        })
                        $("table tbody tr td:nth-child(3), table tbody tr td:nth-child(4), table tbody tr td:nth-child(5), table tbody tr td:nth-child(6), table tbody tr td:nth-child(7)").addClass("hide");
                        clean();
                    }
                })
            }
        })
    } else {
        swal({
          title: 'Corrija los siguientes campos para continuar: ',
          type: 'error',
          html: '<p>'+msgError+'</p>',
          showCloseButton: true,
          confirmButtonText: 'Aceptar',
          //allowEscapeKey: false
        }).catch(swal.noop);
        return false;
    }
});

$( "input#correo_nuevo" ).blur(function() {
    validarInput($(this), regExprEmail);
});
$( "input#password" ).blur(function() {
    validarInput($(this), regExprUser);
});
$( "input#nombre_completo" ).blur(function() {
    validarInput($(this), regExprNombre);
});
$( "select#privilegios_id" ).change(function() {
    validarSelect($(this));
});

function validarInput (campo,regExpr) {
    if($('form#form_usuario_sistema input#id').val() != '' && $(campo).attr('name') == 'password' && $(campo).val() == '') {
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

$('input#foto_usuario').bind('change', function() {
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
/*Fin de código para validar el formulario de datos del usuario*/