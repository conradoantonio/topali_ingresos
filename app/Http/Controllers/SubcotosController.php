<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coto;
use App\Subcoto;
use App\Users;
use Redirect;

class SubcotosController extends Controller
{
    /**
     * Carga la tabla de subcotos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $title = "Administrar subcotos";
            $menu = "Subcotos y departamentos";
            $cotos = Coto::all();
            $subcotos = Subcoto::obtener_sucotos();
            return view('subcotos.subcotos', ['menu' => $menu, 'title' => $title, 'cotos' => $cotos, 'subcotos' => $subcotos]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda un subcoto nuevo.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function guardar_subcoto(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo);

        if (count($validar_correo)) {
            return redirect()->action('SubcotosController@index', ['valido' => md5('false')]);
        }

        /*Se crea un usuario para el coto*/
        $user = new Users;

        $user->nombre_completo = $req->nombre_responsable;
        $user->correo = $req->correo;
        $user->password = bcrypt($req->password);
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 4;//Se asigna con privilegios de admin subcoto

        $user->save();

        /*Se crea el subcoto*/
        $subcoto = new Subcoto;
        
        $subcoto->nombre_subcoto = $req->nombre_subcoto;
        $subcoto->direccion = $req->direccion;
        $subcoto->telefono_1 = $req->telefono_1;
        $subcoto->extension_tel_1 = $req->extension_tel_1;
        $subcoto->telefono_2 = $req->telefono_2;
        $subcoto->extension_tel_2 = $req->extension_tel_2;
        $subcoto->nombre_responsable = $req->nombre_responsable;
        $subcoto->puesto = $req->puesto;
        $subcoto->contacto = $req->contacto;
        $subcoto->cotos_id = $req->cotos_id;
        $subcoto->users_id = $user->id;

        $subcoto->save();

        return Redirect::to('/administrar/subcotos');
    }

    /**
     * Edita un subcoto existente.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function editar_subcoto(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo, $req->correo_viejo);

        if (count($validar_correo)) {
            return redirect()->action('SubcotosController@index', ['valido' => md5('false')]);
        }

        $subcoto = Subcoto::find($req->id);
        if (count($subcoto))
        {
            $subcoto->nombre_subcoto = $req->nombre_subcoto;
            $subcoto->direccion = $req->direccion;
            $subcoto->telefono_1 = $req->telefono_1;
            $subcoto->extension_tel_1 = $req->extension_tel_1;
            $subcoto->telefono_2 = $req->telefono_2;
            $subcoto->extension_tel_2 = $req->extension_tel_2;
            $subcoto->nombre_responsable = $req->nombre_responsable;
            $subcoto->puesto = $req->puesto;
            $subcoto->contacto = $req->contacto;
            $subcoto->cotos_id = $req->cotos_id;

            $subcoto->save();
        }

        if ($req->password != "") {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo, 'password' => bcrypt($req->password)];
        } else {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update);

        return Redirect::to('/administrar/subcotos');
    }

    /**
     * Elimina un subcoto.
     *
     * @param  \Illuminate\Http\Request $req
     * @return ["success" => true]
     */
    public function eliminar_subcoto(Request $req)
    {
        try {
            $subcoto = Subcoto::find($req->id);
            $subcoto->delete();
            return ["success" => true];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }
}
