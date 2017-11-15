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
        <form id="form_usuario_sistema" action="<?php echo url();?>/usuarios/sistema/guardar_usuario" enctype="multipart/form-data" method="POST" autocomplete="off">
            <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}" base-url="<?php echo url();?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 hidden">
                        <div class="form-group">
                            <label class="left" for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Servicio*</label>
                            <input type="text" class="form-control" id="nombre_completo" name="servicio" placeholder="Nombre completo">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Tipo servicio</label>
                            <!-- <input type="text" class="form-control" id="correo_nuevo" name="tipo_servicio" placeholder="Tipo servicio"> -->
                            <select>
                                @foreach( $tipo as $type)
                                    <option value="{{$type->id}}">{{$type->servicio}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Unidad privada</label>
                            <input type="text" class="form-control" id="unidad_privada" name="unidad_privada" placeholder="Unidad privada">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Dirección</label>
                            <input type="text" class="form-control" id="unidad_privada" name="unidad_privada" placeholder="Dirección">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Teléfono</label>
                            <input type="text" class="form-control" id="unidad_privada" name="telefono" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Encargado</label>
                            <input type="text" class="form-control" id="unidad_privada" name="encargado" placeholder="Encargado">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 hide">
                        <div class="form-group">
                            <label class="left" for="user">Correo viejo</label>
                            <input type="text" class="form-control" id="correo_viejo" name="correo_viejo" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="user">Correo</label>
                            <input type="text" class="form-control" id="correo_viejo" name="correo" placeholder="Correo">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="left" for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary btn-guardia-edit" id="guardar-servicio">Guardar</button>
                <button type="button" class="btn btn-default btn-guardia-clear">Limpiar</button>
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
                                        <th class="hide">Encargado</th>
                                        <th class="hide">Usuario</th>
                                        <th class="hide">Contraseña</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="tabla-servicio">
                                        @foreach( $servicios as $servicio)
                                                <tr class="">
                                                    <td>{{$servicio->id}}</td>
                                                    <td>{{$servicio->nombre}}</td>
                                                    <td class="hide">{{$servicio->tipo_servicio}}</td>
                                                    <td class="hide">{{$servicio->unidad_privada}}</td>
                                                    <td class="hide">{{$servicio->direccion}}</td>
                                                    <td class="hide">{{$servicio->telefono}}</td>
                                                    <td class="hide">{{$servicio->encargado}}</td>
                                                    <td class="hide">{{$servicio->usuario}}</td>
                                                    <td class="hide">{{$servicio->contraseña}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-guardia-edit" id="details-service">Detalles</button>
                                                        <button type="button" class="btn btn-info btn-guardia-delete" id="delete-service">Borrar</button>
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
<script type="text/javascript">
    $("#limpiar").on('click',function(){
        clean();
    })

    function clean(){
        $('form input, form select, form textarea').each(function(){
            $(this).val("");
        })
    }
</script>
@endsection