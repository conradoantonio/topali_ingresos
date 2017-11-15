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

    <div class="row normal-margin">
        <h2 class="title-guardia">Lista de servicios</h2> 
        <a type="button" class="btn btn-primary btn-guardia-edit btn-guardia-nuevo" href="{{URL::to('/servicios/add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo guardia</a>   
    </div>
    

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
                    <div class="grid-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="example3">
                                <thead class="centered">    
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo servicio</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody id="tabla-servicios" class="">
                                    @if(count($servicios) > 0)
                                        @foreach($servicios as $servicio)
                                            <tr>
                                                <td>{{$servicio->id}}</td>
                                                <td>{{$servicio->nombre}}</td>
                                                <td>{{$servicio->serv}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-guardia-edit" id="details-service">Detalles</button>
                                                    <button type="button" class="btn btn-info btn-guardia-enter" id="check-service">Entrar?</button>
                                                    <button type="button" class="btn btn-info btn-guardia-clear" id="delete-service">Borrar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="8">No hay servicios disponibles</td>
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
<script>
    
</script>
@endsection