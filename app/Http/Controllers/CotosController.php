<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coto;
use App\Casa;
use App\Users;
use App\TipoServicio;
use App\Estado;
use DB;
use Excel, Input, File;
use Redirect;
class CotosController extends Controller
{
    /**
     * Carga la tabla de cotos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $title = "Administrar servicios";
            $menu = "Servicios";
            $cotos = Coto::obtener_cotos();
            if ( $request->ajax() ) {
            	if ( isset($request->fecha_inicio) || isset($request->fecha_fin) ){
            		$cotos = Coto::obtener_cotos($request->fecha_inicio, $request->fecha_fin);
            	}
                return $cotos;
            } else {
                return view('cotos.cotos', ['menu' => $menu, 'title' => $title, 'cotos' => $cotos]);
            }
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda un coto nuevo.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function guardar_coto(Request $req)
    {
        $validar_correo_servicio = Users::buscar_usuario_por_correo($req->correo);

        if (count($validar_correo_servicio)) {
            return;
            //return redirect()->action('CotosController@index', ['valido' => md5('false')]);
            echo $validar_correo_servicio;
        }

        $validar_correo_guardia = Users::buscar_usuario_por_correo($req->correo_guardia);

        if (count($validar_correo_guardia)) {
            echo $validar_correo_guardia;
        }

        /*Se crea un guardia del coto*/
        $guardia = new Users;

        $guardia->nombre_completo = $req->nombre_responsable_guardia;
        $guardia->correo = $req->correo_guardia;
        $guardia->password = bcrypt($req->password_guardia);
        $guardia->contra = $req->password_guardia;
        $guardia->foto_perfil = "img/img_users/default.jpg";
        $guardia->privilegios_id = 6;//Se asigna con privilegios de guardia

        $guardia->save();

        /*Se crea un usuario para el coto*/
        $user = new Users;

        $user->nombre_completo = $req->nombre_responsable;
        $user->correo = $req->correo;
        $user->password = bcrypt($req->password);
        $user->contra = $req->password;
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 2;//Se asigna con privilegios de admin coto

        $user->save();

        /*Se crea el coto*/
        $coto = new Coto;
        
        $coto->nombre = $req->nombre;
        $coto->tipo_servicio = $req->tipo_servicio;
        $coto->unidad_privativa = $req->unidad_privativa;
        $coto->direccion = $req->direccion;
        $coto->telefono_1 = $req->telefono_1;
        $coto->num_lugares = $req->num_lugares;
        $coto->nombre_responsable = $req->nombre_responsable;
        $coto->users_id = $user->id;
        $coto->guardia_users_id = $guardia->id;
        $coto->id_estado = $req->estado_id;

        $coto->save();

        //return Redirect::to('/administrar/cotos');
    }

    /**
     * Edita un coto existente.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function editar_coto(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo, $req->correo_viejo);

        if (count($validar_correo)) {
            return;
            //return redirect()->action('CotosController@index', ['valido' => md5('false')]);
        }

        $validar_correo_guardia = Users::buscar_usuario_por_correo($req->correo_guardia, $req->correo_viejo_guardia);

        if (count($validar_correo_guardia)) {
            return;
            //return redirect()->action('CotosController@index', ['valido' => md5('false')]);
        }

        $coto = Coto::find($req->id);
        if (count($coto))
        {
            $coto->nombre = $req->nombre;
            $coto->tipo_servicio = $req->tipo_servicio;
            $coto->unidad_privativa = $req->unidad_privativa;
            $coto->direccion = $req->direccion;
            $coto->telefono_1 = $req->telefono_1;
            $coto->num_lugares = $req->num_lugares;
            $coto->nombre_responsable = $req->nombre_responsable;
            $coto->id_estado = $req->estado_id;

            $coto->save();
        }

        if ($req->password != "") {
            $update_user_coto = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo, 'password' => bcrypt($req->password), 'contra' => $req->password];
        } else {
            $update_user_coto = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update_user_coto);

        /*Update para el guardia si es que se necesita*/
        if ($req->password_guardia != "") {
            $update_user_guardia = ['nombre_completo' => $req->nombre_responsable_guardia, 'correo' => $req->correo_guardia, 'password' => bcrypt($req->password_guardia), 'contra' => $req->password_guardia];
        } else {
            $update_user_guardia = ['nombre_completo' => $req->nombre_responsable_guardia, 'correo' => $req->correo_guardia];
        }

        Users::where('correo', $req->correo_viejo_guardia)
        ->update($update_user_guardia);

        //return Redirect::to('/administrar/cotos');
    }

    /**
     * Elimina un coto.
     *
     * @param  \Illuminate\Http\Request $req
     * @return ["success" => true]
     */
    public function eliminar_coto(Request $req)
    {
        try {
            //$usuarios_relacionados = DB::table('users')->pluck('title')->first();
            $coto = Coto::where('users_id', $req->id)->first();
            $usuarios_casas = Casa::where('coto_id', $coto->id)->lists('users_id');

            Users::whereIn('id', $usuarios_casas)->delete();//Se borran los usuarios casa del servicio.
            Users::where('id', $req->id)->delete();//Se borra el administrador del servicio.
            Users::where('id', $coto->guardia_users_id)->delete();//Se borra el guardia.
            #Casa::where('coto_id', $coto->id)->delete();

            Coto::where('users_id', $req->id)->delete();

            /*Coto::where('users_id', $req->id)->delete();
            Users::where('id', $req->id)->delete();*/
            return ["success" => true];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }

    public function create(){
        $title = "Lista de servicios";
        $menu = "Servicios";
        $servicios = Coto::obtener_cotos();
        $tipo = TipoServicio::all();
        $estados = Estado::all();
        return view('cotos.add',['menu' => $menu, 'title' => $title, 'servicios' => $servicios, 'tipo' => $tipo, 'estados'=> $estados]);
    }

    public function exportar($fecha_inicio, $fecha_fin){
    	$inicio = ($fecha_inicio != 'false' )?$fecha_inicio:'';
    	$fin = ($fecha_fin != 'false' )?$fecha_fin:'';
    	//$cotos = Coto::obtener_cotos($inicio, $fin);

    	$query = Coto::select(DB::raw("cotos.id, cotos.nombre, cotos.direccion, cotos.telefono_1 as telefono, cotos.num_lugares as numero_lugares, cotos.unidad_privativa, users.correo AS 'correo_servicio', users_2.nombre_completo AS 'guardia_responsable', users_2.correo AS 'correo_guardia', cotos.created_at as creacion, cotos.updated_at as actualizado"))
        ->leftJoin('users', 'cotos.users_id', '=', 'users.id')
        ->leftJoin('users as users_2', 'cotos.guardia_users_id', '=', 'users_2.id')
        ->leftJoin('estados','estados.id_estado','=','cotos.id_estado')
        ->where('cotos.status', 1);
        
        if ( !empty($inicio) ){
        	$query->where('cotos.created_at','>=',$inicio.' 00:00:00');
        }

        if ( !empty($fin) ){
        	$query->where('cotos.created_at','<=',$fin.' 23:59:59');
        }

        $cotos = $query->get();
    	
    	Excel::create('Servicios', function($excel) use($cotos) {
            $excel->sheet('Hoja 1', function($sheet) use($cotos) {
                $sheet->cells('A:K', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($cotos);
            });
        })->export('xlsx');
    }
}