@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
th {
    text-align: center!important;
}
/* Cambia el color de fondo de los input con autofill */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
</style>
<div class="text-center" style="margin: 20px;">

    @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>Error guardando el casa.</strong> 
            <br>No se ha podido crear la casa debido a que el folio es inválido o está repetido, porfavor, trate con uno diferente.
        </div>
    @endif

    <div class="row normal_margin">
        <div class="col-md-6">
            <h2 class="title-guardia">Lista de casas</h2>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-6">
            <form id="form_casas" action="<?php echo url();?>/casas/guardar_usuario_casa" enctype="multipart/form-data" method="POST" autocomplete="off" onsubmit="return false;">
                    <div class="row left">
                        {!! csrf_field() !!}
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user">Propietario*</label>
                                <input type="text" class="form-control" id="responsable" name="responsable" placeholder="Responsable o dueño...">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 hidden">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="user">Folio casa viejo*</label>
                                <input type="text" class="form-control" id="folio_viejo" name="folio_viejo" placeholder="Folio viejo">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user">Número de casa*</label>
                                <input type="text" class="form-control" id="folio_casa" name="folio_casa" placeholder="Número interior, exterior o clave...">
                            </div>
                        </div>
                        @if(isset($cotos))
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Coto*</label>
                                    <select class="form-control" id="coto_id" name="coto_id">
                                        <option value="0">Elija una opción</option>
                                        @foreach($cotos as $coto)
                                            <option value="{{$coto->id}}">{{$coto->nombre_coto}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-6 col-xs-12 hide">
                            <div class="form-group">
                                <label for="user">Correo viejo*</label>
                                <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Correo viejo">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user">Calle o manzana*</label>
                                <input type="text" class="form-control" id="calle_manzana" name="calle_manzana" placeholder="Calle o manzana">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user">Correo*</label>
                                <input type="text" class="form-control" id="correo_nuevo" name="correo_nuevo" placeholder="Correo para el usuario">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="password">Contraseña*</label>
                                <input type="" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="left">
                        <button type="button" class="btn btn-primary btn-guardia-edit" id="guardar-datos-casa">Guardar</button>
                        <button type="button" class="btn btn-default btn-guardia-clear" id="limpiar">Limpiar</button>
                    </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body">
                        <div class="table-responsive">
                            @include('usuarios.usuariosCasa.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/validacionesCasas.js') }}"></script>
<script src="{{ asset('js/casasAjax.js') }}"></script>
<script>
    $(function(){
        setTimeout(function(){$('.form-control').val("");},50)
    })
    /*Código para cuando se ocultan los modal*/
    $('#editar-casa').on('hidden.bs.modal', function (e) {
        $('#editar-casa div.form-group').removeClass('has-error');
        $('input.form-control').val('');
    });
    /*Fin de código para cuando se ocultan los modal*/
    $('body').delegate('button#exportar_casas_excel','click', function() {
        window.location.href = "<?php echo url();?>/casas/app/exportar_casas_app";
    });

    $('body').delegate('button#nuevo_casa_app','click', function() {
        //$("form#form_casas").get(0).setAttribute('action', '<?php echo url();?>/casas/guardar_usuario_casa');
        $('input.form-control').val('');
        $('#editar-casa select').val(0);
        $("h4#gridSystemModalLabel").text('Nuevo casa (app)');
        $('#editar-casa').modal();
    });

    $('body').delegate('.editar-casa','click', function() {
        $('input.form-control').val('');
        $("form#form_casas").get(0).setAttribute('action', '<?php echo url();?>/casas/editar_usuario_casa');

        id = $(this).parent().siblings("td:nth-child(1)").text(),
        folio = $(this).parent().siblings("td:nth-child(2)").text(),
        responsable = $(this).parent().siblings("td:nth-child(3)").text(),
        coto_id = $(this).parent().siblings("td:nth-child(4)").text(),
        coto = $(this).parent().siblings("td:nth-child(5)").text(),
        subcoto_id = $(this).parent().siblings("td:nth-child(6)").text(),
        subcoto = $(this).parent().siblings("td:nth-child(7)").text(),
        correo = $(this).parent().siblings("td:nth-child(8)").text();
        calle_manzana = $(this).parent().siblings("td:nth-child(9)").text();
        contra_plana = $(this).parent().siblings("td:nth-child(10)").text();
        
        $("#form_casas input#id").val(id);
        $("#form_casas input#folio_casa").val(folio);
        $("#form_casas input#folio_viejo").val(folio);
        $("#form_casas input#responsable").val(responsable);
        $("#form_casas select#coto_id").val(coto_id);
        $("#form_casas select#subcoto_id").val(subcoto_id != 'No aplica' ? subcoto_id : 0);
        $("#form_casas input#correo_viejo").val(correo);
        $("#form_casas input#correo_nuevo").val(correo);
        $("#form_casas input#calle_manzana").val(calle_manzana);
        $("#form_casas input#password").val(contra_plana);

    });

    $("#limpiar").on('click',function(){
        clean();
    })

    $("#guardar-datos-casa").on('click',function(){
        /*$.ajax({
            url:$("form#form_casas").attr('action'),
            method:"POST",
            data:$('#form_casas').serialize(),
            success:function(){
                clean();
                refreshTable();
            }
        })*/
    })

    $('body').delegate('.eliminar-casa','click', function() {
        var id = $(this).parent().siblings("td:nth-child(1)").text();
        var casa = $(this).parent().siblings("td:nth-child(2)").text();
        var responsable = $(this).parent().siblings("td:nth-child(3)").text();
        var token = $("#token").val();

        swal({
            title: "¿Realmente desea eliminar a la casa con el responsable <span style='color:#F8BB86'>" + responsable + "</span>?",
            text: "¡El usuario ya no podrá loguearse nuevamente al sistema ni podrá usarse para referenciar como destino a los usuarios visitantes!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'No, cancelar',
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    eliminarCasa(id,casa,token);
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });

    function clean(){
        $('form input, form select, form textarea').each(function(){
            if($(this).attr('name') != '_token'){
                $(this).val("");
            }
        })
    }

    function refreshTable(){
        $('#example3').fadeOut();
        $('#example3').load("{{ URL::to('/usuarios/casas') }}", function() {
            $('#example3').on( 'destroy.dt', function ( e, settings ) {
                //$(this).off( 'click', );
                $(this).fadeIn();
                $(this).DataTable();
            } );
        });
    }
</script>
@endsection