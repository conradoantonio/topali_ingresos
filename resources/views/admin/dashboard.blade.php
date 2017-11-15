@extends('admin.main')

@section('content')
<style>
    th {
        text-align: center!important;
    }
    textarea {
        resize: none;
    }
    .table td.text {
        max-width: 177px;
    }
    .table td.text span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 100%;
    }
</style>
<div class="content">
    <div class="page-title text-center">
        <h3>Dashboard </h3>
    </div>

    <div class="row" id="data_user_admin">
        <div class="col-md-6 col-vlg-6 col-sm-6">
            <div class="tiles green m-b-10">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title text-black">Usuarios </div>
                    <div class="widget-stats">
                        <div class="wrapper transparent"> 
                            <span class="item-title">Servicio</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->total_servicios}}" data-animation-duration="700">{{$dashboard->total_servicios}}</span>
                        </div>
                    </div>
                    <div class="widget-stats">
                        <div class="wrapper transparent">
                            <span class="item-title">Casas</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->total_casas}}" data-animation-duration="700">{{$dashboard->total_casas}}</span> 
                        </div>
                    </div>
                    <div class="widget-stats ">
                        <div class="wrapper last"> 
                            <span class="item-title">Guardia</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->total_guardia}}" data-animation-duration="700">{{$dashboard->total_guardia}}</span> 
                        </div>
                    </div>
                    <div class="progress transparent progress-small no-radius m-t-20" style="width:100%">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                    </div>
                    <div class="description"> <span class="text-white mini-description ">{{$dashboard->usuarios_mes}} Usuarios nuevos <span class="blend">registrados este mes.</span></span></div>
                </div>            
            </div>  
        </div>
        <div class="col-md-6 col-vlg-6 col-sm-6">
            <div class="tiles blue m-b-10">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title text-black">Registros por día </div>
                    <div class="widget-stats">
                        <div class="wrapper transparent"> 
                            <span class="item-title">Ingresos de hoy</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->ingreso_dia}}" data-animation-duration="700">{{$dashboard->ingreso_dia}}</span>
                        </div>
                    </div>
                    <div class="widget-stats">
                        <div class="wrapper last">
                            <span class="item-title">Egresos de hoy</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->egreso_dia}}" data-animation-duration="700">{{$dashboard->egreso_dia}}</span> 
                        </div>
                    </div>
                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                    </div>
                    <div class="description"> <span class="text-white mini-description ">{{$dashboard->ingreso_mes}} Ingresos nuevos <span class="blend">registrados este mes.</span></span></div>
                </div>            
            </div>  
        </div>
        <div class="col-md-6 col-vlg-6 col-sm-6">
            <div class="tiles purple m-b-10">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title text-black">Solicitudes</div>
                    <div class="widget-stats">
                        <div class="wrapper transparent"> 
                            <span class="item-title">Solicitudes pendientes</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->solicitudes_pendientes}}" data-animation-duration="700">{{$dashboard->solicitudes_pendientes}}</span>
                        </div>
                    </div>
                    <div class="widget-stats">
                        <div class="wrapper last">
                            <span class="item-title">Solicitudes atendidas</span> <span class="item-count animate-number semi-bold" data-value="{{$dashboard->solicitudes_atendidas}}" data-animation-duration="700">{{$dashboard->solicitudes_atendidas}}</span> 
                        </div>
                    </div>
                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                    </div>
                    <div class="description"> <span class="text-white mini-description ">{{$dashboard->solicitudes_mes}} solicitudes de ingresos<span class="blend"> registrados este mes.</span></span></div>
                </div>            
            </div>  
        </div>
        <!--<div class="col-md-6 col-vlg-6 col-sm-6">
            <div class="tiles red m-b-10">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title text-black">Detalles</div>
                    <div class="widget-stats">
                        <div class="wrapper transparent"> 
                            <span class="item-title">Número egresos</span> <span class="item-count animate-number semi-bold" data-value="2415" data-animation-duration="700">0</span>
                        </div>
                    </div>
                    <div class="widget-stats">
                        <div class="wrapper last">
                            <span class="item-title">Número ingresos</span> <span class="item-count animate-number semi-bold" data-value="751" data-animation-duration="700">0</span> 
                        </div>
                    </div>
                    <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                    </div>
                    <div class="description"> <span class="text-white mini-description ">100 solicitudes de ingresos <span class="blend">registrados este mes.</span></span></div>
                </div>            
            </div>  
        </div>-->
    </div>

</div>
@endsection