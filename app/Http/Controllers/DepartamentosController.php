<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Negocio;
use App\Departamento;
use App\Users;
use Redirect;

class DepartamentosController extends Controller
{
    /**
     * Carga la tabla de departamentos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $title = "Administrar departamentos";
            $menu = "Subcotos y departamentos";
            $negocios = Negocio::all();
            $departamentos = Departamento::obtener_departamentos();
            return view('departamentos.departamentos', ['menu' => $menu, 'title' => $title, 'negocios' => $negocios, 'departamentos' => $departamentos]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda un departamento nuevo.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function guardar_departamento(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo);

        if (count($validar_correo)) {
            return redirect()->action('DepartamentosController@index', ['valido' => md5('false')]);
        }

        /*Se crea un usuario para el coto*/
        $user = new Users;

        $user->nombre_completo = $req->nombre_responsable;
        $user->correo = $req->correo;
        $user->password = bcrypt($req->password);
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 5;//Se asigna con privilegios de admin coto

        $user->save();

        /*Se crea el coto*/
        $departamento = new Departamento;
        
        $departamento->nombre_departamento = $req->nombre_departamento;
        $departamento->direccion = $req->direccion;
        $departamento->telefono_1 = $req->telefono_1;
        $departamento->extension_tel_1 = $req->extension_tel_1;
        $departamento->telefono_2 = $req->telefono_2;
        $departamento->extension_tel_2 = $req->extension_tel_2;
        $departamento->nombre_responsable = $req->nombre_responsable;
        $departamento->puesto = $req->puesto;
        $departamento->contacto = $req->contacto;
        $departamento->negocios_id = $req->negocios_id;
        $departamento->users_id = $user->id;

        $departamento->save();

        return Redirect::to('/administrar/departamentos');
    }

    /**
     * Edita un departamento existente.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function editar_departamento(Request $req)
    {
        $validar_correo = Users::buscar_usuario_por_correo($req->correo, $req->correo_viejo);

        if (count($validar_correo)) {
            return redirect()->action('DepartamentosController@index', ['valido' => md5('false')]);
        }

        $departamento = Departamento::find($req->id);
        if (count($departamento))
        {
            $departamento->nombre_departamento = $req->nombre_departamento;
            $departamento->direccion = $req->direccion;
            $departamento->telefono_1 = $req->telefono_1;
            $departamento->extension_tel_1 = $req->extension_tel_1;
            $departamento->telefono_2 = $req->telefono_2;
            $departamento->extension_tel_2 = $req->extension_tel_2;
            $departamento->nombre_responsable = $req->nombre_responsable;
            $departamento->puesto = $req->puesto;
            $departamento->contacto = $req->contacto;
            $departamento->negocios_id = $req->negocios_id;

            $departamento->save();
        }

        if ($req->password != "") {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo, 'password' => bcrypt($req->password)];
        } else {
            $update = ['nombre_completo' => $req->nombre_responsable, 'correo' => $req->correo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update);
        
        return Redirect::to('/administrar/departamentos');
    }

    /**
     * Elimina un departamento.
     *
     * @param  \Illuminate\Http\Request $req
     * @return ["success" => true]
     */
    public function eliminar_departamento(Request $req)
    {
        try {
            $departamento = Departamento::find($req->id);
            $departamento->delete();
            return ["success" => true];
        } catch(\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }
}
