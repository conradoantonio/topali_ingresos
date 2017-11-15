<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Users extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['nombre_completo', 'correo', 'password', 'foto_perfil', 'privilegios_id', 'status'];

    /**
     * Obtiene el privilegio que tiene el usuario.
     */
    public static function usuarios_privilegios()
    {
        return Users::leftJoin('privilegios', 'users.privilegios_id', '=', 'privilegios.id')
        ->select(DB::raw('users.*, privilegios.tipo'))
        ->where('users.id', '!=', auth()->user()->id)
        ->where('status', 1)
        ->get();
    }

    /**
     *
     * @return Regresa el usuario que contenga un correo en específico.
     */
    public static function buscar_usuario_por_correo($correo, $correo_viejo = false)
    {
        return $correo_viejo ? Users::where('correo', '=', $correo)->where('correo', '!=', $correo_viejo)->get() : 
        Users::where('correo', '=', $correo)->get();
    }

    /**
     *
     * @return Regresa los usuarios que sean de tipo casa.
     */
    public static function usuarios_casas($coto_id)
    {
        return Casa::select(DB::raw('casas.*, users.`correo`, users.`nombre_completo` AS responsable, users.contra ,cotos.`id` AS coto_id, 
            cotos.`nombre`AS coto_nombre, subcotos.`id` AS subcoto_id, subcotos.`nombre_subcoto` AS subcoto_nombre'))
        ->leftJoin('users', 'casas.users_id', '=', 'users.id')
        ->leftJoin('cotos', 'casas.coto_id', '=', 'cotos.id')
        ->leftJoin('subcotos', 'casas.subcoto_id', '=', 'subcotos.id')
        ->where('casas.status', 1)
        ->where('users.status', 1)
        ->where('casas.coto_id', $coto_id)
        ->get();
    }

    /**
     *
     * @return Regresa los usuarios que sean de tipo guardia.
     */
    public static function usuarios_guardias()
    {
        return Guardia::select(DB::raw('guardias.*, users.`correo`, users.`nombre_completo` AS responsable, cotos.`id` AS coto_id, cotos.`nombre`AS coto_nombre,
            subcotos.`id` AS subcoto_id, subcotos.`nombre_subcoto` AS subcoto_nombre'))
        ->leftJoin('users', 'guardias.users_id', '=', 'users.id')
        ->leftJoin('cotos', 'guardias.coto_id', '=', 'cotos.id')
        ->leftJoin('subcotos', 'guardias.subcoto_id', '=', 'subcotos.id')
        ->where('guardias.status', 1)
        ->get();
    }
}
