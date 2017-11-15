<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', isset($title) ? $title .' | Topali' : 'Topali')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="{{ asset('plugins/pace/pace-theme-flash.css')}}"  type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('plugins/jquery-scrollbar/jquery.scrollbar.css')}}"  type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/boostrapv3/css/bootstrap.min.css')}}"  type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/boostrapv3/css/bootstrap-theme.min.css')}}"  type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.css')}}"  type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css')}}"  type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/custom-icon-set.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
</head>

<body>

    <div class="header navbar navbar-inverse">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="navbar-inner">
            <!-- BEGIN NAVIGATION HEADER -->
            <div class="header-seperation"> 
                <!-- BEGIN MOBILE HEADER -->
                <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">    
                    <li class="dropdown">
                        <a id="main-menu-toggle" href="#main-menu" class="">
                            <div class="iconset top-menu-toggle-white"></div>
                        </a>
                    </li>        
                </ul>
                <!-- END MOBILE HEADER -->
                <!-- BEGIN LOGO --> 
                <a href="<?php echo url();?>/dashboard">
                    <img src="{{ asset('img/logo.png') }}" class="logo" alt="" data-src="{{ asset('img/logo.png') }}" data-src-retina="{{ asset('img/logo.png') }}" width="106" height="21"/>
                </a>
                <!-- END LOGO --> 
                <!-- BEGIN LOGO NAV BUTTONS -->
                @if(Session::get('privilegio') == "Super Administrador")
                    <ul class="nav pull-right notifcation-center">  
                        <li class="dropdown" id="header_task_bar">
                            <a href="<?php echo url();?>/dashboard" class="dropdown-toggle active" data-toggle="">
                                <div class="iconset top-home"></div>
                            </a>
                        </li>               
                    </ul>
                @endif
                <!-- END LOGO NAV BUTTONS -->
            </div>
            <!-- END NAVIGATION HEADER -->
            <!-- BEGIN CONTENT HEADER -->
            <div class="header-quick-nav"> 
                <!-- BEGIN HEADER LEFT SIDE SECTION -->
                <div class="pull-left"> 
                    <!-- BEGIN SLIM NAVIGATION TOGGLE -->
                    <ul class="nav quick-section">
                        <li class="quicklinks">
                            <a href="#" class="" id="layout-condensed-toggle">
                                <div class="iconset top-menu-toggle-dark"></div>
                            </a>
                        </li>
                    </ul>
                    <!-- END SLIM NAVIGATION TOGGLE -->                         
                </div>
                <!-- END HEADER LEFT SIDE SECTION -->
                <!-- BEGIN HEADER RIGHT SIDE SECTION -->
                <div class="pull-right"> 
                    <div class="chat-toggler">  
                        <!-- BEGIN NOTIFICATION CENTER -->
                        <a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom" data-content="">
                            <div class="user-details"> 
                                <div class="username">
                                    <span class="badge badge-important"></span>Privilegio: <span>{{Session::get('privilegio')}}</span>                                  
                                </div>                      
                            </div> 
                            <div class="iconset"></div>
                        </a>    
                        
                        <!-- END NOTIFICATION CENTER -->
                        <!-- BEGIN PROFILE PICTURE -->
                        <div class="profile-pic"> 
                            <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="" data-src="{{ asset(Auth::user()->foto_perfil) }}" data-src-retina="{{ asset(Auth::user()->foto_perfil) }}" width="35" height="35" /> 
                        </div>  
                        <!-- END PROFILE PICTURE -->                
                    </div>
                    <!-- BEGIN HEADER NAV BUTTONS -->
                    <ul class="nav quick-section">
                        <!-- BEGIN SETTINGS -->
                        <li class="quicklinks"> 
                            <a data-toggle="dropdown" class="dropdown-toggle pull-right" href="#" id="user-options">                        
                                <div class="iconset top-settings-dark"></div>   
                            </a>
                            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
                                <li><a data-toggle="modal" data-target="#cambiar_foto_perfil_sistema" href="#"><i class="fa fa-picture-o" aria-hidden="true"></i> Cambiar foto perfil</a></li>
                                <li><a data-toggle="modal" data-target="#change-pass" href="#"><i class="fa fa-key" aria-hidden="true"></i> Cambiar contraseña</a></li>
                                <li class="divider"></li>  
                                <li class="loggingOut"><a href="#"><i class="fa fa-power-off"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>
                        <!-- END SETTINGS -->
                    </ul>
                    <!-- END HEADER NAV BUTTONS -->
                </div>
                <!-- END HEADER RIGHT SIDE SECTION -->
            </div> 
            <!-- END CONTENT HEADER --> 
        </div>
        <!-- END TOP NAVIGATION BAR --> 
    </div>
    <!-- END HEADER -->
        
    <!-- BEGIN CONTENT -->
    <div class="page-container row-fluid">
        <!-- BEGIN SIDEBAR -->
        <!-- BEGIN MENU -->
        <div class="page-sidebar" id="main-menu"> 
              <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
            <!-- BEGIN MINI-PROFILE -->
            <div class="user-info-wrapper"> 
                <div class="profile-wrapper">
                    <img src=" {{ asset('/img/logo_topali.jpg') }}" alt="" data-src=" {{ asset('/img/logo_topali.jpg') }}" data-src-retina=" {{ asset('/img/logo_topali.jpg') }}" width="69" height="69" />
                </div>
                <div class="user-info">
                    <div class="greeting">Bienvenido</div>
                    <div class="username"><span class="semi-bold">{{Auth::user()->nombre_completo}}</span></div>
<!--                     <div class="status">Status<a href="#"><div class="status-icon green"></div>Online</a></div>
 -->                </div>
            </div>
            <!-- END MINI-PROFILE -->
            <!-- BEGIN SIDEBAR MENU --> 
            <p class="menu-title">Secciones<span class="pull-right"><a href=""><i class="fa fa-refresh"></i></a></span></p>
            <ul>    
                <!-- BEGIN SELECTED LINK -->
                @if(Session::get('privilegio') == "Super Administrador" || Session::get('privilegio') == "Administrador Coto" || Session::get('privilegio') == "Administrador Negocio")
                    <li class="start {{$menu == 'Inicio' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/dashboard">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <span class="title">Inicio</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endif
                <!-- END SELECTED LINK -->

                <!-- BEGIN ONE LEVEL MENU -->
                @if(Session::get('privilegio') == "Super Administrador" || Session::get('privilegio') == "Administrador Coto" || Session::get('privilegio') == "Administrador Negocio")
                    <li class="{{$menu == 'Usuarios' ? 'open start' : ''}}">
                        <a href="javascript:;">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span class="title">Usuarios</span>
                            <span class="{{$menu == 'Usuarios' ? 'arrow open' : 'arrow'}}"></span>
                        </a>
                        <ul class="sub-menu" style="{{$menu == 'Usuarios' ? 'display: block;' : ''}}">
                            @if(Session::get('privilegio') == "Super Administrador")
                                <li class="{{$title == 'Usuarios Sistema' ? 'active' : ''}}"><a href="<?php echo url();?>/usuarios/sistema">Usuarios (Sistema)</a></li> 
                            @endif
                            @if(Session::get('privilegio') == "Administrador Coto" || Session::get('privilegio') == "Administrador Negocio")
                                <li class="{{$title == 'Usuarios casa e industria' ? 'active' : ''}}"><a href="<?php echo url();?>/usuarios/casas">Usuarios (Casa e industria)</a></li>
                                <!-- <li class="{{$title == 'Usuarios Guardia' ? 'active' : ''}}"><a href="<?php echo url();?>/usuarios/guardia">Usuarios (Guardia)</a></li> -->
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- END ONE LEVEL MENU -->

                <!-- BEGIN ONE LEVEL MENU -->
                @if(Session::get('privilegio') == "Super Administrador")
                    <li class="{{$menu == 'Servicios' ? 'open start' : ''}}">
                        <a href="javascript:;">
                            <i class="fa fa-building" aria-hidden="true"></i>
                            {{-- <span class="title">Servicios y negocios</span> --}}
                            <span class="title">Servicios</span>
                            <span class="{{$menu == 'Servicios' ? 'arrow open' : 'arrow'}}"></span>
                        </a>
                        <ul class="sub-menu" style="{{$menu == 'Servicios' ? 'display: block;' : ''}}">
                            <li class="{{$title == 'Administrar servicios' ? 'active' : ''}}"><a href="<?php echo url();?>/administrar/cotos">Administrar servicios</a></li> 
                            @if(Session::get('privilegio') == "None")
                                <li class="{{$title == 'Administrar negocios' ? 'active' : ''}}"><a href="<?php echo url();?>/administrar/negocios">Administrar negocios</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- END ONE LEVEL MENU -->

                <!-- BEGIN ONE LEVEL MENU -->
                <?php /*
                @if(Session::get('privilegio') == "Super Administrador")
                    <li class="{{$menu == 'Subcotos y departamentos' ? 'open start' : ''}}">
                        <a href="javascript:;">
                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                            {{-- <span class="title">Subcotos y departamentos</span> --}}
                            <span class="title">Subcotos</span>
                            <span class="{{$menu == 'Subcotos y departamentos' ? 'arrow open' : 'arrow'}}"></span>
                        </a>
                        <ul class="sub-menu" style="{{$menu == 'Subcotos y departamentos' ? 'display: block;' : ''}}">
                            <li class="{{$title == 'Administrar subcotos' ? 'active' : ''}}"><a href="<?php echo url();?>/administrar/subcotos">Administrar subcotos</a></li> 
                            @if(Session::get('privilegio') == "None")
                                <li class="{{$title == 'Administrar departamentos' ? 'active' : ''}}"><a href="<?php echo url();?>/administrar/departamentos">Administrar departamentos</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                */ ?>
                <!-- END ONE LEVEL MENU -->

                <!-- BEGIN ONE LEVEL MENU -->
                @if(Session::get('privilegio') == "Guardia" || Session::get('privilegio') == "Administrador Coto")
                    <li class="{{$menu == 'Ingresos' ? 'open start' : ''}}">
                        <a href="javascript:;">
                            <i class="fa fa-share" aria-hidden="true"></i>
                            <span class="title">Ingresos</span>
                            <span class="{{$menu == 'Ingresos' ? 'arrow open' : 'arrow'}}"></span>
                        </a>
                        <ul class="sub-menu" style="{{$menu == 'Ingresos' ? 'display: block;' : ''}}">
                            <li class="{{$title == 'Administrar ingresos de coto' ? 'active' : ''}}"><a href="<?php echo url();?>/administrar/ingresos/cotos">Administrar ingresos</a></li> 
                            <li class="{{$title == 'Formulario de ingreos para coto' ? 'active' : ''}}"><a href="<?php echo url();?>/ingresos/cotos/formulario">Nuevo ingreso</a></li>
                            
                        </ul>
                    </li>
                @endif
                <!-- END ONE LEVEL MENU -->

                @if(Session::get('privilegio') == "Guardia" || Session::get('privilegio') == "Administrador Coto")
                <!-- BEGIN SINGLE LINK -->
                    <li class="{{$menu == 'Egresos' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/administrar/egresos/cotos">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                            <span class="title">Egresos</span>
                        </a>
                    </li>
                @endif
                @if(Session::get('privilegio') == "Guardia")
                <!-- BEGIN SINGLE LINK -->
                    <li class="{{$menu == 'Solicitudes ingresos coto' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/solicitudes/ingreso/coto">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                            <span class="title">Solicitudes</span>
                        </a>
                    </li>
                @endif
                <!-- END SINGLE LINK -->

                <!-- BEGIN SINGLE LINK -->
                @if(Session::get('privilegio') == "Guardia")
                    <!-- <li class="{{$menu == 'Solicitudes ingresos coto' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/solicitudes/ingreso/coto">
                            <i class="fa fa-question" aria-hidden="true"></i>
                            <span class="title">Solicitudes de ingreso</span>
                        </a>
                    </li> -->
                @endif
                <!-- END SINGLE LINK -->

                <!-- BEGIN SINGLE LINK -->
                @if(Session::get('privilegio') == "Casa")
                    <li class="{{$menu == 'Mis solicitudes' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/solicitar/ingreso/coto">
                            <i class="fa fa-question" aria-hidden="true"></i>
                            <span class="title">Mis solicitudes</span>
                        </a>
                    </li>
                @endif
                <!-- END SINGLE LINK -->

                <!-- BEGIN SINGLE LINK -->
                @if(Session::get('privilegio') == "Administrador Coto" || Session::get('privilegio') == "Super Administrador")
                    <li class="{{$menu == 'Historial' ? 'active' : ''}}">
                        <a href="<?php echo url();?>/administrar/historial/ingresos">
                            <i class="fa fa-question" aria-hidden="true"></i>
                            <span class="title">Historial ingresos</span>
                        </a>
                    </li>
                @endif
                <!-- END SINGLE LINK -->
                
                <!-- BEGIN SINGLE LINK -->
                <li class="loggingOut">
                    <a href="#">
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        <span class="title">Cerrar sesión</span>
                    </a>
                </li>
                <!-- END SINGLE LINK -->
                <!-- BEGIN SINGLE LINK -->
                <li class="">
                    <a href="#">
                        <i class="" aria-hidden="true"></i>
                        <span class="title"></span>
                    </a>
                </li>
                <!-- END SINGLE LINK --> 
                <!-- END ONE LEVEL MENU -->     
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
        </div>
        <!-- BEGIN SCROLL UP HOVER -->
        <a href="#" class="scrollup">Scroll</a>
        <!-- END SCROLL UP HOVER -->
        <!-- END MENU -->
        <!-- BEGIN SIDEBAR FOOTER WIDGET -->
        <div class="footer-widget">     
            <div class="progress transparent progress-small no-radius no-margin">
                <div data-percentage="100%" class="progress-bar progress-bar-success animate-progress-bar"></div>       
            </div>
            <div class="pull-right">
                <div class="details-status">
                    <span data-animation-duration="1200" data-value="100" class="animate-number"></span>%
                </div>  
                <a href="#" class="loggingOut"><i class="fa fa-power-off"></i></a>
            </div>
        </div>
        <!-- END SIDEBAR FOOTER WIDGET -->
        <!-- END SIDEBAR --> 
        <!-- BEGIN PAGE CONTAINER-->

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo-form-cambiar-contra-main" id="change-pass">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="titulo-form-cambiar-contra-main">Cambio de contraseña para usuario {{Auth::user()->user}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 hidden">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" value="{{Auth::user()->id}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="actualPassword">Contraseña actual</label>
                                    <input type="password" class="form-control" id="actualPassword" placeholder="Escribe la contraseña actual">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="newPassword">Nueva contraseña</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Contraseña nueva">
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="confirmPassword">Confirmar contraseña</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmar contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="cambiar-password">Cambiar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo-form-cambiar-contra-main" id="cambiar_foto_perfil_sistema">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="titulo-form-cambiar-contra-main">Cambio de foto de perfil para {{Auth::user()->correo}}</h4>
                    </div>
                    <form id="cargar_foto_perfil" action="<?php echo url();?>/usuarios/sistema/guardar_foto_usuario_sistema" enctype="multipart/form-data" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="token" name="_token" empresa-id="{{Auth::user()->empresa_id}}" base-url="<?php echo url();?>" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 hidden">
                                    <div class="form-group">
                                        <label for="id">ID</label>
                                        <input type="text" id="id" name="id" value="{{Auth::user()->id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Cargar foto perfil</label>
                                        <input type="file" class="" name="foto_perfil_sistema" id="foto_perfil_sistema" size="5120">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="guardar-foto-usuario-sistema">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/lightbox.js') }}"></script>

        <!-- BEGIN CORE JS FRAMEWORK--> 
        <!--<script src="{{ asset('plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>--> 
        <script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/breakpoints.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('plugins/jquery-block-ui/jqueryblockui.js') }}" type="text/javascript"></script> 
        <!-- END CORE JS FRAMEWORK --> 
        <!-- BEGIN PAGE LEVEL JS -->    
        <script src="{{ asset('plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/pace/pace.min.js') }}" type="text/javascript"></script>  
        <script src="{{ asset('plugins/jquery-numberAnimate/jquery.animateNumbers.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/chart.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->     

        <!-- BEGIN CORE TEMPLATE JS --> 
        <script src="{{ asset('js/core.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('js/chat.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('js/demo.js') }}" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS --> 


        <div class="page-content">
            <main style="padding-top:60px;">
                <section>
                    @yield('content')
                </section>
            </main>
        </div>
        <!-- END PAGE CONTAINER -->
    </div>
    <!-- END CONTENT --> 
    <!-- BEGIN CORE JS FRAMEWORK--> 


    <script type="text/javascript">
    $('#change-pass, #cambiar_foto_perfil_sistema').on('hidden.bs.modal', function (e) {
        $('#change-pass div.form-group').removeClass('has-error');
        $('input.form-control').val('');
        $('input#foto_perfil_sistema').val('');
    });

    $('body').delegate('button#cambiar-password','click', function() {
        $('#change-pass div.form-group').removeClass('has-error');//Remueve los errores de los campos

        if ($('div#change-pass input#actualPassword').val() == '' ||
            $('div#change-pass input#newPassword').val() == '' ||
            $('div#change-pass input#confirmPassword').val() == '') {//Si algún campo está vacío no pasa
            $('div#change-pass input#actualPassword').val() == '' ? $('div#change-pass input#actualPassword').parent().addClass('has-error') : ''
            $('div#change-pass input#newPassword').val() == '' ? $('div#change-pass input#newPassword').parent().addClass('has-error') : ''
            $('div#change-pass input#confirmPassword').val() == '' ? $('div#change-pass input#confirmPassword').parent().addClass('has-error') : ''
            swal({
                title: "Llene todos los campos antes de continuar.",
                type: "error",
                showConfirmButton: true,
            });
        }
        else {
            var id = $('div#change-pass input#id').val();
            var token = '{{ csrf_token() }}';
            var correo = '{{ Auth::user()->correo }}';
            var actualPassword = $('div#change-pass input#actualPassword').val();
            var newPassword = $('div#change-pass input#newPassword').val();
            var confirmPassword = $('div#change-pass input#confirmPassword').val();

            changePassword(id,correo,actualPassword,newPassword,confirmPassword,token);
        }
    });

    function changePassword(id,correo,actualPassword,newPassword,confirmPassword,token) {
        $.ajax({
            method: "POST",
            url: "{{url('/usuarios/sistema/change_password')}}",
            data:{
                "id":id,
                "correo":correo,
                "actualPassword":actualPassword,
                "newPassword":newPassword,
                "confirmPassword":confirmPassword,
                "_token":token
            },
            success: function(data) {
                $('div#change-pass').modal('hide');
                $('div#change-pass div.form-group').removeClass('has-error');

                if (data == 'contra cambiada') {
                    swal({
                        title: "Contraseña modificada con éxito",
                        type: "success",
                        showConfirmButton: true,
                    });
                } else if (data == 'contra nueva diferentes') {
                    swal({
                        title: "Las contraseñas deben ser iguales, corrijala antes de continuar",
                        type: "error",
                        showConfirmButton: true,
                    });
                    $('div#change-pass input#newPassword, div#change-pass input#confirmPassword').parent().addClass('has-error');
                } else if (data == 'contra erronea') {
                    swal({
                        title: "Debe proporcionar la contraseña actual para poder cambiarla",
                        type: "error",
                        showConfirmButton: true,
                    });
                    $('div#change-pass input#actualPassword').parent().addClass('has-error');
                }
                //$('#guardar-usuario-sistema').show();
            },
            error: function(xhr, status, error) {
                swal({
                    title: "<small>Error!</small>",
                    text: "Ha ocurrido un error mientras se cambiaba la contraseña, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                    html: true
                });
            }
        });
    }

    mb = 0;
    fileExtension = ['jpg', 'jpeg', 'png'];
    var msgError = '';
    var regExprAlphNum = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
    var btn_enviar_foto = $("#guardar-foto-usuario-sistema");
    btn_enviar_foto.on('click', function() {
        msgError = '';
        inputs = [];
        validarFotoUsuarioMain($('input#foto_perfil_sistema')) == false ? inputs.push('Foto perfil') : ''

        if (inputs.length == 0) {
            $('#guardar-foto-usuario-sistema').submit();
        } else {
            swal("Corrija el siguiente campo para continuar: ", msgError).catch(swal.noop);
            return false;
        }
    });

    $('input#foto_perfil_sistema').bind('change', function() {
        if ($(this).val() != '') {

            kilobyte = (this.files[0].size / 1024);
            mb = kilobyte / 1024;

            archivo = $(this).val();
            extension = archivo.split('.').pop().toLowerCase();

            if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
                swal({
                    title: "Archivo no válido",
                    showCloseButton: true,
                    text: "Debe seleccionar una imágen con formato jpg, jpeg o png, y debe pesar menos de 5MB",
                    type: "error"
                }).catch(swal.noop);
            }
        }
    });

    function validarFotoUsuarioMain(campo) {
        archivo = $(campo).val();
        extension = archivo.split('.').pop().toLowerCase();

        if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
            $(campo).parent().addClass("has-error");
            msgError = msgError + $(campo).parent().children('label').text() + '\n';
            return false;
        } else {
            $(campo).parent().removeClass("has-error");
            return true;
        }
    }

    $('body').delegate('.loggingOut','click', function() {
        swal({
            title: "¿Desea cerrar la sesión?",
            type: 'question',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Salir',
            cancelButtonText: 'Cancelar',
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    window.location.href = "<?php echo url();?>/logout";
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });
    </script>

</body>

</html>