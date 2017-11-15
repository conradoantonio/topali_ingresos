<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Persona extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'personas';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['nombre_persona', 'foto_identificacion', 'foto_personal', 'texto_placa', 'created_at'];

    /**
     * Obtiene las personas que han ingresado anteriormente a algún coto, esto es para el selec2 del formulario de ingresos.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_personas_coto($casa_id = null)
    {
        $personas = Ingreso::select(DB::raw('personas.*'))
        ->leftJoin('personas', 'ingresos.personas_id', '=', 'personas.id');

        if ($casa_id) {//Significa que es un usuario de coto
            $coto_id = self::buscar_coto_usuario(Session::get('privilegio'), auth()->user()->id);
            $personas = $personas->where('ingresos.main_id', $coto_id);
        }

        return $personas->groupBy('personas.nombre_persona')->orderBy('personas.nombre_persona')->get();
    }

    /**
     * Obtiene las personas que han ingresado anteriormente a algún coto, esto es para el selec2 del formulario de ingresos.
     *
     * @return \Illuminate\Database\Query
     */
    public static function get_personas_coto($coto_id)
    {
        $personas = Ingreso::select(DB::raw('personas.*'))
        ->leftJoin('personas', 'ingresos.personas_id', '=', 'personas.id')
        ->where('main_id', $coto_id)
        ->groupBy('personas.nombre_persona')
        ->orderBy('personas.nombre_persona')
        ->get();

        return $personas;
    }

    /**
     * Obtiene el coto que tiene vinculado un usuario.
     *
     * @return int $id
     */
    public static function buscar_coto_usuario($privilegio, $users_id) 
    {
        if ($privilegio == "Administrador Coto") {
            return Coto::where('users_id', $users_id)->pluck('id');
        }
        if ($privilegio == "Guardia") {
            return Guardia::where('users_id', $users_id)->pluck('coto_id');

        }
        return 0;
    }
}
