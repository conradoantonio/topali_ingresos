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

    <div class="modal fade text-left" ref="egreso-detalles" id="egreso-detalles" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Detalles de egreso</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-bottom: 10px;">
                            <div class="div_egreso_id">
                                <p class="form-control-static bold">Id egreso: <span class="normal" id="egreso_id"></span></p>
                            </div>
                            <div class="div_hora_ingreso">
                                <p class="form-control-static bold">Hora del ingreso: <span class="normal" id="fecha_ingreso"></span></p>
                            </div>
                            <div class="div_fecha_egreso">
                                <p class="form-control-static bold">Hora del egreso: <span class="normal" id="fecha_egreso"></span></p>
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
                                <p class="form-control-static bold">Espacios: <span class="normal" id="espacios"></span></p>
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
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-12 text-center div_foto_identificacion">
                            <label class="bold">Foto identificación (actual)</label>
                            <img id="foto_identificacion" style="width: 100%" src="">
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-12 text-center div_foto_personal">
                            <label class="bold">Foto personal (actual)</label>
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
        <h2 class="title-guardia">Lista de egresos del servicio {{$nom_serv}}</h2>
        @if( Session::get('privilegio') != "Guardia" )
            @if(count($egresos))
                <div>
                    <a href="{{url()}}/egresos/cotos/excel"><button type="button" class="btn btn-primary btn-guardia-edit btn-guardia-nuevo" id="exportar_egresos_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar egresos</button></a>
                </div>
            @endif
        @endif
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body ">
                        <div class="table-responsive">
                            <table class="table" id="example3">
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
                                        <th>Hora ingreso</th>
                                        <th class="hide">Persona con la que va</th>
                                        <th class="hide">Casa</th>
                                        <th class="hide">Placa</th>
                                        <th>Hora egreso</th>
                                        <th class="hide">Espacios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($egresos) > 0)
                                        @foreach($egresos as $egreso)
                                            <tr class="" id="{{$egreso->id}}">
                                                <td>{{$egreso->id}}</td>
                                                <td>{{$egreso->nombre_persona}}</td>
                                                <td class="hide">{{$egreso->nombre_coto}}</td>
                                                <td class="hide">{{$egreso->nombre_subcoto ? $egreso->nombre_subcoto : 'No aplica'}}</td>
                                                <td>{{$egreso->tipo_visita}}</td>
                                                <td class="hide">{{$egreso->comentarios}}</td>
                                                <td class="hide">{{$egreso->foto_identificacion ? $egreso->foto_identificacion : '' }}</td>
                                                <td class="hide">{{$egreso->foto_personal ? $egreso->foto_personal : '' }}</td>
                                                <td>{{$egreso->fecha_ingreso}}</td>
                                                <td class="hide">{{$egreso->va_con}}</td>
                                                <td class="hide">{{$egreso->folio_casa}}</td>
                                                <td class="hide">{{$egreso->texto_placa ? $egreso->texto_placa : 'No aplica'}}</td>
                                                <td>{{$egreso->hora_egreso}}</td>
                                                <td class="hide">{{$egreso->num_lugares}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info ver_detalles_egreso btn-guardia-clear"> Detalles</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="6">No hay egresos registrados</td>
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
<script type="text/javascript">

$('body').delegate('.ver_detalles_egreso','click', function() {
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
    texto_placa = $(this).parent().siblings("td:nth-child(12)").text(),
    fecha_egreso = $(this).parent().siblings("td:nth-child(13)").text();
    espacios = $(this).parent().siblings("td:nth-child(14)").text();
    
    $("#egreso-detalles span#egreso_id").text(id);
    $("#egreso-detalles span#ingresante").text(nombre_persona);
    $("#egreso-detalles span#coto").text(nombre_coto);
    $("#egreso-detalles span#subcoto").text(nombre_subcoto);
    $("#egreso-detalles span#tipo_visita").text(tipo_visita);
    $("#egreso-detalles span#comentarios").text(comentarios);

    foto_identificacion ? $("img#foto_identificacion").attr("src", "{{url()}}/" + foto_identificacion) :  $('div.div_foto_identificacion').addClass('hide');
    foto_personal ? $("img#foto_personal").attr("src", "{{url()}}/" + foto_personal) :  $('div.div_foto_personal').addClass('hide');
    
    $("img#foto_personal").attr("src", "{{url()}}/" + foto_personal);
    $("#egreso-detalles span#fecha_ingreso").text(fecha_ingreso);
    $("#egreso-detalles span#va_con").text(va_con);
    $("#egreso-detalles span#casa_folio").text(casa_folio);
    $("#egreso-detalles span#texto_placa").text(texto_placa);
    $("#egreso-detalles span#fecha_egreso").text(fecha_egreso);
    $("#egreso-detalles span#espacios").text(espacios);

    $('#egreso-detalles').modal();
});
</script>
@endsection