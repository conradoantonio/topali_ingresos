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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_form_departamento" id="formulario_departamento">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="titulo_form_departamento">Nuevo departamento</h4>
                </div>
                <form id="form_departamento" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
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
                                    <label for="nombre_departamento">Nombre del departamento</label>
                                    <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento" placeholder="Nombre del departamento">
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
                                    <label for="extension_tel_1">Extensión</label>
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
                                    <label for="extension_tel_2">Extensión</label>
                                    <input type="text" class="form-control" id="extension_tel_2" name="extension_tel_2" placeholder="Extensión">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Negocio al que pertenece</label>
                                    <select class="form-control" id="negocios_id" name="negocios_id">
                                        <option value="0">Elija una opción</option>
                                        @foreach($negocios as $negocio)
                                            <option value="{{$negocio->id}}">{{$negocio->nombre}}</option>
                                        @endforeach
                                    </select>
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
                                    <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacgto del responsable">
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
                        <button type="submit" class="btn btn-primary" id="guardar_departamento">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <h2>Lista de departamentos</h2>

    @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>Error:</strong> El servicio no ha sido creado porque el correo otorgado para crear su usuario no está disponible, trate con uno distinto.
        </div>
    @endif

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formulario_departamento" id="nuevo_departamento"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo departamento</button>
                    </div>
                    <div class="grid-body ">
                        <table class="table" id="example3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre departamento</th>
                                    <th>Dirección</th>
                                    <th>Teléfono 1</th>
                                    <th class="hide">Extensión teléfono 1</th>
                                    <th class="hide">Teléfono 2</th>
                                    <th class="hide">Extensión teléfono 2</th>
                                    <th>Responsable</th>
                                    <th class="hide">Puesto</th>
                                    <th class="hide">Contacto</th>
                                    <th class="hide">negocio ID</th>
                                    <th class="hide">Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($departamentos) > 0)
                                    @foreach($departamentos as $departamento)
                                        <tr class="" id="{{$departamento->id}}">
                                            <td>{{$departamento->id}}</td>
                                            <td>{{$departamento->nombre_departamento}}</td>
                                            <td>{{$departamento->direccion}}</td>
                                            <td>{{$departamento->telefono_1}}</td>
                                            <td class="hide">{{$departamento->extension_tel_1}}</td>
                                            <td class="hide">{{$departamento->telefono_2}}</td>
                                            <td class="hide">{{$departamento->extension_tel_2}}</td>
                                            <td>{{$departamento->nombre_responsable}}</td>
                                            <td class="hide">{{$departamento->puesto}}</td>
                                            <td class="hide">{{$departamento->contacto}}</td>
                                            <td class="hide">{{$departamento->negocios_id}}</td>
                                            <td class="hide">{{$departamento->correo}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info editar_departamento">Editar</button>
                                                <button type="button" class="btn btn-danger eliminar_departamento">Borrar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="7">No hay departamentos registrados</td>
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
<script src="{{ asset('js/departamentosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesDepartamentos.js') }}"></script>
<script type="text/javascript">

$('#formulario_departamento').on('hidden.bs.modal', function (e) {
    $('#formulario_departamento div.form-group').removeClass('has-error');
    $('input.form-control, textarea.form-control').val('');
    $("#formulario_departamento select").val(0);
});

$('body').delegate('button#nuevo_departamento','click', function() {
    $('input.form-control').val('');
    $('div#foto_departamento').hide();
    $("h4#titulo_form_departamento").text('Nuevo departamento');
    $("form#form_departamento").get(0).setAttribute('action', '<?php echo url();?>/administrar/departamentos/guardar_departamento');
});

$('body').delegate('.editar_departamento','click', function() {
    $('input.form-control').val('');
    $("#formulario_departamento select").val(0);
    id = $(this).parent().siblings("td:nth-child(1)").text(),
    nombre_departamento = $(this).parent().siblings("td:nth-child(2)").text(),
    direccion = $(this).parent().siblings("td:nth-child(3)").text(),
    telefono_1 = $(this).parent().siblings("td:nth-child(4)").text(),
    extension_tel_1 = $(this).parent().siblings("td:nth-child(5)").text(),
    telefono_2 = $(this).parent().siblings("td:nth-child(6)").text(),
    extension_tel_2 = $(this).parent().siblings("td:nth-child(7)").text(),
    nombre_responsable = $(this).parent().siblings("td:nth-child(8)").text(),
    puesto = $(this).parent().siblings("td:nth-child(9)").text(),
    contacto = $(this).parent().siblings("td:nth-child(10)").text();
    negocio_id = $(this).parent().siblings("td:nth-child(11)").text();
    correo = $(this).parent().siblings("td:nth-child(12)").text();

    $("h4#titulo_form_departamento").text('Editar departamento');
    $("form#form_departamento").get(0).setAttribute('action', '<?php echo url();?>/administrar/departamentos/editar_departamento');
    $("#formulario_departamento input#id").val(id);
    $("#formulario_departamento input#nombre_departamento").val(nombre_departamento);
    $("#formulario_departamento textarea#direccion").val(direccion);
    $("#formulario_departamento input#telefono_1").val(telefono_1);
    $("#formulario_departamento input#extension_tel_1").val(extension_tel_1);
    $("#formulario_departamento input#telefono_2").val(telefono_2);
    $("#formulario_departamento input#extension_tel_2").val(extension_tel_2);
    $("#formulario_departamento input#nombre_responsable").val(nombre_responsable);
    $("#formulario_departamento input#puesto").val(puesto);
    $("#formulario_departamento input#contacto").val(contacto);
    $("#formulario_departamento select#negocios_id").val(negocio_id);
    $("#formulario_departamento input#correo").val(correo);
    $("#formulario_departamento input#correo_viejo").val(correo);

    $('#formulario_departamento').modal();
});

$('body').delegate('.eliminar_departamento','click', function() {
    var nombre_departamento = $(this).parent().siblings("td:nth-child(2)").text();
    var token = $("#token").val();
    var id = $(this).parent().parent().attr('id');

    swal({
        title: "¿Realmente desea eliminar al departamento llamado <span style='color:#F8BB86'>" + nombre_departamento + "</span>?",
        text: "¡También se eliminará el usuario relacionado a este departamento, cuidado!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, continuar',
        cancelButtonText: 'No, cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
            return new Promise(function (resolve, reject) {
                eliminarDepartamento(id,token); 
            })
        },
        allowOutsideClick: false
    }).catch(swal.noop);
});

</script>
@endsection