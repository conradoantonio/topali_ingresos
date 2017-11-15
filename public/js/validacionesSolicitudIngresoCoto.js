/*Código para validar el formulario de datos del usuario*/
var inputs = [];
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var msgError = '';
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
var btn_enviar = $("#guardar-solicitud");
btn_enviar.on('click', function() {
    inputs = [];
    msgError = '';
var td_buttons_admin = "<button type='button' data-toggle='modal' data-target='#ver_solicitud' class='btn btn-info btn-guardia-clear' id='details-solicitud'>Detalles</button>";

    validarInput($('textarea#mensaje'), regExprTexto) == false ? inputs.push('Mensaje descriptivo') : ''

    if (inputs.length == 0) {
        //$('#guardar-solicitud-ingreso').hide();
        //$('#guardar-solicitud-ingreso').submit();
        $.ajax({
            url:"/solicitud/ingreso/guardar_solicitud",
            method:"POST",
            data:$('#form_usuario_sistema').serialize(),
            success:function(){
                $.ajax({
                    url:window.location.href,
                    method:"GET",
                    success:function(response){
                        console.log(response)
                        var oTable = $('#example3').dataTable();
                        oTable.fnClearTable();
                        $.each(response,function(i,e){
                            if ( response.length > 0 ){
                                if ( response.length > 0 ){
                                    oTable.dataTable().fnAddData( 
                                    [
                                        e.id_solicitud,
                                        e.nombre_persona,
                                        td_buttons_admin
                                    ] );      
                                }  
                            }
                        })
                    }
                })  
                clean();
            }
        })
    } else {
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "textarea#mensaje" ).blur(function() {
    validarInput($(this), regExprTexto);
});

function validarInput (campo,regExpr) {
    if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}
/*Fin de código para validar el formulario de datos del usuario*/
