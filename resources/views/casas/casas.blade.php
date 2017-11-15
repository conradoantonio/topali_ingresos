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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo-form-usuario-sistema" id="formulario-usuario-sistema">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="titulo-form-usuario-sistema">Nuevo usuario (sistema)</h4>
                </div>
                <form id="form_usuario_sistema" action="<?php echo url();?>/usuarios/sistema/guardar_usuario" enctype="multipart/form-data" method="POST" autocomplete="off">
                    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 hidden">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" id="id" name="id">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 hide">
                                <div class="form-group">
                                    <label for="user">Correo viejo</label>
                                    <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="user">Correo</label>
                                    <input type="text" class="form-control" id="correo_nuevo" name="correo_nuevo" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user">Nombre completo</label>
                                    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Nombre completo">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="input_foto_usuario">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="foto-usuario">Foto usuario</label>
                                    <input type="file" class="form-control" id="foto_usuario" name="foto_usuario">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="foto_usuario">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Foto actual</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="guardar-usuario-sistema">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>Error guardando el usuario.</strong> 
            <br>El nombre de usuario especificado no es válido ya que se encuentra ocupado, trate con uno distinto.
        </div>
    @endif
    <h2>Lista de usuarios del panel</h2>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formulario-usuario-sistema" id="nuevo-usuario"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo usuario (sistema)</button>
                    </div>
                    <div class="grid-body ">
                        <table class="table table-hover" id="example3">
                            <thead class="centered">    
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th class="hide">Foto usuario</th>
                                <th>Privilegios</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody id="tabla-usuarios-sistema" class="">
                                @if(count($usuarios) > 0)                           
                                    @foreach($usuarios as $usuario)
                                        <tr class="" id="{{$usuario->id}}">
                                            <td>{{$usuario->id}}</td>
                                            <td>{{$usuario->nombre_completo}}</td>
                                            <td>{{$usuario->correo}}</td>
                                            <td class="hide">{{$usuario->foto_perfil}}</td>
                                            <td>{{$usuario->privilegios_id}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info editar-usuario">Editar</button>
                                                <button type="button" class="btn btn-danger eliminar-usuario-sistema">Borrar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="5">No hay usuarios disponibles</td>
                                @endif  
                            </tbody>
                        </table>
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
<script src="{{ asset('js/usuariosSistemaAjax.js') }}"></script>
<script src="{{ asset('js/validacionesUsuariosSistema.js') }}"></script>
<script type="text/javascript">

$('#formulario-usuario-sistema').on('hidden.bs.modal', function (e) {
    $('#formulario-usuario-sistema div.form-group').removeClass('has-error');
    $('input#foto_usuario').val('');
    $('input.form-control').val('');
    $('#formulario-usuario-sistema div#usuario_caracteristicas').show();
    $('#formulario-usuario-sistema input#is_admin').prop('checked', false );
});

$('body').delegate('button#nuevo-usuario','click', function() {
    $('input.form-control').val('');
    $('div#foto_usuario').hide();
    $("div#input_foto_usuario").hide();
    $("h4#titulo-form-usuario-sistema").text('Nuevo usuario (sistema)');
});

$('body').delegate('.editar-usuario','click', function() {

    $('input.form-control').val('');
    id = $(this).parent().siblings("td:nth-child(1)").text(),
    nombre_completo = $(this).parent().siblings("td:nth-child(2)").text(),
    correo = $(this).parent().siblings("td:nth-child(3)").text(),
    foto_perfil = $(this).parent().siblings("td:nth-child(4)").text();
    privilegios = $(this).parent().siblings("td:nth-child(5)").text();
    
    $("h4#titulo-form-usuario-sistema").text('Editar usuario');
    $("div#input_foto_usuario").show();
    $("#formulario-usuario-sistema input#id").val(id);
    $("#formulario-usuario-sistema input#correo_nuevo").val(correo);
    $("#formulario-usuario-sistema input#correo_viejo").val(correo);
    $("#formulario-usuario-sistema input#nombre_completo").val(nombre_completo);
    $("#formulario-usuario-sistema select#privilegios_id").val(privilegios);

    $('#formulario-usuario-sistema div#usuario_caracteristicas').hide();

    $('div#foto_usuario').children().children().children().remove('img#foto_usuario');
    $('div#foto_usuario').children().children().append(
        "<img src='<?php echo asset('');?>/"+foto_perfil+"' class='img-responsive img-thumbnail' alt='Responsive image' id='foto_usuario'>"
    );
    $("div#foto_usuario").show();

    $('#formulario-usuario-sistema').modal();
});

$('body').delegate('.eliminar-usuario-sistema','click', function() {
    var correo = $(this).parent().siblings("td:nth-child(3)").text();
    var token = $("#token").val();
    var id = $(this).parent().siblings("td:nth-child(1)").text();

    swal({
        title: "¿Realmente desea eliminar al usuario con el correo <span style='color:#F8BB86'>" + correo + "</span>?",
        text: "¡Cuidado!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, continuar',
        cancelButtonText: 'No, cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
            return new Promise(function (resolve, reject) {
                eliminarUsuarioSistema(id,token);   
            })
        },
        allowOutsideClick: false
    }).catch(swal.noop);
});

</script>
@endsection