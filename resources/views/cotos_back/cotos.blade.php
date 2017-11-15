@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
textarea {
    resize: none;
}
th {
    text-align: center!important;
}
/* Change the white to any color ;) */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
</style>
<div class="text-center" style="margin: 20px;">

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_form_coto" id="formulario_coto">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="titulo_form_coto">Nuevo servicio</h4>
                </div>
                <form id="form_coto" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
                    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 hidden">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" id="id" name="id">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre del coto</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Servicio">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label for="telefono_1">Teléfono 1</label>
                                    <input type="text" class="form-control" id="telefono_1" name="telefono_1" placeholder="Teléfono 1">
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="extension_tel_1">Extensión 1</label>
                                    <input type="text" class="form-control" id="extension_tel_1" name="extension_tel_1" placeholder="Extensión">
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label for="telefono_1">Teléfono 2</label>
                                    <input type="text" class="form-control" id="telefono_2" name="telefono_2" placeholder="Teléfono 2">
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="extension_tel_2">Extensión 2</label>
                                    <input type="text" class="form-control" id="extension_tel_2" name="extension_tel_2" placeholder="Extensión">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre_responsable">Nombre del responsable</label>
                                    <input type="text" class="form-control" id="nombre_responsable" name="nombre_responsable" placeholder="Nombre del responsable">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="puesto">Puesto</label>
                                    <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Puesto del responsable">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="contacto">Contacto</label>
                                    <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacto del responsable">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 hide">
                                <div class="form-group">
                                    <label for="correo_viejo">Correo viejo</label>
                                    <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Correo viejo">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo para crear el usuario">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña de usuario">
                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="guardar_coto">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <h2>Lista de Servicios</h2>

    @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>Error:</strong> El Servicio no ha sido creado porque el correo otorgado para crear su usuario no está disponible, trate con uno distinto.
        </div>
    @endif

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formulario_coto" id="nuevo_coto"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Servicio</button>
                    </div>
                    <div class="grid-body ">
                        <table class="table" id="example3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono 1</th>
                                    <th class="hide">Extensión teléfono 1</th>
                                    <th class="hide">Teléfono 2</th>
                                    <th class="hide">Extensión teléfono 2</th>
                                    <th>Responsable</th>
                                    <th class="hide">Puesto</th>
                                    <th class="hide">Contacto</th>
                                    <th class="hide">User id</th>{{-- Borrar si no se ocupa --}}
                                    <th class="hide">Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($cotos) > 0)
                                    @foreach($cotos as $coto)
                                        <tr class="" id="{{$coto->id}}">
                                            <td>{{$coto->id}}</td>
                                            <td>{{$coto->nombre}}</td>
                                            <td>{{$coto->direccion}}</td>
                                            <td>{{$coto->telefono_1}}</td>
                                            <td class="hide">{{$coto->extension_tel_1}}</td>
                                            <td class="hide">{{$coto->telefono_2}}</td>
                                            <td class="hide">{{$coto->extension_tel_2}}</td>
                                            <td>{{$coto->nombre_responsable}}</td>
                                            <td class="hide">{{$coto->puesto}}</td>
                                            <td class="hide">{{$coto->contacto}}</td>
                                            <td class="hide">{{$coto->user_id}}</td>{{-- Borrar si no se ocupa --}}
                                            <td class="hide">{{$coto->correo}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info editar_coto">Editar</button>
                                                <button type="button" class="btn btn-danger eliminar_coto">Borrar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="6">No hay Servicios registrados</td>
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
<script src="{{ asset('js/cotosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesCotos.js') }}"></script>
<script type="text/javascript">
/*var oTable3 = $('#example3').dataTable( {
    "aaSorting": [[ 0, "desc" ]],
            "oLanguage": {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Mostrando <b>_START_ a _END_</b> de _TOTAL_ registros"
    },
});*/

$('#formulario_coto').on('hidden.bs.modal', function (e) {
    $('#formulario_coto div.form-group').removeClass('has-error');
    $('input.form-control, textarea.form-control').val('');
});

$('body').delegate('button#nuevo_coto','click', function() {
    $('input.form-control').val('');
    $('div#foto_coto').hide();
    $("h4#titulo_form_coto").text('Nuevo coto');
    $("form#form_coto").get(0).setAttribute('action', '<?php echo url();?>/administrar/cotos/guardar_coto');
});

$('body').delegate('.editar_coto','click', function() {
    $('input.form-control').val('');
    id = $(this).parent().siblings("td:nth-child(1)").text(),
    nombre = $(this).parent().siblings("td:nth-child(2)").text(),
    direccion = $(this).parent().siblings("td:nth-child(3)").text(),
    telefono_1 = $(this).parent().siblings("td:nth-child(4)").text(),
    extension_tel_1 = $(this).parent().siblings("td:nth-child(5)").text(),
    telefono_2 = $(this).parent().siblings("td:nth-child(6)").text(),
    extension_tel_2 = $(this).parent().siblings("td:nth-child(7)").text(),
    nombre_responsable = $(this).parent().siblings("td:nth-child(8)").text(),
    puesto = $(this).parent().siblings("td:nth-child(9)").text(),
    contacto = $(this).parent().siblings("td:nth-child(10)").text();
    user_id = $(this).parent().siblings("td:nth-child(11)").text();
    correo = $(this).parent().siblings("td:nth-child(12)").text();

    $("h4#titulo_form_coto").text('Editar coto');
    $("form#form_coto").get(0).setAttribute('action', '<?php echo url();?>/administrar/cotos/editar_coto');
    $("#formulario_coto input#id").val(id);
    $("#formulario_coto input#nombre").val(nombre);
    $("#formulario_coto textarea#direccion").val(direccion);
    $("#formulario_coto input#telefono_1").val(telefono_1);
    $("#formulario_coto input#extension_tel_1").val(extension_tel_1);
    $("#formulario_coto input#telefono_2").val(telefono_2);
    $("#formulario_coto input#extension_tel_2").val(extension_tel_2);
    $("#formulario_coto input#nombre_responsable").val(nombre_responsable);
    $("#formulario_coto input#puesto").val(puesto);
    $("#formulario_coto input#contacto").val(contacto);
    //$("#formulario_coto input#user_id").val(user_id);
    $("#formulario_coto input#correo_viejo").val(correo);
    $("#formulario_coto input#correo").val(correo);

    $('#formulario_coto').modal();
});

$('body').delegate('.eliminar_coto','click', function() {
    var nombre = $(this).parent().siblings("td:nth-child(2)").text();
    var token = $("#token").val();
    var user_id = $(this).parent().siblings("td:nth-child(11)").text();

    swal({
        title: "¿Realmente desea eliminar al coto llamado <span style='color:#F8BB86'>" + nombre + "</span>?",
        text: "¡También se eliminará el usuario relacionado a este coto y todos los subcotos pertenecientes a este, cuidado!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, continuar',
        cancelButtonText: 'No, cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
            return new Promise(function (resolve, reject) {
                eliminarCoto(user_id,token); 
            })
        },
        allowOutsideClick: false
    }).catch(swal.noop);
});

</script>
@endsection