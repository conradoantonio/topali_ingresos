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
            <strong>Error guardando el guardia.</strong> 
            <br>No se ha podido crear la guardia debido a que el correo es inválido o está repetido, porfavor, trate con uno diferente.
        </div>
    @endif

    <h2>Lista de guardias</h2>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="editar-guardia">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Editar guardia</h4>
                </div>
                <form id="form_guardias" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            {!! csrf_field() !!}
                            <div class="col-sm-6 col-xs-12 hidden">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" id="id" name="id">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user">Responsable*</label>
                                    <input type="text" class="form-control" id="responsable" name="responsable" placeholder="Responsable o dueño...">
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
                            @if(count($subcotos))
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Subcoto</label>
                                        <select class="form-control" id="subcoto_id" name="subcoto_id">
                                            <option value="0">Elija una opción</option>
                                            @foreach($subcotos as $subcoto)
                                                <option value="{{$subcoto->id}}">{{$subcoto->nombre_subcoto}}</option>
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
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="user">Correo*</label>
                                    <input type="text" class="form-control" id="correo_nuevo" name="correo_nuevo" placeholder="Correo para el usuario">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password">Contraseña*</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="guardar-datos-guardia">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <button type="button" class="btn btn-primary" id="nuevo_guardia"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo guardia</button>
                    </div>
                    <div class="grid-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="example3">
                                <thead class="centered">    
                                    <th>ID</th>
                                    <th>Responsable</th>
                                    <th class="hide">Coto id</th>
                                    <th class="hide">Coto</th>
                                    <th class="hide">Subcoto id</th>
                                    <th class="hide">Subcoto</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody id="tabla-guardias" class="">
                                    @if(count($guardias) > 0)
                                        @foreach($guardias as $guardia)
                                            <tr>
                                                <td>{{$guardia->id}}</td>
                                                <td>{{$guardia->responsable}}</td>
                                                <td class="hide">{{$guardia->coto_id}}</td>
                                                <td class="hide">{{$guardia->coto_nombre}}</td>
                                                <td class="hide">{{$guardia->subcoto_id ? $guardia->subcoto_id : 'No aplica'}}</td>
                                                <td class="hide">{{$guardia->subcoto_nombre ? $guardia->subcoto_nombre : 'No aplica'}}</td>
                                                <td>{{$guardia->correo}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info editar-guardia" status-guardia="">Editar</button>
                                                    <button type="button" class="btn btn-danger eliminar-guardia">Borrar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="8">No hay guardias disponibles</td>
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

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/validacionesguardias.js') }}"></script>
<script src="{{ asset('js/guardiasAjax.js') }}"></script>
<script>
    /*Código para cuando se ocultan los modal*/
    $('#editar-guardia').on('hidden.bs.modal', function (e) {
        $('#editar-guardia div.form-group').removeClass('has-error');
        $('input.form-control').val('');
    });
    /*Fin de código para cuando se ocultan los modal*/

    $('body').delegate('button#nuevo_guardia','click', function() {
        $("form#form_guardias").get(0).setAttribute('action', '<?php echo url();?>/guardia/guardar_usuario_guardia');
        $('input.form-control').val('');
        $('#editar-guardia select').val(0);
        $("h4#gridSystemModalLabel").text('Nuevo guardia');
        $('#editar-guardia').modal();
    });

    $('body').delegate('.editar-guardia','click', function() {
        $('input.form-control').val('');
        $("form#form_guardias").get(0).setAttribute('action', '<?php echo url();?>/guardia/editar_usuario_guardia');
        
        id = $(this).parent().siblings("td:nth-child(1)").text(),
        responsable = $(this).parent().siblings("td:nth-child(2)").text(),
        coto_id = $(this).parent().siblings("td:nth-child(3)").text(),
        coto = $(this).parent().siblings("td:nth-child(4)").text(),
        subcoto_id = $(this).parent().siblings("td:nth-child(5)").text(),
        subcoto = $(this).parent().siblings("td:nth-child(6)").text(),
        correo = $(this).parent().siblings("td:nth-child(7)").text();

        $("#editar-guardia input#id").val(id);

        $("#editar-guardia input#responsable").val(responsable);
        $("#editar-guardia select#coto_id").val(coto_id);
        $("#editar-guardia select#subcoto_id").val(subcoto_id != 'No aplica' ? subcoto_id : 0);
        $("#editar-guardia input#correo_viejo").val(correo);
        $("#editar-guardia input#correo_nuevo").val(correo);

        $('#editar-guardia').modal();
    });

    $('body').delegate('.eliminar-guardia','click', function() {
        var id = $(this).parent().siblings("td:nth-child(1)").text();
        var guardia = $(this).parent().siblings("td:nth-child(2)").text();
        var token = $("#token").val();

        swal({
            title: "¿Realmente desea eliminar a la guardia <span style='color:#F8BB86'>" + guardia + "</span>?",
            text: "¡También se eliminará los registros relacionados a este usuario, cuidado!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'No, cancelar',
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    eliminarGuardia(id,guardia,token);
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });
</script>
@endsection