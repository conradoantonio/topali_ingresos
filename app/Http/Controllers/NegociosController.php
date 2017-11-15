<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Negocio;
use App\Users;
use Redirect;

class NegociosController extends Controller
{
    /**
     * Carga la tabla de negocios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $title = "Administrar negocios";
            $menu = "Cotos y negocios";
            $negocios = Negocio::obtener_negocios();
            return view('negocios.negocios', ['menu' => $menu, 'title' => $title, 'negocios' => $negocios]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda un negocio nuevo.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function guardar_negocio(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo);

        if (count($validar_correo)) {
            return redirect()->action('NegociosController@index', ['valido' => md5('false')]);
        }

        /*Se crea un usuario para el negocio*/
        $user = new Users;

        $user->nombre_completo = $req->nombre_responsable;
        $user->correo = $req->correo;
        $user->password = bcrypt($req->password);
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 3;//Se asigna con privilegios de admin negocio

        $user->save();

        /*Se crea el negocio*/
        $negocio = new Negocio;
        
        $negocio->nombre = $req->nombre;
        $negocio->nombre_comercial = $req->nombre_comercial;
        $negocio->direccion = $req->direccion;
        $negocio->telefono_1 = $req->telefono_1;
        $negocio->extension_tel_1 = $req->extension_tel_1;
        $negocio->telefono_2 = $req->telefono_2;
        $negocio->extension_tel_2 = $req->extension_tel_2;
        $negocio->nombre_responsable = $req->nombre_responsable;
        $negocio->puesto = $req->puesto;
        $negocio->contacto = $req->contacto;
        $negocio->users_id = $user->id;

        $negocio->save();

        return Redirect::to('/administrar/negocios');
    }

    /**
     * Edita un negocio existente.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function editar_negocio(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo, $req->correo_viejo);

        if (count($validar_correo)) {
            return redirect()->action('NegociosController@index', ['valido' => md5('false')]);
        }

        $negocio = Negocio::find($req->id);
        if (count($negocio))
        {
            $negocio->nombre = $req->nombre;
            $negocio->nombre_comercial = $req->nombre_comercial;
            $negocio->direccion = $req->direccion;
            $negocio->telefono_1 = $req->telefono_1;
            $negocio->extension_tel_1 = $req->extension_tel_1;
            $negocio->telefono_2 = $req->telefono_2;
            $negocio->extension_tel_2 = $req->extension_tel_2;
            $negocio->nombre_responsable = $req->nombre_responsable;
            $negocio->puesto = $req->puesto;
            $negocio->contacto = $req->contacto;

            $negocio->save();
        }

        if ($req->password != "") {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo, 'password' => bcrypt($req->password)];
        } else {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update);
        
        return Redirect::to('/administrar/negocios');
    }

    /**
     * Elimina un negocio.
     *
     * @param  \Illuminate\Http\Request $req
     * @return ["success" => true]
     */
    public function eliminar_negocio(Request $req)
    {
        try {
            $negocio = Negocio::find($req->id);
            $negocio->delete();
            return ["success" => true];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }
}
