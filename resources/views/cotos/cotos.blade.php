@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<link href="{{asset('plugins/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
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
    <div class="row normal-margin">
        <h2 class="title-guardia">Lista de servicios</h2> 
        <a type="button" class="btn btn-primary btn-guardia-edit btn-guardia-nuevo" href="{{URL::to('/administrar/cotos/add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo servicio</a>   
    </div>

	<div class="filters">
		<form id="filter_form" onsubmit="return false;" class="form-horizontal">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="fecha_inicio" class="label-inline">Fecha inicio</label>
				<div class="input-append success date col-md-10 col-lg-6 no-padding">
				    <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio">
				    <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span> 
				</div>
			</div>
			<div class="form-group">
				<label for="fecha_fin" class="label-inline">Fecha fin</label>
				<div class="input-append success date col-md-10 col-lg-6 no-padding">
				    <input type="type" class="form-control" name="fecha_fin" id="fecha_fin">
				    <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span> 
				</div>
			</div>
			<button id="filtrar" class="btn btn-info">Filtrar</button>
			<button id="exportar" class="btn btn-primary">Exportar</button>
		</form>
	</div>

    @if(isset($_GET['valido']) && $_GET['valido'] == md5('false'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>Error:</strong> El servicio no ha sido creado porque el correo otorgado para crear su usuario no está disponible, trate con uno distinto.
        </div>
    @endif
    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body ">
                        <table class="table" id="example3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th class="hide">Tipo servicio id</th>
                                    <th>Tipo servicio</th>
                                    <th class="hide">Unidad privativa</th>
                                    <th class="hide">Dirección</th>
                                    <th class="hide">Teléfono</th>
                                    <th class="hide">No. lugares</th>
                                    <th class="hide">Responsable</th>
                                    <th class="hide">Correo servicio</th>
                                    <th class="hide">Guardia responsable</th>
                                    <th class="hide">Correo guardia</th>
                                    <th class="hide">Users id</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($cotos) > 0)
                                    @foreach($cotos as $coto)
                                        <tr class="" id="{{$coto->id}}">
                                            <td>{{$coto->id}}</td>
                                            <td>{{$coto->nombre}}</td>
                                            <td class="hide">{{$coto->tipo_servicio}}</td>
                                            <td>{!! ($coto->tipo_servicio == 1 ? "<span class='label label-success'>Coto</span>" : ($coto->tipo_servicio == 2 ?  "<span class='label label-info'>Industria</span>" : ''))!!}</td>
                                            <td class="hide">{{$coto->unidad_privativa}}</td>
                                            <td class="hide">{{$coto->direccion}}</td>
                                            <td class="hide">{{$coto->telefono_1}}</td>
                                            <td class="hide">{{$coto->num_lugares}}</td>
                                            <td class="hide">{{$coto->nombre_responsable}}</td>
                                            <td class="hide">{{$coto->correo_servicio}}</td>
                                            <td class="hide">{{$coto->guardia_responsable}}</td>
                                            <td class="hide">{{$coto->correo_guardia}}</td>
                                            <td class="hide">{{$coto->users_id}}</td>
                                            <td>
                                                <a href="{{URL::to('/administrar/cotos/add').'/'.$coto->id}}"><button type="button" class="btn btn-info editar_coto btn-guardia-edit">Editar</button></a>
                                                <a href="{{URL::to('/ingreso_cotos').'/'.$coto->id}}"><button class="btn btn-info btn-guardia-enter">Ingresos</button></a>
                                                <a href="{{URL::to('/egreso_cotos').'/'.$coto->id}}">
                                                	<button class="btn btn-info btn-guardia-enter">Egresos</button>
                                                </a>
                                                <a href="{{URL::to('/casas_cotos').'/'.$coto->id}}">
                                                	<button class="btn btn-info btn-guardia-enter">Casas</button>
                                                </a>
                                                <button type="button" class="btn btn-danger eliminar_coto btn-guardia-clear">Borrar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="6">No hay servicios registrados</td>
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
<script src="{{ asset('plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript">
/*var oTable3 = $('#example3').dataTable( {
    "aaSorting": [[ 0, "desc" ]],
            "oLanguage": {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Mostrando <b>_START_ a _END_</b> de _TOTAL_ registros"
    },
});*/

$('.input-append.date').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: "yyyy-mm-dd"
});

$("#filtrar").on('click',function(){
	$.ajax({
		url:window.location.href,
		type:"POST",
		data:$('#filter_form').serialize(),
		success:function(response){
			var oTable = $('#example3').dataTable();
            oTable.fnClearTable();
            $.each(response,function(i,e){
                if ( response.length > 0 ){
                    var buttons = "<a href='{{URL::to('/administrar/cotos/add')}}/"+e.id+"'><button type='button' class='btn btn-info editar_coto btn-guardia-edit'>Editar</button></a> <a href='/ingreso_cotos/"+e.id+"'><button class='btn btn-info btn-guardia-enter'>Ingresos</button></a> <a href='/egreso_cotos/"+e.id+"'><button class='btn btn-info btn-guardia-enter'>Egresos</button></a> <a href='/casas_cotos/"+e.id+"'><button class='btn btn-info btn-guardia-enter'>Casas</button></a> <button type='button' class='btn btn-danger eliminar_coto btn-guardia-clear'>Borrar</button>";
                    var servicio;
                    if ( e.tipo_servicio == 1 ){
                    	servicio = "<span class='label label-success'>Coto</span>";
                    } else {
                    	servicio = 'Industria';
                    }
                    oTable.dataTable().fnAddData([
                        e.id,
                        e.nombre,
                        e.tipo_servicio,
                        servicio,
                        e.unidad_privativa,
                        e.direccion,
                        e.telefono_1,
                        e.num_lugares,
                        e.nombre_responsable,
                        e.correo_servicio,
                        e.guardia_responsable,
                        e.correo_guardia,
                        e.users_id,
                        buttons
                    ]);      
                }
            })
            $("#example3 tbody tr td:nth-child(3), table tbody tr td:nth-child(5), table tbody tr td:nth-child(6), table tbody tr td:nth-child(7), table tbody tr td:nth-child(8), table tbody tr td:nth-child(9), table tbody tr td:nth-child(10), table tbody tr td:nth-child(11), table tbody tr td:nth-child(12), table tbody tr td:nth-child(13)").addClass("hide");
		}
	})
})

$("#exportar").on('click',function(){
	var inicio = $("#fecha_inicio").val()?$("#fecha_inicio").val():false;
	var fin = $("#fecha_fin").val()?$("#fecha_fin").val():false;
	window.location.href = "<?php echo url();?>/cotos/exportar/"+inicio+"/"+fin;
})

$('#formulario_coto').on('hidden.bs.modal', function (e) {
    $('#formulario_coto div.form-group').removeClass('has-error');
    $('input.form-control, textarea.form-control').val('');
});


$('body').delegate('.eliminar_coto','click', function() {
    var nombre = $(this).parent().siblings("td:nth-child(2)").text();
    var token = "{!! csrf_token() !!}";
    var user_id = $(this).parent().siblings("td:nth-child(13)").text();

    swal({
        title: "¿Realmente desea eliminar al servicio llamado <span style='color:#F8BB86'>" + nombre + "</span>?",
        text: "¡También se eliminará el usuario relacionado a este servicio, cuidado!",
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