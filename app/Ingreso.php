<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ingreso extends Model
{
    /**
     * La tabla de la base de datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'ingresos';

    /**
     * Los atributos que podrán ser alterados masivamente.
     *
     * @var array
     */
    protected $fillable = ['tipo_ingreso', 'main_id', 'sub_id', 'casa_id', 'tipo_visita_id', 'comentarios', 'personas_id', 'va_con', 'egreso', 'hora_egreso', 'created_at'];

    /**
     * Obtiene los ingresos más la persona a la que le corresponde dicho ingreso dependiendo del tipo de ingreso, es decir,
     * 1 se referirá a cotos y subcotos con su respectiva casa, 2 se referirá a las empresas y departamentos venculados a esta.
     *
     * @return $ingresos
     */
    public static function obtener_ingresos_personas($servicio_id = 0, $status = null, $fecha_inicio = null, $fecha_fin = null)
    {
    	$query = Ingreso::select(DB::raw('ingresos.id, ingresos.created_at as fecha_ingreso, personas.nombre_persona, personas.texto_placa, 
            ingresos.main_id AS coto_id, cotos.nombre AS nombre_coto, cotos.num_lugares, ingresos.sub_id AS subcoto_id, ingresos.hora_egreso, subcotos.nombre_subcoto, 
            ingresos.tipo_visita_id, tipo_visita.tipo AS tipo_visita, ingresos.comentarios, personas.foto_identificacion, personas.foto_personal,
            ingresos.va_con, casas.folio_casa'
		))
        ->leftJoin('personas', 'ingresos.personas_id', '=', 'personas.id')
        ->leftJoin('tipo_visita', 'ingresos.tipo_visita_id', '=', 'tipo_visita.id')
        ->leftJoin('cotos', 'ingresos.main_id', '=', 'cotos.id')
        ->leftJoin('subcotos', 'ingresos.sub_id', '=', 'subcotos.id')
        ->leftJoin('casas', 'ingresos.casa_id', '=', 'casas.id');

        if ( is_numeric($status) ) {
        	$query->where('egreso', $status);	
        }
        
        if ( $servicio_id != 0 ){
            $query->where('main_id', $servicio_id);
        }

        if ( !empty($fecha_inicio) ){
        	$query->where('ingresos.created_at','>=',$fecha_inicio.' 00:00:00');
        }

        if ( !empty($fecha_fin) ){
        	$query->where('ingresos.created_at','<=',$fecha_fin.' 23:59:59');
        }

    	$ingresos = $query->get();

        return $ingresos;
    }

    /**
     * Obtiene los ingresos más la persona a la que le corresponde dicho ingreso dependiendo del tipo de ingreso, es decir,
     * 1 se referirá a cotos y subcotos con su respectiva casa, 2 se referirá a las empresas y departamentos venculados a esta.
     *
     * @return $ingresos
     */
    public static function obtener_ingresos_personas_excel($tipo_ingreso, $status)
    {
        $ingresos = Ingreso::select(DB::raw('ingresos.id, ingresos.created_at as "Hora ingreso", personas.nombre_persona as "Nombre ingresante", 
            ingresos.hora_egreso as "Hora egreso", personas.texto_placa as "Placas", cotos.nombre AS "Nombre coto", 
            IF(subcotos.nombre_subcoto, subcotos.nombre_subcoto, "No aplica") as "Nombre subcoto", casas.folio_casa as "Casa", 
            tipo_visita.tipo AS "Tipo visita", ingresos.comentarios as "Comentarios", ingresos.va_con as "Fue con"'
        ))
        ->leftJoin('personas', 'ingresos.personas_id', '=', 'personas.id')
        ->leftJoin('tipo_visita', 'ingresos.tipo_visita_id', '=', 'tipo_visita.id')
        ->leftJoin('cotos', 'ingresos.main_id', '=', 'cotos.id')
        ->leftJoin('subcotos', 'ingresos.sub_id', '=', 'subcotos.id')
        ->leftJoin('casas', 'ingresos.casa_id', '=', 'casas.id')
        ->where('main_id', $tipo_ingreso)
        ->where('egreso', $status)
        ->get();

        return $ingresos;
    }

    public static function ingresos_egresos_dia($status, $coto = null){
    	$query = Ingreso::where('egreso','=',$status)
    		->where('created_at','>=',date('Y-m-d').' 00:00:00')
    		->where('created_at','<=',date('Y-m-d').' 23:59:59');

    	if ( $coto ){
    		$query->where('main_id',$coto);
    	}
    	return $query->count();
    }

    public static function ingreso_mes($coto = null){
    	$numero = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    	$query = Ingreso::where(DB::raw('TIMESTAMP(created_at)'),'>=',date('Y-m').'-01')
    		->where(DB::raw('TIMESTAMP(created_at)'),'<=',date('Y-m').'-'.$numero)
    		->where('egreso',0);

    	if ( $coto ) {
    		$query->where('ingresos.main_id',$coto);
    	}
    		
    	return $query->count();
    }
}
