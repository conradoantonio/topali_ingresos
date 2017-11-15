<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuarios;
use App\Users;
use App\Casa;
use App\Guardia;
use App\Privilegios;
use DB;
use Session;
use Auth;
use Redirect;
use Hash;
use Image;
use Mail;

class UsuariosController extends Controller
{
    /**
     *=====================================================================================================================
     *=                    Empiezan las funciones relacionadas a los usuarios del panel administrativo                    =
     *=====================================================================================================================
     */

    /**
     * Muestra la tabla de los usuarios registrados del sistema.
     *
     * @return view usuarios.usuariosSistema.usuariosSistema
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $title = "Usuarios Sistema";
            $menu = "Usuarios";
            $privilegios = Privilegios::where('tipo', 'Super Administrador')->get();
            $usuarios = Users::usuarios_privilegios();
            if ( $request->ajax() ) {
                return $usuarios = Users::usuarios_privilegios();  
            }
            return view('usuarios.usuariosSistema.usuariosSistema', ['menu' => $menu, 'usuarios' => $usuarios, 'privilegios' => $privilegios, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Cambia la contraseña del usuario logeado del sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return contraseña status
     */
    public function change_password(Request $request)
    {
        $user = DB::table('users')
        ->where('correo', '=', $request->correo)
        ->where('id', '=', $request->id)
        ->first();

        if (Hash::check($request->actualPassword, $user->password)) {
            if ($request->newPassword == $request->confirmPassword) {
                $change = Users::find($request->id);
                $change->password = bcrypt($request->newPassword);
                $change->save();
                return 'contra cambiada';
            } else {
                return 'contra nueva diferentes';
            }
        } else {
            return 'contra erronea';
        }
    }

    /**
     * Guarda o edita un usuario del sistema, validando imagen y que el nombre de usuario sea único
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect /admin/usuarios/sistema
     */
    public function guardar_usuario(Request $request)
    {
        $name = "img/img_users/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
        if ($request->file('foto_usuario')) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
            $extension_archivo = $request->file('foto_usuario')->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $imagen = $request->file('foto_usuario');
                $name = 'img/img_users/'.time().'.'.$request->file('foto_usuario')->getClientOriginalExtension();
                $imagen->move('img/img_users', $name);
                /*$name = 'img/img_users/'.time().'.'.$request->file('foto_usuario')->getClientOriginalExtension();
                $imagen_portada = Image::make($request->file('foto_usuario'))
                ->resize(300, 300)
                ->save($name);*/
            }
        }

        if ($request->id != '') {// es un edit
            $validado = DB::table('users')
            ->where('correo', '=', $request->correo_nuevo)
            ->where('correo', '!=', $request->correo_viejo)
            ->get();
        } else {// es un insert
            $validado = DB::table('users')
            ->where('correo', '=', $request->correo_nuevo)
            ->get();
        }

        if(count($validado) > 0) {
            return redirect()->action('UsuariosController@index', ['valido' => md5('false')]);
        } else {

            if ($request->id != '') {//Es un edit
                $usuarioSistema = Users::find($request->id);

                $usuarioSistema->nombre_completo = $request->nombre_completo;
                $usuarioSistema->correo = $request->correo_nuevo;
                $request->password != '' ? $usuarioSistema->password = bcrypt($request->password) : '';
                $request->password != '' ? $usuarioSistema->contra = $request->password : '';
                $name != 'img/img_users/default.jpg' ? $usuarioSistema->foto_perfil = $name : '';
                $usuarioSistema->privilegios_id = $request->privilegios_id;
            } else {//Es un insert
                $usuarioSistema = new Users;
                $usuarioSistema->nombre_completo = $request->nombre_completo;
                $usuarioSistema->correo = $request->correo_nuevo;
                $usuarioSistema->password = bcrypt($request->password);
                $usuarioSistema->contra = $request->password;
                $usuarioSistema->foto_perfil = $name;
                $usuarioSistema->privilegios_id = $request->privilegios_id;
            }

            $usuarioSistema->save();

            //return redirect::to('/usuarios/sistema');
        }
    }

    /**
     * Elimina un usuario del sistema de forma lógica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Nada
     */
    public function eliminar_usuario(Request $request)
    {
        return DB::table('users')
        ->where('id', $request->id)
        ->update(['status' => 0]);
        /*$coto_id = DB::table('cotos')->where('users_id', $request->id)->pluck('id');
        $subcotos__users_id = DB::table('subcotos')->where('cotos_id', $coto_id)->lists('users_id');
        $negocio_id = DB::table('negocios')->where('users_id', $request->id)->pluck('id');
        $departamentos_users_id = DB::table('departamentos')->where('negocios_id', $coto_id)->lists('users_id');
        $new_array = array_merge($subcotos__users_id, $departamentos_users_id);
        Users::where('id', $request->id)->delete();
        DB::table('users')->whereIn('id', $new_array)->delete();*/
    }

    /**
     * Guarda la foto de perfil de un usuario del sistema
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Vuelve a la página anterior
     */
    public function guardar_foto_usuario_sistema(Request $request)
    {
        $name = "img/img_users/default.jpg";//Solo permanecerá con ese nombre cuando NO se seleccione una imágen como tal.
        if ($request->file('foto_perfil_sistema')) {
            $extensiones_permitidas = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png");
            $extension_archivo = $request->file('foto_perfil_sistema')->getClientOriginalExtension();
            if (array_search($extension_archivo, $extensiones_permitidas)) {
                $imagen = $request->file('foto_perfil_sistema');
                $name = 'img/img_users/'.time().'.'.$request->file('foto_perfil_sistema')->getClientOriginalExtension();
                $imagen->move('img/img_users', $name);
                
                /*$name = 'img/img_users/'.time().'.'.$request->file('foto_perfil_sistema')->getClientOriginalExtension();
                $imagen_portada = Image::make($request->file('foto_perfil_sistema'))
                ->resize(300, 300)
                ->save($name);*/
            }
        }

        $usuarioSistema = Users::find($request->id);

        $usuarioSistema->foto_perfil = $name;

        $usuarioSistema->save();

        return back();
    }

    /**
     *======================================================================================================================
     *=                     Empiezan las funciones relacionadas a la creación de los usuarios de casas                     =
     *======================================================================================================================
     */

    /**
     * Muestra la tabla de los usuarios tipo casa.
     *
     * @return view usuarios.usuariosCasa.usuariosCasa
     */
    public function usuarios_casa(Request $request)
    {
        if (auth()->check()) {
            $title = "Usuarios casa e industria";
            $menu = "Usuarios";
            $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
            $subcotos = app('App\Http\Controllers\IngresosController')->obtener_subcotos($coto_id);
            $casas = Users::usuarios_casas($coto_id);
            if ( $request->ajax() ){
                return view('usuarios.usuariosCasa.table', ['casas' => $casas, 'subcotos' => $subcotos]);
            } else {
                return view('usuarios.usuariosCasa.usuariosCasa', ['menu' => $menu, 'subcotos' => $subcotos, 'casas' => $casas, 'title' => $title]);
            }
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda una casa con su respectivo usuario
     *
     * @return view usuarios.usuariosCasa.usuariosCasa
     */
    public function guardar_casa(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        $validar_correo = Users::buscar_usuario_por_correo($req->correo_nuevo);

        if (count($validar_correo)) {
            $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
            return $casas = Users::usuarios_casas($coto_id);
            //return redirect()->action('UsuariosController@usuarios_casa', ['valido' => md5('false')]);
        }

        /*Se crea un usuario para la casa*/
        $user = new Users;

        $user->nombre_completo = $req->responsable;
        $user->correo = $req->correo_nuevo;
        $user->password = bcrypt($req->password);
        $user->contra = $req->password;
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 7;//Se asigna con privilegios de casa

        $user->save();

        /*Se crea el coto*/
        $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
        $casa = new Casa;
        
        $casa->folio_casa = $req->folio_casa;
        $casa->coto_id = $coto_id;
        $casa->calle_manzana = $req->calle_manzana;
        $casa->subcoto_id = $req->subcoto_id;
        $casa->users_id = $user->id;
        $casa->created_at = date("Y-m-d H:i:s");

        $casa->save();

        $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
        return $casas = Users::usuarios_casas($coto_id);
        //return Redirect::to('/usuarios/casas');
    }

    /**
     * Edita una casa y a su respectivo usuario
     *
     * @return view usuarios.usuariosCasa.usuariosCasa
     */
    public function editar_casa(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        $validar_correo = Users::buscar_usuario_por_correo($req->correo_nuevo, $req->correo_viejo);

        if (count($validar_correo)) {
            $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
            return $casas = Users::usuarios_casas($coto_id);
            //return redirect()->action('UsuariosController@usuarios_casa', ['valido' => md5('false')]);
        }

        /*Se busca el usuario de la casa*/
        if ($req->password != "") {
            $update = ['nombre_completo' => $req->responsable, 'correo' => $req->correo_nuevo, 'password' => bcrypt($req->password), 'contra' => $req->password];
        } else {
            $update = ['nombre_completo' => $req->responsable, 'correo' => $req->correo_nuevo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update);

        /*Se busca la casa*/
        $casa = Casa::find($req->id);
        
        $casa->folio_casa = $req->folio_casa;
        $casa->subcoto_id = $req->subcoto_id;
        $casa->calle_manzana = $req->calle_manzana;
        $casa->save();
        
        $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
        return $casas = Users::usuarios_casas($coto_id);
        //return Redirect::to('/usuarios/casas');
    }

    /**
     *=====================================================================================================================
     *=                   Empiezan las funciones relacionadas a la creación de los usuarios de guardias                   =
     *=====================================================================================================================
     */

    /**
     * Muestra la tabla de los usuarios tipo guardia
     *
     * @return view usuarios.usuariosGuardia.usuariosGuardia
     */
    public function usuarios_guardia()
    {
        if (auth()->check()) {
            $title = "Usuarios Guardia";
            $menu = "Usuarios";
            $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
            $subcotos = app('App\Http\Controllers\IngresosController')->obtener_subcotos($coto_id);
            $guardias = Users::usuarios_guardias();
            return view('usuarios.usuariosGuardia.usuariosGuardia', ['menu' => $menu, 'subcotos' => $subcotos, 'guardias' => $guardias, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Guarda una casa con su respectivo usuario
     *
     * @return view usuarios.usuariosGuardia.usuariosGuardia
     */
    public function guardar_guardia(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        $validar_correo = Users::buscar_usuario_por_correo($req->correo_nuevo);

        if (count($validar_correo)) {
            return redirect()->action('UsuariosController@usuarios_guardia', ['valido' => md5('false')]);
        }

        /*Se crea un usuario para la guardia*/
        $user = new Users;

        $user->nombre_completo = $req->responsable;
        $user->correo = $req->correo_nuevo;
        $user->password = bcrypt($req->password);
        $user->contra = $req->password;
        $user->foto_perfil = "img/img_users/default.jpg";
        $user->privilegios_id = 6;//Se asigna con privilegios de guardia

        $user->save();

        /*Se crea el coto*/
        $coto_id = app('App\Http\Controllers\IngresosController')->obtener_coto_usuario();
        $guardia = new Guardia;

        $guardia->coto_id = $coto_id;
        $guardia->subcoto_id = $req->subcoto_id;
        $guardia->users_id = $user->id;
        $guardia->created_at = date("Y-m-d H:i:s");

        $guardia->save();

        return redirect()->to('/usuarios/guardia');
    }

    /**
     * Edita una guardia y a su respectivo usuario
     *
     * @return view usuarios.usuariosGuardia.usuariosGuardia
     */
    public function editar_guardia(Request $req)
    {
        date_default_timezone_set('America/Mexico_City');
        $validar_correo = Users::buscar_usuario_por_correo($req->correo_nuevo, $req->correo_viejo);

        if (count($validar_correo)) {
            return redirect()->action('UsuariosController@usuarios_guardia', ['valido' => md5('false')]);
        }

        /*Se busca el usuario de la guardia*/
        if ($req->password != "") {
            $update = ['nombre_completo' => $req->responsable, 'correo' => $req->correo_nuevo, 'password' => bcrypt($req->password), 'contra' => $req->password];
        } else {
            $update = ['nombre_completo' => $req->responsable, 'correo' => $req->correo_nuevo];
        }

        Users::where('correo', $req->correo_viejo)
        ->update($update);

        /*Se busca la guardia*/
        $guardia = Guardia::find($req->id);
        
        $guardia->subcoto_id = $req->subcoto_id;
        $guardia->save();

        return redirect()->to('/usuarios/guardia');
    }

    /**
     * Elimina un guardia, aunque realmente solo edita su status
     *
     */
    public function eliminar_guardia(Request $req)
    {
        return DB::table('guardias')
        ->where('id', $req->guardia_id)
        ->update(['status' => 0]);
    }
}