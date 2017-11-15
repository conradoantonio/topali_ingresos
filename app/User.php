<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;	

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *
     * @return Regresa el total de usuarios registrados y activos en la aplicación filtrados por empresa
     */
    public static function count_users_by_status($priv, $coto = null)
    {
    	//2 -> servicios, 6 -> guardias, 7 -> casas
        $query = User::where('privilegios_id', '=', $priv);

        
        if ( !empty($coto) ) {

        	if ( $priv == 2 ) {
	        	$query->leftJoin('cotos','cotos.users_id','=','users.id')
        			->where('cotos.id',$coto);
	        }
        	if ( $priv == 6 ) {
	        	$query->leftJoin('cotos','cotos.guardia_users_id','=','users.id')
        			->where('cotos.id',$coto);	
	        }
        	if ( $priv == 7 ) {
        		$query->leftJoin('casas','casas.users_id','=','users.id')
        			->where('casas.coto_id',$coto);
	        }

        	
        }

        $users = $query->count();
        return $users;
    }

    public static function usuarios_mes($coto = null){
    	$numero = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    	$query = User::where(DB::raw('TIMESTAMP(users.created_at)'),'>=',date('Y-m').'-01')
    		->where(DB::raw('TIMESTAMP(users.created_at)'),'<=',date('Y-m').'-'.$numero);

    	if ( $coto ) {
    		$query->leftJoin('cotos','cotos.users_id','=','users.id')
    		->where('cotos.id',$coto);
    	}
    		
    	return $query->count();
    }
}
