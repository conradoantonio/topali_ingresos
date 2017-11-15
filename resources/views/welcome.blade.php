<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <link rel="stylesheet" href="{{ asset('plugins/pace/pace-theme-flash.css')}}"  type="text/css" media="screen"/>
        <link rel="stylesheet" href="{{ asset('plugins/boostrapv3/css/bootstrap.min.css')}}"  type="text/css"/>
        <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css"/>
        <style type="text/css">
        /* Change the white to any color ;) */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
        }
        .session-error {
            display: block;
            color: red!important;
        }
        </style>
    </head>
    <body style="background-image: url(img/background.jpg);background-repeat: no-repeat; background-size: 100% 100%;">
        <div class="container centered">
            <div class="col-lg-12 text-center">
                <div class="row tiles-container m-b-10">
                    <div class="col-xs-12 col-sm-8 col-sm-push-2 col-sm-pull-2 col col-md-6 col-md-push-3 col-md-pull-3" style="position: absolute;top: 100px;background: rgba(12, 13, 15, 0.05);">
                        <div class="tiles white p-t-20 p-l-15 p-r-15 p-b-30" style="background: rgba(12, 13, 15, 0.82);">
                            <img src="{{asset('/img/login-topali.png')}}" style="width: 35%;margin-top: -80px;">
                            @if(session('valido'))
                                <span class="session-error">¡Usuario y/o contraseña erróneos!</span>
                            @endif
                            <form class="m-t-30 m-l-15 m-r-15 " method="POST" action="login" autocomplete="off">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="form-label icon-user" style="color: #f9ca0c;font-size: 28px;display: inline-block;"></label>
                                    <div class="controls" style="display: inline-block;width: 90%;">
                                        <input type="text" class="form-control" id="correo" name="correo" placeholder="Escribe tu correo" style="background: #2E2F31;color: white;    border: none;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label icon-lock" style="color: #f9ca0c;font-size: 28px;display: inline-block;"></label>
                                    <div class="controls" style="display: inline-block;width: 90%;">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Escribe tu contrase&ntilde;a" style="background: #2E2F31;color: white;    border: none;">
                                    </div>
                                </div>
                                <button class="btn btn-block btn-primary m-t-10" type="submit" style="background: #f9ca0c;width: 60%;"><i class="icon-cloud-download"></i>Entrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    </body>
</html>
