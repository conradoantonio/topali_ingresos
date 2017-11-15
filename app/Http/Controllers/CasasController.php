<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\loginRequest;
use App\Http\Controllers\Controller;
use App\Users;
use DB;
use Session;
use Auth;
use Redirect;
use PDO;


class CasasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $title = "Casas";
            $menu = "Casas";
            //$privilegios = Privilegios::all();
            $usuarios = Users::where('status', 1)
            ->where('id', '!=', Auth::user()->id)
            ->get();
            return view('casas.casas', ['menu' => $menu, 'usuarios' => $usuarios, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Elimina una casa dejándole un status de 0.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminar_casa(Request $req)
    {
        $table_join = DB::table('casas')->leftJoin('users', 'casas.users_id', '=', 'users.id')->where('casas.id', $req->casa_id)->first();
        $user_id = $table_join->users_id;

        DB::table('users')->where('id', $user_id)->update(['status' => 0]);
        DB::table('casas')->where('id', $req->casa_id)->update(['status' => 0]);
    }
}
