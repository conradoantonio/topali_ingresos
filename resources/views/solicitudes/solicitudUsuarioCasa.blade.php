@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<link href="{{asset('plugins/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jquery-editable-select.css')}}" rel="stylesheet">
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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="solicitud-title" id="ver_solicitud">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="solicitud-title">Detalles solicitud</h4>
                    <div class="modal-body">
                    	<ul class="list-group left">
							<li class="list-group-item active">Datos de la solicitud</li>
							<li class="list-group-item"><span id="label_tipo">Visitante: <span id="persona_check"></span></span></li>
							<li class="list-group-item"><span id="label_numero_orden">Tipo visita: <span id="tipo_check"></span></span></li>
							<li class="list-group-item"><span id="label_fecha">Fecha de la visita: <span id='fecha_check'></span></span></li>
							<li class="list-group-item"><span id="label_fecha">Hora visita: <span id='hora_check'></span></span></li>
							<li class="list-group-item"><span id="label_fecha">mensaje: <span id='mensaje_check'></span></span></li>
						</ul>	
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	<div class="row">
		<div class="col-md-6">
			<h2 class="title-guardia margin-bottom">Solicitud de ingreso</h2>
			<form id="form_usuario_sistema" onsubmit="return false" autocomplete="off">
                <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group">
                            <label class="left">Visitante*</label>
                            <input type="text" class='form-control' name="visitante" id='visitante' placeholder="">
                            <!--<select style="width: 100%;background: white;" name="visitante" id="visitante">
                                @foreach($personas as $persona)
                                    <option value="{{$persona->id}}">{{$persona->nombre_persona}}</option>
                                @endforeach 
                            </select>-->
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left">Tipo visita*</label>
                            <select class="form-control" style="width: 100%" name="tipo_visita_id" id="tipo_visita_id">
                                <option value="0">Tipo de visita</option>
                                @foreach($tipo_visita as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->tipo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row hide">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Persona ID</label>
                            <input type="text" class='form-control' name="persona_id" id='persona_id' placeholder="No modificar este valor">
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-6 col-xs-12">
                	    <label class="left">Fecha visita* (dd/mm/yyyy)</label>
                        <div class="input-append success date col-md-10 col-lg-6 no-padding">
                            <input type="text" class="form-control" name="fecha_visita">
                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span> 
                        </div>
                        
                    </div>
                    <div class="col-sm-5 col-xs-12 col-md-offset-1">
                        <label class="left">Hora visita* (HH:mm)</label>
                        <div class="input-group transparent clockpicker">
                            <input type="text" class="form-control" name="hora_visita" placeholder="Pick a time">
                            <span class="input-group-addon ">
                                <i class="fa fa-clock-o"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12 hidden">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left">Mensaje*</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Describa detalladamente quién va a venir y a qué." rows="5"></textarea>    
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                	<button type="submit" class="btn btn-primary btn-guardia-edit" id="guardar-solicitud">Guardar</button>
	                <button type="button" class="btn btn-default btn-guardia-clear" id="limpiar">Limpiar</button>
                </div>
            </form>
		</div>
		<div class="col-md-6">
			<div class="row-fluid">
		        <div class="span12">
		            <div class="grid simple ">
		                <div class="grid-title">
		                    <div class="grid-body ">
		                        <div class="table-responsive">
		                            @include('solicitudes.table')
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
<script src="{{ asset('js/validacionesSolicitudIngresoCoto.js') }}"></script>
<script src="{{ asset('js/ajaxSolicitudesIngresoCoto.js') }}"></script>
<script src="{{ asset('js/jquery-editable-select.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$('#formulario_solicitud').on('hidden.bs.modal', function (e) {
		    $('div.form-group').removeClass('has-error');
		    $('textarea.form-control').val('');
		});
		
		$('.input-append.date').datepicker({
				autoclose: true,
				todayHighlight: true,
				format: "yyyy-mm-dd"
	   });
	    $('.clockpicker ').clockpicker({
            autoclose: true
        });

		$("#limpiar").on('click',function(){
			clean();
			inicializar_datalist();
		})

		$(document).delegate('#details-solicitud','click',function(){
			$.ajax({
				url:"<?php echo url();?>/solicitud/ingreso/show/"+$(this).parent().parent().find('td:first-child').text(),
				method:"GET",
				success:function(response){
					$("#persona_check").text(response[0].nombre_persona)
					$("#tipo_check").text(response[0].tipo)
					$("#fecha_check").text(response[0].fecha_visita)
					$("#hora_check").text(response[0].hora_visita)
					$("#mensaje_check").text(response[0].mensaje)
				}
			})
		})

		//inicializar_datalist();
	})

	function refreshTable(){
		$('#example3 tbody tr').fadeOut();
		$('#example3').load("{{URL::to('/solicitar/ingreso/coto')}}", function() {
			$('#example3 tbody tr').fadeIn();
		});
	}

	function clean(){
		$('form input, form select, form textarea').each(function(){
			if ( $(this).is("select") ) {
				$(this).val(0);
			}
			if ( $(this).attr('id') != "token" ) {
				$(this).val("");
			}
			$(this).parent().removeClass('has-error');	
		})
	}

	function inicializar_datalist() {
        $('#visitante').editableSelect().on('select.editable-select', function (e, li) {
            var visitante_value = li.val();
            if (visitante_value == 0) {
                return true;
            }
            var personas = <?php echo $personas;?>;
            for (var key in personas) {
                if (personas.hasOwnProperty(key)) {
                    if (personas[key].id == visitante_value) {
                        $('input#persona_id').val(personas[key].id);
                    }
                }
            }
            console.info(li.val() + '. ' + li.text());
        });
    }
</script>
@endsection