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
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <strong>Solo se permite editar y crear usuarios administradores en este módulo.</strong> 
        <br>Para modificar un administrador de coto, porfavor vaya al módulo "Administrar servicios"
         @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>Error guardando el usuario.</strong> 
                <br>El nombre de usuario especificado no es válido ya que se encuentra ocupado, trate con uno distinto.
            </div>
        @endif
    </div>
    <div class="row normal-margin">
        <h2 class="title-guardia">Lista de usuarios del panel</h2>    
        <!--<button type="button" class="btn btn-primary btn-guardia-edit btn-guardia-nuevo" data-target="#formulario-usuario-sistema" id="nuevo-usuario">Exportar</button>-->
    </div>
    
    <div class="col-md-6">
        <form id="form_usuario_sistema" onsubmit="return false;" action="<?php echo url();?>/usuarios/sistema/guardar_usuario" enctype="multipart/form-data" method="POST" autocomplete="off">
            <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 hidden">
                        <div class="form-group">
                            <label class="left" for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Nombre completo">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Correo</label>
                            <input type="text" class="form-control" id="correo_nuevo" name="correo_nuevo" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 hide">
                        <div class="form-group">
                            <label class="left" for="user">Correo viejo</label>
                            <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="password">Contraseña</label>
                            <input type="" class="form-control" id="password" name="password" placeholder="Contraseña">
                        </div>
                    </div>
                </div>
                <div class="row hide">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Tipo de usuario</label>
                            <select class="form-control" id="privilegios_id" name="privilegios_id">
                                <option value="0">Elija una opción</option>
                                <option value="1" selected>Superadministrador</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row hide" id="input_foto_usuario">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="foto-usuario">Foto usuario</label>
                            <input type="file" class="form-control" id="foto_usuario" name="foto_usuario">
                        </div>
                    </div>
                </div>
                <div class="row hide" id="foto_usuario">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label >Foto actual</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <button type="button" class="btn btn-primary btn-guardia-edit" id="guardar-usuario-sistema">Guardar</button>
                <button type="button" class="btn btn-default btn-guardia-clear" id="limpiar">Limpiar</button>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <div class="row-fluid">
            <div class="span12">
                <div class="grid simple ">
                    <div class="grid-title">
                        <!-- <h4>Opciones <span class="semi-bold">adicionales</span></h4> -->
                        <div class="grid-body ">
                            <div class="table-responsive">
                                <table class="table table-hover" id="example3">
                                    <thead class="centered">    
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th class="hide">Email</th>
                                        <th class="hide">Foto usuario</th>
                                        <th class="hide">Privilegio_id</th>
                                        <th class="hide">Privilegio</th>
                                        <th class="hide">Contraseña plana</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="tabla-usuarios-sistema" class="">
                                        @if(count($usuarios) > 0)                           
                                            @foreach($usuarios as $usuario)
                                                <tr class="" id="{{$usuario->id}}">
                                                    <td>{{$usuario->id}}</td>
                                                    <td>{{$usuario->nombre_completo}}</td>
                                                    <td class="hide">{{$usuario->correo}}</td>
                                                    <td class="hide">{{$usuario->foto_perfil}}</td>
                                                    <td class="hide">{{$usuario->privilegios_id}}</td>
                                                    <td class="hide">{{$usuario->tipo}}</td>
                                                    <td class="hide">{{$usuario->contra}}</td>
                                                    <td>
                                                        @if($usuario->privilegios_id == 1)
                                                            <button type="button" class="btn btn-info editar-usuario">Editar</button>
                                                        @endif
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
    $(function() {
        setTimeout(function(){$('input.form-control').val("");},50)
    })
    $('#formulario-usuario-sistema').on('hidden.bs.modal', function (e) {
        $('#formulario-usuario-sistema div.form-group').removeClass('has-error');
        $('input#foto_usuario').val('');
        $('input.form-control').val('');
        $('select.form-control').val(0);
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
        contra_plana = $(this).parent().siblings("td:nth-child(7)").text();
        
        //$("h4#titulo-form-usuario-sistema").text('Editar usuario');
        $("div#input_foto_usuario").show();
        $("#form_usuario_sistema input#id").val(id);
        $("#form_usuario_sistema input#correo_nuevo").val(correo);
        $("#form_usuario_sistema input#correo_viejo").val(correo);
        $("#form_usuario_sistema input#nombre_completo").val(nombre_completo);
        $("#form_usuario_sistema select#privilegios_id").val(privilegios);
        $("#form_usuario_sistema input#password").val(contra_plana);

        //$('#formulario-usuario-sistema div#usuario_caracteristicas').hide();

        /*$('div#foto_usuario').children().children().children().remove('img#foto_usuario');
        $('div#foto_usuario').children().children().append(
            "<img src='<?php echo asset('');?>/"+foto_perfil+"' class='img-responsive img-thumbnail' alt='Responsive image' id='foto_usuario'>"
        );*/
        //$("div#foto_usuario").show();

        //$('#formulario-usuario-sistema').modal();
    });

    $('body').delegate('.eliminar-usuario-sistema','click', function() {
        var correo = $(this).parent().siblings("td:nth-child(3)").text();
        var token = $("#token").val();
        var id = $(this).parent().siblings("td:nth-child(1)").text();

        swal({
            title: "¿Realmente desea eliminar al usuario con el correo <span style='color:#F8BB86'>" + correo + "</span>?",
            text: "¡Este usuario no podrá loguearse nuevamente al sistema!",
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

    $("#limpiar").on('click',function(){
        clean();
    })

    function clean(){
        $('form input, form select, form textarea').each(function(){
        	if ( $(this).attr('id') != "token" ){
        		$(this).val("");
        		$(this).parent().removeClass('has-error');
        	}
            if ( $(this).is('select')  ){
                $(this).val(1);
            }
        })
    }
</script>
@endsection