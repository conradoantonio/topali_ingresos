@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<link href="{{ asset('css/jquery-editable-select.css')}}" rel="stylesheet">
<style>
th {
    text-align: center!important;
}
textarea {
    resize: none;
}
</style>
<div class="" style="padding: 20px;">
    <div class="row">
        
        <div class="col-sm-12">
            <form id="form_ingresos" action="<?php echo url();?>/ingresos/cotos/guardar_ingreso" enctype="multipart/form-data" method="POST" autocomplete="off">
            	<div class="col-md-6">
            		<div class="contactForm text-center">
			            <h2 class='form-tittle title-guardia'>Registrar ingreso</h2>
			        </div>
            		<div class="row">
	                    <div class="col-md-10">
	                        <div class="form-group">
	                            <label>Visitante*</label>
	                            <select class="" style="width: 100%; background-color: white;" name="visitante" id="visitante" placeholder="">
	                                @foreach($personas as $persona)
	                                    <option value="{{$persona->id}}">{{$persona->nombre_persona}}</option>
	                                @endforeach 
	                            </select>
	                        </div>
	                    </div>  
	                </div>
	                <div class="row">
	                	<div class="col-md-5">
	                        <div class="form-group">
	                            <label>Placas</label>
	                            <input type="text" class='form-control' value="" name="texto_placas" id='texto_placas' placeholder="Placa del vehículo">
	                        </div>
	                    </div>
	                    <div class="col-md-5">
	                        <div class="form-group">
	                            <label>Tipo visita*</label>
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
	                
	                <div class="row">{{-- Div para la cámara --}}
	                    <div class="col-sm-10 col-md-10">
	                        <label>Tomar foto para identificación</label>
	                        <div id="my_camera" style="width:320px; height:240px;"></div>
	                        <a href="javascript:void(take_snapshot())"><button class="btn btn-success" type="button" name="tomar-foto-identificacion" id="tomar-foto-identificacion"><i class="fa fa-camera" aria-hidden="true"></i> <span>Tomar fotografía de identificación</span></button></a>
	                    </div>
	                </div>{{-- Fin div cámara --}}

	                <div class="row" style="padding-top: 10px;">{{-- Div para los options --}}
		                <div class="col-md-6">
							<div class="radio radio-success">
								<input id="yes" type="radio" name="optionyes" value="yes" class="option_camara" checked="checked">
								<label for="yes">Foto identificación</label>
								<input id="no" type="radio" name="optionyes" value="no" class="option_camara">
								<label for="no">Foto personal</label>
							</div>
						</div>
                    </div>

	                <div class="row" style="padding-top: 15px;">
	                    <div id="input_foto_producto" class="col-md-10">
	                        <div class="form-group">
	                            <label for="foto_personal">Cargar segunda fotografía</label>
	                            <input type="file" class="form-control" id="foto_personal" name="foto_personal">
	                        </div>
	                    </div>
	                   
	                </div>
	                <div class="row">{{-- A dónde se dirige la persona --}}
	                    <div class="col-md-10"> <h4>¿A dónde se dirige la persona?</h4> </div>
	                    <?php /*
	                    @if(count($subcotos))
	                        <div class="col-md-10">
	                            <div class="form-group">
	                                <label>Subcoto</label>
	                                <select class="form-control" style="width: 100%" name="subcotos" id="subcotos">
	                                    <option value="0">Seleccione un subcoto</option>
	                                    @foreach($subcotos as $sub)
	                                        <option value="{{$sub->id}}">{{$sub->nombre_subcoto}}</option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                    @endif
	                    */?>
	                    <div class="col-md-10">
	                        <div class="form-group">
	                            <label>Casa*</label>
	                            <select style="width: 100%" name="casas" id="casas">
	                                <option value="0">Seleccione una opción</option>
	                                @foreach($casas as $casa)
	                                    <option value="{{$casa->id}}">{{$casa->folio_casa}}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>
	                    <div class="col-md-10">
	                        <div class="form-group">
	                            <label>Nombre de la persona con la que va*</label>
	                            <input type="text" class='form-control' value="" name="va_con" class='form-controlID' id='va_con' placeholder="¿Con quién va?">
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-10 col-xs-10">
	                        <div class="form-group">
	                            <label>Comentarios</label>
	                            <textarea class="form-control" id="comentarios" name="comentarios" placeholder="..." rows="3"></textarea>    
	                        </div>
	                    </div>
	                </div>
	                <button class="btn btn-primary" type="submit" id="guardar-ingreso"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                	<button class="btn btn-default" type="button" id="limpiar_formulario"><i class="fa fa-eraser" aria-hidden="true"></i> Limpiar</button>
            	</div>
                <div class="col-md-6" style="margin-bottom: 25px;">
                	<div class="row text-center">
                		<div class="col-sm-12 col-md-12" id="contenedor_snap" style="padding-top: 10px;">
	                        <label style="margin-bottom: 0px;">Foto identificación (Cam)</label>
	                        <div id="my_result"></div>
	                        <input class='form-control' id="foto_b64" type="hidden" name="foto_b64" value=""/>{{-- Input que se encarga de almacenar el contenido de la foto tomada --}}
	                    </div>	
                	</div>
                	<div class="row text-center">
                		<div class="col-sm-12 col-md-12" id="contenedor_snap2" style="padding-top: 10px;">
	                        <label style="margin-bottom: 0px;">Foto personal (Cam)</label>
	                        <div id="my_result2"></div>
	                        <input class='form-control' id="foto2_b64" type="hidden" name="foto2_b64" value=""/>
	                    </div>
                	</div>
                	<div class="row text-center" id="persona_fotos">
	                    <div id="pre_foto_identificacion" class="col-sm-12 col-md-12 col-xs-12" style="padding-top: 10px;">
	                        <label style="margin-bottom: 0px;">Identificación</label>
	                        <img id="foto_identificacion" style="width: 100%" src="">
	                        <input type="hidden" class="form-control" id="foto_identificacion_vieja" name="foto_identificacion_vieja">
	                    </div>
	                    <div id="pre_foto_personal" class="col-sm-12 col-md-12 col-xs-12" style="padding-top: 10px;">
	                        <label style="margin-bottom: 0px;">Foto personal</label>
	                        <img id="foto_personal" style="width: 100%" src="">
	                        <input type="hidden" class="form-control" id="foto_personal_vieja" name="foto_personal_vieja">
	                    </div>
	                </div>
                </div>
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                <table id="solicitudes" class="table text-center">
                	<thead>
                		<th>Folio Casa</th>
                		<th>Nombre</th>
                		<th>Tipo visita</th>
                		<th>Fecha visita</th>
                		<th>Mensaje</th>
                	</thead>
                	<tbody>
                	</tbody>
                </table>
                
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-editable-select.js') }}"></script>
<script src="{{ asset('js/webcam.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/validacionesFormIngresos.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function() {
	    $("#casas").select2();
		var oTable = $('#solicitudes').dataTable();
		/*$("select#visitante").select2({
            allowClear: true,
        });*/
        inicializar_datalist();

		$("#foto_personal").change(function(){
		    readURL(this);
		});

		$('#casas').on('change',function(){
			$.ajax({
				url:"{{URL::to('/getSolicitudesPesrsonaCasa')}}",
				type:"POST",
				data:{
					id:$(this).val()
				},
				success:function(response){
					var oTable = $('#solicitudes').dataTable();
					oTable.fnClearTable();
					$.each(response,function(i,e){
						if ( response.length > 0 ){
							oTable.dataTable().fnAddData( 
					    	[
					        	e.folio_casa,
					        	e.nombre,
					        	e.tipo,
					        	e.fecha_visita,
					        	e.mensaje
					        ] ); 	  
						}
					})
				}
			})
		})
	});

	$('.option_camara').click(function() {
		console.info('hello bro');
		if($('#yes').is(':checked')) { 
			$('#tomar-foto-identificacion span').text('Toma fotografía de identificación');
		}
		if($('#no').is(':checked')) { 
			$('#tomar-foto-identificacion span').text('Toma fotografía personal');
		}
	});
    Webcam.attach('#my_camera');

    function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#foto_identificacion').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
            
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            
            if($('#yes').is(':checked')) {
            	document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
            	var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('foto_b64').value = raw_image_data;
            	$('#contenedor_snap').removeClass('hide');
			}
			else if($('#no').is(':checked')) {
				document.getElementById('my_result2').innerHTML = '<img src="'+data_uri+'"/>';
            	var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('foto2_b64').value = raw_image_data;
            	$('#contenedor_snap2').removeClass('hide');
			}
            
        });
    }

    $('body').delegate('#limpiar_formulario','click', function() {
        limpiar_formulario();
    });
    
    $('#visitante').on('shown.editable-select', function (e) {
        $('input#visitante').addClass('form-control');
    });

    function limpiar_formulario () {
    	$('div#my_result, #my_result2').children('img').remove();
        $('form#form_ingresos div.form-group').removeClass('has-error');
        //$('div#persona_fotos, div#contenedor_snap').addClass('hide');
        $('#form_ingresos input.form-control, #form_ingresos textarea.form-control').val('');
        $('input#visitante').editableSelect('destroy');
        inicializar_datalist();
        $("#form_ingresos select").val(0);
        $("img#foto_identificacion, img#foto_personal").attr("src", "");
    }

    function inicializar_datalist() {
        $('select#visitante').editableSelect().on('select.editable-select', function (e, li) {
            var visitante_value = li.val();
            if (visitante_value == 0) {
                return true;
            }
            $('#pre_foto_identificacion, #pre_foto_personal').addClass('hide');
            var personas = <?php echo $personas;?>;
            for (var key in personas) {
                if (personas.hasOwnProperty(key)) {
                    if (personas[key].id == visitante_value) {
                        $('div#persona_fotos').removeClass('hide');
                        $('input#persona_id').val(personas[key].id);
                        $('input#texto_placas').val(personas[key].texto_placa);
                        $('input#nombre_persona').val(personas[key].nombre_persona);
                        if (personas[key].foto_identificacion) {
                            $("img#foto_identificacion").attr("src", "{{url()}}/" + personas[key].foto_identificacion);
                            $('#pre_foto_identificacion').removeClass('hide');
                        }
                        if (personas[key].foto_personal) {
                            $("img#foto_personal").attr("src", "{{url()}}/" + personas[key].foto_personal);
                            $('#pre_foto_personal').removeClass('hide');
                        }
                        $('input#foto_identificacion_vieja').val(personas[key].foto_identificacion);
                        $('input#foto_personal_vieja').val(personas[key].foto_personal);
                    }
                }
            }
            if ( li.val() !== undefined ) {
	    		$.ajax({
		    		url:"{{URL::to('/getSolicitudesPesrsona')}}",
		    		type:"POST",
		    		data:{
		    			id:li.val()
		    		},
		    		success:function(response){
		    			var oTable = $('#solicitudes').dataTable();
						oTable.fnClearTable();
		    			$.each(response,function(i,e){
		    				if ( response.length > 0 ){
			    				oTable.dataTable().fnAddData( 
						    	[
						        	e.folio_casa,
						        	e.nombre,
						        	e.tipo,
						        	e.fecha_visita,
						        	e.mensaje
						        ] ); 	  
			    			}
		    			})
		    		}
		    	})
	    	}
            console.info(li.val() + '. ' + li.text());
        });
    }
</script>

@endsection