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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="solicitud-title" id="formulario_solicitud">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="solicitud-title">Nueva solicitud</h4>
                </div>
                <form id="form_usuario_sistema" action="<?php echo url();?>/solicitud/ingreso/guardar_solicitud" enctype="multipart/form-data" method="POST" autocomplete="off">
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
                                    <label>Mensaje</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Describa detalladamente quién va a venir y a qué." rows="5"></textarea>    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="guardar-solicitud-ingreso">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <h2>Solicitudes generales del servicio</h2>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body ">
                        <div class="table-responsive">
                            <table class="table" id="example3">
                                <thead>
                                    <tr>
                                        <th>No. Mensaje</th>
                                        <th>Status</th>
                                        <th>Casa</th>
                                        <th>Mensaje</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($solicitudes) > 0)
                                        @foreach($solicitudes as $solicitud)
                                            <tr>
                                                <td>{{$solicitud->id}}</td>
                                                <td>{!!$solicitud->status == 0 ? "<span class='label'>Pendiente</span>" : "<span class='label label-success'>Atendido</span>"!!}</td>
                                                <td>{{$solicitud->folio_casa}}</td>
                                                <td>{{$solicitud->mensaje}}</td>
                                                <td>
                                                    @if($solicitud->status == 0)
                                                        <button type="button" class="btn btn-info marcar_checada" data-toggle="tooltip" data-placement="top" title="Marcar como atendida"><i class="fa fa-check" aria-hidden="true"></i> </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="5">No hay solicitudes registradas</td>
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
<script src="{{ asset('js/ajaxSolicitudesIngresoCoto.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('body').delegate('.marcar_checada','click', function() {
        var solicitud_ingreso_coto_id = $(this).parent().siblings("td:nth-child(1)").text();
        var casa = $(this).parent().siblings("td:nth-child(3)").text();
        var token = $("#token").val();

        swal({
            title: "¿Realmente desea marcar como aceptada la solicitud de la casa <span style='color:#F8BB86'>" + casa + "</span>?",
            text: "¡No podrá deshacer esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'No, cancelar',
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    checarSolicitudIngresoCoto(solicitud_ingreso_coto_id,casa,token); 
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });
</script>
@endsection