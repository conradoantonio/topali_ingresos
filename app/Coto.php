<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Coto extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'cotos';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 'tipo_servicio', 'unidad_privativa', 'direccion', 'telefono_1', 'num_lugares', 'nombre_responsable', 'users_id', 'guardia_users_id', 'id_estado'
    ];

    /**
     * Obtiene los cotos con su usuarios del sistema y guardia asignado.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_cotos($fecha_inicio = null, $fecha_fin = null)
    {
        $query = Coto::select(DB::raw("cotos.*, users.correo AS 'correo_servicio', users.contra as contra_user_servicio, users_2.contra as contra_guardia,
            users_2.nombre_completo AS 'guardia_responsable', users_2.correo AS 'correo_guardia'"))
        ->leftJoin('users', 'cotos.users_id', '=', 'users.id')//Tabla que trae los datos del usuario del servicio
        ->leftJoin('users as users_2', 'cotos.guardia_users_id', '=', 'users_2.id')//tabla que trae los datos del usuario del guardia
        ->where('cotos.status', 1);
        if ( !empty($fecha_inicio) ) {
        	$query->where('cotos.created_at','>=',$fecha_inicio.' 00:00:00');
        }

        if ( !empty($fecha_fin) ) {
        	$query->where('cotos.created_at','<=',$fecha_fin.' 23:59:59');
        }

        /*if (($fecha_inicio || $fecha_fin) {
            dd('entro');
            //$query->where('users.status', 1);
        }*/
        $cotos = $query->get();

        return $cotos;
    }
}
