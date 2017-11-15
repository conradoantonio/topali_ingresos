<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SolicitudIngreso;
use App\Guardia;
use App\Casa;
use App\Coto;
use App\Persona;
use App\TipoVisita;
use DB;
use Session;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {

        	$title = "Solicitudes de ingreso";
	        $menu = "Mis solicitudes";
        	$casa_id = $this->obtener_casa_usuario();
            $solicitudes = SolicitudIngreso::obtener_solicitudes($casa_id);
        	if ( $request->ajax() ) {      
                return $solicitudes;		
	           // return view('solicitudes.table', ['solicitudes' => $solicitudes]);
        	} else {
        	    //echo auth()->user()->id;
        	    $serv = Casa::where('users_id', auth()->user()->id)->pluck('coto_id');
        	    $personas = Persona::get_personas_coto($serv);
        		$tipo_visita = TipoVisita::all();
	            return view('solicitudes.solicitudUsuarioCasa', ['solicitudes' => $solicitudes, 'menu' => $menu, 'title' => $title, 'personas' => $personas, 'tipo_visita' => $tipo_visita]);
        	} 
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Regresa el id del coto vinculado al usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_casa_usuario()
    {
        if (auth()->check()) {
            return Casa::where('users_id', auth()->user()->id)->pluck('id');
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Regresa el id del coto vinculado al usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar_solicitud_ingreso_coto(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');

        if ($req->persona_id) {//Si seleccion¨® una persona que ya existe.
            $visitante = Persona::find($req->persona_id);
            //$visitante->texto_placa = $req->texto_placas;
        } else {//Se crea una persona nueva
            $visitante = New Persona;
            $visitante->nombre_persona = $req->visitante;
        	$visitante->save();
        }

        $solicitud = new SolicitudIngreso;
        $solicitud->casa_id = $this->obtener_casa_usuario();
        $solicitud->persona_id = $req->persona_id ? $req->persona_id : $visitante->id ;
        $solicitud->tipo_visita = $req->tipo_visita_id;
        $solicitud->fecha_visita = $req->fecha_visita;
        $solicitud->hora_visita = $req->hora_visita;
        $solicitud->mensaje = $req->mensaje;
        $solicitud->created_at =  date("Y-m-d H:i:s");
        if ( $solicitud->save() ){
        	echo 'save';
        } else {
        	dd($validation->messages());
        }
        $solicitud->save();

        //return redirect()->to('/solicitar/ingreso/coto');
    }

    /**
     * Regresa el id del coto vinculado al usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudes_ingreso_coto(Request $req)
    {
        if (auth()->check()) {
            $title = "Solicitudes de ingreso";
            $menu = "Solicitudes ingresos coto";
            $solicitudes = $this->obtener_casas_coto();

            return view('solicitudes.solicitudesIngresosCoto', ['solicitudes' => $solicitudes, 'menu' => $menu, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Regresa un arreglo de id de las casas de un coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_casas_coto()
    {
        $casas_id = array();
        $coto_id = Coto::where('guardia_users_id', auth()->user()->id)->pluck('id');
        //$coto_id = Guardia::where('users_id', auth()->user()->id)->pluck('coto_id');
        $casas = Casa::where('coto_id', $coto_id)->get();

        foreach ($casas as $casa) {
            array_push($casas_id, $casa->id);
        }

        return SolicitudIngreso::select(DB::raw('solicitudes_ingreso.*, casas.folio_casa'))
        ->whereIn('casa_id', $casas_id)
        ->leftJoin('casas', 'solicitudes_ingreso.casa_id', '=', 'casas.id')
        ->get();
    }

    /**
     * Regresa un arreglo de id de las casas de un coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function checar_solicitud_ingreso_coto(Request $req)
    {
        return DB::table('solicitudes_ingreso')
        ->where('id', $req->solicitud_id)
        ->update(['status' => 1]);
    }

	public function show($id){
		return DB::table('solicitudes_ingreso')
			->leftJoin('personas','solicitudes_ingreso.persona_id', '=', 'personas.id')
            ->leftJoin('tipo_visita','tipo_visita.id','=','solicitudes_ingreso.tipo_visita')
			->where('solicitudes_ingreso.id','=',$id)
			->get();
	} 

    public function get_solicitud_persona(Request $req){
        return DB::table('solicitudes_ingreso')
            ->leftJoin('casas', 'casas.id','=','solicitudes_ingreso.casa_id')
            ->leftJoin('tipo_visita', 'tipo_visita.id','=','solicitudes_ingreso.tipo_visita')
            ->where('persona_id','=',$req->id)
            ->where('solicitudes_ingreso.status','=',0)
            ->orderBy('created_at','desc')
            ->select('solicitudes_ingreso.*', 'casas.folio_casa', 'tipo_visita.tipo')
            ->get();
    }

    public function get_solicitud_persona_by_casa(Request $req){
        return DB::table('solicitudes_ingreso')
            ->leftJoin('casas', 'casas.id','=','solicitudes_ingreso.casa_id')
            ->leftJoin('tipo_visita', 'tipo_visita.id','=','solicitudes_ingreso.tipo_visita')
            ->leftJoin('personas', 'personas.id','=','solicitudes_ingreso.persona_id')
            ->where('casas.id','=',$req->id)
            ->where('solicitudes_ingreso.status','=',0)
            ->orderBy('created_at','desc')
            ->select('solicitudes_ingreso.*', 'casas.folio_casa', 'tipo_visita.tipo','personas.nombre_persona as nombre')
            ->get();
    }
    
    /**
     * Regresa el id del coto vinculado al usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_coto_usuario()
    {
        if (auth()->check()) {
            if(Session::get('privilegio') == "Guardia") {
                //return Guardia::where('users_id', auth()->user()->id)->pluck('coto_id');
                return Coto::where('guardia_users_id', auth()->user()->id)->pluck('id');
            }
            /*if(Session::get('privilegio') == "Administrador Coto") {*/
                return Coto::where('users_id', auth()->user()->id)->pluck('id');
            /*}*/
        } else {
            return Redirect::to('/');
        }
    }
}
