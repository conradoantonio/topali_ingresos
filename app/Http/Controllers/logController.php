<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\loginRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Ingreso;
use App\Coto;
use App\Privilegios;
use App\SolicitudIngreso;
use DB;
use Session;
use Auth;
use Redirect;
use PDO;

class logController extends Controller
{
    /**
     * Redirecciona al dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            if ( Session::get('privilegio') != "Guardia" ) {
                $title = 'Inicio';
                $menu = 'Inicio';
                $dashboard = $this->dashboardAdminData();
                $user_sessions = $this->get_userSesions();
                return view('admin.dashboard', ['title' => $title, 'menu' => $menu, 'user_sessions' => $user_sessions, 'dashboard' => json_decode($dashboard)]);
            } else {
                return redirect::to('/administrar/ingresos/cotos');
            }
        } else {
            return redirect::to('/');
        }
    }

    /**
     * Valida el inicio de sesión de un usuario.
     *
     * @param  App\Http\Requests\loginRequest $request
     * @return view admin si el usuario y contraseña son correctos, o view login si falla cualquiera de los datos proporcionados.
     */
    public function store(loginRequest $request)
    {
        if(Auth::attempt(['correo' => $request['correo'], 'password' => $request['password'], 'status' => 1])){
            $privilegio = Privilegios::where('id',Auth::user()->privilegios_id)->first();
            Session::put('privilegio', $privilegio->tipo);
            if ($privilegio->tipo == "Casa") {
                return redirect()->action('SolicitudesController@index');
            }
            if ($privilegio->tipo == "Guardia") {
                return redirect()->action('SolicitudesController@solicitudes_ingreso_coto');
            }

            
            return Redirect::to('dashboard');
        }
        //Session::flash('message-error', 'Datos son incorrectos');
        $error = true;
        return redirect()->back()->with('valido' , [md5('false')]);
        //return Redirect::to('/')->with('error');
        
    }

    /**
     * Termina la sesión de un usuario.
     *
     * @return Regresa al login
     */
    public function logout() 
    {
        Auth::logout();
        return Redirect('/');
    }

    /**
     * @return The total of app users, banned app users, denuncias, denuncias aprobadas y porcentajes de usuarios bloqueados y denuncias aprobadas.
     * Dat spanglish mate
     */
    public function dashboardAdminData() 
    {
        $main_data = new \stdClass();
        if (auth()->user()->privilegios_id == 2){
            $serv_id = Coto::where('users_id', auth()->user()->id)->pluck('id');
        } else {
            $serv_id = null;
        }
        $main_data->total_servicios = User::count_users_by_status(2,$serv_id);
        $main_data->total_casas = User::count_users_by_status(7,$serv_id);
        $main_data->total_guardia = User::count_users_by_status(6,$serv_id);
        $main_data->usuarios_mes = User::usuarios_mes($serv_id);

        $main_data->ingreso_dia = Ingreso::ingresos_egresos_dia(0,$serv_id);
        $main_data->egreso_dia = Ingreso::ingresos_egresos_dia(1,$serv_id);
        $main_data->ingreso_mes = Ingreso::ingreso_mes($serv_id);

        $main_data->solicitudes_pendientes = SolicitudIngreso::solicitudes_pendientes_revisadas(0,$serv_id);
        $main_data->solicitudes_atendidas = SolicitudIngreso::solicitudes_pendientes_revisadas(1,$serv_id);
        $main_data->solicitudes_mes = SolicitudIngreso::solicitudes_mes($serv_id);
        
        return json_encode($main_data);
    }
    
    /**
     * @return Regresa el número total de pueblos registrados.
     */
    public function get_userSesions() {
        $dias_s = array('','Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');

        date_default_timezone_set('America/Mexico_City');//Esto fue puesto para obtener corectamente la hora en local, remover si es necesario

        $query = DB::table('registro_logs')
        ->select(DB::raw('fechaLogin, MONTH(fechaLogin) as mes, DAY(fechaLogin) as dia, COUNT(*) AS total_inicios'))
        ->where('fechaLogin', '>=', DB::raw('SUBDATE(CURDATE(),INTERVAL 7 DAY)'))
        ->where('fechaLogin', '<', DB::raw('CURDATE()'))
        ->groupBy(DB::raw('DAY(fechaLogin)'))
        ->get();
        $semana = array();
        $dia_nombre = array();
        for ($i=1; $i <= 7; $i++) {
            $fechaActual = date("Y-m-d");
            $fechaActual = date_create($fechaActual);
            $fechaActual = date_sub($fechaActual, date_interval_create_from_date_string($i.' days'));
            array_push($semana, $fechaActual->format('Y-m-d'));
        }

        foreach ($semana as $dia) {
            array_push($dia_nombre, $dias_s[date('N', strtotime($dia))]);
        }

        $array_wd = array();
        foreach ($query as $value) {
            array_push($array_wd, $value->fechaLogin);
        }

        $numero_logs = array();
        foreach ($query as $value) {
            array_push($numero_logs, $value->total_inicios);
        }
        
        $final_array = $semana;

        foreach ($final_array as $key => $value) { $final_array[$key] = 0; }

        foreach ($array_wd as $key => $val) {
            $numero_logs[$key];
            $pasa = array_search($val, $semana);
            if (is_int($pasa)) {
                $final_array[$pasa] = $numero_logs[$key];
            } 
        }

        $object = new \stdClass();
        $object->dias_semana = array_reverse($dia_nombre);
        $object->total_logs = array_reverse($final_array);

        return json_encode($object);
    }
}
