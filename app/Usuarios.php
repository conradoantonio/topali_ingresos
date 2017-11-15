<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Usuarios extends Model
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre_completo', 'correo', 'password', 'telefono', 'foto_perfil', 'sexo', 'fecha_nacimiento', 'social_network', 'status', 'created_at'];

    public $timestamps = false;

    /**
     *
     * @return Regresa el usuario que contenga un correo en específico.
     */
    public static function buscar_usuario_por_correo($correo)
    {
    	return Usuarios::where('correo', '=', $correo)->get();
    }
}
