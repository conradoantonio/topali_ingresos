<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuarios;
use App\Persona;
use App\Users;
use App\Coto;
use App\Subcoto;
use App\Casa;
use App\Guardia;
use App\Ingreso;
use App\TipoVisita;
use Image;
use DB;
use Excel, Input, File;
use Redirect;
use Session;

class IngresosController extends Controller
{
    /**
     * Despliega la lista de ingresos por coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function ingresos_cotos()
    {
        if (auth()->check()) {
            $title = "Administrar ingresos de coto";
            $menu = "Ingresos";
            $servicio_id = $this->obtener_coto_usuario();
            $num_lug = Coto::where('id', $servicio_id)->pluck('num_lugares');
            $ingresos = Ingreso::obtener_ingresos_personas($servicio_id, 0);
            $cont = 0;
            foreach($ingresos as $ingreso){
                if($ingreso->texto_placa) {
                    $cont++;
                }
            }
            //dd($cont);
            return view('ingresos.cotos.index', ['ingresos' => $ingresos, 'num_lugares' => $num_lug, 'ocupados' => $cont, 'menu' => $menu, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    public function historial_ingresos(Request $request)
    {
        if (auth()->check()) {
            $title = "Historial de ingresos de coto";
            $menu = "Historial";
            if (auth()->user()->privilegios_id == 2){
                $servicio_id = $this->obtener_coto_usuario();
            } else {
                $servicio_id = 0;
            }
            if ( $request->ajax() ) {
                //dd($servicio_id);
            	if ( isset($request->fecha_inicio) || isset($request->fecha_fin) || isset($request->status) ){
                    $ingresos = Ingreso::obtener_ingresos_personas($servicio_id, null,$request->fecha_inicio, $request->fecha_fin);
                }
                return $ingresos;
            } else {
                $ingresos = Ingreso::obtener_ingresos_personas($servicio_id, null,null,null);
                return view('ingresos.cotos.historial', ['ingresos' => $ingresos, 'menu' => $menu, 'title' => $title]);
            }
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Despliega la lista de ingresos por coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function form_ingresos_cotos()
    {
        if (auth()->check()) {
            $title = "Formulario de ingreos para coto";
            $menu = "Ingresos";
            $servicio_id = $this->obtener_coto_usuario();
            $personas = auth()->user()->privilegios_id == 6 ? Persona::get_personas_coto($servicio_id) : Persona::obtener_personas_coto($servicio_id);//Buscará las personas que han ingresado anteriormente al coto
            //return $personas;
            $subcotos = $this->obtener_subcotos($servicio_id);
            $casas = $this->obtener_casas($servicio_id);
            $tipo_visita = TipoVisita::all();
            return view('ingresos.cotos.formulario_ingresos', ['tipo_visita' => $tipo_visita, 'personas' => $personas, 'subcotos' => $subcotos, 'casas' => $casas, 'menu' => $menu, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
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

    /**
     * Regresa los subcotos en caso de el coto contenga alguno.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_subcotos($coto_id)
    {
        if (auth()->check()) {
            return Subcoto::where('cotos_id', $coto_id) ->get();
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Regresa los subcotos en caso de el coto contenga alguno.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_casas($coto_id)
    {
        if (auth()->check()) {
            return Casa::where('coto_id', $coto_id) ->get();
        } else {
            return Redirect::to('/');
        }
    }
    
    /**
     * Guarda un ingreso nuevo.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function guardar_ingreso(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        //$req->persona_id ? dd('old person') : dd('new person');
        if ($req->persona_id) {//Si seleccionó una persona que ya existe.
            $visitante = Persona::find($req->persona_id);
            $visitante->texto_placa = $req->texto_placas;

            if ($req->foto_b64) {//Se actualiza la foto de identificación.
                $encoded_data = $req->foto_b64;
                $binary_data = base64_decode( $encoded_data );
                $ruta_foto = 'img/identificacion/'.time().'.jpg';
                
                $visitante->foto_identificacion = $ruta_foto;
                
                $result = file_put_contents( $ruta_foto, $binary_data );
            }
            if ($req->foto2_b64) {//Se actualiza la foto de identificación.
                $encoded_data = $req->foto2_b64;
                $binary_data = base64_decode( $encoded_data );
                $ruta_foto = 'img/foto_personal/'.time().'.jpg';
                
                $visitante->foto_personal = $ruta_foto;
                
                $result = file_put_contents( $ruta_foto, $binary_data );
            }
            elseif ($req->file('foto_personal')) {//Se actualiza la foto personal
                $name = "img/foto_personal/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
                $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
                $extension_archivo = $req->file('foto_personal')->getClientOriginalExtension();
                if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $imagen = $req->file('foto_personal');
                    $name = 'img/foto_personal/'.time().'.'.$req->file('foto_personal')->getClientOriginalExtension();
                    $imagen->move('img/foto_personal', $name);

                    /*$name = 'img/foto_personal/'.time().'.'.$req->file('foto_personal')->getClientOriginalExtension();
                    $imagen_portada = Image::make($req->file('foto_personal'))
                    ->save($name);*/
                }
                $visitante->foto_personal = $name;
            }

        } else {//Se crea una persona nueva
            $visitante = New Persona;
            $visitante->texto_placa = $req->texto_placas;
            $visitante->nombre_persona = $req->visitante;
            if ($req->foto_b64) {//Se sube una foto de identificación.
                $encoded_data = $req->foto_b64;
                $binary_data = base64_decode( $encoded_data );
                $ruta_foto = 'img/identificacion/'.time().'.jpg';
                
                $result = file_put_contents( $ruta_foto, $binary_data );
                $visitante->foto_identificacion = $ruta_foto;
            }
            if ($req->foto2_b64) {//Se actualiza la foto de identificación.
                $encoded_data = $req->foto2_b64;
                $binary_data = base64_decode( $encoded_data );
                $ruta_foto = 'img/foto_personal/'.time().'.jpg';
                
                $result = file_put_contents( $ruta_foto, $binary_data );
                $visitante->foto_personal = $ruta_foto;
            } elseif ($req->file('foto_personal')) {//Se actualiza la foto personal
                $name = "img/foto_personal/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
                $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
                $extension_archivo = $req->file('foto_personal')->getClientOriginalExtension();
                if (array_search($extension_archivo, $extensiones_permitidas)) {
                    $imagen = $req->file('foto_personal');
                    $name = 'img/foto_personal/'.time().'.'.$req->file('foto_personal')->getClientOriginalExtension();
                    $imagen->move('img/foto_personal', $name);
                    /*$name = 'img/foto_personal/'.time().'.'.$req->file('foto_personal')->getClientOriginalExtension();
                    $imagen_portada = Image::make($req->file('foto_personal'))
                    ->save($name);*/
                }
                $visitante->foto_personal = $name;
            }
        }

        $visitante->save();
        //dd('se reutiliza este id de persona');

        $ingreso = new Ingreso;

        $ingreso->tipo_ingreso = 1;
        $ingreso->main_id = $this->obtener_coto_usuario();
        $ingreso->sub_id = $req->subcotos;
        $ingreso->casa_id = $req->casas;
        $ingreso->tipo_visita_id = $req->tipo_visita_id;
        $ingreso->comentarios = $req->comentarios;
        $ingreso->personas_id = $req->persona_id ? $req->persona_id : $visitante->id ;
        $ingreso->va_con = $req->va_con;
        $ingreso->created_at = date("Y-m-d H:i:s");

        $ingreso->save();

        return Redirect::to('/administrar/ingresos/cotos');
    }

    /**
     * Finaliza la visita de una persona.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function marcar_salida(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        $row = DB::table('ingresos')
        ->where('id', $req->ingreso_id)
        ->update(['egreso' => 1, 'hora_egreso' => date("Y-m-d H:i:s")]);

        return $row;
    }

    public function exportar($fecha_inicio, $fecha_fin,$tipo_ingreso){
    	$inicio = ($fecha_inicio != 'false' )?$fecha_inicio:'';
    	$fin = ($fecha_fin != 'false' )?$fecha_fin:'';
    	$query = Ingreso::select(DB::raw('ingresos.id, personas.nombre_persona, personas.texto_placa, ingresos.main_id AS coto_id, cotos.nombre AS nombre_coto, IF(ingresos.hora_egreso,ingresos.hora_egreso,"Sin hora egreso") as hora_egreso, tipo_visita.tipo AS tipo_visita, ingresos.comentarios, ingresos.va_con, casas.folio_casa, ingresos.created_at as fecha_ingreso'
		))
        ->leftJoin('personas', 'ingresos.personas_id', '=', 'personas.id')
        ->leftJoin('tipo_visita', 'ingresos.tipo_visita_id', '=', 'tipo_visita.id')
        ->leftJoin('cotos', 'ingresos.main_id', '=', 'cotos.id')
        ->leftJoin('subcotos', 'ingresos.sub_id', '=', 'subcotos.id')
        ->leftJoin('casas', 'ingresos.casa_id', '=', 'casas.id');

        if (auth()->user()->privilegios_id == 2){
            $servicio_id = $this->obtener_coto_usuario();
            $query->where('cotos.id',$servicio_id);
        }

        if ( !empty($inicio) ){
        	$query->where('ingresos.created_at','>=',$inicio.' 00:00:00');
        }

        if ( !empty($fin) ){
        	$query->where('ingresos.created_at','<=',$fin.' 23:59:59');
        }

    	$ingresos = $query->get();
    	
    	Excel::create('Historial ingresos', function($excel) use($ingresos) {
            $excel->sheet('Hoja 1', function($sheet) use($ingresos) {
                $sheet->cells('A:K', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($ingresos);
            });
        })->export('xlsx');
    }

    public function ingresos_by_service($servicio_id){
    	if (auth()->check()) {
            $title = "Ver ingresos de servicio";
            $menu = "Ingresos";
            $ingresos = Ingreso::obtener_ingresos_personas($servicio_id, 0);
            $nom_serv = DB::table('cotos')->select('nombre')->where('id',$servicio_id)->first();
            return view('cotos.vista_ingresos', ['ingresos' => $ingresos, 'menu' => $menu, 'title' => $title, 'nom_serv' => $nom_serv->nombre]);
        } else {
            return Redirect::to('/');
        }
    }

    public function egresos_by_service($servicio_id){
    	if (auth()->check()) {
            $title = "Ver ingresos de servicio";
            $menu = "Ingresos";
            $egresos = Ingreso::obtener_ingresos_personas($servicio_id, 1);
            $nom_serv = DB::table('cotos')->select('nombre')->where('id',$servicio_id)->first();
            return view('cotos.vista_egresos', ['egresos' => $egresos, 'menu' => $menu, 'title' => $title, 'nom_serv' => $nom_serv->nombre]);
        } else {
            return Redirect::to('/');
        }
    }

    public function casas_by_service($servicio_id){
    	if (auth()->check()) {
            $title = "Usuarios Casa";
            $menu = "Usuarios";
            $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
            $subcotos = app('App\Http\Controllers\IngresosController')->obtener_subcotos($coto_id);
            $nom_serv = DB::table('cotos')->select('nombre')->where('id',$servicio_id)->first();
            $casas = Users::usuarios_casas($servicio_id);
            return view('cotos.vista_casas', ['menu' => $menu, 'subcotos' => $subcotos, 'casas' => $casas, 'title' => $title, 'nom_serv' => $nom_serv->nombre]);
        } else {
            return Redirect::to('/');
        }
    }
}
