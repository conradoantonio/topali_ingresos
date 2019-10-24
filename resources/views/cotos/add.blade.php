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
    <div class="row normal-margin">
        <h2 class="title-guardia">Registro de servicios</h2>    
        <button type="button" class="btn btn-primary btn-guardia-edit btn-guardia-nuevo" data-target="#formulario-usuario-sistema" id="nuevo-usuario">Exportar</button>
    </div>
    
    <div class="col-md-6">
        <form id="form_coto" action="{{URL::to('/administrar/cotos/guardar_coto')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off">
            <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 hidden">
                        <div class="form-group">
                            <label class="left" for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="nombre">Servicio*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del servicio">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left">Tipo servicio*</label>
                            <select class="form-control" id="tipo_servicio" name="tipo_servicio">
                                <option value="0">Elija una opción</option>
                                <option value="1">Coto</option>
                                <option value="2">Industria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="unidad_privativa">Unidad privativa*</label>
                            <input type="text" class="form-control" id="unidad_privativa" name="unidad_privativa" placeholder="Unidad privativa">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left">Estados</label>
                            <select class="form-control" id="estado_id" name="estado_id">
                                <option value="">Elija una opción</option>
                                @foreach( $estados as $estado)
                                	<option value="{{$estado->id_estado}}">{{$estado->estado}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="direccion">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="telefono_1">Teléfono</label>
                            <input type="text" class="form-control" id="telefono_1" name="telefono_1" placeholder="Teléfono 1">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="num_lugares">Num lugares.</label>
                            <input type="text" class="form-control" id="num_lugares" name="num_lugares" placeholder="Número de lugares para estacionarse">
                        </div>
                    </div>
                                             
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="nombre_responsable">Encargado</label>
                            <input type="text" class="form-control" id="nombre_responsable" name="nombre_responsable" placeholder="Nombre del responsable">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 hide">
                        <div class="form-group">
                            <label class="left" for="correo_viejo">Correo viejo</label>
                            <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Correo viejo">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="correo">Correo*</label>
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo para crear el usuario">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="password">Contraseña*</label>
                            <input type="" class="form-control" id="password" name="password" placeholder="Contraseña de usuario">
                        </div>
                    </div>

                    <div class="col-sm-12 col-xs-12">
                        <div class="progress transparent progress-small no-radius m-t-20" style="width:100%">
                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                        </div>
                        <label class="left" for="">Datos del usuario guardia</label>
                    </div>

                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="nombre_responsable_guardia">Encargado</label>
                            <input type="text" class="form-control" id="nombre_responsable_guardia" name="nombre_responsable_guardia" placeholder="Nombre del guardia responsable">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 hide">
                        <div class="form-group">
                            <label class="left" for="correo_viejo_guardia">Correo viejo</label>
                            <input type="text" class="form-control" id="correo_viejo_guardia" name="correo_viejo_guardia" placeholder="Correo viejo del guardia">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="correo_guardia">Correo*</label>
                            <input type="text" class="form-control" id="correo_guardia" name="correo_guardia" placeholder="Correo para crear el usuario de guardia">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="password_guardia">Contraseña*</label>
                            <input type="" class="form-control" id="password_guardia" name="password_guardia" placeholder="Contraseña de usuario de guardia">
                        </div>
                    </div>
                </div>                            
            </div>
            <div class="container-buttons">
                <button type="submit" class="btn btn-primary" id="guardar_coto">Guardar</button>
                <button type="button" class="btn btn-default" id="limpiar">Limpiar</button>
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
                                        <th class="hide">Tipo Servicio</th>
                                        <th class="hide">Unidad privada</th>
                                        <th class="hide">Dirección</th>
                                        <th class="hide">Teléfono</th>
                                        <th class="hide">Num lugares</th>
                                        <th class="hide">Encargado</th>
                                        <th class="hide">Correo servicio</th>
                                        <th class="hide">Guardia responsable</th>
                                        <th class="hide">Correo guardia</th>
                                        <th class="hide">Id estado</th>
                                        <th class="hide">Id users</th>
                                        <th class="hide">Contra plana usuario servicio</th>
                                        <th class="hide">Contra plana usuario guardia</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="tabla-servicio">
                                        @foreach( $servicios as $servicio)
                                            <tr class="">
                                                <td>{{$servicio->id}}</td>
                                                <td>{{$servicio->nombre}}</td>
                                                <td class="hide">{{$servicio->tipo_servicio}}</td>
                                                <td class="hide">{{$servicio->unidad_privativa}}</td>
		                                        <td class="hide">{{$servicio->direccion}}</td>
		                                        <td class="hide">{{$servicio->telefono_1}}</td>
		                                        <td class="hide">{{$servicio->num_lugares}}</td>
		                                        <td class="hide">{{$servicio->nombre_responsable}}</td>
		                                        <td class="hide">{{$servicio->correo_servicio}}</td>
		                                        <td class="hide">{{$servicio->guardia_responsable}}</td>
		                                        <td class="hide">{{$servicio->correo_guardia}}</td>
		                                        <td class="hide">{{$servicio->id_estado}}</td>
                                                <td class="hide">{{$servicio->users_id}}</td>
                                                <td class="hide">{{$servicio->contra_user_servicio}}</td>
		                                        <td class="hide">{{$servicio->contra_guardia}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-guardia-edit" id="details-service">Editar</button>
                                                    <button type="button" class="btn btn-info btn-guardia-delete eliminar_coto">Borrar</button>
                                                </td>
                                            </tr>
                                        @endforeach
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
<script src="{{ asset('js/cotosAjax.js') }}"></script>
<script src="{{ asset('js/validacionesCotos.js') }}"></script>
<script type="text/javascript">
	$(function(){
		url = window.location.href.split("/");
		if (url[6]){
			setTimeout(function(){ $('#details-service').trigger('click'); }, 500);
		}
		
		$("#limpiar").on('click',function(){
	        clean();
	    })

	    $(document).delegate('#details-service','click',function(){
	    	if (url[6]){
				id = url[6];
			} else {
				id = $(this).parent().siblings("td:nth-child(1)").text();
			}
		    nombre = $(this).parent().siblings("td:nth-child(2)").text(),
		    tipo_servicio_id = $(this).parent().siblings("td:nth-child(3)").text(),
		    //tipo_servicio = $(this).parent().siblings("td:nth-child(4)").text(),
		    unidad_privativa = $(this).parent().siblings("td:nth-child(4)").text(),
		    direccion = $(this).parent().siblings("td:nth-child(5)").text(),
		    telefono_1 = $(this).parent().siblings("td:nth-child(6)").text(),
		    num_lugares = $(this).parent().siblings("td:nth-child(7)").text(),
		    nombre_responsable = $(this).parent().siblings("td:nth-child(8)").text(),
		    correo_servicio = $(this).parent().siblings("td:nth-child(9)").text(),
		    guardia_responsable = $(this).parent().siblings("td:nth-child(10)").text(),
		    correo_guardia = $(this).parent().siblings("td:nth-child(11)").text();
            id_estado = $(this).parent().siblings("td:nth-child(12)").text();
            contra_user_servicio = $(this).parent().siblings("td:nth-child(14)").text();
		    contra_guardia = $(this).parent().siblings("td:nth-child(15)").text();

		    $("form#form_coto").get(0).setAttribute('action', '<?php echo url();?>/administrar/cotos/editar_coto');
		    $("#form_coto input#id").val(id);
		    $("#form_coto input#nombre").val(nombre);
		    $("#form_coto select#tipo_servicio").val(tipo_servicio_id);
		    $("#form_coto input#unidad_privativa").val(unidad_privativa);
		    $("#form_coto textarea#direccion").val(direccion);
		    $("#form_coto input#telefono_1").val(telefono_1);
		    $("#form_coto input#num_lugares").val(num_lugares);
		    $("#form_coto input#nombre_responsable").val(nombre_responsable);
		    //$("#form_coto input#user_id").val(user_id);
		    $("#form_coto input#correo_viejo").val(correo_servicio);
		    $("#form_coto input#correo").val(correo_servicio);
            $("#form_coto input#correo").val(correo_servicio);
		    $("#form_coto input#password").val(contra_user_servicio);

		    /*Guardia inputs*/
		    $("#form_coto input#nombre_responsable_guardia").val(guardia_responsable);
		    $("#form_coto input#correo_viejo_guardia").val(correo_guardia);
		    $("#form_coto input#correo_guardia").val(correo_guardia);
            $("#form_coto select#estado_id").val(id_estado);
		    $("#form_coto input#password_guardia").val(contra_guardia);
	    })

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
	})

    function clean(){
        $('form input, form select, form textarea').each(function(){
        	if ( $(this).is('select') ) {
        		$(this).val(0);	
        	}
        	if ( $(this).attr('id') != 'token' ){
        		$(this).val("");
        		$(this).parent().removeClass('has-errors');
        	}
        })
    }
</script>
@endsection