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

    <div class="modal fade text-left" ref="ingreso-detalles" id="ingreso-detalles" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Detalles de ingreso</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="div_ingreso_id">
                                <p class="form-control-static bold">Id ingreso: <span class="normal" id="ingreso_id"></span></p>
                            </div>
                            <div class="div_ingresante">
                                <p class="form-control-static bold">Nombre del ingresante: <span class="normal" id="ingresante"></span></p>
                            </div>
                            <div class="div_texto_placa">
                                <p class="form-control-static bold">Placas: <span class="normal" id="texto_placa"></span></p>
                            </div>
                            <div class="div_coto">
                                <p class="form-control-static bold">Servicio: <span class="normal" id="coto"></span></p>
                            </div>
                            <div class="div_casa_folio">
                                <p class="form-control-static bold">Casa: <span class="normal" id="casa_folio"></span></p>
                            </div>
                            <div class="div_espacios">
                                <p class="form-control-static bold">Espacios: <span class="normal" id="texto_espacios"></span></p>
                            </div>
                            <div class="div_tipo_visita">
                                <p class="form-control-static bold">Tipo visita: <span class="normal" id="tipo_visita"></span></p>
                            </div>
                            <div class="div_va_con">
                                <p class="form-control-static bold">Fue con: <span class="normal" id="va_con"></span></p>
                            </div>
                            <div class="div_comentarios">
                                <p class="form-control-static bold">Comentarios: <span class="normal" id="comentarios"></span></p>
                            </div>
                            <div class="div_fecha_ingreso">
                                <p class="form-control-static bold">Fecha y hora del ingreso: <span class="normal" id="fecha_ingreso"></span></p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-12 text-center div_foto_identificacion">
                            <label class="bold">Foto identificación</label>
                            <img id="foto_identificacion" style="width: 100%" src="">
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-12 text-center div_foto_personal">
                            <label class="bold">Foto personal</label>
                            <img id="foto_personal" style="width: 100%" src="">
                        </div>
                    </div>
                </div>
                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
                </div>
            </div>
        </div>
    </div>

	<div class="row normal-margin">
		<h2 class="title-guardia">Lista de ingresos del servicio {{$nom_serv}}</h2>
	</div>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body ">
                        <div class="table-responsive">
                            <table class="table table-guardia" id="example3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ingresante</th>
                                        <th class="hide">Servicio</th>
                                        <th class="hide">Subcoto</th>
                                        <th>Tipo visita</th>
                                        <th class="hide">Comentarios</th>
                                        <th class="hide">Foto identificación</th>
                                        <th class="hide">Foto personal</th>
                                        <th>Fecha y hora</th>
                                        <th class="hide">Persona con la que va</th>
                                        <th class="hide">Casa</th>
                                        <th class="hide">Placa</th>
                                        <th class="hide">Espacios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($ingresos) > 0)
                                        @foreach($ingresos as $ingreso)
                                            <tr class="" id="{{$ingreso->id}}">
                                                <td>{{$ingreso->id}}</td>
                                                <td>{{$ingreso->nombre_persona}}</td>
                                                <td class="hide">{{$ingreso->nombre_coto}}</td>
                                                <td class="hide">{{$ingreso->nombre_subcoto ? $ingreso->nombre_subcoto : 'No aplica'}}</td>
                                                <td>{{$ingreso->tipo_visita}}</td>
                                                <td class="hide">{{$ingreso->comentarios}}</td>
                                                <td class="hide">{{$ingreso->foto_identificacion ? $ingreso->foto_identificacion : '' }}</td>
                                                <td class="hide">{{$ingreso->foto_personal ? $ingreso->foto_personal : '' }}</td>
                                                <td>{{$ingreso->fecha_ingreso}}</td>
                                                <td class="hide">{{$ingreso->va_con}}</td>
                                                <td class="hide">{{$ingreso->folio_casa}}</td>
                                                <td class="hide">{{$ingreso->texto_placa ? $ingreso->texto_placa : 'No aplica'}}</td>
                                                <td class="hide">{{$ingreso->num_lugares}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info ver_detalles_ingreso btn-guardia-edit">Detalles</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="6">No hay ingresos registrados</td>
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
<script src="{{ asset('js/ingresoAjax.js') }}"></script>
{{-- <script src="{{ asset('js/validacionesingresos.js') }}"></script> --}}
<script type="text/javascript">
/*var oTable3 = $('#example3').dataTable( {
    "aaSorting": [[ 0, "desc" ]],
            "oLanguage": {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Mostrando <b>_START_ a _END_</b> de _TOTAL_ registros"
    },
});*/

$('body').delegate('.ver_detalles_ingreso','click', function() {
    $('div.div_foto_identificacion, div.div_foto_personal').removeClass('hide');
    $('input.form-control').val('');
    id = $(this).parent().siblings("td:nth-child(1)").text(),
    nombre_persona = $(this).parent().siblings("td:nth-child(2)").text(),
    nombre_coto = $(this).parent().siblings("td:nth-child(3)").text(),
    nombre_subcoto = $(this).parent().siblings("td:nth-child(4)").text(),
    tipo_visita = $(this).parent().siblings("td:nth-child(5)").text(),
    comentarios = $(this).parent().siblings("td:nth-child(6)").text(),
    foto_identificacion = $(this).parent().siblings("td:nth-child(7)").text(),
    foto_personal = $(this).parent().siblings("td:nth-child(8)").text(),
    fecha_ingreso = $(this).parent().siblings("td:nth-child(9)").text(),
    va_con = $(this).parent().siblings("td:nth-child(10)").text();
    casa_folio = $(this).parent().siblings("td:nth-child(11)").text(),
    texto_placa = $(this).parent().siblings("td:nth-child(12)").text();
    espacios = $(this).parent().siblings("td:nth-child(13)").text();
    
    $("#ingreso-detalles span#ingreso_id").text(id);
    $("#ingreso-detalles span#ingresante").text(nombre_persona);
    $("#ingreso-detalles span#coto").text(nombre_coto);
    $("#ingreso-detalles span#subcoto").text(nombre_subcoto);
    $("#ingreso-detalles span#tipo_visita").text(tipo_visita);
    $("#ingreso-detalles span#comentarios").text(comentarios);

    foto_identificacion ? $("img#foto_identificacion").attr("src", "{{url()}}/" + foto_identificacion) :  $('div.div_foto_identificacion').addClass('hide');
    foto_personal ? $("img#foto_personal").attr("src", "{{url()}}/" + foto_personal) :  $('div.div_foto_personal').addClass('hide');
    
    $("img#foto_personal").attr("src", "{{url()}}/" + foto_personal);
    $("#ingreso-detalles span#fecha_ingreso").text(fecha_ingreso);
    $("#ingreso-detalles span#va_con").text(va_con);
    $("#ingreso-detalles span#casa_folio").text(casa_folio);
    $("#ingreso-detalles span#texto_placa").text(texto_placa);
    $("#ingreso-detalles span#texto_espacios").text(espacios);

    $('#ingreso-detalles').modal();
});

$('body').delegate('.finalizar_visita','click', function() {
    var ingreso_id = $(this).parent().siblings("td:nth-child(1)").text();
    var nombre = $(this).parent().siblings("td:nth-child(2)").text();
    var token = $("#token").val();

    swal({
        title: "¿Realmente desea marcar salida para la persona <span style='color:#F8BB86'>" + nombre + "</span>?",
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
                finalizarVisita(ingreso_id,nombre,token); 
            })
        },
        allowOutsideClick: false
    }).catch(swal.noop);
});

</script>
@endsection