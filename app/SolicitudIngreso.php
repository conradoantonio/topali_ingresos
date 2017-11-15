<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudIngreso extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'solicitudes_ingreso';

    /**
     * Los atributos que podrán ser alterados masivamente..
     *
     * @var array
     */
    protected $fillable = ['casa_id', 'mensaje', 'status', 'created_at'];

    /**
     * Obtiene las solicitudes hechas de un usuario de casa.
     *
     * @return \Illuminate\Database\Query
     */
    public static function obtener_solicitudes($casa_id)
    {
        return SolicitudIngreso::where('casa_id', $casa_id)->leftJoin('personas','personas.id', '=', 'solicitudes_ingreso.persona_id')->select('solicitudes_ingreso.id as id_solicitud', 'solicitudes_ingreso.fecha_visita' ,'personas.nombre_persona')->get();
    }

    public static function solicitudes_pendientes_revisadas($status, $coto = null){
    	$query = SolicitudIngreso::where('solicitudes_ingreso.status','=',$status)
    		->where('solicitudes_ingreso.created_at','>=',date('Y-m-d').' 00:00:00')
    		->where('solicitudes_ingreso.created_at','<=',date('Y-m-d').' 23:59:59');
    	
    	if ( $coto ){
    		$query->leftJoin('casas','casas.id','=','solicitudes_ingreso.casa_id')
    		->where('coto_id',$coto);
    	}

    	return $query->count();
    }

    public static function solicitudes_mes($coto = null){
    	$numero = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    	$query = SolicitudIngreso::where(DB::raw('TIMESTAMP(solicitudes_ingreso.created_at)'),'>=',date('Y-m').'-01')
    		->where(DB::raw('TIMESTAMP(solicitudes_ingreso.created_at)'),'<=',date('Y-m').'-'.$numero);

    	if ( $coto ) {
    		$query->leftJoin('casas','casas.id','=','solicitudes_ingreso.casa_id')
    		->where('coto_id',$coto);
    	}
    	return $query->count();
    }
}
