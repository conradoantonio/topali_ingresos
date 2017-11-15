<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Departamento extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'departamentos';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = [
    	'nombre_departamento', 'direccion', 'telefono_1', 'extension_tel_1', 'telefono_2', 'extension_tel_2', 
    	'nombre_responsable', 'puesto', 'contacto', 'negocios_id', 'users_id'
    ];

    /**
     * Obtiene los departamento con su usuario del sistema.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_departamentos()
    {
        return Departamento::select(DB::raw('departamentos.*, users.id as user_id, users.correo'))
        ->leftJoin('users', 'departamentos.users_id', '=', 'users.id')->get();
    }
}
