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
            <strong>Error guardando el casa.</strong> 
            <br>No se ha podido crear la casa debido a que el folio es inválido o está repetido, porfavor, trate con uno diferente.
        </div>
    @endif

    <div class="row normal_margin">
        <div class="col-md-12">
            <h2 class="title-guardia">Lista de casas del servicio {{$nom_serv}}</h2>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <div class="grid-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="example3">
							    <thead class="centered">    
							        <th>ID</th>
							        <th>Folio</th>
							        <th>Responsable</th>
							        <th class="hide">Coto id</th>
							        <th class="hide">Coto</th>
							        <th class="hide">Subcoto id</th>
							        <th class="hide">Subcoto</th>
							        <th>Correo</th>
							    </thead>
							    <tbody id="tabla-casas" class="">
							        @if(count($casas) > 0)
							            @foreach($casas as $casa)
							                <tr>
							                    <td>{{$casa->id}}</td>
							                    <td>{{$casa->folio_casa}}</td>
							                    <td>{{$casa->responsable}}</td>
							                    <td class="hide">{{$casa->coto_id}}</td>
							                    <td class="hide">{{$casa->coto_nombre}}</td>
							                    <td class="hide">{{$casa->subcoto_id ? $casa->subcoto_id : 'No aplica'}}</td>
							                    <td class="hide">{{$casa->subcoto_nombre ? $casa->subcoto_nombre : 'No aplica'}}</td>
							                    <td>{{$casa->correo}}</td>
							                </tr>
							            @endforeach
							        @else
							            <td colspan="8">No hay casas disponibles</td>
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
    </div>

</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/validacionesCasas.js') }}"></script>
<script src="{{ asset('js/casasAjax.js') }}"></script>
<script>
    /*Código para cuando se ocultan los modal*/
    $('#editar-casa').on('hidden.bs.modal', function (e) {
        $('#editar-casa div.form-group').removeClass('has-error');
        $('input.form-control').val('');
    });
    /*Fin de código para cuando se ocultan los modal*/
    $('body').delegate('button#exportar_casas_excel','click', function() {
        window.location.href = "<?php echo url();?>/casas/app/exportar_casas_app";
    });

    $('body').delegate('button#nuevo_casa_app','click', function() {
        //$("form#form_casas").get(0).setAttribute('action', '<?php echo url();?>/casas/guardar_usuario_casa');
        $('input.form-control').val('');
        $('#editar-casa select').val(0);
        $("h4#gridSystemModalLabel").text('Nuevo casa (app)');
        $('#editar-casa').modal();
    });

    $('body').delegate('.editar-casa','click', function() {
        $('input.form-control').val('');
        $("form#form_casas").get(0).setAttribute('action', '<?php echo url();?>/casas/editar_usuario_casa');
        
        id = $(this).parent().siblings("td:nth-child(1)").text(),
        folio = $(this).parent().siblings("td:nth-child(2)").text(),
        responsable = $(this).parent().siblings("td:nth-child(3)").text(),
        coto_id = $(this).parent().siblings("td:nth-child(4)").text(),
        coto = $(this).parent().siblings("td:nth-child(5)").text(),
        subcoto_id = $(this).parent().siblings("td:nth-child(6)").text(),
        subcoto = $(this).parent().siblings("td:nth-child(7)").text(),
        correo = $(this).parent().siblings("td:nth-child(8)").text();
        
        $("#form_casas input#id").val(id);
        $("#form_casas input#folio_casa").val(folio);
        $("#form_casas input#folio_viejo").val(folio);
        $("#form_casas input#responsable").val(responsable);
        $("#form_casas select#coto_id").val(coto_id);
        $("#form_casas select#subcoto_id").val(subcoto_id != 'No aplica' ? subcoto_id : 0);
        $("#form_casas input#correo_viejo").val(correo);
        $("#form_casas input#correo_nuevo").val(correo);
    });

    $("#limpiar").on('click',function(){
        clean();
    })

    $("#guardar-datos-casa").on('click',function(){
        /*$.ajax({
            url:$("form#form_casas").attr('action'),
            method:"POST",
            data:$('#form_casas').serialize(),
            success:function(){
                clean();
                refreshTable();
            }
        })*/
    })

    $('body').delegate('.eliminar-casa','click', function() {
        var id = $(this).parent().siblings("td:nth-child(1)").text();
        var casa = $(this).parent().siblings("td:nth-child(2)").text();
        var token = $("#token").val();

        swal({
            title: "¿Realmente desea eliminar a la casa con el folio <span style='color:#F8BB86'>" + casa + "</span>?",
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
                    eliminarCasa(id,casa,token);
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });

    function clean(){
        $('form input, form select, form textarea').each(function(){
            if($(this).attr('name') != '_token'){
                $(this).val("");
            }
        })
    }

    function refreshTable(){
        $('#example3').fadeOut();
        $('#example3').load("{{ URL::to('/usuarios/casas') }}", function() {
            $('#example3').on( 'destroy.dt', function ( e, settings ) {
                //$(this).off( 'click', );
                $(this).fadeIn();
                $(this).DataTable();
            } );
        });
    }
</script>
@endsection