<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Negocio extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'negocios';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 'nombre_comercial','direccion', 'telefono_1', 'extension_tel_1', 'telefono_2', 'extension_tel_2', 
    	'nombre_responsable', 'puesto', 'contacto', 'users_id'
    ];

    /**
     * Obtiene los negocios con su usuario del sistema.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_negocios()
    {
        return Negocio::select(DB::raw('negocios.*, users.id as user_id, users.correo'))
        ->leftJoin('users', 'negocios.users_id', '=', 'users.id')->get();
    }
}
