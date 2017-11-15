<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subcoto extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'subcotos';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = [
    	'nombre_departamento', 'direccion', 'telefono_1', 'extension_tel_1', 'telefono_2', 'extension_tel_2', 
    	'nombre_responsable', 'puesto', 'contacto', 'coto_id', 'users_id'
    ];

    /**
     * Obtiene los subcotos con su usuarios al sistema.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_sucotos()
    {
        return Subcoto::select(DB::raw('subcotos.*, users.id as user_id, users.correo'))
        ->leftJoin('users', 'subcotos.users_id', '=', 'users.id')->get();
    }
}
